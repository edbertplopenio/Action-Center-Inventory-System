@extends('layout')
@section('title', 'Login')
@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md"> <!-- Increased max width -->
    <!-- Card container -->
    <div class="bg-white rounded-lg shadow-lg p-8">
      <!-- Logo and Heading inside the card -->
      <div class="text-center">
      <img class="mx-auto h-20 w-20" src="{{ asset('images/actioncenter.png') }}" alt="ACTION Center">


        <h2 class="mt-10 text-2xl font-bold text-gray-900">Sign in to your account</h2>
      </div>

      <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
        @csrf
        <!-- Email Field -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-3 py-1.5 text-base text-gray-900 outline-none focus:ring-2 focus:ring-red-600 sm:text-sm">
          </div>
        </div>

        <!-- Password Field -->
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
            <div class="text-sm">
              <a href="#" class="font-semibold text-red-600 hover:text-red-500">Forgot password?</a>
            </div>
          </div>
          <div class="mt-2">
            <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md border border-gray-300 px-3 py-1.5 text-base text-gray-900 outline-none focus:ring-2 focus:ring-red-600 sm:text-sm">
          </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center">
          <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
          <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="w-full flex justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-red-600">
            Sign in
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Not a member?
        <a href="{{ route('registration') }}" class="font-semibold text-red-600 hover:text-red-500">Create an account</a>
      </p>
    </div>
    <!-- End of Card container -->
  </div>
</div>

@if (session('status') == 'success')
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Login successful!',
      showConfirmButton: false,
      timer: 1500
    });
  </script>
@endif

@if (session('status') == 'error')
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Invalid credentials!',
      showConfirmButton: false,
      timer: 1500
    });
  </script>
@endif
@endsection
