@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('DataTables/dataTables.min.css')}}"/>
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
                            Pengeluaran Rutin
                        </h4>
                    </div>
                    <div class="col">
                        <a class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="modal fade" id="tambah" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['PengeluaranRutinController@store'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Tambah Pengeluaran Rutin</h4>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input name="tanggal" id="tanggal" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                    </div>
                                    <div class="form-group">
                                        <select placeholder="Pilih Bulan" name="bulan_id" id="bulan_id" class="form-control" required>
                                            <option value=""></option>
                                            @foreach($bulans as $bulan)
                                                <option value="{{$bulan->id}}">{{$bulan->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="perpus">Pengembangan Perpustakaan</label>
                                        <input name="perpus" id="perpus" type="number" class="form-control" step="1" placeholder="250000" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kegiatan">Pengembangan Kegiatan Pembelajaran</label>
                                        <input name="kegiatan" id="kegiatan" type="number" class="form-control" step="1" placeholder="250000" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="evaluasi">Kegiatan Evaluasi Pembelajar</label>
                                        <input name="evaluasi" id="evaluasi" type="number" class="form-control" step="1" placeholder="250000" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pengelolaan">Pengelolaan Sekolah</label>
                                        <input name="pengelolaan" id="pengelolaan" type="number" class="form-control" step="1" placeholder="250000" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="daya">Langganan Daya dan Jasa</label>
                                        <input name="daya" id="daya" type="number" class="form-control" step="1" placeholder="250000" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="honor">Pembayaran Honor</label>
                                        <input name="honor" id="honor" type="number" class="form-control" step="1" placeholder="250000" required>
                                    </div>
                                    <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                                        {{Form::submit('Submit', ['class' => 'btn btn-md btn-primary'])}}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-5">
                        <strong>Total Pengeluaran Rutin</strong> <br>
                        <strong>Total Seluruh Pengeluaran</strong> <br>
                        <strong>Saldo</strong> <br>
                    </div>
                    <div class="col">
                        : Rp. {{ number_format($total_rutin,0,",",".") }} <br>
                        : Rp. {{ number_format($total_pengeluaran,0,",",".") }} <br>
                        : Rp. {{ number_format($saldo,0,",",".") }} <br>
                    </div>
                </div>
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Bulan</th>  
                            <th>Pengembangan Perpustakaan</th> 
                            <th>Pengembangan Kegiatan Pembelajaran</th> 
                            <th>Kegiatan Evaluasi Pembelajar</th> 
                            <th>Pengelolaan Sekolah</th> 
                            <th>Langganan Daya dan Jasa</th> 
                            <th>Pembayaran Honor</th> 
                            <th>Jumlah</th>   
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengeluaran as $rutin)
                        <tr>
                            <td>{{date('20y/m/d', strtotime($rutin->tanggal))}}</td>
                            <td>{{$rutin->bulan->nama}}</td>
                            <td>Rp. {{ number_format($rutin->perpus,0,",",".") }}</td>
                            <td>Rp. {{ number_format($rutin->kegiatan,0,",",".") }}</td>
                            <td>Rp. {{ number_format($rutin->evaluasi,0,",",".") }}</td>
                            <td>Rp. {{ number_format($rutin->pengelolaan,0,",",".") }}</td>
                            <td>Rp. {{ number_format($rutin->daya,0,",",".") }}</td>
                            <td>Rp. {{ number_format($rutin->honor,0,",",".") }}</td>
                            <td>Rp. {{ number_format($rutin->jumlah,0,",",".") }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$rutin->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$rutin->id}}" href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="edit{{$rutin->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::model($rutin, array('route' => array('pengeluaranrutin.update', $rutin->id), 'method' => 'PUT')) !!}
                                    <div class="modal-body">
                                        <h4 class="mb-5">Edit Data Pengeluaran</h4>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input name="tanggal" id="tanggal" type="date" class="form-control" value="{{$rutin->tanggal}}" required>
                                        </div>
                                        <div class="form-group">
                                            <select placeholder="Pilih Bulan" name="bulan_id" id="bulan_id" class="form-control" required>
                                                <option value=""></option>
                                                @foreach($bulans as $bulan)
                                                    @if($bulan->id == $rutin->bulan_id)
                                                        <option value="{{$bulan->id}}" selected>{{$bulan->nama}}</option>
                                                    @else
                                                        <option value="{{$bulan->id}}">{{$bulan->nama}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="perpus">Pengembangan Perpustakaan</label>
                                            <input name="perpus" id="perpus" type="number" class="form-control" step="1" placeholder="250000" value="{{$rutin->perpus}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kegiatan">Pengembangan Kegiatan Pembelajaran</label>
                                            <input name="kegiatan" id="kegiatan" type="number" class="form-control" step="1" placeholder="250000" value="{{$rutin->kegiatan}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="evaluasi">Kegiatan Evaluasi Pembelajar</label>
                                            <input name="evaluasi" id="evaluasi" type="number" class="form-control" step="1" placeholder="250000" value="{{$rutin->evaluasi}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pengelolaan">Pengelolaan Sekolah</label>
                                            <input name="pengelolaan" id="pengelolaan" type="number" class="form-control" step="1" placeholder="250000" value="{{$rutin->pengelolaan}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="daya">Langganan Daya dan Jasa</label>
                                            <input name="daya" id="daya" type="number" class="form-control" step="1" placeholder="250000" value="{{$rutin->daya}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="honor">Pembayaran Honor</label>
                                            <input name="honor" id="honor" type="number" class="form-control" step="1" placeholder="250000" value="{{$rutin->honor}}" required>
                                        </div>
                                        <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                                        {{Form::submit('Submit', ['class' => 'btn btn-md btn-primary'])}}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="delete{{$rutin->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4 class="mb-5">Konfirmasi</h4>
                                        <p>Apakah anda yakin ingin menghapus data pengeluaran ini? Saldo akan bertambah sesuai dengan nominal data yang dihapus.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!!Form::open(['action' => ['PengeluaranRutinController@destroy', $rutin->id], 'method' => 'POST'])!!}
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
                            <th>Bulan</th>  
                            <th>Pengembangan Perpustakaan</th> 
                            <th>Pengembangan Kegiatan Pembelajaran</th> 
                            <th>Kegiatan Evaluasi Pembelajar</th> 
                            <th>Pengelolaan Sekolah</th> 
                            <th>Langganan Daya dan Jasa</th> 
                            <th>Pembayaran Honor</th> 
                            <th>Jumlah</th>   
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
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });
} );
</script>
@endsection