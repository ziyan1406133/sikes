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
                            Pemasukan Dana Dari Sumber Lainnya
                        </h4>
                    </div>
                    <div class="col">
                        <a class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="modal fade" id="tambah" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['LainController@store'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Tambah Pemasukan Lainnya</h4>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="80" placeholder="Keterangan Pemasukan." required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input name="nominal" id="nominal" type="number" class="form-control" step="1" placeholder="250000" required>
                                        <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_bayar">Tanggal Masuk</label>
                                        <input name="tgl_bayar" id="tgl_bayar" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                    </div>
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
                        <strong>Total Pemasukan Lainnya</strong> <br>
                        <strong>Total Seluruh Pemasukan</strong> <br>
                        <strong>Saldo</strong> <br>
                    </div>
                    <div class="col">
                        : Rp. {{ number_format($total_lain,0,",",".") }} <br>
                        : Rp. {{ number_format($total_pemasukan,0,",",".") }} <br>
                        : Rp. {{ number_format($saldo,0,",",".") }} <br>
                    </div>
                </div>
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal Masuk</th>  
                            <th>Keterangan</th> 
                            <th>Nominal</th>   
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukan as $lain)
                        <tr>
                            <td>{{date('20y/m/d', strtotime($lain->tgl_bayar))}}</td>
                            <td>{{$lain->keterangan}}</td>
                            <td>Rp. {{ number_format($lain->nominal,0,",",".") }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$lain->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$lain->id}}" href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="edit{{$lain->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::model($lain, array('route' => array('pemasukanlain.update', $lain->id), 'method' => 'PUT')) !!}
                                    <div class="modal-body">
                                        <h4 class="mb-5">Edit Data Pemasukan</h4>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="80" placeholder="Keterangan pemasukan dana BOS." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input name="nominal" id="nominal" type="number" class="form-control" step="1" placeholder="250000" required>
                                            <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_bayar">Tanggal Masuk</label>
                                            <input name="tgl_bayar" id="tgl_bayar" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                                            {{Form::submit('Submit', ['class' => 'btn btn-md btn-primary'])}}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="delete{{$lain->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4 class="mb-5">Konfirmasi</h4>
                                        <p>Apakah anda yakin ingin menghapus data pemasukan ini? Saldo akan berkurang sesuai dengan nominal data yang dihapus.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!!Form::open(['action' => ['LainController@destroy', $lain->id], 'method' => 'POST'])!!}
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
                            <th>Tanggal Masuk</th>  
                            <th>Keterangan</th> 
                            <th>Nominal</th>     
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