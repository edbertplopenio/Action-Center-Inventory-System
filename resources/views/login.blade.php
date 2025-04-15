@extends('layout')
@section('title', 'Login')
@section('content')
<div class="relative min-h-screen flex justify-center items-center bg-gray-100">
  <!-- Background Image Covering Full Screen -->
  <div class="absolute inset-0 w-full h-full">
    <img class="w-full h-full object-cover" src="{{ asset('images/BG.png') }}" alt="Background Image">
  </div>

  <!-- Login Form Container (Blurred Background but Sharp Text) -->
  <div class="relative z-10 bg-white bg-opacity-40 backdrop-blur-xl p-8 rounded-2xl shadow-lg w-96 flex flex-col items-center"
    style="backdrop-filter: blur(10px); transform: translateX(45%);">



    <!-- Display Validation Errors -->
    @if ($errors->any())
    <script>
      let errorMessages = `
      <ul style='text-align: left;'>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
      `;

      Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: errorMessages,
        confirmButtonText: 'OK'
      });
    </script>
    @endif

    <form class="space-y-4 flex flex-col items-center w-full" action="{{ route('login.post') }}" method="POST">
      @csrf
      <div class="flex flex-col w-3/4">
        <label for="email" class="text-xs font-medium text-white mb-1">Email address</label>
        <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-900 focus:ring-2 focus:ring-gray-500">
      </div>

      <div class="flex flex-col w-3/4">
        <label for="password" class="text-xs font-medium text-white mb-1">Password</label>
        <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-900 focus:ring-2 focus:ring-gray-500">
      </div>

      <div class="flex items-center w-3/4">
        <input type="checkbox" id="remember" name="remember" class="h-3 w-3 rounded border-gray-300 text-gray-600 focus:ring-gray-500">
        <label for="remember" class="ml-2 text-xs text-white">Remember me</label>
      </div>

      <button type="submit" class="w-auto px-20 py-2 text-xs font-semibold text-white rounded-md hover:bg-red- 00 focus:ring-2 focus:ring-red-600" style="background-color: #780000;">
        Login
      </button>

      <p class="mt-4 text-center text-xs text-white">
        Not a member? <a href="{{ route('registration') }}" class="font-semibold text-blue-400 hover:text-blue-500">Create an account</a>
      </p>
  </div>
</div>

<!-- SweetAlert Messages -->
@if (session('status') == 'registration_success')
<script>
  Swal.fire({
    icon: 'success',
    title: 'Registration Successful!',
    text: 'You can now log in to your account.',
    showConfirmButton: false,
    timer: 1500
  });
</script>
@endif

@if (session('status') == 'login_error')
<script>
  Swal.fire({
    icon: 'error',
    title: 'Login Failed',
    text: 'The provided credentials are incorrect.',
    confirmButtonText: 'OK'
  });
</script>
@endif

@if (session('status') == 'error')
<script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'There was an issue with the registration. Please try again.',
    showConfirmButton: false,
    timer: 1500
  });
</script>
@endif

@endsection