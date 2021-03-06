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
                            Daftar Jenis Tagihan Siswa
                        </h4>
                    </div>
                    <div class="col">
                        <a class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="modal fade" id="tambah" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['JenistController@store'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Tambah Jenis Tagihan Siswa</h4>
                                    <div class="form-group">
                                        <label for="nama">Nama Jenis Tagihan Siswa</label>
                                        <input name="nama" id="nama" type="text" class="form-control" placeholder="Uang Bangunan" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input name="nominal" id="nominal" type="number" class="form-control" step="1" placeholder="250000" required>
                                        <small>Isi dengan angka tanpa tanda baca apapun.</small>
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
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Nominal</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenist as $jenis)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$jenis->nama}}</td>
                            <td>Rp. {{ number_format($jenis->nominal,0,",",".") }}</td>
                            <td class="text-center">
                                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$jenis->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                @if($jenis->id != '4')
                                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$jenis->id}}" href="#"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="edit{{$jenis->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::model($jenis, array('route' => array('jenist.update', $jenis->id), 'method' => 'PUT')) !!}
                                    <div class="modal-body">
                                        <h4 class="mb-5">Edit Jenis Tagihan Siswa</h4>
                                        <div class="form-group">
                                            <label for="nama">Nama Jenis Tagihan Siswa</label>
                                            @if($jenis->id == '4')
                                                <input name="nama" id="nama" type="text" class="form-control" value="{{$jenis->nama}}" readonly>
                                            @else
                                                <input name="nama" id="nama" type="text" class="form-control" value="{{$jenis->nama}}" required>
                                            @endif
                                            <div class="form-group">
                                                <label for="nominal">Nominal</label>
                                                <input name="nominal" id="nominal" type="number" class="form-control" step="1" value="{{$jenis->nominal}}" required>
                                                <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                            </div>
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

                        <div class="modal fade" id="delete{{$jenis->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4 class="mb-5">Konfirmasi</h4>
                                        <p>Apakah anda yakin ingin menghapus jenis pengeluaran ini? Semua pengeluaran yang terkait dengan jenis ini juga akan terhapus.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!!Form::open(['action' => ['JenistController@destroy', $jenis->id], 'method' => 'POST'])!!}
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
    $('#example').DataTable();
} );
</script>
@endsection