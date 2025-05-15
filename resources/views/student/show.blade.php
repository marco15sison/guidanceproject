@extends('layouts.student')

@section('title', 'Inventory Submitted')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Submission Successful</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                <p>Your student inventory form has been submitted successfully.</p>
                <p>Form ID: <strong>{{ $inventory->form_id }}</strong></p>
            </div>
            
            <div class="row mt-4 mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Student Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $inventory->full_name }}</p>
                            <p><strong>Course:</strong> {{ $inventory->course }}</p>
                            <p><strong>Year Level:</strong> {{ $inventory->year_level }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Next Steps</h5>
                        </div>
                        <div class="card-body">
                            <p>Please keep your Form ID for future reference.</p>
                            <p>The Guidance Office will review your submission and may contact you if needed.</p>
                            <p class="small text-muted">For questions, contact guidance@psu.edu.ph</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
    <a href="{{ route('student.download', $inventory->id) }}" class="btn btn-primary">
        <i class="fas fa-download"></i> Download PDF
    </a>
</div>
        </div>
    </div>
</div>
@endsection