<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blogpost;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * GET /api/announcements
     * Senarai pengumuman/blog post (published) dengan filter community_id
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);

        $query = Blogpost::with('category')
            ->where('status', 'PUBLISHED')
            ->orderBy('created_at', 'desc');

        if ($request->filled('community_id')) {
            $query->where('community_id', $request->community_id);
        }

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $paginated = $query->paginate($perPage);

        $data = $paginated->getCollection()->map(fn($post) => $this->formatPost($post));

        return response()->json([
            'success' => true,
            'data'    => $data,
            'meta'    => [
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
                'total'        => $paginated->total(),
            ],
        ]);
    }

    /**
     * GET /api/announcements/{id}
     * Detail satu pengumuman
     */
    public function show($id)
    {
        $post = Blogpost::with('category')
            ->where('status', 'PUBLISHED')
            ->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak dijumpai',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $this->formatPost($post, true),
        ]);
    }

    private function formatPost(Blogpost $post, bool $withContent = false): array
    {
        $result = [
            'id'           => $post->id,
            'title'        => $post->title,
            'slug'         => $post->slug,
            'image'        => $post->image ? url('storage/' . $post->image) : null,
            'tags'         => $post->tags,
            'community_id' => $post->community_id,
            'category'     => $post->category ? [
                'id'   => $post->category->id,
                'name' => $post->category->name,
            ] : null,
            'created_at'   => $post->created_at,
            'updated_at'   => $post->updated_at,
        ];

        if ($withContent) {
            $result['content'] = $post->content;
        } else {
            $plain = $this->parseQuillContent($post->content);
            $result['excerpt'] = $plain ? mb_substr(trim($plain), 0, 150) : null;
        }

        return $result;
    }

    private function parseQuillContent(?string $content): ?string
    {
        if (!$content) return null;

        $decoded = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['ops'])) {
            return collect($decoded['ops'])
                ->map(fn($op) => is_string($op['insert'] ?? null) ? $op['insert'] : '')
                ->implode('');
        }

        return strip_tags($content);
    }
}
