@extends('layout')
@section('title', 'Registration')
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
      <h2 class="mt-4 text-lg font-semibold text-red-600 text-center">Create a new account</h2>

      @if ($errors->any())
      <script>
        let errorMessages = `
        <ul style='text-align: center;'>
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

      <form class="space-y-3 flex flex-col items-center" action="{{ route('registration.post') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-3 w-3/4">
          <div class="flex flex-col">
            <label for="first_name" class="text-xs font-medium text-gray-900 mb-1">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
            @error('first_name')
            <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
          </div>
          <div class="flex flex-col">
            <label for="last_name" class="text-xs font-medium text-gray-900 mb-1">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
            @error('last_name')
            <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="flex flex-col w-3/4">
          <label for="email" class="text-xs font-medium text-gray-900 mb-1">Email address</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
          @error('email')
          <span class="text-red-600 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col w-3/4">
          <label for="department" class="text-xs font-medium text-gray-900 mb-1">Department</label>
          <input type="text" name="department" id="department" value="{{ old('department') }}" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
          @error('department')
          <span class="text-red-600 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col w-3/4">
          <label for="contact_number" class="text-xs font-medium text-gray-900 mb-1">Contact Number</label>
          <input type="tel" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
          @error('contact_number')
          <span class="text-red-600 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col w-3/4">
          <label for="password" class="text-xs font-medium text-gray-900 mb-1">Password</label>
          <input type="password" name="password" id="password" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
          @error('password')
          <span class="text-red-600 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex flex-col w-3/4">
          <label for="password_confirmation" class="text-xs font-medium text-gray-900 mb-1">Confirm Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full rounded-md border border-gray-300 px-2 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
          @error('password_confirmation')
          <span class="text-red-600 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex items-center w-3/4">
          <input type="checkbox" id="terms" name="terms" required class="h-3 w-3 rounded border-gray-300 text-red-600 focus:ring-red-500">
          <label for="terms" class="ml-2 block text-xs text-gray-900">Agree to terms and conditions</label>
        </div>

        <div class="w-3/4">
          <button type="submit" class="w-full flex justify-center rounded-md bg-blue-500 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-600 focus:ring-2 focus:ring-red-600">
            Register
          </button>
        </div>
      </form>

      <p class="mt-4 text-center text-xs text-gray-500">
        Already a member? <a href="{{ route('login') }}" class="font-semibold text-blue-500 hover:text-blue-600">Sign in</a>
      </p>
    </div>
  </div>
</div>

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