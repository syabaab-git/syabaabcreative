<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-700">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-red-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Mohon unduh data apa pun yang ingin Anda simpan sebelum menghapus akun.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl shadow-sm font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        {{ __('Hapus Akun Permanen') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda secara permanen?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Tindakan ini tidak dapat dibatalkan. Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini beserta seluruh isinya secara permanen.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 rounded-xl border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 transition"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
