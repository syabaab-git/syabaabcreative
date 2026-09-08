<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900">
            {{ __('Informasi Dasar') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __("Perbarui nama dan alamat email untuk profil publik Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Avatar Upload -->
        <div x-data="avatarPreview()">
            <label for="avatar" class="block font-medium text-sm text-slate-700 mb-2">{{ __('Foto Profil') }}</label>
            <div class="flex items-center gap-4">
                <div class="relative w-16 h-16 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200">
                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!imageUrl && removeAvatar == 0">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-xl uppercase bg-gradient-to-br from-slate-100 to-slate-200">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </template>
                    <template x-if="!imageUrl && removeAvatar == 1">
                        <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-xl uppercase bg-gradient-to-br from-slate-100 to-slate-200">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </template>
                </div>
                <div>
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" @change="fileChosen">
                    <input type="hidden" name="remove_avatar" :value="removeAvatar">
                    
                    <div class="flex items-center gap-2">
                        <button type="button" @click="document.getElementById('avatar').click()" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition shadow-sm">
                            Pilih Foto
                        </button>
                        
                        @if($user->avatar)
                        <button type="button" @click="removeAvatar = 1; imageUrl = null; document.getElementById('avatar').value = '';" x-show="removeAvatar == 0" style="display: none;" class="px-3 py-1.5 bg-red-50 border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-100 transition shadow-sm">
                            Hapus
                        </button>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-slate-500">JPG, JPEG, atau PNG. Maks 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>
        
        <script>
            function avatarPreview() {
                return {
                    imageUrl: null,
                    removeAvatar: 0,
                    fileChosen(event) {
                        this.removeAvatar = 0;
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },
                    fileToDataUrl(event, callback) {
                        if (! event.target.files.length) return
                        let file = event.target.files[0],
                            reader = new FileReader()
                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            }
        </script>

        <div>
            <label for="name" class="block font-medium text-sm text-slate-700">{{ __('Nama Lengkap') }}</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block font-medium text-sm text-slate-700">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 bg-amber-50 border border-amber-200 rounded-lg p-3">
                    <p class="text-sm text-amber-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="font-bold underline text-amber-900 hover:text-amber-700 focus:outline-none ml-1">
                            {{ __('Klik di sini untuk mengirim ulang link verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Link verifikasi yang baru telah dikirimkan ke email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
            <button type="submit" class="settings-submit-btn inline-flex items-center px-4 py-2 border rounded-xl shadow-sm font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-600 flex items-center"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
