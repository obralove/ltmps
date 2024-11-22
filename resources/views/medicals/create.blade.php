@extends('layouts.app')

@section('content')
<div class="container">
    
    <h2 class="mb-4 text-center">Add Medical Record</h2>

    <div class="d-flex justify-content-center">
    <div class="w-50" style="background-color: #d9e7f4; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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

        <form action="{{ route('medical.store') }}" method="POST">
            @csrf
            <input type="hidden" name="livestock_id" value="{{ $livestock_id }}">

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" placeholder="Date" value="{{ old('date') }}" required>
                </div>
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                    <input type="text" class="form-control @error('veterinarian') is-invalid @enderror" id="veterinarian" name="veterinarian" placeholder="Enter Veterinarian" value="{{ old('veterinarian') }}" required>
                </div>
                @error('veterinarian')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-bandage"></i></span>
                    <!-- <input type="text" class="form-control @error('treatment') is-invalid @enderror" id="treatment" name="treatment" placeholder="Enter Treatment" value="{{ old('treatment') }}" required>
                      -->
                        <select class="treatment-dropdown" style="width: 90%;" class="form-control @error('treatment') is-invalid @enderror" name="treatment[]" multiple="multiple">
                            <option value="Valbazen">Valbazen   </option>
                            <option value="Albendazole">Albendazole</option>
                            <option value="Bovine">Bovine</option>
                            <option value="Antibiotic intramammary tubes">Antibiotic intramammary tubes</option>
                            <option value="Vitamin B">Vitamin B</option>
                            <option value="Aminoglycosides">Aminoglycosides</option>
                            <option value="Lincosamides">Lincosamides</option>
                            <option value="Multivitamins">Multivitamins</option>
                        </select>
                </div>
                @error('treatment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="4" placeholder="Enter your notes" required>{{ old('note') }}</textarea>
                </div>
                @error('note')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn custom-btn-color w-100">Add Medical Record</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    $(document).ready(function() {
        $('.treatment-dropdown').select2({placeholder: "Select a treatment",
            allowClear: true});
    });
</script>

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
    color: #000; 
}
</style>
@endsection
