@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="row">
            <div class="col-3">
                <img src="{{asset('img/avatar/'.$user->avatar)}}" alt="Avatar">
                <div class="mt-4 panel panel-default">
                    <div class="panel-heading">
                        Pengaturan
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-more medium mb-3" href="/user/{{$user->id}}/edit"><i class="glyphicon glyphicon-edit"></i> Edit Profil</a>
                        @if(auth()->user()->id == $user->id)
                            <a class="btn btn-more medium" href="/editpassword/{{$user->id}}/user"><i class="fa fa-lock"></i> Ubah Password</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="panel panel-default mb-5">
                    <div class="panel-heading">
                        <h4>
                            Profil {{$user->role}}
                        </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-borderless table-responsive">
                            <tbody>
                                <tr>
                                    <td>NIP</td>
                                    <td>: {{$user->no_induk}}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td>: {{$user->username}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    @if($user->email == NULL)
                                        <td>: -</td>
                                    @else
                                        <td>: {{$user->email}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    @if($user->no_hp == NULL)
                                        <td>: -</td>
                                    @else
                                        <td>: {{$user->no_hp}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    @if($user->alamat == NULL)
                                        <td>: -</td>
                                    @else
                                        <td>: {{$user->alamat}}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
