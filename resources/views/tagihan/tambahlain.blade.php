@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="panel panel-default mb-5">
            <div class="panel-body">
                <h3>Input Tagihan {{$user->nama}}</h3>
                <hr>
                {!! Form::open(['action' => 'TagihanController@tambahlain', 'method' => 'POST']) !!}
                <div class="form-group row">
                    <label for="user" class="col-md-2 col-form-label text-md-right">Siswa</label>
            
                    <div class="col">
                        <input name="user_id" id="user_id" type="hidden" class="form-control" value="{{$user->id}}">
                        <input name="user" id="user" type="text" class="form-control" value="{{$user->no_induk}} - {{$user->name}}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user" class="col-md-2 col-form-label text-md-right">Jenis Pembayaran</label>
            
                    <div class="col">
                        <input name="jenist_id" id="jenist_id" type="hidden" class="form-control" value="{{$jenist->id}}">
                        <input name="pembayaran" id="pembayaran" type="text" class="form-control" value="{{$jenist->nama}}" disabled>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Tanggal Bayar</label>
            
                    <div class="col">
                        <input name="tgl_bayar" id="tgl_bayar" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Nominal Pembayaran</label>
            
                    <div class="col">
                        <input name="dibayar" id="dibayar" type="number" class="form-control" step="1" placeholder="{{$jenist->nominal}}" required>
                        <small>Isi dengan angka tanpa tanda baca apapun.</small>
                    </div>
                </div>

                <input class="btn btn-md btn-primary pull-right mt-5 mb-3" type="submit" value="Submit">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection