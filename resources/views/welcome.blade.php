@extends('layout')

@section('title', 'Home Page')

@section('content')
    <!-- Header -->
    <header class="w-full flex justify-end p-6 bg-white shadow-md">
    <nav class="flex space-x-4">
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-6 py-3 bg-green-500 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-green-600">
                Register
            </a>
        @endif
    </nav>
</header>
    <!-- Hero Section --> 
    <div class="relative min-h-screen flex flex-col items-center justify-center bg-cover bg-center font-sans"
        style="background-image: url('/images/home.jpg'); background-size: cover; background-position: center; max-height: 60vh;">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-20"></div>

        <!-- Content at the top -->
        <div class="relative z-10 flex flex-col items-center text-center text-white px-6 pt-20">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold">
                Welcome to the BatStateU <br> ACTION Center
            </h1>
            <p class="text-lg sm:text-xl mt-10 max-w-xl">
                Adaptive Capacity-building and Technology Innovation for Occupational Hazards and Natural Disasters.
            </p>
        </div>
    </div>

    <!-- About Us Section -->
    <div id="aboutus" class="py-20 bg-gray-100 text-center" style="font-family: 'Times New Roman', serif; font-size: 18px;">
        <h2 class="text-3xl sm:text-4xl font-bold">About Us</h2>
        <p class="mt-4 max-w-2xl mx-auto">
            The BatStateU ACTION Center is the home for community folks, barangay leaders, local executives, disaster managers, researchers, partner civil society organizations, and other stakeholders needing assistance and support to enhance their knowledge and skills on disaster preparedness and response.
        </p>
        <p class="mt-6 max-w-2xl mx-auto">
            BatStateU ACTION Center operates under the Office of the University President in collaboration with partner Local Government Units (LGUs), Regional Line Agencies (RLAs), and private organizations at the local, national, and international levels.
        </p>

        <h3 class="text-2xl sm:text-3xl font-semibold mt-8">The ACTION Center aims to:</h3>
        <ul class="list-disc list-inside mt-4 max-w-2xl mx-auto text-left">
            <li>Protect whatever economic gains people and communities have garnered through formal education and research using science and technology.</li>
            <li>Take a proactive role in making people and communities safer and more resilient to save their lives and properties in times of natural calamities through professional education, skills training, and innovative research.</li>
            <li>Make local leaders and communities more aware of the dangers of natural hazards and be prepared when such disasters occur.</li>
            <li>Inform people and communities about all possible natural hazards in their areas, the warning information, and the suggested actions to take during these events.</li>
        </ul>
    </div>

    <!-- JavaScript for Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection