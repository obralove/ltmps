@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center" style="font-family: Georgia, serif;">
        Edit Vaccination Record for Livestock: {{ $livestock->name }}
    </h2>

    <div class="d-flex justify-content-center">
        <div class="w-50" style="background-color: #d9e7f4; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('vaccinations.update', $vaccination->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ Crypt::encrypt($vaccination->id) }}">

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $vaccination->date) }}" required>
                    </div>
                    @error('date')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="vaccination" class="form-label">Vaccination</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                        <input type="text" class="form-control @error('vaccination') is-invalid @enderror" id="vaccination" name="vaccination" value="{{ old('vaccination', $vaccination->vaccination) }}" required>
                    </div>
                    @error('vaccination')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="booster" class="form-label">Booster</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                        <textarea class="form-control @error('booster') is-invalid @enderror" id="booster" name="booster" rows="4">{{ old('booster', $vaccination->booster) }}</textarea>
                    </div>
                    @error('booster')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn custom-btn-color w-100">Update Vaccination Record</button>
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
