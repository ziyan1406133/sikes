@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="panel panel-default mb-5">
            <div class="panel-body">
                <h3>Input {{$spp->nama}}</h3>
                <hr>
                {!! Form::open(['action' => 'TagihanController@tambahspp', 'method' => 'POST']) !!}
                <div class="form-group row">
                    <label for="user" class="col-md-2 col-form-label text-md-right">Siswa</label>
            
                    <div class="col">
                        <input name="user_id" id="user_id" type="hidden" class="form-control" value="{{$user->id}}">
                        <input name="user" id="user" type="text" class="form-control" value="{{$user->no_induk}} - {{$user->name}}" readonly>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Kelas</label>
            
                    <div class="col">
                        <select placeholder="Pilih Kelas..." name="kelas_id" id="kelas_id" class="form-control" required>
                            <option value=""></option>
                            @foreach($user->kelas1 as $class)
                                <option value="{{$class->id}}">{{$class->tahun->tahun}} - {{$class->kelas->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Bulan</label>
            
                    <div class="col">
                        <select placeholder="Pilih Kelas..." name="bulan_id" id="bulan_id" class="form-control" required>
                            <option value=""></option>
                            @foreach($bulans as $bulan)
                                <option value="{{$bulan->id}}">{{$bulan->nama}}</option>
                            @endforeach
                        </select>
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
                        <input name="nominal" id="nominal" type="hidden" class="form-control" value="{{$spp->nominal}}">
                        <input name="dibayar" id="dibayar" type="number" class="form-control" step="1" placeholder="{{$spp->nominal}}" required>
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