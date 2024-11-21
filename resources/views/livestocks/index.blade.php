@extends('layouts.app')
@section('content')

<h1 class="listing mb-4 text-center">Livestock Management System</h1>

<div class="container">

    <div class="form-filter align-items-center mb-4">
        <form method="GET" action="{{ route('livestocks.index') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" name="species" class="form-control" placeholder="Search Livestock" value="{{ request('species') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="veterinarian" class="form-control" placeholder="Search Veterinarian" value="{{ request('veterinarian') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 text-black">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    @if($livestocks->count())
        <p class="text-muted">{{ $livestocks->count() }} records found</p>
    @else
        <p class="text-muted">No records found</p>
    @endif

    
    <div class="d-flex justify-content-end mb-3">
    <a href="/livestocks/create" class="btn btn-success">
        <i class="fas fa-plus"></i> Add Livestock
    </a>
    <a href="/livestocks/showdeleted" class="btn btn-danger ms-2">
        <i class="fas fa-trash-alt"></i> Deleted Livestock
    </a>
</div>
    
    <table class="table table-striped table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Owner</th>
                <th>Veterinarian</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Livestock</th>
                <th>Tag Number</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($livestocks as $livestock)
                <tr>
                    <td>{{ $livestock->id }}</td>
                    <td>{{ $livestock->owner }}</td>
                    <td>{{ $livestock->veterinarian }}</td>
                    <td>{{ $livestock->name }}</td>
                    <td>{{ $livestock->date_of_birth }}</td>
                    <td>{{ $livestock->species }}</td>
                    <td>{{ $livestock->tag }}</td>
                    <td>
                        <img src="{{ asset('storage/'.$livestock->picture) }}" alt="{{ $livestock->picture }}" class="img-fluid" style="max-width: 150px; aspect-ratio: 2/1;">
                    </td>

                    <td>
    
    <a href="{{ route('livestocks.edit', $livestock->id) }}" class="btn btn-warning btn-sm p-1">
        <i class="fas fa-edit fa-sm"></i> 
    </a>

   
    <form action="{{ route('livestocks.destroy', $livestock->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm p-1">
            <i class="fas fa-trash fa-sm"></i>
        </button>
    </form>

   
    <a href="{{ route('livestocks.show', $livestock->id) }}" class="btn btn-info btn-sm p-1">
        <i class="fas fa-eye fa-sm"></i>
    </a>
</td>

                </tr>
            @endforeach   
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $livestocks->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this livestock entry? This action cannot be undone.');
        }
    </script>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-color: #99d9f9; 
        font-family: 'Arial', sans-serif; 
        margin: 0;
        height: 100vh;
    }
    .table img {
        border-radius: 5px;
    }
    .form-filter {
        background-color: #d9e7f4; 
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        background-color: #9dcbe4;
        border: none; 
        border-radius: 5px; 
    }
    .btn-primary:hover {
        background-color: #0056b3; 
    }
    .btn-success {
        border-radius: 5px;
    }
    .btn-warning, .btn-danger, .btn-info {
        border-radius: 5px; 
    }
    .pagination-wrap {
        margin-top: 20px; 
    }
    .table .btn {
    padding: 4px; 
    margin: 2px; 
    width: 30px; 
    height: 30px; 
}

.table .btn i {
    font-size: 14px; 
    vertical-align: middle; 
}
</style>

@endsection