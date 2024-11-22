@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Add New Livestock</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <div class="w-50" style="background-color: #e0f7fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <form action="{{ route('livestocks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 d-none">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="owner" class="form-control" id="owner" placeholder="Enter Owner" value="{{ auth()->user()->name }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                        <input type="text" name="veterinarian" class="form-control" id="veterinarian" placeholder="Enter Veterinarian" value="{{ old('veterinarian') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-paw"></i></span>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="date_of_birth" class="form-control" id="Enter Date of Birth" value="{{ old('date_of_birth') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-kiwi-bird"></i></span>
                        <input type="text" name="livestock" class="form-control" id="livestock" placeholder="Enter Livestock" value="{{ old('livestock') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                        <input type="file" name="picture" class="form-control" id="picture" required accept="image/*">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Save</button>
            </form>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-color: #f0f8ff; 
        
    }
    .input-group-text {
        background-color: #e9ecef; 
    }
    .input-group-text i {
        color: #007bff; 
    }
</style>

@endsection