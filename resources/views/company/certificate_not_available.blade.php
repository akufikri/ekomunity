@extends('home')
@section('title-dashboard', 'Company')
@section('title','View Certificate')

@section('breadcrumb')

<li class="breadcrumb-item active"><a href="/listCompanyActive">View Certificate</a></li>
<li class="breadcrumb-item active">Certificate</li>

@endsection
<style>
    .img-container-block {
        text-align: center;
    }
    .no-label {
        text-align: left;
    }
</style>
@section('content')
    <div class="card">
        
            <h5 style="color: blue; margin: 20px;">Certificate not available</h5>

    </div>
@endsection