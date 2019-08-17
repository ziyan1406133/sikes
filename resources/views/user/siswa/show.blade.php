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
                        <div class="row">
                            <div class="col">
                                <h4>
                                    Profil {{$user->role}}
                                </h4>
                            </div>
                            <div class="col">
                                <div class="pull-right">
                                    <a class="btn btn-md btn-primary" href="/tagihan/{{$user->id}}"><i class="fa fa-money"></i></a>
                                    <a class="btn btn-md btn-danger" data-toggle="modal" data-target="#delete" href="#"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h4 class="mb-5">Konfirmasi</h4>
                                    <p>Apakah anda yakin ingin menghapus akun siswa ini? semua data tagihan dari siswa ini juga akan terhapus</p>
                                </div>
                                <div class="modal-footer">
                                    {!!Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'POST'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                            <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Batal</button>
                                            {{Form::submit('Ya', ['class' => 'btn btn-md btn-default'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-borderless table-responsive">
                            <tbody>
                                <tr>
                                    <td>NIS</td>
                                    <td>: {{$user->no_induk}}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    @foreach($user->currentclass as $kelas)
                                        <td>: {{$kelas->nama}} <a class="btn btn-empty btn-sm" data-toggle="modal" data-target="#riwayatkelas" href="#"><i class="fa fa-eye"></i></a></td>
                                    @endforeach
                                </tr>
                                <div class="modal fade" id="riwayatkelas" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h4 class="mb-5">Riwayat Kelas {{$user->name}}</h4>
                                                <ul>
                                                    @foreach ($user->kelas1 as $class)
                                                        <li>{{$class->tahun->tahun}} : {{$class->kelas->nama}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        <hr>
                        <h3 class="mb-5">Data Orang Tua/Wali</h3>
                        <table class="table table-borderless table-responsive">
                            @if($user->nama_ayah != NULL)
                                <tr>
                                    <td>Nama Ayah</td>
                                    <td>: {{$user->nama_ayah}}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>: {{$user->pekerjaan_ayah}}</td>
                                </tr>
                            @endif
                            @if($user->nama_ibu != NULL)
                                <tr>
                                    <td>Nama Ibu</td>
                                    <td>: {{$user->nama_ibu}}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>: {{$user->pekerjaan_ibu}}</td>
                                </tr>
                            @endif
                            @if($user->nama_wali != NULL)
                                <tr>
                                    <td>Nama Ibu</td>
                                    <td>: {{$user->nama_wali}}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>: {{$user->pekerjaan_wali}}</td>
                                </tr>
                            @endif
                            @if($user->alamat_wali != NULL)
                                <tr>
                                    <td>Alamat Orang Tua</td>
                                    <td>: {{$user->alamat_wali}}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
