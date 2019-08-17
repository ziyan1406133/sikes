@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('DataTables/dataTables.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('select2/css/select2.min.css')}}"/>
@endsection

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col">
                        <h4>
                            Tagihan Siswa
                        </h4>
                    </div>
                    <div class="col">
                        <div class="pull-right">
                            <a class="btn btn-md btn-primary" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>

                            <div class="modal fade" id="tambah" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        {!! Form::open(['action' => 'TagihanController@tambah', 'method' => 'POST']) !!}
                                        <div class="modal-body">
                                            <h4 class="mb-5">Tambah Pemasukan dari Tagihan Siswa</h4>
                                            <div class="form-group">
                                                <label for="user_id">Siswa</label>
                                                <br>
                                                <select placeholder="Pilih Siswa..." name="user_id" class="select2" style="width: 100%" required>
                                                    @foreach($siswa as $user)
                                                        <option value="{{$user->id}}">{{$user->no_induk}} - {{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis">Jenis Pembayaran</label>
                                                <br>
                                                <select placeholder="Pilih Siswa..." name="jenis" id="jenis" class="select2" style="width: 100%" required>
                                                    <option value="1">SPP Bulanan</option>
                                                    @foreach($jenist as $jenis)
                                                        <option value="{{$jenis->id}}">{{$jenis->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">

                                                <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                                                {{Form::submit('Lanjutkan', ['class' => 'btn btn-md btn-primary'])}}
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-5">
                        <strong>Total Tagihan Siswa</strong> <br>
                        <strong>Total Seluruh Pemasukan</strong> <br>
                        <strong>Saldo</strong> <br>
                    </div>
                    <div class="col">
                        : Rp. {{ number_format($total_tagihan,0,",",".") }} <br>
                        : Rp. {{ number_format($total_pemasukan,0,",",".") }} <br>
                        : Rp. {{ number_format($saldo,0,",",".") }} <br>
                    </div>
                </div>
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal</th>  
                            <th>Nama Siswa</th> 
                            <th>Jenis Tagihan</th>
                            <th>Dibayar</th>   
                            <th>Bulan</th>   
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($jenistusers as $jenus)
                            <tr>
                                <td>{{date('20y/m/d', strtotime($jenus->tgl_bayar))}}</td>
                                <td><a href="/user/{{$jenus->jenistuser->user->id}}">{{$jenus->jenistuser->user->name}}</a></td>
                                <td>{{$jenus->jenistuser->jenist->nama}}</td>
                                <td>Rp. {{ number_format($jenus->dibayar,0,",",".") }}</td>
                                <td>-</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$jenus->id}}" href="#"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete{{$jenus->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="mb-5">Konfirmasi</h4>
                                            <p>Apakah anda yakin ingin menghapus data pemasukan ini? Saldo akan berkurang sesuai dengan nominal data yang dihapus.</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!!Form::open(['action' => ['TagihanController@hapuslain', $jenus->id], 'method' => 'POST'])!!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Batal</button>
                                                    {{Form::submit('Ya', ['class' => 'btn btn-md btn-default'])}}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @foreach($pembayaran as $spp1)
                            <tr>
                                <td>{{date('20y/m/d', strtotime($spp1->tgl_bayar))}}</td>
                                <td><a href="/user/{{$spp1->spp->user->id}}">{{$spp1->spp->user->name}}</a></td>
                                <td>{{$jenis_spp->nama}} ({{$spp1->spp->kelas_user->tahun->tahun}} - {{$spp1->spp->kelas_user->kelas->nama}})</td>
                                <td>Rp. {{ number_format($spp1->dibayar,0,",",".") }}</td>
                                <td>{{$spp1->spp->bulan->nama}}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$spp1->id}}" href="#"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete{{$spp1->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="mb-5">Konfirmasi</h4>
                                            <p>Apakah anda yakin ingin menghapus data pemasukan ini? Saldo akan berkurang sesuai dengan nominal data yang dihapus.</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!!Form::open(['action' => ['TagihanController@hapusspp', $spp1->id], 'method' => 'POST'])!!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                    <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Batal</button>
                                                    {{Form::submit('Ya', ['class' => 'btn btn-md btn-default'])}}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tanggal</th>  
                            <th>Nama Siswa</th> 
                            <th>Jenis Tagihan</th>
                            <th>Dibayar</th>   
                            <th>Bulan</th>   
                            <th class="text-center">Opsi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('DataTables/dataTables.min.js')}}"></script>
<script src="{{asset('select2/js/select2.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });
    $('.select2').select2();
} );
</script>
@endsection