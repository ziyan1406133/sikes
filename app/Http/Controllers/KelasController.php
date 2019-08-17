<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use App\KelasUser;
use App\Spp;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $no = 1;
        return view('kelas.index', compact('kelas', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kelas = new Kelas;
        $kelas->nama = $request->input('nama');
        $kelas->save();

        return redirect('/kelas')->with('success', 'Kelas Baru Telah Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->nama = $request->input('nama');
        $kelas->save();

        return redirect('/kelas')->with('success', 'Kelas Telah Diperbaharui');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tambah(Request $request)
    {
        $user_id = $request->input('user_id');

        $kelas = new KelasUser;
        $kelas->user_id = $user_id;
        $kelas->kelas_id = $request->input('kelas_id');
        $kelas->tahun_id = $request->input('tahun_id');
        $kelas->save();

        return redirect('/user/'.$user_id.'/edit')->with('success', 'Kelas Telah Diperbaharui');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ubah(Request $request, $id)
    {
        $kelas = KelasUser::findOrFail($id);

        $user_id = $kelas->user_id;

        $kelas->kelas_id = $request->input('kelas_id');
        $kelas->tahun_id = $request->input('tahun_id');
        $kelas->save();

        return redirect('/user/'.$user_id.'/edit')->with('success', 'Kelas Telah Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $kelas = KelasUser::findOrFail($id);
        
        $user_id = $kelas->user_id;

        $spps = Spp::where('kelas_tahun_id', $kelas->id)->get();
        if(count($spps) > 0) {
            foreach($spps as $spp) {
                $uang = Uang::orderBy('id', 'asc')->first();
                $uang->masuk = $uang->masuk - $spp->dibayar;
                $uang->save();

                $spp->delete();
            }
        }
        $kelas->delete();

        return redirect('/user/'.$user_id.'/edit')->with('success', 'Kelas Telah Dihapus Dari Siswa Ini');
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelasuser = KelasUser::where('kelas_id', $id)->get();
        if(count($kelasuser) > 0) {
            foreach($kelasuser as $kelas) {
                $spps = Spp::where('kelas_tahun_id', $kelasuser->id)->get();
                if(count($spps) > 0) {
                    foreach($spps as $spp) {
                        $uang = Uang::orderBy('id', 'asc')->first();
                        $uang->masuk = $uang->masuk - $spp->dibayar;
                        $uang->save();
                        $spp->delete();
                    }
                }
                $kelas->delete();
            }
        }
        $kelas->delete();

        return redirect('/kelas')->with('success', 'Kelas Telah Berhasil Dihapus');
        
    }
}
