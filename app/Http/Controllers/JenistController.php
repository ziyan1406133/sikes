<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenist;
use App\JenistUser;

class JenistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenist = Jenist::orderBy('id', 'desc')->get();
        $no = 1;
        return view('jenistagihan.index', compact('jenist', 'no'));
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
        $jenist = new Jenist;
        $jenist->nama = $request->input('nama');
        $jenist->nominal = $request->input('nominal');
        $jenist->save();

        return redirect('/jenist')->with('success', 'Jenis Tagihan Siswa Baru Telah Dibuat');
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
        $jenist = Jenist::findOrFail($id);
        $jenist->nama = $request->input('nama');
        $jenist->nominal = $request->input('nominal');
        $jenist->save();

        return redirect('/jenist')->with('success', 'Jenis Tagihan Siswa Telah Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenist = Jenist::findOrFail($id);
        $jenist_user = JenistUser::where('jenist_id', $id)->get();
        if(count($jenist_user) > 0) {
            foreach($jenist_user as $tagihan) {
                $uang = Uang::orderBy('id', 'asc')->first();
                $uang->masuk = $uang->masuk - $tagihan->nominal;
                $uang->save();
                $tagihan->delete();
            }
        }
        $jenist->delete();

        return redirect('/jenist')->with('success', 'Jenis Tagihan Siswa Telah Dihapus');
    }
}
