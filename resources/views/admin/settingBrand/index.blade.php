@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a>Setting brand</a></li>
@endsection

@section('content')
    <div class="card card-outline card-info" style="height: 100vh">
        <div class="card-header">
            <a href="/setting-brand/detail" class="btn btn-info text-white btn-sm">
                <i data-lucide="settings" class="w-4 h-4"></i>
                Settings
            </a>
        </div>
        <div class="card-body">
            <iframe src="{{ env('APP_URL') }}/landing-v2" width="100%" height="100%" frameborder="0" allowfullscreen>
            </iframe>
        </div>
    </div>
@endsection

