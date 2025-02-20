<nav class="bg-indigo-600 p-4">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
      </div>
      <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
        <a href="{{ route('home') }}" class="text-white text-lg font-semibold">ACTION Center</a>
      </div>
      <div class="flex space-x-4">
        <a href="{{ route('login') }}" class="text-white">Login</a>
        <a href="{{ route('registration') }}" class="text-white">Register</a>
      </div>
    </div>
  </div>
</nav>
