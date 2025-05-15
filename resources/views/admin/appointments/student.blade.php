@extends('layouts.admin')

@section('title', 'Appointments Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointments Management</h5>
                    <div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter by Status
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.appointments.student') }}">All</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.appointments.student', ['status' => 'pending']) }}">Pending</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.appointments.student', ['status' => 'approved']) }}">Approved</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.appointments.student', ['status' => 'completed']) }}">Completed</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.appointments.student', ['status' => 'cancelled']) }}">Cancelled</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.appointments.student', ['status' => 'rejected']) }}">Rejected</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($appointments->isEmpty())
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-calendar.svg') }}" alt="No Appointments" class="img-fluid mb-3" style="max-height: 150px;">
                            <h5>No Appointments Found</h5>
                            <p class="text-muted">There are no appointments matching your filter criteria.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date & Time</th>
                                        <th>Student</th>
                                        <th>Counsellor</th>
                                        <th>Status</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}<br>
                                                <span class="badge bg-light text-dark">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($appointment->student)
                                                    <a href="{{ route('admin.student.profile', $appointment->student->id) }}" class="text-decoration-none">
                                                        {{ $appointment->student->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Not Available</span>
                                                @endif
                                            </td>
                                            <td>{{ $appointment->counsellor->name ?? 'Not Assigned' }}</td>
                                            <td>
                                                @if($appointment->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($appointment->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($appointment->status == 'completed')
                                                    <span class="badge bg-info">Completed</span>
                                                @elseif($appointment->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($appointment->status == 'rejected')
                                                    <span class="badge bg-secondary">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $appointment->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $appointments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection