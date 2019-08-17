@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="panel panel-default mb-5">
            <div class="panel-body">
                <h3>Edit Profil {{$user->role}}</h3>
                <hr>
                <div class="row">
                    <div class="col-5">
                        <h4 class="mb-5">Data Pribadi</h6>
                        <strong>Kelas :</strong>
                        <ul>
                            @foreach ($user->kelas1 as $class)
                                <li>{{$class->tahun->tahun}} : {{$class->kelas->nama}} 
                                    @if(auth()->user()->role == 'Admin') 
                                    <a class="btn btn-empty btn-sm" data-toggle="modal" data-target="#edit{{$class->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a class="btn btn-empty btn-sm" data-toggle="modal" data-target="#delete{{$class->id}}" href="#"><i class="fa fa-trash"></i></a>
                                    @endif
                                </li>
                                @if(auth()->user()->role == 'Admin') 
                                <div class="modal fade" id="edit{{$class->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            {!! Form::model($class, array('route' => array('kelasuser.ubah', $class->id), 'method' => 'PUT')) !!}
                                            <div class="modal-body">
                                                <h4 class="mb-5">Ubah Kelas {{$user->name}}</h4>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 col-form-label text-md-right">Kelas</label>
                                            
                                                    <div class="col">
                                                        <select placeholder="Pilih Kelas..." name="kelas_id" id="kelas_id" class="form-control" required>
                                                            <option value=""></option>
                                                            @foreach($kelas as $kelaspilihan)
                                                                @if($kelaspilihan->id == $class->kelas->id)
                                                                    <option value="{{$kelaspilihan->id}}" selected>{{$kelaspilihan->nama}}</option>
                                                                @else
                                                                    <option value="{{$kelaspilihan->id}}">{{$kelaspilihan->nama}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select placeholder="Pilih Tahun Ajaran..." name="tahun_id" id="tahun_id" class="form-control" required>
                                                            <option value=""></option>
                                                            @foreach($tahun_ajaran as $tahun)
                                                                @if($tahun->id == $class->tahun->id)
                                                                    <option value="{{$tahun->id}}" selected>{{$tahun->tahun}}</option>
                                                                @else
                                                                    <option value="{{$tahun->id}}">{{$tahun->tahun}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
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
                                
                                <div class="modal fade" id="delete{{$class->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h4 class="mb-5">Konfirmasi</h4>
                                                <p>Apakah anda yakin ingin menghapus Kelas siswa ini? Semua SPP yang pernah dibayar oleh siswa ini di kelas tersebut akan ikut terhapus.</p>
                                            </div>
                                            <div class="modal-footer">
                                                {!!Form::open(['action' => ['KelasController@hapus', $class->id], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                        <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Batal</button>
                                                        {{Form::submit('Ya', ['class' => 'btn btn-md btn-default'])}}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                            @if(auth()->user()->role == 'Admin') 
                                <li><a class="btn btn-empty btn-sm" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a></li>
                                <div class="modal fade" id="tambah" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            {!! Form::open(['action' => 'KelasController@tambah', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <div class="modal-body">
                                                <h4 class="mb-5">Tambah Kelas {{$user->name}}</h4>
                                                <input name="user_id" id="user_id" type="hidden" value="{{$user->id}}">
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 col-form-label text-md-right">Kelas</label>
                                            
                                                    <div class="col">
                                                        <select placeholder="Pilih Kelas..." name="kelas_id" id="kelas_id" class="form-control" required>
                                                            <option value=""></option>
                                                            @foreach($kelas as $kelaspilihan)
                                                                <option value="{{$kelaspilihan->id}}">{{$kelaspilihan->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <select placeholder="Pilih Tahun Ajaran..." name="tahun_id" id="tahun_id" class="form-control" required>
                                                            <option value=""></option>
                                                            @foreach($tahun_ajaran as $tahun)
                                                                <option value="{{$tahun->id}}">{{$tahun->tahun}}</option>
                                                            @endforeach
                                                        </select>
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
                            @endif
                        </ul>
                    </div>
                {!! Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}
                    <div class="col">
                        <div class="form-group">
                            <label for="avatar" class="col-form-label text-md-right">Avatar</label>
                            <input name="avatar" id="avatar" type="file" class="form-control">
                        </div>
                        <img src="{{asset('img/avatar/'.$user->avatar)}}" width="30%" alt="">
                    </div>
                </div>
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
                <hr>
                <h4 class="mb-5">Data Orang Tua/Wali</h6>
                
                <div class="form-group row">
                    <label for="nama_ayah" class="col-md-2 col-form-label text-md-right">Nama Ayah</label>
            
                    <div class="col">
                        <input name="nama_ayah" id="nama_ayah" type="text" class="form-control" value="{{$user->nama_ayah}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_ayah" class="col-md-2 col-form-label text-md-right">Pekerjaan Ayah</label>
            
                    <div class="col">
                        <input name="pekerjaan_ayah" id="nama_ayah" type="text" class="form-control" value="{{$user->pekerjaan_ayah}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_ibu" class="col-md-2 col-form-label text-md-right">Nama Ibu</label>
            
                    <div class="col">
                        <input name="nama_ibu" id="nama_ibu" type="text" class="form-control" value="{{$user->nama_ibu}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_ibu" class="col-md-2 col-form-label text-md-right">Pekerjaan Ibu</label>
            
                    <div class="col">
                        <input name="pekerjaan_ibu" id="nama_ibu" type="text" class="form-control" value="{{$user->pekerjaan_ibu}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_wali" class="col-md-2 col-form-label text-md-right">Nama Wali</label>
            
                    <div class="col">
                        <input name="nama_wali" id="nama_wali" type="text" class="form-control" value="{{$user->nama_wali}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_wali" class="col-md-2 col-form-label text-md-right">Pekerjaan Wali</label>
            
                    <div class="col">
                        <input name="pekerjaan_wali" id="nama_wali" type="text" class="form-control" value="{{$user->pekerjaan_wali}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat_wali" class="col-md-2 col-form-label text-md-right">Alamat Orangtua/Wali</label>
            
                    <div class="col">
                        <textarea name="alamat_wali" id="alamat_wali" class="form-control" rows="3" maxlength="191">{{$user->alamat}}</textarea>
                    </div>
                </div>
                <input class="btn btn-md btn-primary pull-right mt-5 mb-3" type="submit" value="Submit">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
