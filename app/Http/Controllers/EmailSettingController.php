<?php

namespace App\Http\Controllers;

use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmailSettingController extends Controller
{
    public function getData(Request $request)
    {
        $query = EmailSetting::query();

        return DataTables::of($query)
            ->addIndexColumn() // auto numbering
            ->editColumn('notif_enabled', function ($row) {
                return $row->notif_enabled ? 'Enabled' : 'Disabled';
            })
            ->editColumn('notif_types', function ($row) {
                return $row->notif_types ? implode(', ', $row->notif_types) : '-';
            })
            ->addColumn('action', function ($row) {
                return '<button type="button" class="btn btn-sm btn-primary editBtn" data-id="' . $row->id . '">Edit</button>';
            })
            ->rawColumns(['action']) // biar button dirender sebagai HTML
            ->make(true);
    }
    public function updateOrStore(Request $request)
    {
        $validated = $request->validate([
            'notif_enabled' => 'required|boolean',
            'notif_types'   => 'nullable|string', // karena kamu pakai input text dengan koma
            'sender_name'   => 'nullable|string|max:100',
            'sender_email'  => 'required|email|unique:tb_email_setting,sender_email,' . $request->id,
            'admin_email'   => 'nullable|email',
        ]);

        // convert notif_types string jadi array kalau perlu
        if ($request->notif_types) {
            $validated['notif_types'] = explode(',', str_replace(' ', '', $request->notif_types));
        }

        $setting = EmailSetting::updateOrCreate(
            ['id' => $request->id], // cari by id dari request
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => $request->id ? 'Email setting updated!' : 'Email setting created!',
            'data' => $setting
        ]);
    }


    public function show($id)
    {
        $data = EmailSetting::findOrFail($id);
        return response()->json($data);
    }

    public function index()
    {
        return view('admin.emailSetting.index');
    }
}
