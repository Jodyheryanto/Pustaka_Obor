<x-guest-layout>
    <x-jet-authentication-card>
        <!-- logo -->
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" style="border-radius: 0;" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <div class="input-group block mt-1 w-full">
                    <div class="input-group-area"><x-jet-input id="password" style="border-radius: 0;" type="password" name="password" required autocomplete="current-password" /></div>
                    <div class="input-group-icon" onclick="switchVisibility()"><i class="fas fa-eye eyeClass"></i></div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<script>
    function switchVisibility() {
        $('#password').prop('type') == 'password' ? $('#password').prop('type', 'text') : $('#password').prop('type', 'password');
    }
</script>
