<nav class="bg-red-600 p-4 shadow-lg">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
      </div>
      <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
        <!-- Logo and Text -->
        <div class="flex items-center space-x-2 text-white text-lg font-semibold">
          <!-- Add your logo here -->
          <img class="h-8 w-auto" src="{{ asset('images/bsulogo.png') }}" alt="ACTION Center Logo">
          <span>ACTION Center</span>
        </div>
      </div>
      <div class="flex space-x-4">
        <a href="{{ route('login') }}" class="text-white hover:bg-white hover:text-red-600 px-3 py-2 rounded-md transition duration-300 ease-in-out">Login</a>
        <a href="{{ route('registration') }}" class="text-white hover:bg-white hover:text-red-600 px-3 py-2 rounded-md transition duration-300 ease-in-out">Register</a>
      </div>
    </div>
  </div>
</nav>
