<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunAjaran;
use App\Spp;
use App\KelasUser;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunajaran = TahunAjaran::orderBy('tahun', 'desc')->get();
        $no = 1;
        return view('tahunajaran.index', compact('tahunajaran', 'no'));
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
        $tahunajaran = new TahunAjaran;
        $tahunajaran->tahun = $request->input('tahun');
        $tahunajaran->save();
        return redirect('/tahunajaran')->with('success', 'Tahun Ajaran Baru Telah Dibuat');
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
        $tahunajaran = TahunAjaran::findOrFail($id);
        $tahunajaran->tahun = $request->input('tahun');
        $tahunajaran->save();
        return redirect('/tahunajaran')->with('success', 'Tahun Ajaran Telah Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tahunajaran = TahunAjaran::findOrFail($id);
        $kelasuser = KelasUser::where('tahun_id', $id)->get();
        if(count($kelasuser) > 0) {
            foreach($kelasuser as $kelas) {
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
            }
        }
        $tahunajaran->delete();
        return redirect('/tahunajaran')->with('success', 'Tahun Ajaran Telah Dihapus');
    }
}
