@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-start" style="min-height: 50vh; padding-top: 5px;">

    <div class="mb-4">
        <img src="{{ asset('images/logoo.png') }}" alt="Logo" style="width: 200px; height: auto;">
    </div>

    <div class="w-100 d-flex justify-content-center">
        <div class="w-40" style="background-color: #d9e7f4; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: 1px solid #ccc; max-width: 400px;">

            
            <h3 class="text-center mb-4">Login</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong> {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                    </div>
                </div>
                <div class="mb-3 d-flex align-items-center justify-content-end">
                    <a href="{{ route('password.forgot.view') }}"  class="" style="font-size: 10pt;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn custom-btn-color w-100">Login</button>
            </form>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-color: #99d9f9;
    }
    .input-group-text {
        background-color: #e9ecef; 
    }
    .input-group-text i {
        color: #007bff; 
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
