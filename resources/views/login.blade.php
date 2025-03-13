@extends('layout')
@section('title', 'Login')
@section('content')
<div class="flex min-h-screen justify-center items-center px-6">
  <div class="lg:w-2/3 h-screen hidden lg:block">
    <img class="w-full h-full object-cover" src="{{ asset('images/home.jpg') }}" alt="Background Image">
  </div>
  <div class="lg:w-2/5 flex justify-center items-center">
    <div class="w-full max-w-md">
      <div class="flex justify-center items-center space-x-4">
        <img class="h-16 w-16" src="{{ asset('images/bsulogo.png') }}" alt="Logo">
        <img class="h-16 w-16" src="{{ asset('images/actioncenter.png') }}" alt="Logo">
      </div>
      <h2 class="mt-4 text-lg font-semibold text-red-600 text-center">Sign in to your account</h2>

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
          html: errorMessages, // Use `html` to properly format the list
          confirmButtonText: 'OK'
        });
      </script>
      @endif

      <form class="space-y-3 flex flex-col items-center" action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="flex flex-col w-3/4">
          <label for="email" class="text-xs font-medium text-gray-900 mb-1">Email address</label>
          <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-3 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
        </div>

        <div class="flex flex-col w-3/4">
          <label for="password" class="text-xs font-medium text-gray-900 mb-1">Password</label>
          <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md border border-gray-300 px-3 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
        </div>

        <div class="flex items-center w-3/4">
          <input type="checkbox" id="remember" name="remember" class="h-3 w-3 rounded border-gray-300 text-red-600 focus:ring-red-500">
          <label for="remember" class="ml-2 text-xs text-gray-900">Remember me</label>
        </div>

        <div class="w-3/4">
          <button type="submit" class="w-full flex justify-center rounded-md bg-blue-500 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-600 focus:ring-2 focus:ring-red-600">
            Sign in
          </button>
        </div>
      </form>

      <p class="mt-4 text-center text-xs text-gray-500">
        Not a member? <a href="{{ route('registration') }}" class="font-semibold text-blue-500 hover:text-blue-600">Create an account</a>
      </p>
    </div>
  </div>
</div>

<!-- Success and Error messages using SweetAlert -->
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
