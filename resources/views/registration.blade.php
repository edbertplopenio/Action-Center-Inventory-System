@extends('layout')
@section('title', 'Registration')
@section('content')

<!-- Phosphor Icons -->
<link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/regular/style.css">

<div class="relative min-h-screen flex justify-center items-center px-6">
  <img class="absolute w-full h-full object-cover" src="{{ asset('images/REGBG.png') }}" alt="Background Image">

  <div class="relative z-10 bg-white bg-opacity-40 backdrop-blur-xl p-3 rounded-2xl shadow-lg min-h-[80px] flex flex-col items-center justify-center"
    style="width: calc(33.33% + 192px); transform: translateX(35%);">

    <div class="w-full flex flex-col">
      <h2 class="mt-2 text-lg font-semibold mb-2 text-center text-white">Create a new account</h2>

      <form id="registrationForm" class="space-y-3 flex flex-col items-center" action="{{ route('registration.post') }}" method="POST">
        @csrf

        <!-- First & Last Name -->
        <div class="grid grid-cols-2 gap-3 w-full">
          <div class="flex flex-col">
            <label for="first_name" class="text-xs font-medium text-white mb-1 ml-20">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
              class="w-64 ml-auto rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 focus:ring-2 focus:ring-red-600" required>
            @error('first_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
          <div class="flex flex-col">
            <label for="last_name" class="text-xs font-medium text-white mb-1">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
              class="w-64 rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 focus:ring-2 focus:ring-red-600" required>
            @error('last_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
        </div>

        <!-- Email & Department -->
        <div class="grid grid-cols-2 gap-3 w-full">
          <div class="flex flex-col">
            <label for="email" class="text-xs font-medium text-white mb-1 ml-20">Email address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
              class="w-64 ml-auto rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 focus:ring-2 focus:ring-red-600" required>
            @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
          <div class="flex flex-col">
            <label for="department" class="text-xs font-medium text-white mb-1">Department</label>
            <input type="text" name="department" id="department" value="{{ old('department') }}"
              class="w-64 rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 focus:ring-2 focus:ring-red-600" required>
            @error('department') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
          </div>
        </div>

        <!-- Password & Confirm Password -->
        <div class="grid grid-cols-2 gap-3 w-full">
          <!-- Password -->
          <div class="flex flex-col relative">
            <label for="password" class="text-xs font-medium text-white mb-1 ml-20">Password</label>
            <div class="w-64 ml-auto relative">
              <input type="password" name="password" id="password"
                class="w-full pr-8 rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 focus:ring-2 focus:ring-red-600" required>
              <button type="button" id="togglePassword" class="absolute top-1/2 right-2 transform -translate-y-1/2">
                <i id="eyeIcon" class="ph ph-eye text-black text-lg"></i>
              </button>
            </div>
            @error('password') <span class="text-red-600 text-xs ml-auto">{{ $message }}</span> @enderror

            <!-- Password Checklist -->
            <div id="passwordChecklist" class="text-xs space-y-1 w-64 ml-auto mt-2">
              <p class="font-semibold text-white mb-1">Password must contain:</p>
              <div id="rule-length" class="flex items-center gap-2"><span class="check-icon text-white">•</span><span class="text-white">At least 8 characters</span></div>
              <div id="rule-lower" class="flex items-center gap-2"><span class="check-icon text-white">•</span><span class="text-white">At least 1 lowercase letter (a–z)</span></div>
              <div id="rule-upper" class="flex items-center gap-2"><span class="check-icon text-white">•</span><span class="text-white">At least 1 uppercase letter (A–Z)</span></div>
              <div id="rule-number" class="flex items-center gap-2"><span class="check-icon text-white">•</span><span class="text-white">At least 1 number (0–9)</span></div>
              <div id="rule-symbol" class="flex items-center gap-2"><span class="check-icon text-white">•</span><span class="text-white">At least 1 special symbol (!@#$...)</span></div>
            </div>
          </div>

         <!-- Confirm Password -->
<div class="flex flex-col relative">
  <label for="password_confirmation" class="text-xs font-medium text-white mb-1">Confirm Password</label>
  <div class="w-64 relative">
    <input type="password" name="password_confirmation" id="password_confirmation"
      class="w-full pr-8 rounded-md border border-gray-300 px-2 py-1.5 text-xs text-gray-900 focus:ring-2 focus:ring-red-600" required>
    <button type="button" id="toggleConfirmPassword" class="absolute top-1/2 right-2 transform -translate-y-1/2">
      <i id="eyeConfirmIcon" class="ph ph-eye text-black text-lg"></i>
    </button>
  </div>
  <span id="confirmMessage" class="text-xs mt-1"></span>
  @error('password_confirmation') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
</div>


        <!-- Terms -->
      

<!-- Submit -->
<div class="flex justify-start">
  <div class="w-80 ml-72"> <!-- Adjusted width, slightly wider container -->
    <button type="submit" class="w-full flex justify-center rounded-md px-7 py-3 text-sm font-semibold text-white hover:bg-blue-600 focus:ring-2 focus:ring-red-600"
      style="background-color: #780000;">
      Register
    </button>

    <p class="mt-3 text-center text-xs text-white">
      Already a member? <a href="{{ route('login') }}" class="font-semibold text-blue-500 hover:text-blue-600">Sign in</a>
    </p>
  </div>
</div>
</form>




<!-- Remove browser's default eye icon -->
<style>
  input::-ms-reveal,
  input::-ms-clear {
    display: none;
  }

  input[type="password"]::-webkit-credentials-auto-fill-button {
    visibility: hidden;
    display: none !important;
    pointer-events: none;
    height: 0;
    width: 0;
    margin: 0;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Remove the original registration_success alert --}}
@if (session('status') == 'verification_pending')
<script>
  Swal.fire({
    icon: 'info',
    title: 'Account Activation Required',
    html: 'To activate your account, we will send a verification link to your email address. Please check your inbox and follow the instructions to activate your account.',
    confirmButtonText: 'OK',
    confirmButtonColor: '#780000',
  });
</script>
@endif

@if (session('status') == 'error')
<script>
  Swal.fire({
    icon: 'error',
    title: 'Registration Failed',
    text: 'There was an issue processing your registration. Please try again.',
    confirmButtonColor: '#780000',
  });
</script>
@endif

<script>
  // Password visibility toggles using Phosphor icons
  function toggleEye(buttonId, inputId, iconId) {
    const button = document.getElementById(buttonId);
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    button.addEventListener('click', () => {
      const isVisible = input.type === 'text';
      input.type = isVisible ? 'password' : 'text';
      icon.classList.toggle('ph-eye', isVisible);
      icon.classList.toggle('ph-eye-slash', !isVisible);
    });
  }

  toggleEye('togglePassword', 'password', 'eyeIcon');
  toggleEye('toggleConfirmPassword', 'password_confirmation', 'eyeConfirmIcon');

  // Password validation checklist
  document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const rules = {
      length: val.length >= 8,
      lower: /[a-z]/.test(val),
      upper: /[A-Z]/.test(val),
      number: /\d/.test(val),
      symbol: /[^A-Za-z0-9]/.test(val),
    };

    for (let id in rules) updateRule(`rule-${id}`, rules[id]);
  });

  function updateRule(id, passed) {
    const el = document.getElementById(id);
    const icon = el.querySelector('.check-icon');
    icon.textContent = passed ? '✔' : '•';

    // Force visual red glow
    icon.style.color = passed ? '#ff3b3b' : '#ffffff';
    icon.style.fontWeight = passed ? 'bold' : 'normal';
    icon.style.textShadow = passed ? '0 0 3px #ff3b3b' : 'none';
  }

  // ✅ Confirm password live validation
  const passwordInput = document.getElementById('password');
  const confirmInput = document.getElementById('password_confirmation');
  const confirmMessage = document.getElementById('confirmMessage');

  confirmInput.addEventListener('input', function () {
    const password = passwordInput.value;
    const confirmPassword = confirmInput.value;

    if (confirmPassword.length === 0) {
      confirmMessage.textContent = '';
      return;
    }

    if (password === confirmPassword) {
      confirmMessage.textContent = '✅ Passwords match';
      confirmMessage.classList.remove('text-red-500');
      confirmMessage.classList.add('text-green-500');
    } else {
      confirmMessage.textContent = '❌ Passwords do not match';
      confirmMessage.classList.remove('text-green-500');
      confirmMessage.classList.add('text-red-500');
    }
  });
</script>
@endsection