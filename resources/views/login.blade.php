@extends('layout')
@section('title', 'Login')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="relative min-h-screen flex justify-center items-center bg-gray-100">
  <!-- Background Image Covering Full Screen -->
  <div class="absolute inset-0 w-full h-full">
    <img class="w-full h-full object-cover" src="{{ asset('images/BG.png') }}" alt="Background Image">
  </div>

  <!-- Login Form Container (Blurred Background but Sharp Text) -->
  <div class="relative z-10 bg-white bg-opacity-40 backdrop-blur-xl p-8 rounded-2xl shadow-lg w-96 flex flex-col items-center"
    style="backdrop-filter: blur(10px); transform: translateX(45%);">


    @if(session('status') == 'login_error')
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: 'Invalid credentials. Please try again.'
      });
    </script>
    @endif

    @if(session('status') == 'inactive_account')
    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Account Inactive',
        text: 'Please verify your email before logging in.'
      });
    </script>
    @endif

    @if(session('status') == 'verification_success')
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Email Verified!',
        text: 'Your account has been activated. You may now log in.'
      });
    </script>
    @endif


    <!-- Display Validation Errors -->
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
        html: errorMessages,
        confirmButtonText: 'OK'
      });
    </script>
    @endif

    <form class="space-y-4 flex flex-col items-center w-full" action="{{ route('login.post') }}" method="POST">
      @csrf
      <div class="flex flex-col w-3/4">
        <label for="email" class="text-xs font-medium text-white mb-1">Email address</label>
        <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-900 focus:ring-2 focus:ring-gray-500">
      </div>

      <div class="flex flex-col w-3/4">
        <label for="password" class="text-xs font-medium text-white mb-1">Password</label>
        <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-900 focus:ring-2 focus:ring-gray-500">
      </div>

      <!-- Forgot Password Link -->
      <div class="flex items-center w-3/4">
        <a href="#" id="forgotPasswordLink" class="text-xs text-white hover:underline">Forgot password?</a>
      </div>

      <button type="submit" class="w-auto px-20 py-2 text-xs font-semibold text-white rounded-md hover:bg-red- 00 focus:ring-2 focus:ring-red-600" style="background-color: #780000;">
        Login
      </button>

      <p class="mt-4 text-center text-xs text-white">
        Not a member? <a href="{{ route('registration') }}" class="font-semibold text-blue-400 hover:text-blue-500">Create an account</a>
      </p>
  </div>
</div>

<!-- SweetAlert Messages -->
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

@if (session('status') == 'account_inactive')
<script>
  Swal.fire({
    icon: 'error',
    title: 'Account Inactive',
    text: 'Your account is inactive. Please contact an administrator.',
    confirmButtonText: 'OK'
  });
</script>
@endif



<!-- Modal HTML -->
<div class="relative z-10" id="forgotPasswordModal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <!-- Backdrop with blur effect -->
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
              <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-base font-semibold text-gray-900" id="modal-title">Reset your password</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">Please enter your email address below to receive a password reset link.</p>
                <input type="email" id="resetEmail" placeholder="Enter your email" class="mt-2 w-full rounded-md border-gray-300 p-2 text-sm text-gray-900 focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
          <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto" id="resetPasswordBtn">Send reset link</button>
          <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" id="cancelModalBtn">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
  // Get modal and buttons
  const forgotPasswordLink = document.getElementById('forgotPasswordLink'); // Ensure this is defined in your HTML
  const forgotPasswordModal = document.getElementById('forgotPasswordModal');
  const cancelModalBtn = document.getElementById('cancelModalBtn');
  const resetPasswordBtn = document.getElementById('resetPasswordBtn');
  const resetEmail = document.getElementById('resetEmail');

  // Open modal when forgot password link is clicked
  forgotPasswordLink.addEventListener('click', function(event) {
    event.preventDefault();
    forgotPasswordModal.style.display = 'block'; // Show modal
    setTimeout(function() {
      forgotPasswordModal.classList.add('show'); // Add 'show' class for opacity transition
    }, 10);
  });

  // Close modal when cancel button is clicked
  cancelModalBtn.addEventListener('click', function() {
    forgotPasswordModal.classList.remove('show'); // Remove 'show' class for fade-out transition
    setTimeout(function() {
      forgotPasswordModal.style.display = 'none'; // Hide modal after fade-out
    }, 300); // Time matches the transition duration (0.3s)
  });

  // Optional: Close modal if clicking outside the modal content
  window.addEventListener('click', function(event) {
    if (event.target === forgotPasswordModal) {
      forgotPasswordModal.classList.remove('show'); // Remove 'show' class for fade-out transition
      setTimeout(function() {
        forgotPasswordModal.style.display = 'none'; // Hide modal after fade-out
      }, 300); // Time matches the transition duration (0.3s)
    }
  });

  // Handle the reset password button click
  resetPasswordBtn.addEventListener('click', function() {
    const emailValue = resetEmail.value.trim(); // Get the trimmed email input value

    if (emailValue === "") {
      // If email is empty, show SweetAlert
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please enter your email address!',
      });
    } else {
      // Send email to the server for validation (check if the email exists)
      fetch('/validate-email', { // Replace with the correct URL for email validation
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token for security
          },
          body: JSON.stringify({
            email: emailValue
          }),
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // If email is valid, show success alert
            Swal.fire({
              icon: 'success',
              title: 'Password reset link sent!',
              text: 'Check your email for the reset link.',
            }).then(() => {
              // Close the modal after success
              forgotPasswordModal.classList.remove('show'); // Remove 'show' class for fade-out transition
              setTimeout(function() {
                forgotPasswordModal.style.display = 'none'; // Hide modal after fade-out
              }, 300); // Time matches the transition duration (0.3s)
            });
          } else {
            // If email does not exist or is invalid, show error alert
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'This email is not registered or is invalid. Please try again.',
            });
          }
        })
        .catch(error => {
          // Handle error if the server fails to respond
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while processing your request. Please try again later.',
          });
        });
    }
  });
</script>




<style>
  /* Backdrop - apply blur and darken the background */
  #forgotPasswordModal .backdrop-blur-sm {
    backdrop-filter: blur(10px);
    /* Adjust blur strength here */
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent dark background */
    transition: opacity 0.3s ease;
    /* Smooth fade-in effect for the backdrop */
  }

  #forgotPasswordModal {
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.3s ease, visibility 0.3s ease;
  }

  #forgotPasswordModal.show {
    visibility: visible;
    opacity: 1;
  }

  /* Optional: Add opacity transition for the backdrop */
  #forgotPasswordModal .backdrop-blur-sm {
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  #forgotPasswordModal.show .backdrop-blur-sm {
    opacity: 1;
  }
</style>

@endsection