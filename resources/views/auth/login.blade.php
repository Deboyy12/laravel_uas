<x-guest-layout>
    <style>
        /* Menyusun layout */
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            position: relative;
        }

        /* Container untuk form login */
        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Watermark Logo */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0.1;
        }

        .watermark img {
            width: 300px;
            height: auto;
        }

        /* Sesuaikan tampilan form input */
        .form-input {
            margin-bottom: 1rem;
        }

        .form-input input {
            padding: 0.75rem;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-input button {
            padding: 0.75rem;
            width: 100%;
            background-color: #3490dc;
            border: none;
            border-radius: 5px;
            color: white;
        }

        /* Tombol Captcha */
        .custom-btn {
            padding: 0.5rem; /* Padding lebih kecil */
            font-size: 12px; /* Ukuran font lebih kecil */
            width: 20px; /* Lebar tombol lebih kecil */
            height: 20px; /* Tinggi tombol lebih kecil */
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%; /* Tombol bulat */
            border: none; /* Menghilangkan border */
            background-color: #f1f1f1; /* Warna latar belakang tombol */
            cursor: pointer; /* Efek kursor */
        }

        /* Tombol Remember Me */
        input[type="checkbox"] {
            width: 15px;
            height: 15px;
            margin-right: 5px;
        }

        span.text-sm {
            font-size: 12px;
        }
    </style>

    <!-- Session Status -->
    <div class="container">
        <!-- Watermark Logo -->
        <div class="watermark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-input">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-input mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 form-input">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- CAPTCHA -->
            <div class="mt-4 form-input">
                <x-input-label for="captcha" :value="__('Masukkan Captcha')" />
                <div class="flex items-center">
                    <img src="{{ captcha_src() }}" alt="CAPTCHA" class="captcha-img">
                    <button type="button" onclick="refreshCaptcha()" class="mr-1 custom-btn">🔄</button>
                </div>
                <x-text-input id="captcha" class="block mt-2 w-full" type="text" name="captcha" required />
                <x-input-error :messages="$errors->get('captcha')" class="mt-2 text-red-600" />
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>

<script>
    function refreshCaptcha() {
        fetch('/refresh-captcha')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.captcha-img').src = data.captcha;
            });
    }
</script>
