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
                            Daftar Kelas
                        </h4>
                    </div>
                    <div class="col">
                        <a class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="modal fade" id="tambah" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['KelasController@store'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Tambah Kelas</h4>
                                    <div class="form-group">
                                        <label for="nama">Nama Kelas</label>
                                        <input name="nama" id="nama" type="text" class="form-control" placeholder="XI IPA 2" required>
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
                            <th>Nama Kelas</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $class)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$class->nama}}</td>
                            <td class="text-center">
                                @if($class->id == '6')
                                    -
                                @else 
                                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$class->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$class->id}}" href="#"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="edit{{$class->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    {!! Form::model($class, array('route' => array('kelas.update', $class->id), 'method' => 'PUT')) !!}
                                    <div class="modal-body">
                                        <h4 class="mb-5">Edit Kelas</h4>
                                        <div class="form-group">
                                            <label for="nama">Nama Kelas</label>
                                            <input name="nama" id="nama" type="text" class="form-control" value="{{$class->nama}}" required>
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

                        <div class="modal fade" id="delete{{$class->id}}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h4 class="mb-5">Konfirmasi</h4>
                                        <p>Apakah anda yakin ingin menghapus kelas ini? SPP yang dibayar siswa pada kelas ini juga akan terhapus.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!!Form::open(['action' => ['KelasController@destroy', $class->id], 'method' => 'POST'])!!}
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