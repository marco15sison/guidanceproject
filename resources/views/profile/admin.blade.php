@extends('layouts.admin')

@section('title', 'Profile')

@section('page_title', 'My Profile')

@section('custom_styles')
<style>
    .profile-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 20px 30px;
        margin: 40px auto;
        width: 80%;
        max-width: 800px;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .profile-header i {
        font-size: 24px;
        color: var(--primary-color);
        margin-right: 15px;
    }
    
    .profile-header h3 {
        font-size: 22px;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    
    .form-group {
        display: flex;
        margin-bottom: 20px;
        align-items: center;
    }
    
    .form-label {
        width: 35%;
        text-align: right;
        padding-right: 20px;
        color: #333;
        font-weight: 500;
    }
    
    .form-control {
        flex: 1;
        max-width: 350px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 8px 12px;
        background-color: #fff;
    }
    
    .form-control:read-only {
        background-color: #f5f5f5;
    }
    
    .password-section {
        margin-top: 35px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .password-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .password-header i {
        font-size: 20px;
        color: var(--primary-color);
        margin-right: 15px;
    }
    
    .password-header h3 {
        font-size: 18px;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    
    .update-btn {
        margin-top: 15px;
        display: inline-block;
        padding: 8px 25px;
        background-color: var(--accent-color);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.2s;
    }
    
    .update-btn:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .alert {
        margin-bottom: 25px;
    }
    
    .locked-field {
        position: relative;
    }
    
    .locked-field i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        cursor: not-allowed;
    }
    
    /* Center content wrapper on smaller screens */
    @media (max-width: 992px) {
        .profile-container {
            width: 90%;
        }
    }
    
    @media (max-width: 768px) {
        .profile-container {
            width: 95%;
            padding: 20px 25px;
            margin: 20px auto;
        }
        
        .form-group {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .form-label {
            width: 100%;
            text-align: left;
            margin-bottom: 8px;
            padding-right: 0;
        }
        
        .form-control {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid d-flex justify-content-center">
    <div class="profile-container">
        <div class="profile-header">
            <i class="fas fa-user-circle"></i>
            <h3>Profile</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">ID Number</label>
                <div class="locked-field" style="flex: 1; max-width: 350px;">
                    <input id="email" type="text" class="form-control" value="{{ $user->email }}" readonly>
                    <i class="fas fa-lock"></i>
                    <input type="hidden" name="email" value="{{ $user->email }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="user_type">User Type</label>
                <input type="text" class="form-control" value="{{ ucfirst($user->user_type) }}" readonly>
            </div>

            <div class="password-section">
                <div class="password-header">
                    <i class="fas fa-key"></i>
                    <h3>Change Password</h3>
                </div>

                <div class="form-group">
                    <label class="form-label" for="current_password">Current Password</label>
                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password">
                    
                    @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="new_password">New Password</label>
                    <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password">
                    
                    @error('new_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <div class="form-label"></div>
                    <button type="submit" class="update-btn">
                        Update Profile
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection