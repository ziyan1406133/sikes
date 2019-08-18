<?php

namespace App\Http\Controllers;

use App\Bulan;
use Illuminate\Http\Request;
use App\Uang;
use App\Rutin;

class PengeluaranRutinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran = Rutin::orderBy('tanggal', 'desc')->get();

        $keluarrutin[] = 0;
        foreach($pengeluaran as $keluar) {
            $keluarrutin[] = $keluar->jumlah;
        }
        $total_rutin= array_sum($keluarrutin);

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;

        $total_pengeluaran = $uang->keluar;

        $bulans = Bulan::orderBy('id', 'asc')->get();
        
        return view('keluarrutin.index', compact('pengeluaran', 'total_rutin', 'bulans', 'total_pengeluaran', 'saldo'));
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
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $perpus = $request->input('perpus');
        $kegiatan = $request->input('kegiatan');
        $evaluasi = $request->input('evaluasi');
        $pengelolaan = $request->input('pengelolaan');
        $daya = $request->input('daya');
        $honor = $request->input('honor');

        $jumlah = $perpus + $kegiatan + $evaluasi + $pengelolaan + $daya + $honor;

        if($jumlah > $saldo) {
            
            return redirect('/pengeluaranrutin')->with('error', 'Saldo Tidak Mencukupi.');
        } else {
            $rutin = new Rutin;
            $rutin->tanggal = $request->input('tanggal');  
            $rutin->bulan_id = $request->input('bulan_id');
            $rutin->perpus = $perpus;
            $rutin->kegiatan = $kegiatan;
            $rutin->evaluasi = $evaluasi;
            $rutin->pengelolaan = $pengelolaan;
            $rutin->daya = $daya;
            $rutin->honor = $honor;
            $rutin->jumlah = $jumlah;
            
            $uang->keluar = $uang->keluar + $jumlah;
    
            $uang->save();
        
            $rutin->save();
    
            return redirect('/pengeluaranrutin')->with('success', 'Data Pengeluaran Rutin Baru Telah Ditambahkan.');
        }
        
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

        $rutin = Rutin::findOrFail($id);
        
        $perpus = $request->input('perpus');
        $kegiatan = $request->input('kegiatan');
        $evaluasi = $request->input('evaluasi');
        $pengelolaan = $request->input('pengelolaan');
        $daya = $request->input('daya');
        $honor = $request->input('honor');

        $jumlah = $perpus + $kegiatan + $evaluasi + $pengelolaan + $daya + $honor;

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->keluar = $uang->keluar - $rutin->jumlah;
        $uang->save();

        $carisaldo = Uang::orderBy('id', 'asc')->first();
        $saldo = $carisaldo->masuk - $carisaldo->keluar;

        if($jumlah > $saldo) {
            $uang = Uang::orderBy('id', 'asc')->first();
            $uang->keluar = $uang->keluar + $rutin->jumlah;
            $uang->save();

            return redirect('/pengeluaranrutin')->with('error', 'Saldo Tidak Mencukupi.');
        } else {

            $rutin->tanggal = $request->input('tanggal');  
            $rutin->bulan_id = $request->input('bulan_id');
            $rutin->perpus = $perpus;
            $rutin->kegiatan = $kegiatan;
            $rutin->evaluasi = $evaluasi;
            $rutin->pengelolaan = $pengelolaan;
            $rutin->daya = $daya;
            $rutin->honor = $honor;
            $rutin->jumlah = $jumlah;
            
            $uang->keluar = $uang->keluar + $jumlah;
    
            $uang->save();
        
            $rutin->save();
    
            return redirect('/pengeluaranrutin')->with('success', 'Data Pengeluaran Rutin Telah Diperbaharui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rutin = Rutin::findOrFail($id);
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->keluar = $uang->keluar - $rutin->jumlah;
        $uang->save();

        $rutin->delete();

        return redirect('/pengeluaranrutin')->with('success', 'Data Pengeluaran Rutin Telah Dihapus');
    }
}
