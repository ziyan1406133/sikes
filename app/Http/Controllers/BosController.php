<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemasukan;
use App\Uang;
use App\JenistUser;
use App\Spp;

class BosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasukan = Pemasukan::where('sumber', 'BOS')->orderBy('created_at')->get();
        
        $masukbos1 = Pemasukan::where('sumber', 'BOS')->orderBy('created_at')->get();
        $masukbos[] = 0;
        foreach($masukbos1 as $masuk) {
            $masukbos[] = $masuk->nominal;
        }
        $total_bos = array_sum($masukbos);
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pemasukan = $uang->masuk;

        return view('bos.index', compact('pemasukan', 'total_bos', 'total_pemasukan', 'saldo'));
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
        $bos = new Pemasukan;
        $bos->sumber = 'BOS';
        $bos->triwulan = $request->input('triwulan');
        $bos->nominal = $request->input('nominal');

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk + $request->input('nominal');
        $uang->save();

        $bos->tgl_bayar = $request->input('tgl_bayar');
        $bos->keterangan = $request->input('keterangan');
        $bos->save();

        return redirect('/BOS')->with('success', 'Dana BOS Berhasil Ditambahkan');
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
        $bos = Pemasukan::findOrFail($id);

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk - $bos->nominal;
        $uang->save();

        $bos->sumber = 'BOS';
        $bos->triwulan = $request->input('triwulan');
        $bos->nominal = $request->input('nominal');

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk + $request->input('nominal');
        $uang->save();


        $bos->tgl_bayar = $request->input('tgl_bayar');
        $bos->keterangan = $request->input('keterangan');
        $bos->save();

        return redirect('/BOS')->with('success', 'Dana BOS Berhasil Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bos = Pemasukan::findOrFail($id);

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk - $bos->nominal;
        $uang->save();
        
        $bos->delete();

        return redirect('/BOS')->with('success', 'Dana BOS Berhasil Dihapus');
    }
}
