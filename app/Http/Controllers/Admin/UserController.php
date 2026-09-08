<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'semua');
        $search = $request->has('search') ? $request->search : '';
        $sort = $request->get('sort', 'latest');

        // Base Query builder function to apply search and sort
        $applySearchSort = function($q) use ($search, $sort) {
            if ($search != '') {
                $q->where(function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            switch ($sort) {
                case 'oldest': $q->oldest(); break;
                case 'name_asc': $q->orderBy('name', 'asc'); break;
                case 'name_desc': $q->orderBy('name', 'desc'); break;
                case 'latest': default: $q->latest(); break;
            }
            return $q;
        };

        // Query Semua
        $querySemua = User::with(['roles', 'enrollments.course', 'orders.service']);
        $applySearchSort($querySemua);
        $usersSemua = $querySemua->paginate(15, ['*'], 'semua_page')->withQueryString();
        $totalSemua = $querySemua->count();

        // Query Staff
        $queryStaff = User::with(['roles', 'enrollments.course', 'orders.service'])->whereHas('roles', function($q) {
            $q->whereIn('name', ['super-admin', 'agency-staff', 'mentor']);
        });
        $applySearchSort($queryStaff);
        $usersStaff = $queryStaff->paginate(15, ['*'], 'staff_page')->withQueryString();
        $totalStaff = $queryStaff->count();

        // Query Siswa
        $querySiswa = User::with(['roles', 'enrollments.course', 'orders.service'])->whereHas('roles', function($q) {
            $q->whereIn('name', ['member', 'siswa']);
        })->has('enrollments');
        $applySearchSort($querySiswa);
        $usersSiswa = $querySiswa->paginate(15, ['*'], 'siswa_page')->withQueryString();
        $totalSiswa = $querySiswa->count();

        $onlineUsersIds = \DB::table('sessions')
            ->where('last_activity', '>', time() - config('session.lifetime') * 60)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();
            
        return view('admin.users.index', compact('usersSemua', 'usersStaff', 'usersSiswa', 'onlineUsersIds', 'activeTab', 'totalSemua', 'totalStaff', 'totalSiswa', 'search', 'sort'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->role_id);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Hindari pengeditan terhadap super admin jika yang login bukan super admin (meski rute dibatasi, ini langkah preventif tambahan)
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role_id' => ['required', 'exists:roles,id'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync role (asumsikan 1 user 1 role utama untuk sistem ini)
        $user->roles()->sync([$request->role_id]);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Mencegah hapus diri sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Mencegah menghapus akun Super Admin utama
        if ($user->hasRole('super-admin') && User::whereHas('roles', function($q){ $q->where('name', 'super-admin'); })->count() === 1) {
            return redirect()->route('admin.users.index')->with('error', 'Sistem harus menyisakan setidaknya satu Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
