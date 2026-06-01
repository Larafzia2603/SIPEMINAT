<x-guest-layout>
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-gray-600 mt-1">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Role -->
        <div>
            <x-input-label for="role" :value="__('Role')" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <select id="role" name="role" class="block w-full rounded-lg border border-gray-300 bg-white pl-10 pr-3 py-2.5 text-gray-900 shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200" required>
                    <option value="mahasiswa" @selected(old('role') === 'mahasiswa')>Mahasiswa</option>
                    <option value="dosen_pa" @selected(old('role') === 'dosen_pa')>Dosen PA</option>
                    <option value="kaprodi" @selected(old('role') === 'kaprodi')>Kaprodi</option>
                    <option value="dekan" @selected(old('role') === 'dekan')>Dekan</option>
                </select>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Identifier -->
        <div>
            <x-input-label for="login" :value="__('NIM / Stambuk')" id="login-label" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm4 3h6m-6 4h6m-6 4h3" />
                    </svg>
                </div>
                <x-text-input id="login" class="pl-10" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="Cth: 2204010123" data-login-input />
            </div>
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
            <p class="mt-2 text-xs text-gray-500" id="login-help">Mahasiswa login dengan NIM/Stambuk.</p>
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="pl-10 pr-10" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" data-password-toggle data-target="password" aria-label="Toggle password visibility" aria-pressed="false">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 transition-all duration-200" name="remember">
                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors duration-200">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors duration-200" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="space-y-4">
            <x-primary-button class="w-full justify-center py-3 text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('register'))
                <div class="text-center">
                    <span class="text-sm text-gray-600">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium ml-1 transition-colors duration-200">
                        Daftar sekarang
                    </a>
                </div>
            @endif
        </div>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const loginLabel = document.getElementById('login-label');
        const loginInput = document.querySelector('[data-login-input]');
        const loginHelp = document.getElementById('login-help');

        const updateLoginLabel = () => {
            if (!roleSelect || !loginLabel || !loginInput || !loginHelp) {
                return;
            }

            const role = roleSelect.value;

            if (role === 'mahasiswa') {
                loginLabel.textContent = 'NIM / Stambuk';
                loginInput.placeholder = 'Cth: 2204010123';
                loginHelp.textContent = 'Mahasiswa login dengan NIM/Stambuk.';
            } else {
                loginLabel.textContent = 'NIP';
                loginInput.placeholder = 'Cth: 19870101001';
                loginHelp.textContent = 'Dosen, kaprodi, dan dekan login dengan NIP.';
            }
        };

        updateLoginLabel();
        roleSelect?.addEventListener('change', updateLoginLabel);

        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            });
        });
    </script>
</x-guest-layout>
