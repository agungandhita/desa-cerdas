<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan role
        if ($request->has('role') && $request->role !== '') {
            $role = $request->role;
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        // Pencarian berdasarkan nama atau email
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->latest('created_at')->paginate(10);

        // Statistik sederhana
        $statistics = [
            'total' => User::count(),
            'admin' => User::role('admin')->count(),
            'operator' => User::role('operator')->count(),
            'warga' => User::role('warga')->count(),
        ];

        $roles = Role::all()->pluck('name');

        return view('admin.users.index', compact('users', 'statistics', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nik' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'], // casted to hashed automatically
                'nik' => $validated['nik'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            ]);

            $user->syncRoles($validated['roles']);

            Alert::success('Berhasil', 'Pengguna berhasil ditambahkan');
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menambahkan pengguna');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'nik' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nik' => $validated['nik'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            ];

            if (!empty($validated['password'])) {
                $data['password'] = $validated['password']; // auto-hashed via cast
            }

            $user->update($data);
            $user->syncRoles($validated['roles']);

            Alert::success('Berhasil', 'Pengguna berhasil diperbarui');
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui pengguna');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Cegah menghapus diri sendiri
            if (Auth::id() === $user->id) {
                Alert::warning('Tidak Diizinkan', 'Anda tidak dapat menghapus akun Anda sendiri');
                return back();
            }

            $user->delete();
            Alert::success('Berhasil', 'Pengguna berhasil dihapus');
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus pengguna');
            return back();
        }
    }
}