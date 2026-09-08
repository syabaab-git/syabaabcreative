<x-guest-layout>
    <div class="mb-10 text-center">
        <h3 class="text-[26px] font-black text-slate-900 tracking-tight leading-none">Buat Akun Baru</h3>
        <p class="text-[13px] font-medium text-slate-500 mt-3">Daftar dan bergabung ke layanan syabaab creative.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
            <input id="name" class="mt-1 block w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap kamu">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Alamat Email</label>
            <input id="email" class="mt-1 block w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Alamat email kamu">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Kata Sandi</label>
            <input id="password" class="mt-1 block w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium transition-colors" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="mt-1 block w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium transition-colors" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-[16px] shadow-sm text-[14px] font-bold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none transition-all hover:-translate-y-0.5 hover:shadow-lg">
                Daftar Sekarang
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm font-medium text-slate-500">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors">Masuk di sini</a>
    </div>
</x-guest-layout>
