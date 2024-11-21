@extends('layouts.app')

@section('content')

<div class="container record-container">
    <h2 class="text-center mb-4">LIVESTOCK RECORD DETAILS</h2>

    <div class="row mb-5">
        
        <div class="col-md-6">
            <div class="data-background p-4">
                <div class="mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" value="{{ $livestock->owner }}" placeholder="Owner" readonly>
                </div>
                <div class="mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-stethoscope"></i></span>
                    <input type="text" class="form-control" value="{{ $livestock->veterinarian }}" placeholder="Veterinarian" readonly>
                </div>
                <div class="mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-tag"></i></span>
                    <input type="text" class="form-control" value="{{ $livestock->name }}" placeholder="Name" readonly>
                </div>
                <div class="mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-calendar-alt"></i></span>
                    <input type="date" class="form-control" value="{{ $livestock->date_of_birth }}" placeholder="Date of Birth" readonly>
                </div>
                <div class="mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-paw"></i></span>
                    <input type="text" class="form-control" value="{{ $livestock->species }}" placeholder="Species" readonly>
                </div>
                <div class="mb-3 position-relative">
                    <span class="input-icon"><i class="fas fa-id-badge"></i></span>
                    <input type="text" class="form-control" value="{{ $livestock->tag }}" placeholder="Tag #" readonly>
                </div>
            </div>
        </div>

       
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="image-container">
                @if($livestock->picture)
                    <img src="{{ asset('storage/' . $livestock->picture) }}" alt="Livestock Picture" class="img-fluid livestock-picture">
                @else
                    <div class="image-placeholder border p-5 text-center">
                        PICTURE NOT AVAILABLE
                    </div>
                @endif
            </div>
        </div>
    </div>

  
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#qrCodeModal" data-id="{{ $livestock->id }}">
        <i class="fas fa-qrcode"></i> Generate QR Code
    </button>

    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR Code for Livestock Tag #: {{ $livestock->tag }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div id="qrCodeImageContainer">
                        <p>Generating QR Code...</p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-primary" onclick="printQrCode()">Print QR Code</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrCodeModal = document.getElementById('qrCodeModal');
            qrCodeModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const livestockId = button.getAttribute('data-id');

                fetch(`/livestock/${livestockId}/generate-qr-code`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('qrCodeImageContainer').innerHTML = `<img src="${data.qrCodeUrl}" alt="QR Code" class="img-fluid">`;
                        } else {
                            document.getElementById('qrCodeImageContainer').innerHTML = '<p>Error generating QR Code.</p>';
                        }
                    })
                    .catch(() => {
                        document.getElementById('qrCodeImageContainer').innerHTML = '<p>Error loading QR Code.</p>';
                    });
            });
        });

        function printQrCode() {
            const qrCodeImage = document.querySelector('#qrCodeImageContainer img');
            if (qrCodeImage) {
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`<html><head><title>Print QR Code</title></head><body><img src="${qrCodeImage.src}" alt="QR Code"></body></html>`);
                printWindow.document.close();
                printWindow.print();
            } else {
                alert('QR Code not available for printing.');
            }
        }
    </script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</div>

<style>
    body {
        background-color: #99d9f9;
    }

    .data-background {
        background-color: #d9e7f4;
        border-radius: 8px;
        border: 1px solid #b8daff;
    }

    .input-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    .form-control {
        padding-left: 2.5rem;
        color: #495057;
    }

    .form-control:readonly {
        background-color: #e7f1ff;
    }

    .image-container {
        height: 100%;
        width: 100%;
        max-height: 350px;
        background-color: #d9e7f4;
        border-radius: 8px;
        border: 1px solid #b8daff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .livestock-picture {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .image-placeholder {
        height: 100%;
        width: 100%;
        max-height: 350px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #6c757d;
        background-color: #e7f1ff;
        border-radius: 8px;
    }

    .btn-info i {
        margin-right: 5px;
    }
</style>



<div class="med-vac-rec d-flex justify-content-end">
    <a href="{{ route('medical.create', ['livestockId' => $livestock->id]) }}" class="btn btn-primary me-2">
        <i class="fas fa-notes-medical"></i> Add Medical Record
    </a>
    <a href="{{ route('vaccination.create', ['livestockId' => $livestock->id]) }}" class="btn btn-primary">
        <i class="fas fa-syringe"></i> Add Vaccination Record
    </a>
</div><br><br>
<style>
    .btn-info i {
    margin-right: 5px; 
}
</style>
  


<h3 class="mb-4 text-center">Medical Records</h3>
<div class="table-responsive mb-4">
<table class="table table-striped table-bordered text-center align-middle table-light">
    <thead class="table-dark">
        <tr>
            <th>Date</th>
            <th>Treatment</th>
            <th>Notes</th>
          
        </tr>
    </thead>
    <tbody>
        @foreach ($medicals as $medical)
        <tr class="table-info"> 
            <td>{{ $medical->date }}</td>
            <td>{{ $medical->treatment }}</td>
            <td>{{ $medical->note }}</td>
            <!-- <td>
                <a href="{{ route('medicals.edit', $medical->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#delete-{{$medical->id}}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td> -->
        </tr>

        {{-- Modal delete confirmation --}}
        <div class="modal fade" id="delete-{{$medical->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5>Are you sure you want to delete this medical record?</h5>
                        <form action="{{ route('medicals.destroy', $medical->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <hr>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </tbody>
</table>
</div><br>

<h3 class="mb-4 text-center">Vaccination Records</h3>
<div class="table-responsive mb-4">
<table class="table table-striped table-bordered text-center align-middle table-light">
    <thead class="table-dark">
        <tr>
            <th>Date</th>
            <th>Vaccination</th>
            <th>Booster</th>
            <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
        @foreach ($vaccinations as $vaccination)
        <tr class="table-info">
            <td>{{ $vaccination->date }}</td>
            <td>{{ $vaccination->vaccination }}</td>
            <td>{{ $vaccination->booster }}</td>
            
        </tr>

        {{-- Modal delete confirmation --}}
        <div class="modal fade" id="delete-{{$vaccination->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5>Are you sure you want to delete this vaccination record?</h5>
                        <form action="{{ route('vaccinations.destroy', $vaccination->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <hr>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </tbody>
</table>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .table th, .table td {
        vertical-align: middle; 
        text-align: center; 
    }

    .modal-header {
        background-color: #f8f9fa; 
    }

    .btn-warning {
        background-color: #ffc107; 
        border-color: #ffc107;
    }

    .btn-danger {
        background-color: #dc3545; 
        border-color: #dc3545;
    }

    .table-light {
        background-color: #f8f9fa; 
    }
</style>
@endsection
