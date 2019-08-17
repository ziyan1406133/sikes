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
                            Pemasukan Dana BOS
                        </h4>
                    </div>
                    <div class="col">
                        <a class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="modal fade" id="tambah" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['BosController@store'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Tambah Pemasukan Dari Dana BOS</h4>
                                    <div class="form-group">
                                        <label for="triwulan">Triwulan</label>
                                        <select placeholder="Pilih Triwulan ..." name="triwulan" id="triwulan" class="form-control" required>
                                            <option value=""></option>
                                            <option value="I">Triwulan I</option>
                                            <option value="II">Triwulan II</option>
                                            <option value="III">Triwulan III</option>
                                        </select>
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
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan (Opsional)</label>
                                        <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="70" placeholder="Keterangan pemasukan dana BOS.">
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
                        <strong>Total Dana Bos</strong> <br>
                        <strong>Total Pemasukan</strong> <br>
                        <strong>Saldo</strong> <br>
                    </div>
                    <div class="col">
                        : Rp. {{ number_format($total_bos,0,",",".") }} <br>
                        : Rp. {{ number_format($total_pemasukan,0,",",".") }} <br>
                        : Rp. {{ number_format($saldo,0,",",".") }} <br>
                    </div>
                </div>
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <th>Triwulan</th>
                            <th>Nominal</th>   
                            <th>Keterangan</th>   
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukan as $bos)
                        <tr>
                            <td>{{date('20y/m/d', strtotime($bos->tgl_bayar))}}</td>
                            <td>Triwulan {{$bos->triwulan}}</td>
                            <td>Rp. {{ number_format($bos->nominal,0,",",".") }}</td>
                            <td>
                                @if($bos->keterangan == NULL)
                                    -
                                @else
                                    {{$bos->keterangan}}
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$bos->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$bos->id}}" href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="edit{{$bos->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::model($bos, array('route' => array('BOS.update', $bos->id), 'method' => 'PUT')) !!}
                                    <div class="modal-body">
                                        <h4 class="mb-5">Edit Pemasukan Dari Dana BOS</h4>
                                        <div class="form-group">
                                            <label for="triwulan">Triwulan</label>
                                            {!! Form::select('triwulan', ['I' => 'Triwulan I', 'II' => 'Triwulan III', 'III' => 'Triwulan III'], $bos->triwulan, ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input name="nominal" id="nominal" type="number" class="form-control" step="1" value="{{$bos->nominal}}" required>
                                            <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_bayar">Tanggal Masuk</label>
                                            <input name="tgl_bayar" id="tgl_bayar" type="date" class="form-control" value="{{$bos->tgl_bayar}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan (Opsional)</label>
                                            <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="70" placeholder="Keterangan pemasukan dana BOS." value="{{$bos->keterangan}}">
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

                        <div class="modal fade" id="delete{{$bos->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4 class="mb-5">Konfirmasi</h4>
                                        <p>Apakah anda yakin ingin menghapus data pemasukan ini? Saldo akan berkurang sesuai dengan nominal data yang dihapus.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!!Form::open(['action' => ['BosController@destroy', $bos->id], 'method' => 'POST'])!!}
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
                            <th>Triwulan</th>
                            <th>Nominal</th>   
                            <th>Keterangan</th>   
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