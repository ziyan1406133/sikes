@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
            @include('inc.messages')
        <div class="panel panel-default mb-5">
            <div class="panel-body">
                <h3>Edit Profil {{$user->role}}</h3>
                <hr>
                {!! Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}
                @if($user->role == 'Bendahara')
                    <div class="form-group row">
                        <label for="avatar" class="col-md-2 col-form-label text-md-right">Avatar</label>
                        <div class="col">
                            <input name="avatar" id="avatar" type="file" class="form-control">
                            <img src="{{asset('img/avatar/'.$user->avatar)}}" width="30%" alt="">
                        </div>
                    </div>
                @else
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <input name="avatar" id="avatar" type="file" class="form-control">
                            <img src="{{asset('img/avatar/'.$user->avatar)}}" width="30%" alt="">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="ttd">Tanda Tangan</label>
                            <input name="ttd" id="ttd" type="file" class="form-control">
                            <img src="{{asset('img/ttd/'.$user->ttd)}}" width="30%" alt="">
                        </div>
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label for="no_induk" class="col-md-2 col-form-label text-md-right">Nomor Induk Siswa</label>
            
                    <div class="col">
                        @if(auth()->user()->role == 'Siswa')
                            <input name="no_induk" id="no_induk" type="text" class="form-control" value="{{$user->no_induk}}" readonly>
                        @else
                            <input name="no_induk" id="no_induk" type="text" class="form-control" value="{{$user->no_induk}}" required>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Nama Lengkap</label>
            
                    <div class="col">
                        @if(auth()->user()->role == 'Siswa')
                            <input name="name" id="name" type="text" class="form-control" value="{{$user->name}}" readonly>
                        @else
                            <input name="name" id="name" type="text" class="form-control" value="{{$user->name}}" required>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-md-2 col-form-label text-md-right">Username</label>
            
                    <div class="col">
                        <input name="username" id="username" type="text" class="form-control" value="{{$user->username}}" maxlength="16" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-2 col-form-label text-md-right">E-Mail</label>
            
                    <div class="col">
                        <input name="email" id="email" type="email" class="form-control" value="{{$user->email}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_hp" class="col-md-2 col-form-label text-md-right">Nomor Handphone</label>
            
                    <div class="col">
                        <input name="no_hp" id="no_hp" type="text" class="form-control" value="{{$user->no_hp}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-md-2 col-form-label text-md-right">Alamat</label>
            
                    <div class="col">
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" maxlength="191">{{$user->alamat}}</textarea>
                    </div>
                </div>

                <input class="btn btn-md btn-primary pull-right mt-5 mb-3" type="submit" value="Submit">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
