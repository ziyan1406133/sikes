<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uang;
use App\Pengeluaran;
use App\SppBayar;
use App\JenistUserBayar;
use App\Pemasukan;
use Carbon\Carbon;
use App\User;
use App\Bulan;
use App\Rutin;
use PDF;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexmasuk()
    {
        $pemasukan = Pemasukan::orderBy('created_at', 'desc')->get();
        $tagihanlain = JenistUserBayar::orderBy('created_at', 'desc')->get();
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pemasukan = $uang->masuk;

        $no = 1;
        return view('laporan.indexmasuk', compact('saldo', 'no', 'total_pemasukan', 'pemasukan', 'tagihanlain'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexkeluar()
    {
        $pengeluaran = Pengeluaran::where('status', 'Diterima')->orderBy('updated_at')->get();
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pengeluaran = $uang->keluar;

        $no = 1;
        return view('laporan.indexkeluar', compact('saldo', 'no', 'total_pengeluaran', 'pengeluaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filtermasuk(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $pemasukan = Pemasukan::whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();
        $tagihanlain = JenistUserBayar::whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pemasukan = $uang->masuk;

        $no = 1;
        return view('laporan.filtermasuk', compact('saldo', 'no', 'total_pemasukan', 'pemasukan', 'tagihanlain'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterkeluar(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');
        $pengeluaran = Pengeluaran::where('status', 'Diterima')->whereBetween('tanggal', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('updated_at')->get();
        
        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pengeluaran = $uang->keluar;

        $no = 1;
        return view('laporan.filterkeluar', compact('saldo', 'no', 'total_pengeluaran', 'pengeluaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdfmasuk(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $bulan = date('m', strtotime($tgl));
        $bln = Bulan::findOrFail(intval($bulan));
        $bulan1 = date('m', strtotime($tgl1));
        $bln1 = Bulan::findOrFail(intval($bulan1));
        $tahun = date('20y', strtotime($tgl1));
        $tahun1 = date('20y', strtotime($tgl1));

        $bos = Pemasukan::where('sumber', 'BOS')->whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();
        $lain = Pemasukan::where('sumber', 'Lainnya')->whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();
        $pemasukan = Pemasukan::whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();
        $tagihanlain = JenistUserBayar::whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();
        
        $sub_bos[] = 0;
        foreach($bos as $satu) {
            $sub_bos[] = $satu->nominal; 
        }
        $subbos = array_sum($sub_bos);

        $sub_tlain[] = 0;
        foreach($tagihanlain as $tiga) {
            $sub_tlain[] = $tiga->dibayar; 
        }
        $subtlain = array_sum($sub_tlain);

        $sub_lain[] = 0;
        foreach($lain as $empat) {
            $sub_lain[] = $empat->nominal; 
        }
        $sublain = array_sum($sub_lain);

        $kepsek = User::where('role', 'Kepala Sekolah')->first();
        
        $total = $subbos + $sublain + $subtlain;

        $keuangan = User::where('role', 'Admin')->first();

        $pdf = PDF::loadview('laporan.pdfmasuk',
                            compact('keuangan', 'total', 'sumasuk', 'subtlain' , 'pemasukan', 'sublain', 'bos', 'lain', 'tagihanlain', 'saldo', 'no', 'total', 'kepsek', 'bln', 'bln1', 'tahun', 'tahun1'))->setPaper('a4', 'portrait');
                            
        return $pdf->stream('Laporan Pemasukan - '.time().'.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdfkeluar(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $bulan = date('m', strtotime($tgl));
        $bln = Bulan::findOrFail(intval($bulan));
        $bulan1 = date('m', strtotime($tgl1));
        $bln1 = Bulan::findOrFail(intval($bulan1));
        $tahun = date('20y', strtotime($tgl1));
        $tahun1 = date('20y', strtotime($tgl1));

        $pengeluaran = Pengeluaran::where('status', 'Diterima')->whereBetween('tanggal', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('updated_at')->get();

        $kepsek = User::where('role', 'Kepala Sekolah')->first();

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;
        
        $total_pengeluaran = $uang->keluar;

        $sub_nonrutin[] = 0;
        foreach($pengeluaran as $nr) {
            $sub_nonrutin[] = $nr->nominal; 
        }
        $subnonrutin = array_sum($sub_nonrutin);
        $total = $subnonrutin;

        $keuangan = User::where('role', 'Admin')->first();

        $no = 1;
        $pdf = PDF::loadview('laporan.pdfkeluar',
                            compact('pengeluaran', 'keuangan', 'total', 'subnonrutin', 'rutin', 'nonrutin', 'saldo', 'no', 'kepsek', 'bln', 'bln1', 'tahun', 'tahun1'))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan Pengeluaran Non Rutin - '.time().'.pdf');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexrutin()
    {
        $pengeluaran = Rutin::orderBy('tanggal', 'desc')->get();

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;

        return view('laporan.indexrutin', compact('pengeluaran', 'saldo', 'uang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterrutin(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $pengeluaran = Rutin::whereBetween('tanggal', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('tanggal', 'desc')->get();

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;

        return view('laporan.filterrutin', compact('pengeluaran', 'saldo', 'uang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdfrutin(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $bulan = date('m', strtotime($tgl));
        $bln = Bulan::findOrFail(intval($bulan));
        $bulan1 = date('m', strtotime($tgl1));
        $bln1 = Bulan::findOrFail(intval($bulan1));
        $tahun = date('20y', strtotime($tgl1));
        $tahun1 = date('20y', strtotime($tgl1));

        $pengeluaran = Rutin::whereBetween('tanggal', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('tanggal', 'desc')->get();

        $sub[] = 0;
        foreach($pengeluaran as $nr) {
            $sub[] = $nr->jumlah; 
        }
        $total = array_sum($sub);
        
        $keuangan = User::where('role', 'Admin')->first();
        $kepsek = User::where('role', 'Kepala Sekolah')->first();

        $pdf = PDF::loadview('laporan.pdfrutin',
                            compact('kepsek', 'keuangan', 'pengeluaran', 'total', 'bln', 'bln1', 'tahun', 'tahun1'))->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Pengeluaran Rutin - '.time().'.pdf');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexspp()
    {
        $spp = SppBayar::orderBy('created_at', 'desc')->get();

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;

        $no = '1';

        return view('laporan.indexspp', compact('uang', 'saldo', 'spp', 'no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterspp(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $spp = SppBayar::whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();

        $uang = Uang::orderBy('id', 'asc')->first();
        $saldo = $uang->masuk - $uang->keluar;

        $no = '1';

        return view('laporan.filterspp', compact('uang', 'saldo', 'spp', 'no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdfspp(Request $request)
    {
        $tgl = $request->input('tanggal');
        $tgl1 = $request->input('tanggal1');

        $bulan = date('m', strtotime($tgl));
        $bln = Bulan::findOrFail(intval($bulan));
        $bulan1 = date('m', strtotime($tgl1));
        $bln1 = Bulan::findOrFail(intval($bulan1));
        $tahun = date('20y', strtotime($tgl1));
        $tahun1 = date('20y', strtotime($tgl1));

        $spp = SppBayar::whereBetween('tgl_bayar', [new Carbon($tgl), new Carbon($tgl1)])->orderBy('created_at', 'desc')->get();

        $sub[] = 0;
        foreach($spp as $nr) {
            $sub[] = $nr->dibayar; 
        }
        $total = array_sum($sub);
        
        $keuangan = User::where('role', 'Admin')->first();

        $no = 1;
        $pdf = PDF::loadview('laporan.pdfspp',
                            compact('keuangan', 'spp', 'no', 'total', 'bln', 'bln1', 'tahun', 'tahun1'))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan SPP - '.time().'.pdf');
    }

}
