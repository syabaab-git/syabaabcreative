<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi publik dan keamanan akun Anda.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-6 sm:p-10 bg-white shadow-sm border border-slate-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-sm border border-slate-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-red-50/50 shadow-sm border border-red-100 sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
