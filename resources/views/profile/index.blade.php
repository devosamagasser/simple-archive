@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Profile</h2>

    <!-- رسالة النجاح -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- فورم تعديل البيانات -->
    <div class="card mb-4">
        <div class="card-header">Edit Profile</div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                </div>

                <div class="form-group">
                    <label>New Password (optional)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    <!-- الملفات المشتركة مع المستخدم -->
    <div class="card">
        <div class="card-header">Files Shared with You</div>
        <div class="card-body">
            @if($sharedFiles->isEmpty())
                <p>No files shared with you.</p>
            @else
                <ul class="list-group">
                    @foreach($sharedFiles as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('files.show', $file->id) }}">{{ $file->name }}</a>
                            <span class="badge badge-secondary">{{ ucfirst($file->type) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
