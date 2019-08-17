<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengeluaran;
use App\Uang;
use App\Jenisk;

class PengeluaranNonRutinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::where('jenis', 'Non Rutin')->where('status', 'Diterima')->orderBy('created_at', 'desc')->get();
        $pending = Pengeluaran::where('jenis', 'Non Rutin')->where('status', '!=', 'Diterima')->orderBy('status', 'desc')->get();

        $keluarnonrutin[] = 0;
        foreach($pengeluaran as $keluar) {
            $keluarnonrutin[] = $keluar->nominal;
        }
        $total_non_rutin= array_sum($keluarnonrutin);

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;

        $total_pengeluaran = $uang->keluar;

        $jenispengeluaran = Jenisk::orderBy('nama', 'asc')->get();
        
        return view('keluarnonrutin.index', compact('pengeluaran', 'pending', 'total_non_rutin', 'jenispengeluaran', 'total_pengeluaran', 'saldo'));
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
        
        if($request->input('nominal') > $saldo) {
            
            return redirect('/pengeluarannonrutin')->with('error', 'Saldo Tidak Mencukupi.');
        } else {
            $non_rutin = new Pengeluaran;
            $non_rutin->jenis = 'Non Rutin';
            $non_rutin->jenisk_id = $request->input('jenisk_id');
            $non_rutin->keterangan = $request->input('keterangan');
            $non_rutin->nominal = $request->input('nominal');
    
            $uang->save();
    
            $non_rutin->tanggal = $request->input('tanggal'); 
    
            $non_rutin->save();
    
            return redirect('/pengeluarannonrutin')->with('success', 'Data Pengeluaran Non Rutin Baru Telah Ditambahkan, Silahkan Tunggu Dikonfirmasi Oleh Kepala Sekolah.');
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

        $non_rutin = Pengeluaran::findOrFail($id);
        
        if($non_rutin->status == 'Diterima') {
            return redirect('/pengeluarannonrutin')->with('success', 'Anda Tidak Bisa Mengubah Data Pengeluaran yang Telah Disetujui Kepala Sekolah.');

        } else {
            $carisaldo = Uang::orderBy('id', 'asc')->first();
            $saldo = $carisaldo->masuk - $carisaldo->keluar;
    
            if($request->input('nominal') > $saldo) {
    
                return redirect('/pengeluarannonrutin')->with('error', 'Saldo Tidak Mencukupi');
            } else {
                $non_rutin->jenis = 'Non Rutin';
                $non_rutin->jenisk_id = $request->input('jenisk_id');
                $non_rutin->keterangan = $request->input('keterangan');
                $non_rutin->nominal = $request->input('nominal');
                
                if($non_rutin->status == 'Ditolak') {
                    $non_rutin->status = 'Menunggu Konfirmasi';
                }
                
                $non_rutin->tanggal = $request->input('tanggal');  
                $non_rutin->save();
        
                return redirect('/pengeluarannonrutin')->with('success', 'Data Pengeluaran Rutin Telah Diperbaharui.');
            }
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
        $non_rutin = Pengeluaran::findOrFail($id);
        
        if($non_rutin->status == 'Diterima') {
            $uang = Uang::orderBy('id', 'asc')->first();
            $uang->keluar = $uang->keluar - $non_rutin->nominal;
            $uang->save();
        }

        $non_rutin->delete();

        return redirect('/pengeluarannonrutin')->with('success', 'Data Pengeluaran Rutin Telah Dihapus');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function terima(Request $request, $id)
    {
        $non_rutin = Pengeluaran::findOrFail($id);
        $non_rutin->status = 'Diterima';

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->keluar = $uang->keluar + $non_rutin->nominal;
        $uang->save();

        $non_rutin->save();

        return redirect('/pengeluarannonrutin')->with('success', 'Permintaan Pengeluaran Berhasil Diterima');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tolak(Request $request, $id)
    {
        $non_rutin = Pengeluaran::findOrFail($id);
        $non_rutin->status = 'Ditolak';
        $non_rutin->alasan = $request->input('alasan');
        $non_rutin->save();

        return redirect('/pengeluarannonrutin')->with('success', 'Permintaan Pengeluaran Berhasil Ditolak');
    }
}
