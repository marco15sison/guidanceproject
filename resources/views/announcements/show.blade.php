@extends('layouts.student')

@section('title', $announcement ? $announcement->title : 'Announcement Not Found')

@section('styles')
<style>
    .announcement-header {
        position: relative;
        padding: 3rem 0;
        margin-bottom: 2rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }
    
    .announcement-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .announcement-content {
        font-size: 1.05rem;
        line-height: 1.7;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        margin-bottom: 1.5rem;
        text-decoration: none;
        color: #0d6efd;
    }
    
    .related-announcement {
        transition: all 0.3s ease;
        border-bottom: 1px solid #dee2e6;
        padding: 15px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Back button -->
    <a href="{{ route('announcements.index') }}" class="back-link mb-4">
        <i class="fas fa-arrow-left me-2"></i> Back to Announcements
    </a>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Announcement header -->
                    <div id="announcementHeader" class="mb-4">
                        @if($announcement)
                            <h1 class="announcement-title mb-3">{{ $announcement->title }}</h1>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if(isset($announcement->category))
                                    <span class="badge bg-primary">{{ $announcement->category->name }}</span>
                                @endif
                                
                                @if(isset($announcement->target_audience))
                                    <span class="badge bg-info">{{ $announcement->target_audience }}</span>
                                @endif
                                
                                @if(isset($announcement->publish_date))
                                    <span class="badge bg-secondary">
                                        Published: {{ date('M d, Y', strtotime($announcement->publish_date)) }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <h1 class="announcement-title mb-3">Announcement Not Found</h1>
                        @endif
                    </div>
                    
                    <!-- Announcement content -->
                    <div id="announcementContent" class="announcement-content">
                        @if($announcement && $announcement->content)
                            {!! $announcement->content !!}
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Content unavailable. This announcement may have been removed or is no longer accessible.
                                
                                <!-- Debug info -->
                                @if(config('app.debug'))
                                    <div class="mt-3 p-3 bg-light">
                                        <strong>Debug Info:</strong>
                                        <ul>
                                            <li>ID: {{ $id }}</li>
                                            <li>Announcement Found: {{ $announcement ? 'Yes' : 'No' }}</li>
                                            @if($announcement)
                                                <li>Status: {{ $announcement->status }}</li>
                                                <li>Publish Date: {{ $announcement->publish_date }}</li>
                                                <li>Expiry Date: {{ $announcement->expiry_date }}</li>
                                                <li>Current Date: {{ now() }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Attachments -->
            @if($announcement && isset($announcement->attachments) && count($announcement->attachments) > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Attachments</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($announcement->attachments as $attachment)
                                <div class="col-md-6 mb-3">
                                    <a href="/storage/{{ $attachment->filename }}" class="text-decoration-none" target="_blank">
                                        <div class="border rounded p-3 h-100">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="fas fa-file fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-break">{{ $attachment->original_filename ?? 'Attachment' }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <!-- About/Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">About</h5>
                </div>
                <div class="card-body">
                    @if($announcement)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Published on</small>
                            <p class="mb-0">{{ date('F j, Y', strtotime($announcement->publish_date)) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Valid until</small>
                            <p class="mb-0">{{ date('F j, Y', strtotime($announcement->expiry_date)) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Target audience</small>
                            <p class="mb-0">{{ $announcement->target_audience }}</p>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Views</small>
                            <p class="mb-0">{{ $announcement->views }}</p>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Information unavailable
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Related Announcements -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Related Announcements</h5>
                </div>
                <div class="card-body p-0">
                    @if(count($relatedAnnouncements) > 0)
                        @foreach($relatedAnnouncements as $related)
                            <a href="{{ route('announcements.show', $related->id) }}" class="text-decoration-none text-body">
                                <div class="related-announcement">
                                    <h6 class="mb-1">{{ $related->title }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ date('M d', strtotime($related->publish_date)) }}</small>
                                        <span class="badge bg-secondary">{{ $related->category->name ?? 'General' }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-3 text-center text-muted">
                            <p class="mb-0">No related announcements found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection