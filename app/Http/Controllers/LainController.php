<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemasukan;
use App\Uang;
use App\JenistUser;
use App\Spp;

class LainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasukan = Pemasukan::where('sumber', 'Lainnya')->orderBy('created_at')->get();
        
        $masuklain1 = Pemasukan::where('sumber', 'Lainnya')->orderBy('created_at')->get();
        $masuklain[] = 0;
        foreach($masuklain1 as $masuk) {
            $masuklain[] = $masuk->nominal;
        }
        $total_lain = array_sum($masuklain);
        
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pemasukan = $uang->masuk;
        
        return view('pemasukanlain.index', compact('pemasukan', 'total_lain', 'total_pemasukan', 'saldo'));
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
        $lain = new Pemasukan;
        $lain->sumber = 'Lainnya';
        $lain->keterangan = $request->input('keterangan');
        $lain->tgl_bayar = $request->input('tgl_bayar');
        $lain->nominal = $request->input('nominal');
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk + $request->input('nominal');
        $uang->save();

        $lain->save();

        return redirect('/pemasukanlain')->with('success', 'Data Pemasukan Baru Berhasil Dibuat');
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
        $lain = Pemasukan::findOrFail($id);

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk - $lain->nominal;
        $uang->save();

        $lain->keterangan = $request->input('keterangan');
        $lain->tgl_bayar = $request->input('tgl_bayar');
        $lain->nominal = $request->input('nominal');
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk + $request->input('nominal');
        $uang->save();

        $lain->save();

        return redirect('/pemasukanlain')->with('success', 'Data Pemasukan Berhasil Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lain = Pemasukan::findOrFail($id);

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk - $lain->nominal;
        $uang->save();
        
        $lain->delete();

        return redirect('/pemasukanlain')->with('success', 'Data Pemasukan Berhasil Dihapus');
    }
}
