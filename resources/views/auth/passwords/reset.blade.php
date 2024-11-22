@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: #d9e7f4; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: 1px solid #ccc; max-width: 600px;">
                <div class="card-header">{{ __('Forgot Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.forgot') }}">
                        @csrf

                        @if(session('success'))
                            <div class="alert alert-danger" role="alert">
                                <p class="font-bold">Success!</p>
                                <p>Please check email for new password!</p>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn custom-btn-color w-100">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
 body {
    background-color: #99d9f9;
}

.custom-btn-color {
        background-color: #99d9f9; 
        border-color: #99d9f9; 
        color: #000; 
    }
    .custom-btn-color:hover {
        background-color: #0056b3; 
        border-color: #0056b3;
        color: #fff; 
    }
    </style>
@endsection
