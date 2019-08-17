@extends('layouts.app')

@section('content')
<div id="content">
    <div class="container">
        @include('inc.messages')
        <div class="panel panel-default mb-5">
            <div class="panel-body">
                <h3>Tambah Siswa</h3>
                <hr>
                <h4 class="mb-5">Data Pribadi</h6>
                {!! Form::open(['action' => 'UserController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group row">
                    <label for="avatar" class="col-md-2 col-form-label text-md-right">Avatar</label>
                    <div class="col">
                        <input name="avatar" id="avatar" type="file" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_induk" class="col-md-2 col-form-label text-md-right">Nomor Induk Siswa*</label>
            
                    <div class="col">
                        <input name="no_induk" id="no_induk" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Nama Lengkap*</label>
            
                    <div class="col">
                        <input name="name" id="name" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Kelas*</label>
            
                    <div class="col">
                        <select placeholder="Pilih Kelas..." name="kelas_id" id="kelas_id" class="form-control" required>
                            <option value=""></option>
                            @foreach($kelas as $class)
                                <option value="{{$class->id}}">{{$class->nama}}</option>
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
                <div class="form-group row">
                    <label for="username" class="col-md-2 col-form-label text-md-right">Username*</label>
            
                    <div class="col">
                        <input name="username" id="username" type="text" class="form-control" maxlength="16" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-2 col-form-label text-md-right">E-Mail</label>
            
                    <div class="col">
                        <input name="email" id="email" type="email" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_hp" class="col-md-2 col-form-label text-md-right">Nomor Handphone</label>
            
                    <div class="col">
                        <input name="no_hp" id="no_hp" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-md-2 col-form-label text-md-right">Alamat</label>
            
                    <div class="col">
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" maxlength="191"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Konfirmasi Password*</label>
            
                    <div class="col">
                        <input name="password" id="password" type="password" class="form-control" required>
                    </div>
                    <div class="col">
                        <input name="password1" id="password1" type="password" class="form-control" required>
                    </div>
                </div>
                <hr>
                <h4 class="mb-5">Data Orang Tua/Wali</h6>
                
                <div class="form-group row">
                    <label for="nama_ayah" class="col-md-2 col-form-label text-md-right">Nama Ayah</label>
            
                    <div class="col">
                        <input name="nama_ayah" id="nama_ayah" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_ayah" class="col-md-2 col-form-label text-md-right">Pekerjaan Ayah</label>
            
                    <div class="col">
                        <input name="pekerjaan_ayah" id="nama_ayah" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_ibu" class="col-md-2 col-form-label text-md-right">Nama Ibu</label>
            
                    <div class="col">
                        <input name="nama_ibu" id="nama_ibu" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_ibu" class="col-md-2 col-form-label text-md-right">Pekerjaan Ibu</label>
            
                    <div class="col">
                        <input name="pekerjaan_ibu" id="nama_ibu" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_wali" class="col-md-2 col-form-label text-md-right">Nama Wali</label>
            
                    <div class="col">
                        <input name="nama_wali" id="nama_wali" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_wali" class="col-md-2 col-form-label text-md-right">Pekerjaan Wali</label>
            
                    <div class="col">
                        <input name="pekerjaan_wali" id="nama_wali" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat_wali" class="col-md-2 col-form-label text-md-right">Alamat Orangtua/Wali</label>
            
                    <div class="col">
                        <textarea name="alamat_wali" id="alamat_wali" class="form-control" rows="3" maxlength="191"></textarea>
                    </div>
                </div>
                <small>*) harus diisi.</small>
                <input class="btn btn-md btn-primary pull-right mt-5 mb-3" type="submit" value="Submit">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection