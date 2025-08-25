<?php $level = \Auth::user()->id_level; ?>

@if($level == 3)

    <?php
        $maklumatPribadi = $dataValidation->photo == null || $dataValidation->fullname == null || $dataValidation->phone_number == null || $dataValidation->email == null || $dataValidation->manpower->id_city == null || $dataValidation->manpower->id_state == null || $dataValidation->manpower->id_country == null || $dataValidation->manpower->id_nation == null || $dataValidation->manpower->id_agama == null || $dataValidation->manpower->postcode == null || $dataValidation->manpower->address == null || $dataValidation->manpower->marital_status == null || $dataValidation->manpower->native_status == null;
        $maklumatPendidikan = $dataValidation->manpower->id_status_education == null || $dataValidation->manpower->education_field == null;
        $maklumatPerniagaan = $dataValidation->manpower->name_of_business == null || $dataValidation->manpower->picture_of_business == null || $dataValidation->manpower->picture_product == null || $dataValidation->manpower->business_type == null || $dataValidation->manpower->business_address == null || $dataValidation->manpower->business_activity === null || $dataValidation->manpower->business_phone == null || $dataValidation->manpower->business_income == null || $dataValidation->manpower->business_email == null;
   ?>

    @if($maklumatPribadi)
    <div class="alert alert-danger alert-dismissible">
        <h5><i class="icon fas fa-id-card"></i> Lengkapkan Maklumat Peribadi. <a style="color:#ff0018;" href="/personalDetail/{{$dataValidation->id}}/edit">Klik Sini</a></h5>
    </div>
    @endif

    @if($maklumatPendidikan)
    <div class="alert alert-danger alert-dismissible">
        <h5><i class="icon fas fa-graduation-cap"></i> Lengkapkan Maklumat Pendidikan. <a style="color:#ff0018;" href="/editMaklumatPendidikan/{{$dataValidation->id}}">Klik Sini</a></h5>
    </div>
    @endif

    {{-- @if($maklumatPerniagaan)
    <div class="alert alert-danger alert-dismissible">
        <h5><i class="icon fas fa-shopping-bag"></i> Lengkapkan Maklumat Perniagaan. <a style="color:#ff0018;" href="/editMaklumatPerniagaan/{{$dataValidation->id}}">Klik Sini</a></h5>
    </div>
    @endif --}}

    {{-- @if(!$maklumatPribadi && !$maklumatPendidikan && !$maklumatPerniagaan  && $dataValidation->manpower->business_income_monthly == null)
    <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-check"></i> Mohon luangkan waktu anda untuk mengisi survey dari kami, <a style="color:#119ff2;" target="_blank" href="/register_ahli/step_five">Klik Sini</a></h5>
    </div>
    @endif --}}
@endif
