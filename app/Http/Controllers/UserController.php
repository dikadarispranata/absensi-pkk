<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use App\Models\jabatan;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['departemen', 'jabatan']);
        $departemens = departemen::all();
        $jabatans = jabatan::all();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('departemens_id')) {
            $query->where('departemens_id', $request->departemens_id);
        }
        if ($request->filled('jabatans_id')) {
            $query->where('jabatans_id', $request->jabatans_id);
        }
        if ($request->filled('role')){
            $query->where('role', $request->role);
        }
        $users = $query->paginate(10);

        return view('karyawan.index', compact('users', 'departemens', 'jabatans'));
    }

    public function create()
    {
        $departemens = departemen::all();
        $jabatans = jabatan::all();
        return view('karyawan.create', compact('departemens', 'jabatans'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|unique:users',
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6',
                'no_hp' => 'required',
                'alamat' => 'required',
                'departemens_id' => 'required',
                'jabatans_id' => 'required',
                'role' => 'required'
            ],
            [
                'username.unique' => 'Username sudah dipakai',
                'email.unique' => 'Email sudah dipakai',
                'password.min' => 'Password minimal 6 huruf'
            ]
        );
        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'departemens_id' => $request->departemens_id,
            'jabatans_id' => $request->jabatans_id,
            'role' => $request->role,
        ]);
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }
    public function edit(User $karyawan)
    {
        $departemens = departemen::all();
        $jabatans = jabatan::all();

        return view('karyawan.edit', compact('karyawan', 'departemens', 'jabatans'));
    }
    public function update(Request $request, User $karyawan)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $karyawan->id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'no_hp' => 'required',
            'alamat' => 'required',
            'departemens_id' => 'required',
            'jabatans_id' => 'required',
            'role' => 'required',
        ]);
        $data = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $karyawan->password,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'departemens_id' => $request->departemens_id,
            'jabatans_id' => $request->jabatans_id,
            'role' => $request->role,
        ];
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $karyawan->update($data);
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui');
    }
    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }

}
