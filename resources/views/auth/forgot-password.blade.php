<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-white p-6">

        <div class="w-full max-w-md bg-white/90 backdrop-blur-lg shadow-2xl rounded-2xl p-8">

            <!-- Title -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    Lupa Password?
                </h2>
                <p class="text-sm text-gray-500 mt-2">
                    Masukkan email kamu dan kami akan mengirimkan link untuk reset password.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Button -->
                <div class="mt-6">
                    <x-primary-button
                        class="w-full justify-center py-3 text-base rounded-lg bg-indigo-600 hover:bg-indigo-700 transition duration-300">
                        Kirim Link Reset Password
                    </x-primary-button>
                </div>
            </form>

            <!-- Back to Login -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">
                    ← Kembali ke Login
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
