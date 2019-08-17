@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="panel panel-default mb-5">
            <div class="panel-body">
                <h3>Ubah Password</h3>
                <hr>
                {!! Form::model($user, array('route' => array('password', $user->id), 'method' => 'PUT')) !!}
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Password Lama</label>
            
                    <div class="col">
                        <input name="oldpassword" id="oldpassword" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Password Baru</label>
            
                    <div class="col">
                        <input name="password" id="password" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Konfirmasi Password</label>
            
                    <div class="col">
                        <input name="password1" id="password1" type="password" class="form-control" required>
                    </div>
                </div>
                <input class="btn btn-md btn-primary pull-right mt-5 mb-3" type="submit" value="Submit">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection