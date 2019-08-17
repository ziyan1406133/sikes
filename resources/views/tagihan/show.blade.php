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
                            Tagihan {{$user->name}}
                        </h4>
                    </div>
                    @if(auth()->user()->role == 'Admin')
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
                                                    <select placeholder="Pilih Siswa..." name="user_id" class="form-control" style="width: 100%" readonly>
                                                        <option value="{{$user->id}}">{{$user->no_induk}} - {{$user->name}}</option>
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
                    @endif
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3">
                        <a href="#" class="nav-tabs-dropdown btn btn-block btn-primary">Tabs</a>
                        <ul id="nav-tabs-wrapper" class="nav nav-tabs nav-pills nav-stacked well">
                            <li class="active"><a href="#vtab1" data-toggle="tab">Tagihan Lainnya</a></li>
                            @foreach($user->kelas1 as $class)
                                @if($class->kelas->id != '6')
                                    <li><a href="#tab{{$class->kelas->id}}" data-toggle="tab">SPP {{$class->kelas->nama}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="vtab1">
                                <h3 class="mb-5">Tagihan Lainnya</h3>
                                <table class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tagihan</th>  
                                            <th>Beban Pembayaran</th>  
                                            <th class="text-center">Riwayat Pembayaran</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->tagihan as $tagihan)
                                        <tr>    
                                            <td>{{$tagihan->nama}}</td>
                                            <td>Rp. {{ number_format($tagihan->nominal,0,",",".") }}</td>
                                            <td class="text-center">
                                                @php
                                                $status = App\JenistUser::where('user_id', $user->id)->where('jenist_id', $tagihan->id)->first()
                                                @endphp
                                                <a class="btn btn-more small" data-toggle="modal" data-target="#riwayat{{$tagihan->id}}" href="#"><i class="fa fa-eye"></i>{{$status->status}}</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="riwayat{{$tagihan->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h4 class="mb-5">Riwayat Pembayaran</h4>
                                                        <ul>
                                                            @foreach ($tagihan->jenus as $jenus)
                                                                @foreach($jenus->bayar as $bayar)
                                                                    @if($bayar->jenistuser->user->id == $user->id)
                                                                        <li>{{$bayar->tgl_bayar}} : Rp. {{ number_format($bayar->dibayar,0,",",".") }}</li>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @foreach($user->kelas1 as $class)
                                @if($class->kelas->id != '6')
                                    <div role="tabpanel" class="tab-pane fade" id="tab{{$class->kelas->id}}">
                                        <h3 class="mb-5">{{$class->kelas->nama}} ({{$class->tahun->tahun}})</h3>
                                        <table class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Bulan</th>  
                                                    <th>Beban Pembayaran</th>  
                                                    <th class="text-center">Riwayat Pembayaran</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bulans as $bulan)
                                                    <tr>
                                                    @if($bulan->id > 6)
                                                        <td>{{$bulan->id - 6}}</td>
                                                        <td>{{$bulan->nama}}</td>
                                                        @php
                                                        $pembayaran = App\Spp::where('user_id', $user->id)->where('bulan_id', $bulan->id)->where('kelas_tahun_id', $class->id)->first()
                                                        @endphp
                                                        @if($pembayaran == NULL)
                                                            <td>Rp. {{ number_format($biaya->nominal,0,",",".") }}</td>
                                                            <td class="text-center">-</td>
                                                        @else
                                                            <td>Rp. {{ number_format($pembayaran->nominal,0,",",".") }}</td>
                                                            <td class="text-center">
                                                                    <a class="btn btn-more small" data-toggle="modal" data-target="#riwayat{{$pembayaran->id}}" href="#"><i class="fa fa-eye"></i>{{$pembayaran->status}}</a>
                                                            </td>
                                                            <div class="modal fade" id="riwayat{{$pembayaran->id}}" role="dialog">
                                                                <div class="modal-dialog">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <h4 class="mb-5">Riwayat Pembayaran</h4>
                                                                            <ul>
                                                                                @foreach ($pembayaran->bayar as $spp)
                                                                                    <li>{{$spp->tgl_bayar}} : Rp. {{ number_format($spp->dibayar,0,",",".") }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    </tr>
                                                @endforeach
                                                @foreach($bulans as $bulan)
                                                    <tr>
                                                    @if($bulan->id < 7)
                                                        <td>{{$bulan->id + 6}}</td>
                                                        <td>{{$bulan->nama}}</td>
                                                        @php
                                                        $pembayaran = App\Spp::where('user_id', $user->id)->where('bulan_id', $bulan->id)->where('kelas_tahun_id', $class->id)->first()
                                                        @endphp
                                                        @if($pembayaran == NULL)
                                                            <td>Rp. {{ number_format($biaya->nominal,0,",",".") }}</td>
                                                            <td class="text-center">-</td>
                                                        @else
                                                            <td>Rp. {{ number_format($pembayaran->nominal,0,",",".") }}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-more small" data-toggle="modal" data-target="#riwayat{{$pembayaran->id}}" href="#"><i class="fa fa-eye"></i>{{$pembayaran->status}}</a>
                                                            </td>
                                                            <div class="modal fade" id="riwayat{{$pembayaran->id}}" role="dialog">
                                                                <div class="modal-dialog">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <h4 class="mb-5">Riwayat Pembayaran</h4>
                                                                            <ul>
                                                                                @foreach ($pembayaran->bayar as $spp)
                                                                                    <li>{{$spp->tgl_bayar}} : Rp. {{ number_format($spp->dibayar,0,",",".") }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
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
    $('table.display').DataTable();
    $('.select2').select2();
} );
</script>
@endsection