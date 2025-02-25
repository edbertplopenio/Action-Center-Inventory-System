<nav class="bg-red-600 p-4">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
      </div>
      <div class="flex-1 flex items-center justify-start sm:items-stretch sm:justify-start">
        <a href="{{ route('home') }}" class="text-white text-lg font-semibold">ACTION Center</a>
      </div>
      <div class="flex space-x-4">
        <a href="{{ route('login') }}" class="text-white">Login</a>
        <a href="{{ route('registration') }}" class="text-white">Register</a>
        <a href="#aboutus" class="text-white">About Us</a> <!-- Added About Us link -->
      </div>
    </div>
  </div>
</nav>
