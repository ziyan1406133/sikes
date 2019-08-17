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
                            Daftar Siswa
                        </h4>
                    </div>
                    <div class="col">
                        <a class="btn btn-md btn-primary pull-right" href="/user/create"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>E-Mail</th>
                            <th>Kelas</th>   
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->no_induk}}</td>
                                <td>{{$user->name}}</td>
                                <td>
                                    @if($user->email == NULL)
                                        -
                                    @else
                                        {{$user->email}}
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->currentclass as $kelas)
                                        {{$kelas->nama}}
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="/user/{{$user->id}}"><i class="fa fa-user"></i></a>
                                    <a class="btn btn-sm btn-primary" href="/tagihan/{{$user->id}}"><i class="fa fa-money"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>E-Mail</th>
                            <th>Kelas</th>   
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