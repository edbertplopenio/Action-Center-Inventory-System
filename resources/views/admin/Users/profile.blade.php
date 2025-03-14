@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="profile-info">
        <!-- Display Profile Photo -->
        @if($user->photo)
            <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="Profile Photo" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
        @else
            <img src="{{ asset('storage/photos/default.png') }}" alt="Default Profile Photo" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
        @endif

        <!-- Form to update profile -->
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name input -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <!-- Email input -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>

            <!-- Profile photo upload -->
            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>
@endsection
