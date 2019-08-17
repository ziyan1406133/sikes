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
                            Laporan Pemasukan
                        </h4>
                    </div>
                    <div class="col">
                        <div class="pull-right">
                            <a class="btn btn-md btn-primary" data-toggle="modal" data-target="#filter" href="#"><i class="fa fa-filter"></i></a>
                            <a class="btn btn-md btn-primary" data-toggle="modal" data-target="#pdf" href="#"><i class="fa fa-file-pdf-o"></i></a>
                        </div>
                    </div>
                    <div class="modal fade" id="filter" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['LaporanController@filtermasuk'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Filter Data Pemasukan</h4>
                                    <div class="form-group">
                                        <label for="tanggal">Pada Tanggal...</label>
                                        <div class="row">
                                            <div class="col">
                                                <input name="tanggal" id="tanggal" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                            </div>
                                            <div class="col-1">
                                                -
                                            </div>
                                            <div class="col">
                                                <input name="tanggal1" id="tanggal1" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                            </div>
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
                    <div class="modal fade" id="pdf" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                    {!!Form::open(['action' => ['LaporanController@pdfmasuk'], 'method' => 'POST'])!!}
                                <div class="modal-body">
                                    <h4 class="mb-5">Filter Data Pemasukan</h4>
                                    <div class="form-group">
                                        <label for="tanggal">Pada Tanggal...</label>
                                        <div class="row">
                                            <div class="col">
                                                <input name="tanggal" id="tanggal" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                            </div>
                                            <div class="col-1">
                                                -
                                            </div>
                                            <div class="col">
                                                <input name="tanggal1" id="tanggal1" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                            </div>
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
                </div>
            </div>
            <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-5">
                        <strong>Total Pemasukan</strong> <br>
                        <strong>Saldo</strong> <br>
                    </div>
                    <div class="col">
                        : Rp. {{ number_format($total_pemasukan,0,",",".") }} <br>
                        : Rp. {{ number_format($saldo,0,",",".") }} <br>
                    </div>
                </div>
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <th>Sumber Pemasukan</th>
                            <th>Nominal</th>   
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukan as $satu)
                            <tr>
                                <td>{{date('20y/m/d', strtotime($satu->tgl_bayar))}}</td>
                                <td>
                                    @if($satu->sumber == 'BOS')
                                        {{$satu->sumber}}
                                    @else
                                        {{$satu->keterangan}}
                                    @endif
                                </td>
                                <td>Rp. {{ number_format($satu->nominal,0,",",".") }}</td>
                            </tr>
                        @endforeach
                        @foreach($tagihanlain as $tiga)
                            <tr>
                                <td> {{date('20y/m/d', strtotime($tiga->tgl_bayar))}} </td>
                                <td>
                                    {{$tiga->jenistuser->jenist->nama}} ({{$tiga->jenistuser->user->name}})
                                </td>
                                <td>Rp. {{ number_format($tiga->dibayar,0,",",".") }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <th>Sumber Pemasukan</th>
                            <th>Nominal</th>   
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