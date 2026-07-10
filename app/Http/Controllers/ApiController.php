<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use SebastianBergmann\CodeUnit\TraitMethodUnit;
use Validator;
use Exception;
use Carbon\Carbon;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\WorkType;
use App\Models\Position;
use App\Models\Segment;
use App\Models\School;
use App\Models\TypeSchool;
use App\Models\CompanyType;
use App\Models\StatusNative;
use App\Models\DetailManpower;
use App\Models\User;
use App\Models\Parliament;
use App\Models\Dun;
use App\Models\Product;
use App\Models\BusinessType;
use App\Models\Gender;
use App\Models\Nation;
use App\Models\MaritalStatus;
use App\Models\BusinessActivity;
use App\Models\Religion;
use App\Models\Cawangan;


class ApiController extends Controller
{
	public function projectionDataAhli(Request $r)
	{

		$total_ahli_overall = DetailManpower::get()->count();
		$total_ahli_pemilik_produk = Product::distinct('id_detail_manpower')->count('id_detail_manpower');
		$total_ahli_geran = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('q_financing', 'Ya')->get()->count();
		$total_ahli_perniaga_se = 0;

		$income_weekly_a = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_income_weekly', '<', '100')->get()->count();
		$income_monthly_a = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_income_monthly', '<', '1000')->get()->count();

		$income_weekly_b = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->whereBetween('business_income_weekly', ['100', '500'])->get()->count();
		$income_monthly_b = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->whereBetween('business_income_monthly', ['1000', '5000'])->get()->count();

		$income_weekly_c = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_income_weekly', '>', '500')->get()->count();
		$income_monthly_c = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_income_monthly', '>', '5000')->get()->count();

		$weekly = [];
		$weekly[] = ['label' => 'DIBAWAH RM100', 'total' => $income_weekly_a];
		$weekly[] = ['label' => 'RM100 - RM500', 'total' => $income_weekly_b];
		$weekly[] = ['label' => 'DIATAS RM500', 'total' => $income_weekly_c];

		$monthly = [];
		$monthly[] = ['label' => 'DIBAWAH RM1000', 'total' => $income_monthly_a];
		$monthly[] = ['label' => 'RM1000 - RM5000', 'total' => $income_monthly_b];
		$monthly[] = ['label' => 'DIATAS RM5000', 'total' => $income_monthly_c];

		$total_income_ahli = [
			'weekly' => $weekly,
			'monthly' => $monthly,
		];


		return compact('total_ahli_overall', 'total_ahli_pemilik_produk', 'total_ahli_geran', 'total_ahli_perniaga_se', 'total_income_ahli');
	}

	public function projectionDataBusinessType()
	{
		$total_ahli_business_type_all = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_type', '!=', null)->get()->count();

		$business_type = BusinessType::select('id_business_type', 'business_type')->where('is_active', 'ENABLE')->get();

		foreach ($business_type as $item) {
			$total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_type', $item->id_business_type)->get()->count();
			$sum = round(($total / $total_ahli_business_type_all) * 100, 2);
			$item->percentage_value = $sum;
			$item->percentage_label = "$sum%";
		}

		return compact('business_type');
	}

	public function projectionDataGender()
	{

		$total_ahli_gender_all = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('gender', '!=', null)->get()->count();

		$gender = Gender::select('id_gender', 'gender')->where('is_active', 'ENABLE')->get();

		foreach ($gender as $item) {
			$total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('gender', $item->id_gender)->get()->count();
			$sum = round(($total / $total_ahli_gender_all) * 100, 2);
			$item->percentage_value = $sum;
			$item->percentage_label = "$sum%";
		}

		return compact('gender');
	}

	public function projectionDataNation()
	{

		$total_ahli_nation_all = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('id_nation', '!=', null)->get()->count();

		$nation = Nation::select('id_nation', 'nation')->where('is_active', 'ENABLE')->get();

		foreach ($nation as $item) {
			$total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('id_nation', $item->id_nation)->get()->count();
			$sum = round(($total / $total_ahli_nation_all) * 100, 2);
			$item->percentage_value = $sum;
			$item->percentage_label = "$sum%";
		}

		return compact('nation');
	}

	public function projectionDataMarital()
	{
		$total_ahli_marital_all = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('marital_status', '!=', null)->get()->count();

		$marital = MaritalStatus::select('id_marital_status', 'marital_status')->where('is_active', 'ENABLE')->get();

		foreach ($marital as $item) {
			$total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('marital_status', $item->id_marital_status)->get()->count();
			$sum = round(($total / $total_ahli_marital_all) * 100, 2);
			$item->percentage_value = $sum;
			$item->percentage_label = "$sum%";
		}

		return compact('marital');
	}

	public function projectionDataBusinessActivity()
	{

		$total_ahli_business_activity_all = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_activity', '!=', null)->get()->count();

		$business_activity = BusinessActivity::select('id_business_activity', 'business_activity')->where('is_active', 'ENABLE')->get();

		foreach ($business_activity as $item) {
			$item->total = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('business_activity', $item->id_business_activity)->get()->count();
			// $sum = round(($total/$total_ahli_business_activity_all)*100, 2);
			// $item->percentage_value = $sum;
			// $item->percentage_label = "$sum%";
		}

		return compact('business_activity');
	}

	public function projectionDataAge()
	{

		$ahli_age_all = DetailManpower::select('id_detail_manpower', 'ic_number')->where('step_registration', DetailManpower::$stepRegistration)->where('ic_number', '!=', null)->get();
		$total_ahli_age_all = DetailManpower::where('step_registration', DetailManpower::$stepRegistration)->where('ic_number', '!=', null)->get()->count();


		// return $ahli_age_all;

		// 18-30 tahun
		// 30-50 tahun
		// 50 tahun keatas
		$range_age_1 = 0;
		$range_age_2 = 0;
		$range_age_3 = 0;
		foreach ($ahli_age_all as $item) {
			$digit_1_ic = substr($item->ic_number, 0, 1);
			if ($digit_1_ic == 0 || $digit_1_ic == 1) {
				$birth_year = "20" . substr($item->ic_number, 0, 2);
			} else {
				$birth_year = "19" . substr($item->ic_number, 0, 2);
			}

			$current_year = Carbon::now()->format('Y');
			$age = (int)$current_year - (int)$birth_year;

			if ($age >= 18 && $age <= 30) {
				$range_age_1 = $range_age_1 + 1;
			} else if ($age > 30 && $age < 50) {
				$range_age_2 = $range_age_2 + 1;
			} else if ($age >= 50) {
				$range_age_3 = $range_age_3 + 1;
			}
		}

		$pecent_age_1 = round(($range_age_1 / $total_ahli_age_all) * 100, 2);
		$pecent_age_1_value = $pecent_age_1;
		$pecent_age_1_label = "$pecent_age_1%";

		$pecent_age_2 = round(($range_age_2 / $total_ahli_age_all) * 100, 2);
		$pecent_age_2_value = $pecent_age_2;
		$pecent_age_2_label = "$pecent_age_2%";

		$pecent_age_3 = round(($range_age_3 / $total_ahli_age_all) * 100, 2);
		$pecent_age_3_value = $pecent_age_3;
		$pecent_age_3_label = "$pecent_age_3%";

		$age = [];
		$age[] = ['label' => '18-30 tahun', 'percentage' => $pecent_age_1_value, 'percentage_label' => $pecent_age_1_label];
		$age[] = ['label' => '30-50 tahun', 'percentage' => $pecent_age_2_value, 'percentage_label' => $pecent_age_2_label];
		$age[] = ['label' => '50 tahun keatas', 'percentage' => $pecent_age_3_value, 'percentage_label' => $pecent_age_3_label];


		return compact('age');
	}
	public function verifyAhli(Request $r)
	{

		if (!$r->code) {
			return $this->commitResponse('Nomor Sijil harus diisi!');
		}

		$data = DetailManpower::with('user')->where('number_certificate', 'LIKE', '%' . $r->code . '%')->first();

		if (!$data) {
			return $this->commitResponse('Nomor Sijil Pendaftaran tidak ditemukan!');
		}

		return $this->commitResponse('Selamat Nomor Sijil Pendaftaran ditemukan!', true, $data);
	}

	public function getDataAhli($email)
	{

		$data = User::select('id', 'fullname', 'phone_number', 'email')
			->with(['manpower' => function ($query) {
				$query->select('id_detail_manpower', 'id_user', 'business_license_no', 'key_reference', 'number_certificate');
			}])->where('email', $email)->first();

		if (!$data) {
			return $this->commitResponse('Data Ahli not found on datappk!');
			// return $this->commitResponse('Data Ahli not found on datappk!');
		}

		$data->linkProfileDigital = env("APP_URL") . "/id/" . $data->manpower->key_reference;

		// $detail = DetailManpower::select('')->where('id_user', $data->id)->first();

		return $this->commitResponse('Get Data Ahli Successfuly!', true, $data);
	}

	public function updateAhli(Request $request)
	{

		$email = $request->email;

		$data = User::where('email', $email)->first();

		if (!$data) {
			return $this->commitResponse('Data Ahli not found on datappk!', true);
			// return $this->commitResponse('Data Ahli not found on datappk!');
		}

		$detail = DetailManpower::where('id_user', $data->id)->first();

		$cek_email = User::where('email', $request->email)->where('id', '!=', $detail->id_user)->first();

		if ($cek_email) {
			return $this->commitResponse('Email already exist on datappk!');
		}

		if ($request->phone_number) {
			$cek_phone = User::where('phone_number', $request->phone_number)->where('id', '!=', $detail->id_user)->first();
			if ($cek_phone) {
				return $this->commitResponse('Phone Number already exist on datappk!');
			}
		}

		if ($request->fullname) $data->fullname = $request->fullname;
		if ($request->phone_number) $data->phone_number = $request->phone_number;

		if ($request->name_of_business) $detail->name_of_business = $request->name_of_business;
		if ($request->business_address) $detail->business_address = $request->business_address;
		if ($request->business_license_no) $detail->business_license_no = $request->business_license_no;
		if ($request->business_phone) $detail->business_phone = $request->business_phone;
		if ($request->postcode) $detail->postcode = $request->postcode;
		if ($request->id_country) $detail->id_country = $request->id_country;
		if ($request->id_state) $detail->id_state = $request->id_state;
		if ($request->id_city) $detail->id_city = $request->id_city;

		$detail->save();
		$data->save();

		return $this->commitResponse('Update Data Successfuly!', true, $data);
	}

	public function getCountry(Request $r)
	{
		$s = Country::where('id_country', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('country_name', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getCompanyType(Request $r)
	{
		$s = CompanyType::where('id_company_type', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('company_type', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getState(Request $r)
	{
		$c = State::where('id_state', '>', '0')->where('is_active', 'ENABLE');
		if ($r->id_country) {
			$c = $c->where('id_country', $r->id_country);
		}
		if ($r->q) {
			$c = $c->where('state', 'LIKE', '%' . $r->q . '%');
		}
		if ($r->country_name) {
			$country = Country::where('country_name', $r->country_name)->first();
			$c = $c->where('id_country', $country->id_country);
		}
		$c = $c->get();

		return response()->json($c);
	}

	// public function getCity(Request $r)
	// {
	//     $c = City::where('id_city','>','0')->where('is_active','ENABLE');
	//     if($r->id_state){
	//         $c = $c->where('id_state', $r->id_state);
	//     }
	//     if($r->q){
	//         $c = $c->where('city', 'LIKE', '%'. $r->q .'%');
	//     }
	//     if($r->state_name) {
	//         $state = State::where('state_name', $r->state_name)->first();
	//         $c = $c->where('id_state', $country->id_state);
	//     }
	//     $c = $c->get();

	//     return response()->json($c);
	// }

	public function getCity(Request $r)
	{
		$query = City::where('id_city', '>', 0)
			->where('is_active', 'ENABLE');

		if ($r->id_state) {
			$query->where('id_state', $r->id_state);
		}

		if ($r->q) {
			$query->where('city', 'LIKE', '%' . $r->q . '%');
		}

		if ($r->state_name) {
			$state = State::where('state_name', $r->state_name)->first();
			if ($state) {
				$query->where('id_state', $state->id_state);
			}
		}

		if ($r->boolean('is_pagination')) {

			$perPage = $r->per_page ?? 10;
			$page = $r->page ?? 1;

			$cities = $query->paginate($perPage, ['*'], 'page', $page);

			return response()->json([
				'success' => true,
				'is_pagination' => true,
				'data' => $cities->items(),
				'meta' => [
					'current_page' => $cities->currentPage(),
					'next_page' => $cities->currentPage() < $cities->lastPage() ? $cities->currentPage() + 1 : null,
					'prev_page' => $cities->currentPage() > 1 ? $cities->currentPage() - 1 : null,
					'last_page' => $cities->lastPage(),
					'per_page' => $cities->perPage(),
					'total' => $cities->total()
				]
			]);
		}

		$cities = $query->get();

		return response()->json($cities);
	}



	public function getParliament(Request $r)
	{
		$c = Parliament::where('id', '>', '0')->where('is_active', 'ENABLE');
		if ($r->id_state) {
			$c = $c->where('id_state', $r->id_state);
		}
		if ($r->q) {
			$c = $c->where('parliament', 'LIKE', '%' . $r->q . '%');
		}
		if ($r->state_name) {
			$state = State::where('state_name', $r->state_name)->first();
			$c = $c->where('id_state', $country->id_state);
		}
		$c = $c->get();

		return response()->json($c);
	}

	public function getDun(Request $r)
	{
		$c = Dun::where('id', '>', '0')->where('is_active', 'ENABLE');
		if ($r->id_parliament) {
			$c = $c->where('id_parliament', $r->id_parliament);
		}
		if ($r->q) {
			$c = $c->where('dun', 'LIKE', '%' . $r->q . '%');
		}

		$c = $c->get();

		return response()->json($c);
	}

	public function getWorkType(Request $r)
	{
		$s = WorkType::where('id_work_type', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('work_type', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getPosition(Request $r)
	{
		$s = Position::where('id_position', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('position', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getSegment(Request $r)
	{
		$s = Segment::where('id_segment', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('segment', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getTypeSchool(Request $r)
	{
		$s = TypeSchool::where('id_type_school', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('type_school', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getSchool(Request $r)
	{
		$c = School::where('id_school', '>', '0')->where('is_active', 'ENABLE');
		if ($r->id_type_school) {
			$c = $c->where('id_type_school', $r->id_type_school);
		}
		if ($r->q) {
			$c = $c->where('school', 'LIKE', '%' . $r->q . '%');
		}
		$c = $c->get();

		return response()->json($c);
	}

	public function getNative(Request $r)
	{
		$c = StatusNative::where('id_status_native', '>', '0');
		if ($r->id_status_native) {
			$c = $c->where('id_status_native', $r->id_status_native);
		}
		if ($r->q) {
			$c = $c->where('status_native', 'LIKE', '%' . $r->q . '%');
		}
		$c = $c->get();

		return response()->json($c);
	}

	public function getNation(Request $r)
	{
		$s = Nation::where('id_nation', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('nation', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getReligion(Request $r)
	{
		$s = Religion::where('id_religion', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('religion', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getCawangan(Request $r)
	{
		$s = Cawangan::where('id_cawangan', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('name', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}

	public function getGender(Request $r)
	{
		$s = Gender::where('id_gender', '>', '0')->where('is_active', 'ENABLE');
		if ($r->q) {
			$s = $s->where('gender', 'LIKE', '%' . $r->q . '%');
		}
		$s = $s->get();

		return response()->json($s);
	}
}
