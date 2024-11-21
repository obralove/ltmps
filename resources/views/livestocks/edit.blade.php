@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Edit Livestock</h1>

    <div class="d-flex justify-content-center">
        <div class="w-50" style="background-color: #e0f7fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <form action="{{ route('livestocks.update', $livestock->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="owner" name="owner" placeholder="Owner" value="{{ old('owner', $livestock->owner) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                        <input type="text" class="form-control" id="veterinarian" name="veterinarian" placeholder="Vet" value="{{ old('veterinarian', $livestock->veterinarian) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-paw"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $livestock->name) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $livestock->date_of_birth) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-kiwi-bird"></i></span>
                        <input type="text" class="form-control" id="species" name="species" placeholder="Species" value="{{ old('species', $livestock->species) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                        <input type="file" class="form-control" id="picture" name="picture">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Livestock</button>
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