<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bulan;
use App\User;
use App\KelasUser;
use App\Uang;
use App\Spp;
use App\JenistUser;
use App\Jenist;
use App\SppBayar;
use App\JenistUserBayar;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayaran = SppBayar::orderBy('created_at', 'desc')->get();
        $jenistusers = JenistUserBayar::orderBy('created_at', 'desc')->get();

        $jenist = Jenist::where('id', '!=', '4')->orderBy('nama', 'asc')->get();
        $masuk[] = 0;
        foreach($pembayaran as $spp) {
            $masuk[] = $spp->dibayar;
        }
        foreach($jenistusers as $ju) {
            $masuk[] = $ju->dibayar;
        }
        $total_tagihan= array_sum($masuk);

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pemasukan = $uang->masuk;

        $jenis_spp = Jenist::findOrFail(4);

        $kelas_lulus = KelasUser::where('kelas_id', '6')->get();
        
        $lulus_id[] = 0;
        foreach($kelas_lulus as $lulus) {
            $lulus_id[] = $lulus->user_id;
        }

        $siswa = User::where('role', 'Siswa')->whereNotIn('id', $lulus_id)->orderBy('no_induk', 'asc')->get();
        $bulans = Bulan::orderBy('id', 'asc')->get();

        return view('tagihan.index', compact('bulans', 'pembayaran', 'siswa', 'jenis_spp', 'jenist', 'jenistusers', 'total_tagihan', 'total_pemasukan', 'saldo'));
        
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
        $user = User::findOrFail($request->input('user_id'));
        $jenis_id = $request->input('jenis');
        $bulans = Bulan::orderBy('id', 'asc')->get();

        if($jenis_id == '1') {

            $spp = Jenist::findOrFail(4);
            return view('tagihan.tambahspp', compact('user', 'bulans', 'spp'));
        } else {
            $jenist = Jenist::findOrFail($jenis_id);
            return view('tagihan.tambahlain', compact('user', 'bulans', 'jenist'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tambahspp(Request $request)
    {
        $user_id = $request->input('user_id');
        $bulan_id = $request->input('bulan_id');
        $kelas_id = $request->input('kelas_id');

        $cekspp = SPP::where('user_id', $user_id)->where('bulan_id', $bulan_id)->where('kelas_tahun_id', $kelas_id)->first();
        if($cekspp == NULL) {
            $spp = new SPP;
            
        } else {
            $spp = $cekspp;
        }
        $spp->user_id = $user_id;
        $spp->bulan_id = $bulan_id;
        $spp->kelas_tahun_id = $kelas_id;
        $spp->nominal = $request->input('nominal');
        $spp->save();

        if($cekspp == NULL) {
            $lastspp = Spp::orderBy('updated_at', 'desc')->first();
            
        } else {
            $lastspp = $cekspp;
        }

        $bayar = new SppBayar;
        $bayar->spp_id = $lastspp->id;
        $bayar->dibayar = $request->input('dibayar');

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk + $request->input('dibayar');
        $uang->save();

        $bayar->tgl_bayar = $request->input('tgl_bayar');
        $bayar->save();

        $pembayaran[] = 0;
        foreach($lastspp->bayar as $bayar) {
            $pembayaran[] = $bayar->dibayar;
        }
        $sumba = array_sum($pembayaran);

        $ceklunas = SPP::where('user_id', $user_id)->where('bulan_id', $bulan_id)->where('kelas_tahun_id', $kelas_id)->first();
        if($sumba >= $ceklunas->nominal) {
            $ceklunas->status = 'Lunas';
            $ceklunas->save();
        }

        $jenis_spp = Jenist::findOrFail(4);

        return redirect('/tagihan')->with('success', 'Pembayaran '.$jenis_spp->nama.' Berhasil Diterima.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tambahlain(Request $request)
    {
        $user_id = $request->input('user_id');
        $jenist_id = $request->input('jenist_id');

        $cektagihan = JenistUser::where('user_id', $user_id)->where('jenist_id', $jenist_id)->first();
        if($cektagihan == NULL) {
            $tagihan = new JenistUser;
            
        } else {
            $tagihan = $cektagihan;
        }
        $tagihan->user_id = $user_id;
        $tagihan->jenist_id = $jenist_id;
        $tagihan->save();
        if($cektagihan == NULL) {
            $lasttagihan = JenistUser::orderBy('updated_at', 'desc')->first();
            
        } else {
            $lasttagihan = $cektagihan;
        }

        $bayar = new JenistUserBayar;
        $bayar->tagihan_id = $lasttagihan->id;
        $bayar->dibayar = $request->input('dibayar');
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk + $request->input('dibayar');
        $uang->save();

        $bayar->tgl_bayar = $request->input('tgl_bayar');
        $bayar->save();

        $pembayaran[] = 0;
        foreach($lasttagihan->bayar as $bayar) {
            $pembayaran[] = $bayar->dibayar;
        }
        $sumba = array_sum($pembayaran);

        $cektagihan = JenistUser::where('user_id', $user_id)->where('jenist_id', $jenist_id)->first();
        if($sumba >= $cektagihan->jenist->nominal) {
            $cektagihan->status = 'Lunas';
            $cektagihan->save();
        }

        return redirect('/tagihan')->with('success', 'Pembayaran '.$lasttagihan->jenist->nama.' Berhasil Diterima.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenist = Jenist::where('id', '!=', '4')->orderBy('nama', 'asc')->get();
        $user = User::findOrFail($id);
        $bulans = Bulan::orderBy('id', 'asc')->get();
        $biaya = Jenist::findOrFail(4);
        return view('tagihan.show', compact('jenist', 'user','bulans', 'biaya'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapusspp($id)
    {
        $spp = SppBayar::findOrFail($id);

        $cekspp = SPP::findOrFail($spp->spp_id);

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk - $spp->dibayar;
        $uang->save();
        
        $spp->delete();

        $daftarspp = SppBayar::where('spp_id', $cekspp->id)->get();
        if(count($daftarspp) == '0') {
            $cekspp->delete();
        }

        $jenis_spp = Jenist::findOrFail(4);

        return redirect('/tagihan')->with('success', 'Tagihan '.$jenis_spp->nama.' Berhasil Dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapuslain($id)
    {
        $jenistuserbayar = JenistUserBayar::findOrFail($id);

        $uang = Uang::orderBy('id', 'asc')->first();
        $uang->masuk = $uang->masuk - $jenistuserbayar->dibayar;
        $uang->save();

        $jenistuserbayar->delete();

        return redirect('/tagihan')->with('success', 'Tagihan '.$jenistuserbayar->jenistuser->jenist->nama.' Berhasil Dihapus');
    }
}
