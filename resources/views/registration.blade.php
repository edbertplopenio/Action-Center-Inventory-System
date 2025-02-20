@extends('layout')
@section('title', 'Registration')
@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">Create a new account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="{{ route('registration.post') }}" method="POST">
      @csrf
      <!-- Name Field -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-900">Full Name</label>
        <div class="mt-2">
          <input type="text" name="name" id="name" autocomplete="name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
        </div>
      </div>

      <!-- Email Field -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
        <div class="mt-2">
          <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
        </div>
      </div>

      <!-- Department Field -->
      <div>
        <label for="department" class="block text-sm font-medium text-gray-900">Department</label>
        <div class="mt-2">
          <input type="text" name="department" id="department" autocomplete="department" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
        </div>
      </div>

      <!-- Cellphone Number Field -->
      <div>
        <label for="cellphone_number" class="block text-sm font-medium text-gray-900">Cellphone Number</label>
        <div class="mt-2">
          <input type="tel" name="cellphone_number" id="cellphone_number" autocomplete="cellphone" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
        </div>
      </div>

      <!-- Password Field -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
        <div class="mt-2">
          <input type="password" name="password" id="password" autocomplete="new-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
        </div>
      </div>

      <!-- Terms Checkbox -->
      <div class="flex items-center">
        <input type="checkbox" id="terms" name="terms" required class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="terms" class="ml-2 block text-sm text-gray-900">Agree to terms and conditions</label>
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" class="w-full flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-indigo-600">
          Register
        </button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
      Already a member?
      <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
    </p>
  </div>
</div>
@endsection
