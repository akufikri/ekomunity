<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogpostController extends Controller
{
    use ApiResponder;

    public function index()
    {
        return view('admin.blogPost.index');
    }

    public function getData()
    {
        try {
            $id = request()->input('id');

            if ($id) {
                // Return single post for editing with category relationship
                $result = Blogpost::with('category')->find($id);
                return response()->json($result);
            }

            // Return DataTables response with category relationship
            $data = Blogpost::with('category')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset('storage/' . $row->image) . '" alt="Image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;">';
                    }
                    return '<span class="badge badge-secondary">No Image</span>';
                })
                ->addColumn('title', function ($row) {
                    return '<div style="max-width: 200px;">' . Str::limit($row->title, 50) . '</div>';
                })
                ->addColumn('content', function ($row) {
                    // Parse Quill JSON content and extract plain text
                    $content = $this->parseQuillContent($row->content);
                    return '<div style="max-width: 250px;">' . Str::limit($content, 100) . '</div>';
                })
                ->addColumn('tags', function ($row) {
                    $tags = json_decode($row->tags, true);
                    if ($tags && is_array($tags)) {
                        $tagHtml = '';
                        foreach ($tags as $tag) {
                            $tagHtml .= '<span class="badge badge-primary mr-1">' . $tag . '</span>';
                        }
                        return $tagHtml;
                    }
                    return '<span class="badge badge-secondary">No Tags</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'PUBLISHED') {
                        return '<span class="badge badge-success">Published</span>';
                    } else {
                        return '<span class="badge badge-warning">Draft</span>';
                    }
                })
                ->addColumn('category', function ($row) {
                    if ($row->category) {
                        return '<span class="badge badge-info">' . strtoupper($row->category->name) . '</span>';
                    }
                    return '<span class="badge badge-secondary">No Category</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button class="btn btn-sm btn-success mr-1" onClick="editData(' . $row->id . ')"><i class="fas fa-edit"></i> Edit</button>';
                    $btn .= '<button class="btn btn-sm btn-danger" onClick="deleteData(' . $row->id . ')"><i class="fas fa-trash"></i> Delete</button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['image', 'title', 'content', 'tags', 'status', 'category', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed fetch data post, please try again later'], 500);
        }
    }

    // Helper method untuk parse Quill JSON content
    private function parseQuillContent($content)
    {
        try {
            // Decode JSON content dari Quill
            $delta = json_decode($content, true);

            if (!$delta || !isset($delta['ops'])) {
                return strip_tags($content); // Fallback jika bukan format Quill
            }

            $text = '';
            foreach ($delta['ops'] as $op) {
                if (isset($op['insert'])) {
                    if (is_string($op['insert'])) {
                        $text .= $op['insert'];
                    }
                }
            }

            return trim($text);
        } catch (\Exception $e) {
            // Fallback jika parsing gagal
            return strip_tags($content);
        }
    }

    // Atau alternatif method yang lebih sederhana
    private function parseQuillContentSimple($content)
    {
        // Remove semua HTML tags dan decode JSON jika ada
        $cleanContent = strip_tags($content);

        // Jika content berupa JSON, coba extract text
        if (str_starts_with(trim($content), '{')) {
            try {
                $delta = json_decode($content, true);
                if (isset($delta['ops'])) {
                    $text = '';
                    foreach ($delta['ops'] as $op) {
                        if (isset($op['insert']) && is_string($op['insert'])) {
                            $text .= $op['insert'];
                        }
                    }
                    return trim($text);
                }
            } catch (\Exception $e) {
                // Continue with original content
            }
        }

        return $cleanContent;
    }


    public function createPost(Request $request)
    {
        $user = Auth::user();
        if (!$user && $user->id_level == 1) {
            return $this->error("Unauthorized", 401);
        }
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:3',
                'image' => 'required|mimes:png,jpg,jpeg|max:2048',
                'content' => 'required|string',
                'tags' => 'required|array',
                'tags.*' => 'string',
                'status' => 'required|in:DRAFT,PUBLISHED',
                'id_category' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->error("Failed validation: " . $validator->errors()->first(), 400);
            }

            // Generate unique slug from title
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            while (Blogpost::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Handle image upload to local storage
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Create directory if not exists
                $directory = public_path('storage/blog-images');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $image->move($directory, $imageName);
                $imagePath = 'blog-images/' . $imageName;
            }

            // Create blog post
            $blogPost = Blogpost::create([
                'title' => $request->title,
                'slug' => $slug,
                'content' => $request->content, // JSON string from Summernote
                'image' => $imagePath,
                'tags' => json_encode($request->tags), // Convert array to JSON
                'status' => $request->status,
                'category' => $request->id_category,
            ]);

            return $this->success($blogPost, "Successfully created blog post", 201);
        } catch (\Throwable $th) {
            return $this->error("Failed create data post, please try again later", 500);
        }
    }

    public function updatePost(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user && $user->id_level == 1) {
            return $this->error("Unauthorized", 401);
        }
        try {
            $blogPost = Blogpost::find($id);

            if (!$blogPost) {
                return $this->error("Blog post not found", 404);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|min:3',
                'image' => 'sometimes|mimes:png,jpg,jpeg|max:2048',
                'content' => 'sometimes|required|string',
                'tags' => 'sometimes|required|array',
                'tags.*' => 'string',
                'status' => 'sometimes|required|in:DRAFT,PUBLISHED',
                'id_category' => 'sometimes|required'
            ]);

            if ($validator->fails()) {
                return $this->error("Failed validation: " . $validator->errors()->first(), 400);
            }

            $updateData = [];

            // Update title and regenerate slug if title is provided
            if ($request->has('title')) {
                $slug = Str::slug($request->title);
                $originalSlug = $slug;
                $counter = 1;

                while (Blogpost::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                $updateData['title'] = $request->title;
                $updateData['slug'] = $slug;
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($blogPost->image) {
                    $oldImagePath = public_path('storage/' . $blogPost->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Create directory if not exists
                $directory = public_path('storage/blog-images');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $image->move($directory, $imageName);
                $updateData['image'] = 'blog-images/' . $imageName;
            }

            // Update other fields if provided
            if ($request->has('content')) {
                $updateData['content'] = $request->content;
            }

            if ($request->has('tags')) {
                $updateData['tags'] = json_encode($request->tags);
            }

            if ($request->has('status')) {
                $updateData['status'] = $request->status;
            }
            if ($request->has('id_category')) {
                $updateData['id_category'] = $request->id_category;
            }

            // Update the blog post
            $blogPost->update($updateData);

            return $this->success($blogPost->fresh(), "Successfully updated blog post", 200);
        } catch (\Throwable $th) {
            return $this->error("Failed update data post, please try again later", 500);
        }
    }

    public function deletePost($id)
    {
        $user = Auth::user();
        if (!$user && $user->id_level == 1) {
            return $this->error("Unauthorized", 401);
        }
        try {
            $blogPost = Blogpost::find($id);

            if (!$blogPost) {
                return $this->error("Blog post not found", 404);
            }

            // Delete associated image if exists
            if ($blogPost->image) {
                $imagePath = public_path('storage/' . $blogPost->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the blog post
            $blogPost->delete();

            return $this->success(null, "Successfully deleted blog post", 200);
        } catch (\Throwable $th) {
            return $this->error("Failed delete data post, please try again later", 500);
        }
    }

    // for public used
    public function getDataPublic()
    {
        try {
            $is_top = request()->input('is_top', false);
            $slug = request()->input('slug');
            $id_category = request()->input('id_category');

            if ($slug) {
                // Return single post by slug with category relationship
                $result = Blogpost::with('category')
                    ->where('slug', $slug)
                    ->where('status', 'PUBLISHED')
                    ->first();

                if (!$result) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Blog post not found'
                    ], 404);
                }

                // Format single post data
                $post = [
                    'slug' => $result->slug,
                    'title' => $result->title,
                    'content' => $result->content,
                    'content_preview' => $this->parseQuillContent($result->content, 150),
                    'image_url' => $result->image ? asset('storage/' . $result->image) : null,
                    'tags' => json_decode($result->tags, true) ?? [],
                    'status' => $result->status,
                    'category' => [
                        'id' => $result->category ? $result->category->id : null,
                        'name' => $result->category ? $result->category->name : null,
                    ],
                    'created_at' => $result->created_at,
                    'updated_at' => $result->updated_at
                ];

                return response()->json([
                    'success' => true,
                    'data' => $post
                ]);
            }

            // Filter by category if provided
            $query = Blogpost::with('category')->where('status', 'PUBLISHED');

            if ($id_category) {
                $query->where('id_category', $id_category);
            }

            $query->latest();

            // If is_top is true, modify the response
            if ($is_top) {
                // Get the most recent top post
                $topPost = $query->first();

                if (!$topPost) {
                    return response()->json([
                        'success' => true,
                        'total' => 0,
                        'is_top' => [],
                        'message' => 'No posts found'
                    ]);
                }

                // Get the rest of the posts excluding the top post
                $otherPostsQuery = Blogpost::with('category')
                    ->where('status', 'PUBLISHED')
                    ->where('slug', '!=', $topPost->slug);

                if ($id_category) {
                    $otherPostsQuery->where('id_category', $id_category);
                }

                $otherPosts = $otherPostsQuery->latest()->get();

                // Map top post with content preview and full details
                $mappedTopPost = [
                    'slug' => $topPost->slug,
                    'title' => $topPost->title,
                    'content' => $topPost->content,
                    'content_preview' => $this->parseQuillContent($topPost->content, 150),
                    'image_url' => $topPost->image ? asset('storage/' . $topPost->image) : null,
                    'tags' => json_decode($topPost->tags, true) ?? [],
                    'status' => $topPost->status,
                    'category' => [
                        'id' => $topPost->category ? $topPost->category->id : null,
                        'name' => $topPost->category ? $topPost->category->name : null,
                    ],
                    'created_at' => $topPost->created_at,
                    'updated_at' => $topPost->updated_at
                ];

                // Group other posts by category name
                $groupedPosts = $otherPosts->groupBy(function ($post) {
                    return $post->category ? $post->category->name : 'uncategorized';
                });

                // Prepare response data
                $responseData = [
                    'success' => true,
                    'total' => $otherPosts->count() + 1,
                    'is_top' => [$mappedTopPost]
                ];

                // Add each category as a separate key in response
                foreach ($groupedPosts as $categoryName => $posts) {
                    $mappedCategoryPosts = $posts->map(function ($post) {
                        return [
                            'slug' => $post->slug,
                            'title' => $post->title,
                            'content' => $post->content,
                            'content_preview' => $this->parseQuillContent($post->content, 150),
                            'image_url' => $post->image ? asset('storage/' . $post->image) : null,
                            'tags' => json_decode($post->tags, true) ?? [],
                            'status' => $post->status,
                            'category' => [
                                'id' => $post->category ? $post->category->id : null,
                                'name' => $post->category ? $post->category->name : null,
                            ],
                            'created_at' => $post->created_at,
                            'updated_at' => $post->updated_at
                        ];
                    });

                    // Use category name as key (e.g., 'Pengumuman', 'Acara')
                    $responseData[strtolower($categoryName)] = $mappedCategoryPosts->values()->toArray();
                }

                return response()->json($responseData);
            }

            // Default behavior: return all published posts
            $posts = $query->get()->map(function ($post) {
                return [
                    'slug' => $post->slug,
                    'title' => $post->title,
                    'content' => $post->content,
                    'content_preview' => $this->parseQuillContent($post->content, 150),
                    'image_url' => $post->image ? asset('storage/' . $post->image) : null,
                    'tags' => json_decode($post->tags, true) ?? [],
                    'status' => $post->status,
                    'category' => [
                        'id' => $post->category ? $post->category->id : null,
                        'name' => $post->category ? $post->category->name : null,
                    ],
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $posts,
                'total' => $posts->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch blog posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
