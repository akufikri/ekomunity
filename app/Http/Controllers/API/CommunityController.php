<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\DetailCompany;
use App\Models\DetailManpower;
use App\Models\JoinCompany;
use App\Models\Blogpost;
use App\Models\ManpowerPosition;
use App\Notifications\MemberInvited;
use Illuminate\Support\Facades\Log;

class CommunityController extends Controller
{
    /**
     * GET /api/communities
     * Senarai semua komuniti dengan search dan pagination
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');

        $query = User::where('id_level', 2)
            ->where('status', 'ACTIVE')
            ->with(['detailCompany.state', 'detailCompany.city']);

        if ($search) {
            $query->whereHas('detailCompany', function ($q) use ($search) {
                $q->where('full_company_name', 'LIKE', "%{$search}%");
            });
        }

        $paginated = $query->paginate($perPage);

        // Get user's joined/waiting communities
        $joinedCommunityIds = [];
        if ($user) {
            $manpower = DetailManpower::where('id_user', $user->id)->first();
            if ($manpower) {
                $joinedCommunityIds = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
                    ->whereIn('status_approval', ['APPROVED', 'WAITING'])
                    ->pluck('id_detail_company')
                    ->toArray();
            }
        }

        $data = $paginated->getCollection()->map(function ($communityUser) use ($joinedCommunityIds) {
            $company = $communityUser->detailCompany;
            if (!$company) return null;

            $memberCount = JoinCompany::where('id_detail_company', $company->id_detail_company)
                ->where('status_approval', 'APPROVED')
                ->whereDate('expired_at', '>', date('Y-m-d'))
                ->count();

            $isJoined = in_array($company->id_detail_company, $joinedCommunityIds);

            return [
                'id'          => $communityUser->id,
                'name'        => $company->full_company_name,
                'registration'=> $company->company_registration,
                'description' => $company->mengenai,
                'slogan'      => $company->slogan,
                'logo'        => $company->logo_picture ? url('CompanyLogo/' . $company->logo_picture) : null,
                'banner'      => $company->banner ? url('CompanyBanner/' . $company->banner) : null,
                'state'       => optional($company->state)->state,
                'city'        => optional($company->city)->city,
                'joining_fee' => $company->joining_fee,
                'member_count'=> $memberCount,
                'is_joined'   => $isJoined,
            ];
        })->filter()->values();

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
     * POST /api/communities/{id}/join
     * Ahli memohon untuk menyertai komuniti
     */
    public function join(Request $request, $id)
    {
        $user = Auth::user();

        $communityUser = User::where('id_level', 2)->find($id);
        if (!$communityUser) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        $company = DetailCompany::where('id_user', $id)->first();
        if (!$company) {
            return response()->json(['message' => 'Maklumat komuniti tidak ditemukan'], 404);
        }

        $manpower = DetailManpower::where('id_user', $user->id)->first();
        if (!$manpower) {
            return response()->json(['message' => 'Profil ahli tidak ditemukan. Sila lengkapkan profil terlebih dahulu.'], 422);
        }

        $existing = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
            ->where('id_detail_company', $company->id_detail_company)
            ->whereNull('deleted_at')
            ->first();

        if ($existing) {
            if ($existing->status_approval === 'WAITING') {
                return response()->json(['message' => 'Permohonan anda sedang menunggu kelulusan'], 422);
            }
            if ($existing->status_approval === 'APPROVED') {
                return response()->json(['message' => 'Anda sudah menyertai komuniti ini'], 422);
            }
        }

        $join = new JoinCompany();
        $join->id_detail_manpower = $manpower->id_detail_manpower;
        $join->id_detail_company  = $company->id_detail_company;
        $join->joining_fee        = $company->joining_fee;
        $join->status_approval    = 'WAITING';
        $join->created_by         = $user->id;
        $join->save();

        return response()->json(['message' => 'Permohonan untuk menyertai komuniti telah dihantar'], 201);
    }

    /**
     * DELETE /api/communities/{id}/leave
     * Ahli keluar dari komuniti
     */
    public function leave(Request $request, $id)
    {
        $user = Auth::user();

        $company = DetailCompany::where('id_user', $id)->first();
        if (!$company) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        $manpower = DetailManpower::where('id_user', $user->id)->first();
        if (!$manpower) {
            return response()->json(['message' => 'Profil ahli tidak ditemukan'], 404);
        }

        $join = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
            ->where('id_detail_company', $company->id_detail_company)
            ->whereNull('deleted_at')
            ->first();

        if (!$join) {
            return response()->json(['message' => 'Anda bukan ahli komuniti ini'], 404);
        }

        $join->delete();

        return response()->json(['message' => 'Anda telah berjaya keluar dari komuniti']);
    }

    /**
     * GET /api/user/communities
     * Komuniti yang telah disertai oleh user yang login
     */
    public function userCommunities(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 15);

        $manpower = DetailManpower::where('id_user', $user->id)->first();
        if (!$manpower) {
            return response()->json([
                'success' => true,
                'data'    => [],
                'meta'    => ['current_page' => 1, 'last_page' => 1, 'total' => 0],
            ]);
        }

        $paginated = JoinCompany::with(['company.state', 'company.city'])
            ->where('id_detail_manpower', $manpower->id_detail_manpower)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $data = $paginated->getCollection()->map(function ($join) {
            $company = $join->company;
            if (!$company) return null;

            $communityUser = User::where('id_level', 2)
                ->where('id', $company->id_user)
                ->first();

            return [
                'id'             => optional($communityUser)->id,
                'name'           => $company->full_company_name,
                'logo'           => $company->logo_picture ? url('CompanyLogo/' . $company->logo_picture) : null,
                'banner'         => $company->banner ? url('CompanyBanner/' . $company->banner) : null,
                'state'          => optional($company->state)->state,
                'city'           => optional($company->city)->city,
                'joining_fee'    => $company->joining_fee,
                'status'         => $join->status_approval,
                'payment_status' => $join->payment_date ? ($join->expired_at > date('Y-m-d') ? 'PAID' : 'EXPIRED') : 'UNPAID',
                'expired_at'     => $join->expired_at,
                'joined_at'      => $join->created_at,
            ];
        })->filter()->values();

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
     * GET /api/communities/{id}/feed
     * Aktiviti dan pengumuman terkini bagi komuniti
     */
    public function feed(Request $request, $id)
    {
        $perPage = $request->input('per_page', 10);
        $user = Auth::user();

        $communityUser = User::where('id_level', 2)->find($id);
        if (!$communityUser) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        // Recent activities for this community
        $activities = \App\Models\Activity::where('community_id', $id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($activity) use ($user) {
                $isRsvp = false;
                if ($user) {
                    $isRsvp = \App\Models\Rsvp::where('activity_id', $activity->id)
                        ->where('user_id', $user->id)
                        ->exists();
                }
                $dateObj = \Carbon\Carbon::parse($activity->date);
                return [
                    'type'       => 'activity',
                    'id'         => $activity->id,
                    'title'      => $activity->title,
                    'date'       => $dateObj->format('Y-m-d'),
                    'date_display' => [
                        'month' => $dateObj->format('M'),
                        'day'   => $dateObj->format('d'),
                    ],
                    'location'   => $activity->location,
                    'is_rsvp'    => $isRsvp,
                    'created_at' => $activity->created_at,
                ];
            });

        // Recent announcements for this community
        $announcements = \App\Models\Blogpost::where('community_id', $id)
            ->where('status', 'PUBLISHED')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'type'       => 'announcement',
                    'id'         => $post->id,
                    'title'      => $post->title,
                    'slug'       => $post->slug,
                    'image'      => $post->image ? url('storage/' . $post->image) : null,
                    'tags'       => $post->tags,
                    'created_at' => $post->created_at,
                ];
            });

        // Merge and sort by created_at desc
        $feed = $activities->merge($announcements)
            ->sortByDesc('created_at')
            ->values();

        return response()->json([
            'success' => true,
            'data'    => $feed,
        ]);
    }

    /**
     * GET /api/communities/{id}/qr
     * QR Code Jemputan Komuniti
     */
    public function qrCode($id)
    {
        $user = User::where('id_level', 2)->find($id);

        if (!$user) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        $company = DetailCompany::where('id_user', $id)->first();

        if (!$company) {
            return response()->json(['message' => 'Maklumat komuniti tidak ditemukan'], 404);
        }

        // Generate share_link
        $shareLink = env("APP_URL") . "/persatuan/$company->key_reference";

        return response()->json([
            'share_link' => $shareLink,
            'key_reference' => $company->key_reference,
        ]);
    }

    /**
     * GET /api/communities/{id}
     * Maklumat Komuniti
     */
    public function show($id)
    {
        $user = User::where('id_level', 2)->find($id);

        if (!$user) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        $company = DetailCompany::with(['state', 'city'])->where('id_user', $id)->first();

        if (!$company) {
            return response()->json(['message' => 'Maklumat komuniti tidak ditemukan'], 404);
        }

        return response()->json([
            'id'                 => $user->id,
            'nama_pertubuhan'    => $company->full_company_name,
            'email'              => $user->email,
            'no_pendaftaran'     => $company->company_registration,
            'poskod'             => $company->postcode,
            'nama_wakil'         => $user->fullname,
            'email_wakil'        => $user->email,
            'no_telefon_wakil'   => $user->phone_number,
            'no_telefon_pejabat' => $company->phone_office,
            'daerah'             => optional($company->city)->city,
            'negeri'             => optional($company->state)->state,
            'no_fax'             => $company->fax_number,
            'laman_web'          => $company->company_website,
            'yuran'              => $company->joining_fee,
            'alamat'             => $company->address,
            'slogan'             => $company->slogan,
            'mengenai'           => $company->mengenai,
            'pautan'             => $company->custom_link ? url($company->custom_link) : null,
            'gambar_persatuan'   => $company->logo_picture ? url('CompanyLogo/' . $company->logo_picture) : null,
            'banner'             => $company->banner ? url('CompanyBanner/' . $company->banner) : null,
        ]);
    }

    /**
     * PUT /api/communities/{id}
     * Update Maklumat Komuniti
     */
    public function update(Request $request, $id)
    {
        $authUser = Auth::user();

        // Cari user level 2
        $user = User::where('id_level', 2)->find($id);
        if (!$user) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        // Cek authorization
        if ($authUser->id !== $user->id) {
            return response()->json(['message' => 'Tidak dibenarkan'], 403);
        }

        // Cari detail company
        $company = DetailCompany::where('id_user', $id)->first();
        if (!$company) {
            return response()->json(['message' => 'Maklumat komuniti tidak ditemukan'], 404);
        }

        // Handle custom link
        if ($request->filled('kostum_nama_pautan')) {
            $processedLink = preg_replace('/\s+/', '/', trim($request->kostum_nama_pautan));
            $exists = DetailCompany::where('custom_link', $processedLink)
                ->where('id_user', '!=', $id)
                ->exists();
            if ($exists) {
                return response()->json(['message' => 'Custom link sudah digunakan, silakan pilih link lain'], 422);
            }
            $company->custom_link = $processedLink;
        }

        // Update basic fields
        if ($request->filled('nama_pertubuhan'))    $company->full_company_name  = $request->nama_pertubuhan;
        if ($request->filled('email'))              $user->email                 = $request->email;
        if ($request->filled('no_pendaftaran'))     $company->company_registration = $request->no_pendaftaran;
        if ($request->filled('poskod'))             $company->postcode           = $request->poskod;
        if ($request->filled('no_telefon_pejabat')) $company->phone_office       = $request->no_telefon_pejabat;
        if ($request->filled('no_fax'))             $company->fax_number         = $request->no_fax;
        if ($request->filled('no_telefon'))         $user->phone_number          = $request->no_telefon;
        if ($request->filled('laman_web'))          $company->company_website    = $request->laman_web;
        if ($request->filled('yuran'))              $company->joining_fee        = $request->yuran;
        if ($request->filled('slogan'))             $company->slogan             = $request->slogan;
        if ($request->filled('mengenai'))           $company->mengenai           = $request->mengenai;
        if ($request->filled('alamat'))             $company->address            = $request->alamat;
        if ($request->filled('toyyibpay_category_code')) $company->collection_id = $request->toyyibpay_category_code;
        if ($request->filled('toyyibpay_secret_key'))    $company->secret_key    = $request->toyyibpay_secret_key;

        // Map state name to ID
        if ($request->filled('negeri')) {
            $state = \App\Models\State::where('state', $request->negeri)->first();
            if (!$state) {
                return response()->json(['message' => 'Negeri tidak ditemukan'], 404);
            }
            $company->id_state = $state->id_state;
        }

        // Map city name to ID
        if ($request->filled('daerah')) {
            if (!isset($state)) {
                return response()->json(['message' => 'Negeri harus diisi sebelum memilih daerah'], 422);
            }
            $city = \App\Models\City::where('city', $request->daerah)
                ->where('id_state', $company->id_state)
                ->first();
            if (!$city) {
                return response()->json(['message' => 'Daerah tidak ditemukan'], 404);
            }
            $company->id_city = $city->id_city;
        }

        // Upload logo (CompanyLogo)
        if ($request->hasFile('gambar_persatuan')) {
            $file = $request->file('gambar_persatuan');
            if ($file->isValid()) {
                $ext = $file->getClientOriginalExtension();
                $name = time() . '_' . Str::random(6) . '.' . $ext;
                $file->move(public_path('CompanyLogo'), $name);
                $company->logo_picture = $name;
            } else {
                return response()->json(['message' => 'File logo tidak valid'], 422);
            }
        }

        // Upload banner (CompanyBanner)
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            if ($file->isValid()) {
                $ext = $file->getClientOriginalExtension();
                $name = time() . '_' . Str::random(6) . '.' . $ext;
                $file->move(public_path('CompanyBanner'), $name);
                $company->banner = $name;
            } else {
                return response()->json(['message' => 'File banner tidak valid'], 422);
            }
        }

        // Simpan data
        $user->save();
        $company->save();

        return response()->json(['message' => 'Maklumat komuniti berjaya dikemaskini']);
    }


    /**
     * GET /api/user/community-members
     * Senarai ahli komuniti berdasarkan komuniti auth user (tanpa perlu community ID)
     */
    public function myMembers(Request $request)
    {
        $user = Auth::user();
        $communityId = null;

        // Admin (id_level=2 / CAWANGAN): find community via DetailCompany
        if ($user->id_level == 2) {
            $company = DetailCompany::where('id_user', $user->id)->first();
            $communityId = optional($company)->id_detail_company;
        } else {
            // Member: find via DetailManpower -> JoinCompany
            $manpower = DetailManpower::where('id_user', $user->id)->first();

            if ($manpower) {
                // Some members have id_detail_company set directly
                $communityId = $manpower->id_detail_company;

                // Fallback: check JoinCompany
                if (!$communityId) {
                    $join = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
                        ->whereNull('deleted_at')
                        ->latest()
                        ->first();
                    $communityId = optional($join)->id_detail_company;
                }
            }
        }

        if (!$communityId) {
            return response()->json(['data' => [], 'meta' => ['current_page' => 1, 'last_page' => 1, 'total' => 0]]);
        }

        // Resolve community admin user ID for invite/update endpoints
        $communityUserId = ($user->id_level == 2)
            ? $user->id
            : optional(DetailCompany::where('id_detail_company', $communityId)->first())->id_user;

        return $this->membersQuery($request, $communityId, $communityUserId);
    }

    /**
     * GET /api/communities/{id}/members
     * Senarai Ahli dengan search dan pagination (id = User.id komuniti, id_level=2)
     */
    public function members(Request $request, $id)
    {
        $company = DetailCompany::where('id_user', $id)->first();

        if (!$company) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        return $this->membersQuery($request, $company->id_detail_company);
    }

    /**
     * Shared query for members — mirrors web getDataAhliPersatuan
     * Uses JoinCompany (not DetailManpower) since id_detail_company lives there
     */
    private function membersQuery(Request $request, $idDetailCompany, $communityUserId = null)
    {
        $query = JoinCompany::with([
            'manpower.user',
            'manpower.status_native',
        ])->where('id_detail_company', $idDetailCompany)
            ->whereNull('deleted_at')
            ->whereDate('expired_at', '>', date('Y-m-d'));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('manpower.user', function ($uq) use ($search) {
                    $uq->where('fullname', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('phone_number', 'LIKE', "%$search%");
                })->orWhereHas('manpower', function ($mq) use ($search) {
                    $mq->where('ic_number', 'LIKE', "%$search%");
                });
            });
        }

        $filter = $request->input('filter', 'all');
        if ($filter === 'today') {
            $query->whereDate('created_at', date('Y-m-d'));
        } elseif ($filter === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($filter === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $paginated = $query->orderBy('created_at', 'DESC')->paginate(10);

        $data = $paginated->getCollection()->map(function ($join) {
            $user     = optional($join->manpower)->user;
            $manpower = $join->manpower;
            $name     = optional($user)->fullname ?? '';

            $words    = array_filter(explode(' ', trim($name)));
            $initials = count($words) >= 2
                ? strtoupper(substr(array_values($words)[0], 0, 1) . substr(array_values($words)[1], 0, 1))
                : strtoupper(substr($name, 0, 2));

            $invoice = $join->payment_date ? 'PAID' : 'UNPAID';

            return [
                'id'       => optional($user)->id,
                'name'     => $name,
                'initials' => $initials,
                'email'    => optional($user)->email,
                'phone'    => optional($user)->phone_number,
                'ic'       => optional($manpower)->ic_number,
                'role'     => optional($user)->id_level == 2 ? 'admin' : 'member',
                'invoice'  => $invoice,
                'status'   => optional($user)->status === 'ACTIVE' ? 'Aktif' : 'Tidak Aktif',
            ];
        });

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page'      => $paginated->currentPage(),
                'last_page'         => $paginated->lastPage(),
                'total'             => $paginated->total(),
                'community_user_id' => $communityUserId,
            ],
        ]);
    }

    /**
     * PUT /api/communities/{id}/members/{member_id}
     * Update data Ahli
     */
    public function updateMember(Request $request, $id, $memberId)
    {
        $authUser = Auth::user();

        $communityUser = User::where('id_level', 2)->find($id);
        if (!$communityUser) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        if ($authUser->id !== $communityUser->id) {
            return response()->json(['message' => 'Tidak dibenarkan'], 403);
        }

        $company = DetailCompany::where('id_user', $id)->first();

        $joinExists = JoinCompany::where('id_detail_company', $company->id_detail_company)
            ->whereHas('manpower', function ($q) use ($memberId) {
                $q->where('id_user', $memberId);
            })->exists();

        if (!$joinExists) {
            return response()->json(['message' => 'Ahli tidak ditemukan dalam komuniti ini'], 404);
        }

        $member   = User::find($memberId);
        $manpower = DetailManpower::where('id_user', $memberId)->first();

        if ($request->filled('name'))   $member->fullname     = $request->name;
        if ($request->filled('email'))  $member->email        = $request->email;
        if ($request->filled('phone'))  $member->phone_number = $request->phone;
        if ($request->filled('status')) {
            $member->status = $request->status === 'Aktif' ? 'ACTIVE' : 'INACTIVE';
        }
        $member->save();

        if ($manpower) {
            if ($request->filled('ic'))          $manpower->ic_number     = $request->ic;
            if ($request->filled('bumiputera'))  $manpower->native_status = $request->bumiputera;
            $manpower->save();
        }

        if ($request->filled('invoice')) {
            $join = JoinCompany::where('id_detail_company', $company->id_detail_company)
                ->whereHas('manpower', function ($q) use ($memberId) {
                    $q->where('id_user', $memberId);
                })->first();
            if ($join && $request->invoice === 'PAID' && $join->payment_date === null) {
                $join->payment_date = now();
                $join->save();
            }
        }

        return response()->json(['message' => 'Maklumat ahli berjaya dikemaskini']);
    }

    /**
     * POST /api/communities/{id}/invite
     * Hantar Jemputan kepada Ahli Baharu
     */
    public function invite(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $authUser = Auth::user();

        $communityUser = User::where('id_level', 2)->find($id);
        if (!$communityUser) {
            return response()->json(['message' => 'Komuniti tidak ditemukan'], 404);
        }

        if ($authUser->id !== $communityUser->id) {
            return response()->json(['message' => 'Tidak dibenarkan'], 403);
        }

        $memberUser = User::where('email', $request->email)->first();
        if (!$memberUser) {
            return response()->json(['message' => 'Akun Ahli tidak ditemukan'], 404);
        }

        $manpower = DetailManpower::where('id_user', $memberUser->id)->first();
        if (!$manpower) {
            return response()->json(['message' => 'Maklumat ahli tidak ditemukan'], 404);
        }

        $company = DetailCompany::where('id_user', $id)->first();

        $alreadyJoin = JoinCompany::where('id_detail_manpower', $manpower->id_detail_manpower)
            ->where('id_detail_company', $company->id_detail_company)
            ->first();

        if ($alreadyJoin) {
            if ($alreadyJoin->status_approval === 'WAITING') {
                return response()->json(['message' => 'Ahli sudah dijemput, menunggu kelulusan'], 422);
            }
            if ($alreadyJoin->status_approval === 'APPROVED') {
                return response()->json(['message' => 'Ahli sudah menyertai komuniti ini'], 422);
            }
        }

        $join = new JoinCompany();
        $join->id_detail_manpower = $manpower->id_detail_manpower;
        $join->id_detail_company  = $company->id_detail_company;
        $join->joining_fee        = $company->joining_fee;
        $join->status_approval    = 'WAITING';
        $join->created_by         = $authUser->id;
        $join->save();

        try {
            $this->sendEmailJemputanJoinCompany($join->id);
        } catch (\Exception) {
            // Email failure is non-blocking
        }

        // Notify the invited member
        try {
            $memberUser->notify(new MemberInvited($company));
        } catch (\Exception $e) {
            Log::error('Failed to send MemberInvited notification', ['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Jemputan berjaya dihantar']);
    }
}
