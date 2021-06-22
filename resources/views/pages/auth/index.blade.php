@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="row justify-content-center form-bg-image mt-5">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <div class="text-center text-md-center mb-4 mt-md-0">
                    <img
                        src="{{asset('assets/img/oksetda_absensi_250px.png')}}"
                        height="75"
                        alt="cleverlabs-logo"
                        class="mb-4"
                    >
                    <h1 class="mb-0 h3">Electronic Attendance</h1>
                    <p>
                        Welcome back, please use your
                        <a href="#" class="fw-bold">credentials</a>
                        <br> to access your account
                    </p>
                </div>

                @livewire('auth.login-action-form')

                <div class="d-flex justify-content-center align-items-center mt-4">
                    <span class="fw-normal">
                        Have an issue?
                        <a href="#" class="fw-bold">Help me!</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-style')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection
