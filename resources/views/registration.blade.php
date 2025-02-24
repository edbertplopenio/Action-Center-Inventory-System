@extends('layout')
@section('title', 'Registration')
@section('content')
<div class="flex min-h-full flex-col justify-center px-4 py-8 lg:px-6">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <!-- Card container with adjusted height -->
    <div class="bg-white rounded-lg shadow-lg p-4 min-h-[350px]">
      <!-- Logo and Heading inside the card -->
      <div class="text-center">
      <img class="mx-auto h-16 w-16" src="{{ asset('images/actioncenter.png') }}" alt="ACTION Center">
        <h2 class="mt-6 text-lg font-semibold text-red-600">Create a new account</h2> <!-- Reduced font size -->
      </div>

      <form class="space-y-3" action="{{ route('registration.post') }}" method="POST">
        @csrf
        <!-- Name Field -->
        <div>
          <label for="name" class="block text-xs font-medium text-gray-900">Full Name</label>
          <div class="mt-1">
            <input type="text" name="name" id="name" autocomplete="name" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-red-600">
          </div>
        </div>

        <!-- Email Field -->
        <div>
          <label for="email" class="block text-xs font-medium text-gray-900">Email address</label>
          <div class="mt-1">
            <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-red-600">
          </div>
        </div>

        <!-- Department Field -->
        <div>
          <label for="department" class="block text-xs font-medium text-gray-900">Department</label>
          <div class="mt-1">
            <input type="text" name="department" id="department" autocomplete="department" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-red-600">
          </div>
        </div>

        <!-- Cellphone Number Field -->
        <div>
          <label for="cellphone_number" class="block text-xs font-medium text-gray-900">Cellphone Number</label>
          <div class="mt-1">
            <input type="tel" name="cellphone_number" id="cellphone_number" autocomplete="cellphone" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-red-600">
          </div>
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-xs font-medium text-gray-900">Password</label>
          <div class="mt-1">
            <input type="password" name="password" id="password" autocomplete="new-password" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-red-600">
          </div>
        </div>

        <!-- Terms Checkbox -->
        <div class="flex items-center">
          <input type="checkbox" id="terms" name="terms" required class="h-3 w-3 rounded border-gray-300 text-red-600 focus:ring-red-500">
          <label for="terms" class="ml-2 block text-xs text-gray-900">Agree to terms and conditions</label>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="w-full flex justify-center rounded-md bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-red-600">
            Register
          </button>
        </div>
      </form>

      <p class="mt-4 text-center text-xs text-gray-500">
        Already a member?
        <a href="{{ route('login') }}" class="font-semibold text-red-600 hover:text-red-500">Sign in</a>
      </p>
    </div>
    <!-- End of Card container -->
  </div>
</div>

@if (session('status') == 'success')
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
