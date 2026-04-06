<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * GET /api/notifications
     * Senarai notifikasi user yang sedang login
     * Query params: per_page (default 15), unread (boolean, default false)
     */
    public function index(Request $request)
    {
        $user    = Auth::user();
        $perPage = $request->per_page ?? 15;

        $query = $request->boolean('unread')
            ? $user->unreadNotifications()
            : $user->notifications();

        $paginated = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $data = $paginated->getCollection()->map(fn ($n) => [
            'id'         => $n->id,
            'type'       => $n->data['type'] ?? null,
            'title'      => $n->data['title'] ?? null,
            'message'    => $n->data['message'] ?? null,
            'data'       => $n->data,
            'is_read'    => !is_null($n->read_at),
            'read_at'    => $n->read_at,
            'created_at' => $n->created_at,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $data,
            'meta'    => [
                'current_page'  => $paginated->currentPage(),
                'last_page'     => $paginated->lastPage(),
                'total'         => $paginated->total(),
                'unread_count'  => $user->unreadNotifications()->count(),
            ],
        ]);
    }

    /**
     * GET /api/notifications/{id}
     * Detail notifikasi + otomatis tandai sebagai dibaca
     */
    public function show(string $id)
    {
        $user         = Auth::user();
        $notification = $user->notifications()->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'id'         => $notification->id,
                'type'       => $notification->data['type'] ?? null,
                'title'      => $notification->data['title'] ?? null,
                'message'    => $notification->data['message'] ?? null,
                'data'       => $notification->data,
                'is_read'    => !is_null($notification->read_at),
                'read_at'    => $notification->read_at,
                'created_at' => $notification->created_at,
            ],
        ]);
    }

    /**
     * PUT /api/notifications/{id}/read
     * Tandai satu notifikasi sebagai dibaca
     */
    public function markAsRead(string $id)
    {
        $user         = Auth::user();
        $notification = $user->notifications()->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai telah dibaca',
        ]);
    }

    /**
     * PUT /api/notifications/read-all
     * Tandai semua notifikasi sebagai dibaca
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai telah dibaca',
        ]);
    }

    /**
     * GET /api/notifications/unread-count
     * Jumlah notifikasi yang belum dibaca
     */
    public function unreadCount()
    {
        $user = Auth::user();

        return response()->json([
            'success'      => true,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }
}
