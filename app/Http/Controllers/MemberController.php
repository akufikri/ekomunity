<?php

namespace App\Http\Controllers;

use App\Models\DetailCompany;
use App\Models\User;
use App\Models\DetailManpower;
use App\Models\JoinCompany;
use App\Notifications\NewMemberJoined;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    /**
     * Display a listing of members (id_level = 3)
     * For Ketua Bahagian (id_level = 4): show members in their state
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // Build query for users with id_level = 3 (Ahli)
            $query = User::with([
                'manpower.state',
                'manpower.city',
                'manpower.parliament',
                'manpower.dun',
                'manpower.nation',
                'manpower.religion',
                'manpower.gender_relation'
            ])->where('id_level', 3);

            // If user is Ketua Bahagian (id_level = 4), filter by state
            if ($user->id_level == 4) {
                $query->whereHas('manpower', function ($q) use ($user) {
                    $q->where('id_state', $user->id_state);
                });
            }

            // Search functionality
            if ($request->search) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('phone_number', 'LIKE', "%{$search}%")
                        ->orWhereHas('manpower', function ($subQ) use ($search) {
                            $subQ->where('ic_number', 'LIKE', "%{$search}%");
                        });
                });
            }

            // Filter by status
            if ($request->status) {
                $query->where('status', $request->status);
            }

            // Pagination
            $perPage = $request->per_page ?? 15;
            $members = $query->orderBy('created_at', 'DESC')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $members
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in members index', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error fetching members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified member
     */
    public function show($id)
    {
        try {
            $user = Auth::user();

            $member = User::with([
                'manpower.state',
                'manpower.city',
                'manpower.parliament',
                'manpower.dun',
                'manpower.nation',
                'manpower.religion',
                'manpower.gender_relation'
            ])->where('id_level', 3)
                ->find($id);

            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member not found'
                ], 404);
            }

            // If user is Ketua Bahagian, check if member is in their state
            if ($user->id_level == 4) {
                if ($member->manpower && $member->manpower->id_state != $user->id_state) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to view this member'
                    ], 403);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $member
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in member show', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error fetching member detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created member
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|string|max:20',
                'password' => 'required|string|min:6',
                'ic_number' => 'required|string|max:20',
                'gender' => 'required|integer',
                'id_agama' => 'nullable|integer',
                'id_nation' => 'nullable|integer',
                'marital_status' => 'nullable|string',
                'native_status' => 'nullable|string',
                'address' => 'nullable|string',
                'id_state' => 'required|integer',
                'id_city' => 'nullable|integer',
                'id_parliament' => 'nullable|integer',
                'id_dun' => 'nullable|integer',
                'postcode' => 'nullable|string|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create User
            $user = new User();
            $user->id_level = 3; // Ahli
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->password = Hash::make($request->password);
            $user->status = 'ACTIVE';
            $user->is_verified = 0;
            $user->save();

            // Create DetailManpower
            $manpower = new DetailManpower();
            $manpower->id_user = $user->id;
            $manpower->ic_number = $request->ic_number;
            $manpower->gender = $request->gender;
            $manpower->id_agama = $request->id_agama;
            $manpower->id_nation = $request->id_nation;
            $manpower->marital_status = $request->marital_status;
            $manpower->native_status = $request->native_status;
            $manpower->address = $request->address;
            $manpower->id_state = $request->id_state;
            $manpower->id_city = $request->id_city;
            $manpower->id_parliament = $request->id_parliament;
            $manpower->id_dun = $request->id_dun;
            $manpower->postcode = $request->postcode;
            $manpower->business_phone = $request->phone_number;
            $manpower->business_email = $request->email;
            $manpower->step_registration = DetailManpower::$stepRegistration ?? 'completed';
            $manpower->save();

            // ✅ Jika user login adalah level 2 (Persatuan), tambahkan ke JoinCompany
            $authUser = Auth::user();
            if ($authUser && $authUser->id_level == 2) {
                $company = DetailCompany::where('id_user', $authUser->id)->first();

                if ($company) {
                    $join = new JoinCompany();
                    $join->id_detail_manpower = $manpower->id_detail_manpower;
                    $join->id_detail_company = $company->id_detail_company;
                    // $join->id_user = $user->id;
                    $join->payment_date = now();
                    $join->expired_at = now()->addYear();
                    $join->save();

                    // Notify super admins (level 1) about new member
                    try {
                        $admins = User::where('id_level', 1)->get();
                        Notification::send($admins, new NewMemberJoined($user, $company));
                    } catch (\Exception $e) {
                        Log::error('Failed to send NewMemberJoined notification', ['error' => $e->getMessage()]);
                    }
                }
            }

            // Load relationships
            $user->load([
                'manpower.state',
                'manpower.city',
                'manpower.parliament',
                'manpower.dun',
                'manpower.nation',
                'manpower.religion',
                'manpower.gender_relation'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Member created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating member', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error creating member',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified member
     */
    public function update(Request $request, $id)
    {
        try {
            $authUser = Auth::user();

            $user = User::where('id_level', 3)->find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member not found'
                ], 404);
            }

            // If user is Ketua Bahagian, check authorization
            if ($authUser->id_level == 4) {
                if ($user->manpower && $user->manpower->id_state != $authUser->id_state) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update this member'
                    ], 403);
                }
            }

            $validator = Validator::make($request->all(), [
                'fullname' => 'string|max:255',
                'email' => 'email|unique:users,email,' . $id,
                'phone_number' => 'string|max:20',
                'password' => 'nullable|string|min:6',
                'ic_number' => 'string|max:20',
                'gender' => 'integer',
                'id_agama' => 'nullable|integer',
                'id_nation' => 'nullable|integer',
                'marital_status' => 'nullable|string',
                'native_status' => 'nullable|string',
                'address' => 'nullable|string',
                'id_state' => 'integer',
                'id_city' => 'nullable|integer',
                'id_parliament' => 'nullable|integer',
                'id_dun' => 'nullable|integer',
                'postcode' => 'nullable|string|max:10',
                'status' => 'nullable|in:ACTIVE,INACTIVE',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update User
            if ($request->has('fullname')) $user->fullname = $request->fullname;
            if ($request->has('email')) $user->email = $request->email;
            if ($request->has('phone_number')) $user->phone_number = $request->phone_number;
            if ($request->has('password')) $user->password = Hash::make($request->password);
            if ($request->has('status')) $user->status = $request->status;

            $user->save();

            // Update DetailManpower
            $manpower = $user->manpower;
            if ($manpower) {
                if ($request->has('ic_number')) $manpower->ic_number = $request->ic_number;
                if ($request->has('gender')) $manpower->gender = $request->gender;
                if ($request->has('id_agama')) $manpower->id_agama = $request->id_agama;
                if ($request->has('id_nation')) $manpower->id_nation = $request->id_nation;
                if ($request->has('marital_status')) $manpower->marital_status = $request->marital_status;
                if ($request->has('native_status')) $manpower->native_status = $request->native_status;
                if ($request->has('address')) $manpower->address = $request->address;
                if ($request->has('id_state')) $manpower->id_state = $request->id_state;
                if ($request->has('id_city')) $manpower->id_city = $request->id_city;
                if ($request->has('id_parliament')) $manpower->id_parliament = $request->id_parliament;
                if ($request->has('id_dun')) $manpower->id_dun = $request->id_dun;
                if ($request->has('postcode')) $manpower->postcode = $request->postcode;

                $manpower->save();
            }

            // Load relationships
            $user->load([
                'manpower.state',
                'manpower.city',
                'manpower.parliament',
                'manpower.dun',
                'manpower.nation',
                'manpower.religion',
                'manpower.gender_relation'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating member', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified member (soft delete)
     */
    public function destroy($id)
    {
        try {
            $authUser = Auth::user();

            $user = User::where('id_level', 3)->find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member not found'
                ], 404);
            }

            // If user is Ketua Bahagian, check authorization
            if ($authUser->id_level == 4) {
                if ($user->manpower && $user->manpower->id_state != $authUser->id_state) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to delete this member'
                    ], 403);
                }
            }

            // Soft delete user (assuming User model uses SoftDeletes)
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Member deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting member', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting member',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
