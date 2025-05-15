@extends('layouts.admin')

@section('title', 'Appointment Notes')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Appointment
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointment Notes</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="fas fa-plus me-2"></i> Add Note
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Appointment Details</h6>
                            <p class="mb-1">
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                            </p>
                            <p class="mb-1">
                                <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </p>
                            <p class="mb-1">
                                <strong>Status:</strong> 
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
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Student Information</h6>
                            <p class="mb-1">
                                <strong>Name:</strong> {{ $appointment->student->name ?? 'Not Available' }}
                            </p>
                            <p class="mb-1">
                                <strong>Email:</strong> {{ $appointment->student->email ?? 'Not Available' }}
                            </p>
                            <p class="mb-1">
                                <strong>Counsellor:</strong> {{ $appointment->counsellor->name ?? 'Not Assigned' }}
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Notes History</h6>
                        <div class="filters">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary filter-btn active" data-filter="all">All</button>
                                <button type="button" class="btn btn-sm btn-outline-primary filter-btn" data-filter="status_change">Status Changes</button>
                                <button type="button" class="btn btn-sm btn-outline-primary filter-btn" data-filter="general">General</button>
                                <button type="button" class="btn btn-sm btn-outline-primary filter-btn" data-filter="confidential">Confidential</button>
                            </div>
                        </div>
                    </div>

                    @if($appointment->notes->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted">No notes have been added yet.</p>
                        </div>
                    @else
                        <div class="timeline">
                            @foreach($appointment->notes as $note)
                                <div class="timeline-item mb-4 note-item" data-type="{{ $note->note_type ?? 'general' }}">
                                    <div class="d-flex">
                                        <div class="timeline-indicator 
                                            @if(isset($note->note_type) && $note->note_type == 'status_change') bg-info
                                            @elseif(isset($note->note_type) && $note->note_type == 'confidential') bg-danger
                                            @else bg-primary @endif
                                            rounded-circle me-3" style="width: 12px; height: 12px; margin-top: 6px;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="fw-bold">
                                                    {{ $note->admin->name ?? 'Admin' }}
                                                    @if(isset($note->note_type))
                                                        @if($note->note_type == 'status_change')
                                                            <span class="badge bg-info ms-2">Status Change</span>
                                                        @elseif($note->note_type == 'confidential')
                                                            <span class="badge bg-danger ms-2">Confidential</span>
                                                        @else
                                                            <span class="badge bg-primary ms-2">General</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-primary ms-2">General</span>
                                                    @endif
                                                    
                                                    @if(isset($note->is_visible_to_student) && $note->is_visible_to_student)
                                                        <span class="badge bg-success ms-1">Visible to Student</span>
                                                    @endif
                                                </span>
                                                <div>
                                                    <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                                    @if(isset($note->admin_id) && $note->admin_id == Auth::id())
                                                        <div class="dropdown d-inline-block ms-2">
                                                            <button class="btn btn-sm btn-link text-secondary p-0" type="button" data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editNoteModal{{ $note->id }}">
                                                                        <i class="fas fa-edit me-2"></i> Edit
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteNoteModal{{ $note->id }}">
                                                                        <i class="fas fa-trash me-2"></i> Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $note->note }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Note Modal -->
                                @if(isset($note->admin_id) && $note->admin_id == Auth::id())
                                    <div class="modal fade" id="editNoteModal{{ $note->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Edit Note</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.appointments.notes.edit', $note->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="note_type" class="form-label">Note Type</label>
                                                            <select class="form-select" name="note_type" id="note_type" required>
                                                                <option value="general" {{ (isset($note->note_type) && $note->note_type == 'general') ? 'selected' : '' }}>General</option>
                                                                <option value="status_change" {{ (isset($note->note_type) && $note->note_type == 'status_change') ? 'selected' : '' }}>Status Change</option>
                                                                <option value="confidential" {{ (isset($note->note_type) && $note->note_type == 'confidential') ? 'selected' : '' }}>Confidential</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="note" class="form-label">Note</label>
                                                            <textarea class="form-control" id="note" name="note" rows="3" required>{{ $note->note }}</textarea>
                                                        </div>
                                                        
                                                        <div class="mb-3 form-check">
                                                            <input type="checkbox" class="form-check-input" id="is_visible_to_student{{ $note->id }}" name="is_visible_to_student" {{ (isset($note->is_visible_to_student) && $note->is_visible_to_student) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="is_visible_to_student{{ $note->id }}">Visible to Student</label>
                                                        </div>
                                                        
                                                        <div class="mb-3 form-check">
                                                            <input type="checkbox" class="form-check-input" id="is_visible_to_counsellor{{ $note->id }}" name="is_visible_to_counsellor" {{ (isset($note->is_visible_to_counsellor) && $note->is_visible_to_counsellor) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="is_visible_to_counsellor{{ $note->id }}">Visible to Counsellor</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Note</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Note Modal -->
                                    <div class="modal fade" id="deleteNoteModal{{ $note->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this note? This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.appointments.notes.delete', $note->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete Note</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.appointments.notes', $appointment->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note_type" class="form-label">Note Type</label>
                        <select class="form-select" name="note_type" id="note_type" required>
                            <option value="general">General</option>
                            <option value="status_change">Status Change</option>
                            <option value="confidential">Confidential</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_visible_to_student" name="is_visible_to_student">
                        <label class="form-check-label" for="is_visible_to_student">Visible to Student</label>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_visible_to_counsellor" name="is_visible_to_counsellor" checked>
                        <label class="form-check-label" for="is_visible_to_counsellor">Visible to Counsellor</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter notes
        const filterButtons = document.querySelectorAll('.filter-btn');
        const noteItems = document.querySelectorAll('.note-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                // Show/hide notes based on filter
                noteItems.forEach(item => {
                    if (filterValue === 'all') {
                        item.style.display = 'block';
                    } else {
                        if (item.getAttribute('data-type') === filterValue) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });
    });
</script>
@endsection