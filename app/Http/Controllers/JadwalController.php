<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = jadwal::query();
        if ($request->filled('nama_shift')){
            $query->where('nama_shift', $request->nama_shift);
        }
        $jadwals = $query->paginate(10);
        return view('jadwal.index', compact('jadwals'));
    }
    public function create()
    {
        return view('jadwal.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_shift' => 'required|unique:jadwals,nama_shift',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required|after:jam_masuk'
        ], [
            'nama_shift.unique' => 'Shift sudah ada',
            'nama_shift.required' => 'Mohon isi nama shift',
            'jam_masuk.required' => 'Mohon iai jam masuk',
            'jam_keluar' => 'Mohon isi jam keluar',
            'jam_keluar.after' => 'Jam keluar harus lebih besar daripada jam masuk'
        ]);
        jadwal::create($validate);
        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil ditambahkan');
    }
    public function edit($id)
    {
        $jadwal = jadwal::find($id);
        return view('jadwal.edit', compact('jadwal'));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_shift' => 'required|unique:jadwals,nama_shift',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required'
        ], [
            'nama_shift.unique' => 'Shift sudah ada',
            'nama_shift.required' => 'Mohon isi nama shift',
            'jam_masuk.required' => 'Mohon iai jam masuk',
            'jam_keluar' => 'Mohon isi jam keluar'
        ]);
        $jadwal = jadwal::find($id)->update($validate);
        return redirect()->route('jadwals.index')->with('success', 'Data berhasil diupdate!');
    }
    public function destroy($id)
    {
        $jadwal = jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwals.index')->with('success', 'Data berhasil dihapus!');
    }
}
