<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $query = departemen::query();
        if ($request->filled(key: 'nama_departemen')) {
            $query->where('nama_departemen', $request->nama_departemen);
        }
        $departemens = $query->paginate(10);
        return view('departemen.index', compact('departemens'));
    }
    public function create()
    {
        return view('departemen.create');
    }
    public function store(Request $request)
    {
        $vvalidate = $request->validate(
            [
                'nama_departemen' => 'required|unique:departemens,nama_departemen'
            ],
            [
                'nama_departemen.unique' => 'Departemen sudah ada!',
                'nama.departemen.required' => 'Mohon isi departemen '
            ]
        );
        departemen::create($vvalidate);
        return redirect()->route('departemens.index')->with('success', 'Departemen berhasil ditambahkan');
    }
    public function edit($id)
    {
        $departemen = departemen::find($id);
        return view('departemen.edit', compact('departemen'));
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate(
            [
                'nama_departemen' => 'required|unique:departemens,nama_departemen'
            ],
            [
                'nama_departemen.unique' => 'Departemen sudah ada!',
                'nama.departemen.required' => 'Mohon isi departemen '
            ]
        );
        $departemen = departemen::find($id)->update($validate);
        return redirect()->route('departemens.index')->with('success', 'Data berhasil diupdate!');
    }
    public function destroy($id)
    {
        $departemen = departemen::findOrFail($id);
        $departemen->delete();
        return redirect()->route('departemens.index')->with('success', 'Data berhasil dihapus!');
    }
}
