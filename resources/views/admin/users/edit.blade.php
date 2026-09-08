<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- HEADER -->
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Edit Pengguna</h2>
            </div>

            <!-- FORM CARD -->
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required autofocus>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Role -->
                            @php $userRole = $user->roles->first(); @endphp
                            <div>
                                <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Jabatan (Role) <span class="text-red-500">*</span></label>
                                <div x-data="{ open: false, value: '{{ old('role_id') ?? optional($userRole)->id }}', label: '{{ optional($userRole)->label ?? optional($userRole)->name ?? 'Pilih hak akses' }}' }" class="relative">
                                    <input type="hidden" name="role_id" x-model="value">
                                    <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 px-0 py-2 text-[16px] font-medium text-slate-900 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                        <span x-text="label"></span>
                                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-[16px] shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                                        <div class="max-h-60 overflow-y-auto p-2">
                                            @foreach($roles as $role)
                                                <button type="button" @click="value = '{{ $role->id }}'; label = '{{ $role->label ?? $role->name }}'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between" :class="value == '{{ $role->id }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 font-medium'">
                                                    {{ $role->label ?? $role->name }}
                                                    <svg x-show="value == '{{ $role->id }}'" class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                            </div>

                            <!-- Password Section -->
                            <div class="pt-6 border-t border-slate-100">
                                <h3 class="text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-4">Ganti Password <span class="text-slate-400 font-normal normal-case">(Opsional)</span></h3>
                                <div class="space-y-6">
                                    <div>
                                        <label for="password" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Password Baru</label>
                                        <input type="password" name="password" id="password" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" placeholder="Biarkan kosong jika tidak ingin menggantinya">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors">
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-slate-700 font-bold text-[15px] rounded-2xl hover:bg-slate-50 transition-all border border-slate-200 w-full sm:w-auto">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-2xl hover:bg-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
