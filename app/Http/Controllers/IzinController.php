<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use App\Models\izin;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $izin = $request->input('izin');
        $tanggal_mulai = $request->input('tanggal_mulai');
        if (Auth::user()->role == 'admin') {
            $query = izin::with('user');
        } else {
            $query = izin::with('user')->where('users_id', Auth::id());
        }

        if ($status && $status != '') {
            $query->where('status', $status);
        }
        if ($tanggal_mulai) {
            $query->where('tanggal_mulai', $tanggal_mulai);
        }
        if ($izin && $izin != '') {
            $query->where('jenis_izin', $izin);
        }
        if ($request->filled('users_id')) {
            $query->where('users_id', $request->users_id);
        }
        $izins = $query->get();
        $izins = $query->paginate(7);
        $izins->appends($request->all());
        $users = User::all();
        return view('izins.index', compact('izins', 'users'));
    }
    public function create()
    {
        $users = User::all();
        return view('izins.create', compact('users'));
    }
    public function store(Request $request)
    {
        // $pending =
        $request->validate([
            'users_id' => 'required',
            'tanggal_mulai' => 'required|after_or_equal:today',
            'tanggal_selesai' => 'required|after_or_equal:today',
            'jenis_izin' => 'required',
            'alasan' => 'required',
            'status' => 'required'
        ], [
            'tanggal_mulai.after_or_equal' => "Tanggal mulai minimal hari ini.",
            'tanggal_selesai.after_or_equal' => "Tanggal selesai minimal hari ini.",
        ]);
        $user = Auth::user();
        $izinpending = Izin::where('users_id', $user->id)->where('status', 'pending')->exists();

        if (Auth::user()->role == 'admin') {
            izin::create([
                'users_id' => $request->users_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jenis_izin' => $request->jenis_izin,
                'alasan' => $request->alasan,
                'status' => $request->status
            ]);
        } else {
            if ($izinpending) {
                return redirect()->route('izins.index')->with('error', 'Anda masih memiliki pengajuan izin yang belum diproses.');
            }
            izin::create([
                'users_id' => Auth::user()->id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'jenis_izin' => $request->jenis_izin,
                'alasan' => $request->alasan,
                'status' => 'Pending'
            ]);
        }
        return redirect()->route('izins.index')->with('success', 'Izin berhasil diajukan!');
    }
    public function edit($id)
    {
        $izins = izin::find($id);
        $users = User::all();
        return view('izins.edit', compact('users', 'izins'));
    }
    public function update(Request $request, $id)
    {
        // $validate = $request->validate([
        //     'users_id' => 'required',
        //     'tanggal_mulai' => 'required|after_or_equal:today',
        //     'tanggal_selesai' => 'required|after_or_equal:today',
        //     'jenis_izin' => 'required',
        //     'alasan' => 'required',
        //     'status' => 'required'
        // ], [
        //     'tanggal_mulai.after_or_equal' => "Tanggal mulai minimal hari ini.",
        //     'tanggal_selesai.after_or_equal' => "Tanggal selesai minimal hari ini.",
        // ]);
        // $izins = izin::find($id)->update($validate);
        $izins = izin::find($id);
        $izins->users_id = $request->users_id;
        $izins->tanggal_mulai = $request->tanggal_mulai;
        $izins->tanggal_selesai = $request->tanggal_selesai;
        $izins->jenis_izin = $request->jenis_izin;
        $izins->alasan = $request->alasan;
        $izins->status = $request->status;
        $izins->save();
        return redirect()->route('izins.index')->with('success', 'Data berhasil diupdate!');
    }
    public function destroy($id)
    {
        $izins = izin::findOrFail($id);
        $izins->delete();
        return redirect()->route('izins.index')->with('success', 'Data berhasil dihapus!');
    }
}
