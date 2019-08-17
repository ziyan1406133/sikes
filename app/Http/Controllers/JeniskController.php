<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenisk;
use App\Pengeluaran;

class JeniskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisk = Jenisk::orderBy('id', 'desc')->get();
        $no = 1;
        return view('jenispengeluaran.index', compact('jenisk', 'no'));
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
        $jenisk = new Jenisk;
        $jenisk->nama = $request->input('nama');
        $jenisk->save();

        return redirect('/jenisk')->with('success', 'Jenis Pengeluaran Baru Telah Dibuat');
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
        $jenisk = Jenisk::findOrFail($id);
        $jenisk->nama = $request->input('nama');
        $jenisk->save();

        return redirect('/jenisk')->with('success', 'Jenis Pengeluaran Telah Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenisk = Jenisk::findOrFail($id);
        $pengeluarans = Pengeluaran::where('jenisk_id', $jenisk->id)->get();
        if(count($pengeluarans) > 0) {
            foreach($pengeluarans as $pengeluaran) {
                $uang = Uang::orderBy('id', 'asc')->first();
                $uang->masuk = $uang->masuk - $pengeluaran->nominal;
                $uang->save();
        
                $pengeluaran->delete();
            }
        }
        $jenisk->delete();

        return redirect('/jenisk')->with('success', 'Jenis Pengeluaran Telah Dihapus');
    }
}
