<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DetailCompany;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    public function home()
    {
        return view('landingpage.pages.index');
    }

    public function blogPost()
    {
        return view('landingpage.pages.post');
    }

    public function detailPost($slug)
    {
        return view('landingpage.pages.detail');
    }

    public function direktori()
    {
        return view('landingpage.pages.direktori');
    }

    public function viewMap()
    {
        // Ambil semua city yang aktif
        $cities = City::select('id_city', 'city', 'latitude', 'longitude')
            ->where('is_active', 'ENABLE')
            ->get();

        // Ambil data company dengan relasi user dan city
        $companies = DetailCompany::with([
            'user:id,fullname,kod_cawangan',
            'city:id_city,city,latitude,longitude'
        ])
            ->where('step_registration', DetailCompany::$stepRegistration)
            ->where('status_approval', 'APPROVED')
            ->get();

        // Group companies berdasarkan city
        $cityData = [];

        foreach ($companies as $company) {
            if (!$company->city) continue;

            $cityId = $company->city->id_city;

            if (!isset($cityData[$cityId])) {
                $cityData[$cityId] = [
                    'city_id' => $cityId,
                    'city_name' => $company->city->city,
                    'latitude' => $company->city->latitude,
                    'longitude' => $company->city->longitude,
                    'companies_count' => 0,
                    'companies' => []
                ];
            }

            $cityData[$cityId]['companies'][] = [
                'company_name' => $company->user->fullname,
                'email' => $company->email_company,
                'phone' => $company->phone_office,
                'address' => $company->address,
                'user_name' => $company->user->fullname ?? 'Tidak Ada',
                'kod_cawangan' => $company->user->kod_cawangan ?? null,
                'postcode' => $company->postcode,
                'company_registration' => $company->company_registration,
            ];

            $cityData[$cityId]['companies_count']++;
        }

        // Convert array keyed by cityId ke indexed array
        $mapData = array_values($cityData);

        return view('viewmap.cawanganMap', compact('mapData'));
    }
}
