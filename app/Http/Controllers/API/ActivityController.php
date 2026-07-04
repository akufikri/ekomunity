<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\DetailCompany;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivityController extends Controller
{
    /**
     * GET /api/activities
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 10);

        $query = Activity::with('communityUser')
            ->orderBy('date', 'desc');

        if ($request->filled('community_id')) {
            $query->where('community_id', $request->community_id);
        }

        $paginated = $query->paginate($perPage);

        $mapped = $paginated->getCollection()->map(function ($activity) use ($user) {
            return $this->formatActivity($activity, $user, false);
        });

        return response()->json([
            'success' => true,
            'data' => $mapped,
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'total' => $paginated->total(),
            ]
        ]);
    }

    /**
     * GET /api/activities/{id}
     */
    public function show($id)
    {
        $activity = Activity::with('communityUser')->find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found',
            ], 404);
        }

        $user = Auth::user();

        return response()->json($this->formatActivity($activity, $user, true));
    }

    /**
     * POST /api/activities/{id}/rsvp
     */
    public function rsvp($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found',
            ], 404);
        }

        $user = Auth::user();

        $rsvpCount = Rsvp::where('activity_id', $activity->id)->count();
        if ($rsvpCount >= $activity->max_attendees) {
            return response()->json([
                'success' => false,
                'message' => 'Had kuota penyertaan bagi aktiviti ini telah penuh.',
            ], 400);
        }

        Rsvp::firstOrCreate([
            'activity_id' => $activity->id,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'RSVP confirmed',
        ]);
    }

    /**
     * DELETE /api/activities/{id}/rsvp
     */
    public function cancelRsvp($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found',
            ], 404);
        }

        $user = Auth::user();

        Rsvp::where('activity_id', $activity->id)
            ->where('user_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'RSVP cancelled',
        ]);
    }

    /**
     * Format activity for API response
     */
    private function formatActivity(Activity $activity, $user, bool $detail): array
    {
        $dateObj = Carbon::parse($activity->date);
        $startTime = Carbon::parse($activity->start_time)->format('g:i A');
        $endTime = Carbon::parse($activity->end_time)->format('g:i A');

        $isRsvp = false;
        if ($user) {
            $isRsvp = Rsvp::where('activity_id', $activity->id)
                ->where('user_id', $user->id)
                ->exists();
        }

        $rsvpCount = Rsvp::where('activity_id', $activity->id)->count();

        // Resolve community name from community_id → DetailCompany
        $communityId = $activity->community_id;
        $communityName = $activity->organizer ?: 'Jawatankuasa Komuniti';

        if ($communityId && $activity->communityUser) {
            $company = DetailCompany::where('id_user', $communityId)->first();
            if ($company) {
                $communityName = $company->full_company_name;
            }
        }

        $base = [
            'id'           => $activity->id,
            'title'        => $activity->title,
            'description'  => $activity->description,
            'date'         => $dateObj->format('Y-m-d'),
            'date_display' => [
                'month' => $dateObj->format('M'),
                'day'   => $dateObj->format('d'),
            ],
            'start_time'   => Carbon::parse($activity->start_time)->format('H:i'),
            'end_time'     => Carbon::parse($activity->end_time)->format('H:i'),
            'time_display' => "$startTime - $endTime",
            'location'     => $activity->location,
            'community'    => [
                'id'   => $communityId ?? 0,
                'name' => $communityName,
            ],
            'is_rsvp'      => $isRsvp,
            'rsvp_count'   => $rsvpCount,
        ];

        if ($detail) {
            $agenda = $activity->agenda;
            if (!is_array($agenda)) {
                $agenda = json_decode($agenda, true) ?? [];
            }

            $base['address']       = $activity->address;
            $base['organizer']     = $activity->organizer ?: 'Jawatankuasa Komuniti';
            $base['type']          = $activity->type ?: 'aktiviti';
            $base['status']        = $activity->status ?: 'upcoming';
            $base['attendees']     = $rsvpCount;
            $base['max_attendees'] = $activity->max_attendees;
            $base['agenda']        = $agenda;
        }

        return $base;
    }
}
