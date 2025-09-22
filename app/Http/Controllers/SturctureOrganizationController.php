<?php

namespace App\Http\Controllers;

use App\Models\DetailCompany;
use App\Models\DetailManpower;
use App\Models\JoinCompany;
use App\Models\User;
use App\Models\OrganizationChart;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class SturctureOrganizationController extends Controller
{
    /**
     * Get users for select dropdown (renamed from getAhli for better clarity)
     */

    public function getAhli(Request $request)
    {
        $user = Auth::user();

        $id_user = $user->sub_company ?? $user->id;
        if ($request->id_user) $id_user = $request->id_user;

        if ($user->id_level == "2" || $request->id_user) {
            $detail = DetailCompany::where('id_user', $id_user)->first();
        }

        $data = JoinCompany::with(['manpower.user' => function ($query) {
            $query->select('id', 'fullname');
        }])
            ->where('id_detail_company', $detail->id_detail_company)
            ->whereDate('expired_at', '>', date('Y-m-d'))
            ->orderBy('created_at', 'DESC')
            ->get();

        // ✅ Filter hanya yang manpower & user-nya ADA
        $data = $data->filter(function ($item) {
            return $item->manpower && $item->manpower->user;
        })->map(function ($item) {
            return [
                'id' => $item->manpower->user->id,
                'fullname' => $item->manpower->user->fullname,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Successfully fetch data',
            'data' => $data
        ], 200);
    }


    /**
     * Keep backward compatibility
     */

    public function getView()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        $data = OrganizationChart::where('created_by', $user->id)->first();
        return view('company.carta-organisasi.index', compact('data'));
    }
    public function getDetail($id)
    {
        return view('company.carta-organisasi.preview');
    }

    /**
     * Get organizational chart data
     */
    public function getData(Request $request)
    {
        try {
            // Get chart ID from request and authenticated user's ID
            $chartId = $request->get('chart_id');
            $user = Auth::user();

            // Build query with created_by filter
            $query = OrganizationChart::with(['activeStructures.user'])
                ->where('is_active', true)
                ->where('created_by', $user->id);

            // If chart_id is provided, filter by it; otherwise, get the first matching chart
            $chart = $chartId
                ? $query->where('id', $chartId)->first()
                : $query->first();

            if (!$chart) {
                return response()->json([
                    'success' => false,
                    'message' => 'No chart found for the current user',
                    'data' => []
                ]);
            }

            // Format data for frontend
            $structures = $chart->activeStructures->map(function ($structure) {
                return [
                    'id' => $structure->id,
                    'title' => $structure->position_title,
                    'name' => $structure->user ? $structure->user->fullname : 'Select person',
                    'personId' => (int)$structure->user_id,
                    'parentId' => (int)$structure->parent_id,
                    'level' => $structure->level,
                    'x' => $structure->position_x ?? 0,
                    'y' => $structure->position_y ?? 0,
                    'order_index' => $structure->order_index,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved chart data',
                'data' => $structures,
                'chart_id' => $chart->id
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching chart data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch chart data',
                'data' => []
            ]);
        }
    }

    /**
     * Save organizational chart structure
     */
    public function saveStructure(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chart_id' => 'nullable|integer',
                'structures' => 'required|array',
                'structures.*.id' => 'nullable|integer',
                'structures.*.title' => 'required|string|max:255',
                'structures.*.personId' => 'nullable|integer|exists:users,id',
                'structures.*.parentId' => 'nullable|integer',
                'structures.*.x' => 'nullable|numeric',
                'structures.*.y' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $chartId = $request->get('chart_id');
            $structures = $request->get('structures', []);

            DB::beginTransaction();

            // Get or create chart
            if ($chartId) {
                $chart = OrganizationChart::find($chartId);
                if (!$chart) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Chart not found'
                    ], 404);
                }
            } else {
                // Create new chart
                $chart = OrganizationChart::create([
                    'chart_name' => 'Organization Chart - ' . Auth::user()->fullname,
                    'chart_type' => 'organizational',
                    'created_by' => Auth::id(),
                    'is_active' => true,
                    'is_published' => true,
                    'effective_date' => now(),
                ]);
                $chartId = $chart->id;
            }

            // Process each structure
            foreach ($structures as $index => $structureData) {
                $data = [
                    'chart_id' => $chartId,
                    'position_title' => $structureData['title'],
                    'user_id' => $structureData['personId'] ?? null,
                    'parent_id' => $structureData['parentId'] ?? null,
                    'position_x' => $structureData['x'] ?? 0,
                    'position_y' => $structureData['y'] ?? 0,
                    'order_index' => $index + 1,
                    'is_active' => true,
                ];

                if (isset($structureData['id']) && $structureData['id']) {
                    // Update existing structure
                    OrganizationStructure::where('id', $structureData['id'])->update($data);
                } else {
                    // Create new structure
                    OrganizationStructure::create($data);
                }
            }

            // Update levels for all structures in this chart
            $this->updateStructureLevels($chartId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chart saved successfully',
                'chart_id' => $chartId
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving chart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save chart'
            ], 500);
        }
    }

    /**
     * Add new position to organizational structure
     */
    public function addPosition(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chart_id' => 'nullable|integer',
                'position_title' => 'required|string|max:255',
                'user_id' => 'nullable|integer|exists:users,id',
                'parent_id' => 'nullable|integer',
                'position_x' => 'nullable|numeric',
                'position_y' => 'nullable|numeric',
            ]);

            // Custom validation for parent_id
            if ($request->has('parent_id') && $request->get('parent_id')) {
                $parentExists = OrganizationStructure::where('id', $request->get('parent_id'))
                    ->where('chart_id', $request->get('chart_id') ?: 1)
                    ->exists();

                if (!$parentExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Parent position not found in the current chart',
                        'errors' => ['parent_id' => ['The selected parent position is invalid.']]
                    ], 422);
                }
            }

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $chartId = $request->get('chart_id') ?: 1; // Default to chart ID 1 if not provided

            // Check if chart exists
            $chart = OrganizationChart::find($chartId);
            if (!$chart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chart not found with ID: ' . $chartId
                ], 404);
            }

            Log::info('Adding position to chart: ' . $chartId . ' with data: ' . json_encode($request->all()));

            // Calculate order index
            $parentId = $request->get('parent_id');
            $orderIndex = OrganizationStructure::where('chart_id', $chartId)
                ->where('parent_id', $parentId)
                ->max('order_index') + 1;

            $structure = OrganizationStructure::create([
                'chart_id' => $chartId,
                'position_title' => $request->get('position_title'),
                'user_id' => $request->get('user_id'),
                'parent_id' => $parentId,
                'position_x' => $request->get('position_x', 0),
                'position_y' => $request->get('position_y', 0),
                'order_index' => $orderIndex,
                'is_active' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Position added successfully',
                'data' => [
                    'id' => $structure->id,
                    'title' => $structure->position_title,
                    'name' => $structure->user ? $structure->user->fullname : 'Select person',
                    'personId' => $structure->user_id,
                    'parentId' => $structure->parent_id,
                    'level' => $structure->level,
                    'x' => $structure->position_x,
                    'y' => $structure->position_y,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding position: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add position: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Update existing position
     */
    public function updatePosition(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'position_title' => 'required|string|max:255',
                'user_id' => 'nullable|integer|exists:users,id',
                'position_x' => 'nullable|numeric',
                'position_y' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $structure = OrganizationStructure::find($id);

            if (!$structure) {
                return response()->json([
                    'success' => false,
                    'message' => 'Position not found'
                ], 404);
            }

            // Don't allow editing root position (optional check)
            if (!$structure->parent_id && $request->has('parent_id')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Root position cannot be moved'
                ], 400);
            }

            $structure->update([
                'position_title' => $request->get('position_title'),
                'user_id' => $request->get('user_id'),
                'position_x' => $request->get('position_x'),
                'position_y' => $request->get('position_y'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Position updated successfully',
                'data' => [
                    'id' => $structure->id,
                    'title' => $structure->position_title,
                    'name' => $structure->user ? $structure->user->fullname : 'Select person',
                    'personId' => $structure->user_id,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating position: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update position'
            ], 500);
        }
    }

    /**
     * Delete position and its children
     */
    public function deletePosition($id)
    {
        try {
            $structure = OrganizationStructure::with('children')->find($id);

            if (!$structure) {
                return response()->json([
                    'success' => false,
                    'message' => 'Position not found'
                ], 404);
            }

            // Don't allow deleting root position
            if (!$structure->parent_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Root position cannot be deleted'
                ], 400);
            }

            DB::beginTransaction();

            // Get all descendants to delete
            $allDescendants = $this->getAllDescendants($structure);
            $idsToDelete = $allDescendants->pluck('id')->push($structure->id);

            // Hard delete all positions (since we're not using soft deletes)
            OrganizationStructure::whereIn('id', $idsToDelete)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Position and subordinates deleted successfully',
                'deleted_count' => $idsToDelete->count()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting position: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete position'
            ], 500);
        }
    }

    /**
     * Update structure levels recursively
     */
    private function updateStructureLevels($chartId)
    {
        // Get all structures for this chart
        $structures = OrganizationStructure::where('chart_id', $chartId)
            ->where('is_active', true)
            ->get();

        // Update levels starting from root
        $rootStructures = $structures->whereNull('parent_id');

        foreach ($rootStructures as $root) {
            $this->updateLevelRecursive($root, 0, $structures);
        }
    }

    /**
     * Recursively update levels
     */
    private function updateLevelRecursive($structure, $level, $allStructures)
    {
        $structure->level = $level;
        $structure->save();

        // Update children
        $children = $allStructures->where('parent_id', $structure->id);
        foreach ($children as $child) {
            $this->updateLevelRecursive($child, $level + 1, $allStructures);
        }
    }

    /**
     * Get all descendants recursively
     */
    private function getAllDescendants($structure)
    {
        $descendants = collect();

        foreach ($structure->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($this->getAllDescendants($child));
        }

        return $descendants;
    }
}
