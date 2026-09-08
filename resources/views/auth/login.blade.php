<x-guest-layout>
    <div class="mb-10 text-center">
        <h3 class="text-[26px] font-black text-slate-900 tracking-tight leading-none">Selamat Datang!</h3>
        <p class="text-[13px] font-medium text-slate-500 mt-3">Masuk ke akun Anda untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Alamat Email</label>
            <input id="email" class="mt-1 block w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Kata Sandi</label>
            <input id="password" class="mt-1 block w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium transition-colors" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" name="remember">
                <span class="ms-2 text-[13px] font-bold text-slate-600">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[13px] font-bold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-[16px] shadow-sm text-[14px] font-bold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none transition-all hover:-translate-y-0.5 hover:shadow-lg">
                Masuk ke Dashboard
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm font-medium text-slate-500">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors">Daftar sekarang</a>
    </div>
</x-guest-layout>
