<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\jadwal;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $query = jabatan::query();
        if ($request->filled('nama_jabatan')){
            $query->where('nama_jabatan', $request->nama_jabatan);
        }
        $jabatans = $query->paginate(10);
        return view('jabatan.index', compact('jabatans'));
    }
    public function create()
    {
        return view('jabatan.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan'
        ], [
            'nama_jabatan.required' => 'Mohon isi nama jabatan',
            'nama_jabatan.unique' => 'Nama jabatan sudah digunakan'
        ]);
        jabatan::create($validate); 
        return redirect()->route('jabatans.index')->with('success', 'Jabatan berhasil ditambahkan');
    }
    public function edit($id)
    {
        $jabatan = jabatan::find($id);
        return view('jabatan.edit', compact('jabatan'));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan,' . $id,
        ], [
            'nama_jabatan.required' => 'Mohon isi nama jabatan',
            'nama_jabatan.unique' => 'Nama jabatan sudah digunakan'
        ]);
        $jabatan = jabatan  ::find($id)->update($validate);
        return redirect()->route('jabatans.index')->with('success', 'Data berhasil diupdate!');
    }
    public function destroy($id)
    {
        $jabatan = jabatan::findOrFail($id);
        $jabatan->delete();
        return redirect()->route('jabatans.index')->with('success', 'Data berhasil dihapus!');
    }
}
