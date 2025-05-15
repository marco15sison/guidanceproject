@extends('layouts.student')

@section('title', 'Check Submission Status')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Check Your Submission Status</h4>
        </div>
        <div class="card-body">
            @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
            @endif

            <p>Enter your student number to check if you have already submitted an inventory form.</p>
            
            <form action="{{ route('student.check') }}" method="GET">
                <div class="mb-3">
                    <label for="student_number" class="form-label">Student Number</label>
                    <input type="text" class="form-control" id="student_number" name="student_number" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Check Status</button>
            </form>
            
            <div class="mt-4">
                <p>Don't remember if you've submitted a form?</p>
                <p>Enter your student number above to check. If you have already submitted, you will be redirected to view your form.</p>
                <p>If you haven't submitted yet, you'll be directed to the form page.</p>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{ route('inventory.create') }}" class="btn btn-outline-primary">Go to Inventory Form</a>
                <a href="{{ url('/') }}" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection