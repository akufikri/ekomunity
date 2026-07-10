@extends('landingpage.layout.app')

@section('title', 'Delete Account - eKomuniti')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h1 class="h3 fw-bold">Delete Account</h1>
                        <p class="text-muted">Request to permanently delete your eKomuniti account</p>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h5 class="fw-semibold">What happens when you delete your account?</h5>
                        <ul class="list-unstyled mt-3">
                            <li class="mb-2">
                                <i class="bi bi-x-circle text-danger me-2"></i>
                                All personal data (profile, membership history, payment records) permanently removed
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-x-circle text-danger me-2"></i>
                                Access to all eKomuniti organisation portala and features revoked
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-x-circle text-danger me-2"></i>
                                Your membership in all organisations terminated
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-x-circle text-danger me-2"></i>
                                Email address freed for new registration
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4 class="fw-semibold">How to request account deletion</h4>
                        <ol class="mt-3">
                            <li class="mb-2">Log in to your eKomuniti account</li>
                            <li class="mb-2">Go to <strong>Profile &gt; Settings</strong></li>
                            <li class="mb-2">Click <strong>Request Account Deletion</strong></li>
                            <li class="mb-2">Confirm your request via the email verification link</li>
                        </ol>
                    </div>

                    <div class="alert alert-info bg-info bg-opacity-10 border border-info border-opacity-25 rounded-3">
                        <div class="d-flex">
                            <i class="bi bi-info-circle fs-4 me-3"></i>
                            <div>
                                <h5 class="fw-semibold mb-1">Processing Time</h5>
                                <p class="mb-0">Account deletion requests are processed within <strong>7 working days</strong> after email verification. You will receive a confirmation email once the process is complete.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="fw-semibold">Need help?</h4>
                        <p class="text-muted">
                            Contact us at <a href="mailto:support@ekomuniti.app">support@ekomuniti.app</a> for any questions regarding account deletion.
                        </p>
                    </div>

                    <hr>

                    <div class="text-center">
                        <a href="/" class="btn btn-primary px-4">Back to Home</a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    eKomuniti &mdash; Satu platform, Semua komuniti
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    body {
        background-color: #f5f7fa;
    }
    .card {
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
</style>
@endpush