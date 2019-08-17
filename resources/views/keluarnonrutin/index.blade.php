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
                            Pengeluaran Non Rutin
                        </h4>
                    </div>
                    @if(auth()->user()->role == 'Admin')
                        <div class="col">
                            <a class="btn btn-md btn-primary pull-right" data-toggle="modal" data-target="#tambah" href="#"><i class="fa fa-plus"></i></a>
                        </div>
                        <div class="modal fade" id="tambah" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                        {!!Form::open(['action' => ['PengeluaranNonRutinController@store'], 'method' => 'POST'])!!}
                                    <div class="modal-body">
                                        <h4 class="mb-5">Tambah Pengeluaran</h4>
                                        <div class="form-group">
                                            <select placeholder="Pilih Jenis" name="jenisk_id" id="jenisk_id" class="form-control" required>
                                                <option value=""></option>
                                                @foreach($jenispengeluaran as $jenisk)
                                                    <option value="{{$jenisk->id}}">{{$jenisk->nama}}</option>
                                                @endforeach
                                            </select>
                                            <small>Jika tidak ada di pilihan, silahkan tambah terlebih dahulu <a href="/jenisk">di sini</a></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input name="nominal" id="nominal" type="number" class="form-control" step="1" placeholder="250000" required>
                                            <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal Pengeluaran</label>
                                            <input name="tanggal" id="tanggal" type="date" class="form-control" placeholder="mm/dd/yyyy" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="80" placeholder="Keterangan Pengeluaran." required>
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
                </div>
            </div>
            <div class="panel-body">
                <div class="row mb-3">
                    <div class="col-5">
                        <strong>Total Pengeluaran Non Rutin</strong> <br>
                        <strong>Total Seluruh Pengeluaran</strong> <br>
                        <strong>Saldo</strong> <br>
                    </div>
                    <div class="col">
                        : Rp. {{ number_format($total_non_rutin,0,",",".") }} <br>
                        : Rp. {{ number_format($total_pengeluaran,0,",",".") }} <br>
                        : Rp. {{ number_format($saldo,0,",",".") }} <br>
                    </div>
                </div>
                <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Tanggal Pengeluaran</th>  
                            <th>Perihal</th> 
                            <th>Nominal</th>   
                            <th>Keterangan</th> 
                            <th>Status</th> 
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pending as $non_rutin)
                            <tr>
                                <td>{{date('20y/m/d', strtotime($non_rutin->tanggal))}}</td>
                                <td>{{$non_rutin->jenisk->nama}}</td>
                                <td>Rp. {{ number_format($non_rutin->nominal,0,",",".") }}</td>
                                <td>{{$non_rutin->keterangan}}</td>
                                <td>{{$non_rutin->status}}</td>
                                <td class="text-center">
                                    @if($non_rutin->status == 'Ditolak')
                                        <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#alasan{{$non_rutin->id}}" href="#"><i class="fa fa-eye"></i></a>
                                        @if(auth()->user()->role == 'Admin')
                                            <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$non_rutin->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$non_rutin->id}}" href="#"><i class="fa fa-trash"></i></a>
                                        @endif
                                    @else
                                        @if(auth()->user()->role == 'Admin')
                                            <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$non_rutin->id}}" href="#"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$non_rutin->id}}" href="#"><i class="fa fa-trash"></i></a>
                                        @else
                                            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#terima{{$non_rutin->id}}" href="#"><i class="fa fa-check"></i></a>
                                            <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#tolak{{$non_rutin->id}}" href="#">×</a>

                                        @endif
                                    @endif
                                </td>
                                @if($non_rutin->status == 'Ditolak')
                                    <div class="modal fade" id="alasan{{$non_rutin->id}}" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h4 class="mb-5">Pengeluaran ditolak dengan alasan : </h4>
                                                    "{{$non_rutin->alasan}}"
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="edit{{$non_rutin->id}}" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                {!! Form::model($non_rutin, array('route' => array('pengeluarannonrutin.update', $non_rutin->id), 'method' => 'PUT')) !!}
                                                <div class="modal-body">
                                                    <h4 class="mb-5">Edit Data Pengeluaran</h4>
                                                    <div class="form-group">
                                                        <select placeholder="Pilih Jenis" name="jenisk_id" id="jenisk_id" class="form-control" required>
                                                            <option value=""></option>
                                                            @foreach($jenispengeluaran as $jenisk)
                                                                @if($jenisk->id == $non_rutin->jenisk_id)
                                                                    <option value="{{$jenisk->id}}" selected>{{$jenisk->nama}}</option>
                                                                @else
                                                                    <option value="{{$jenisk->id}}">{{$jenisk->nama}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <small>Jika tidak ada di pilihan, silahkan tambah terlebih dahulu <a href="/jenisk">di sini</a></small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nominal">Nominal</label>
                                                        <input name="nominal" id="nominal" type="number" class="form-control" step="1" value="{{$non_rutin->nominal}}" required>
                                                        <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tanggal">Tanggal Masuk</label>
                                                        <input name="tanggal" id="tanggal" type="date" class="form-control" value="{{$non_rutin->tanggal}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan</label>
                                                        <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="80" value="{{$non_rutin->keterangan}}" placeholder="Keterangan Pengeluaran." required>
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
                                    
                                    <div class="modal fade" id="delete{{$non_rutin->id}}" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h4 class="mb-5">Konfirmasi</h4>
                                                    <p>Apakah anda yakin ingin menghapus data pengeluaran ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    {!!Form::open(['action' => ['PengeluaranNonRutinController@destroy', $non_rutin->id], 'method' => 'POST'])!!}
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                            <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Batal</button>
                                                            {{Form::submit('Ya', ['class' => 'btn btn-md btn-default'])}}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($non_rutin->status == 'Menunggu Konfirmasi')
                                    @if(auth()->user()->role == 'Admin')
                                        <div class="modal fade" id="edit{{$non_rutin->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    {!! Form::model($non_rutin, array('route' => array('pengeluarannonrutin.update', $non_rutin->id), 'method' => 'PUT')) !!}
                                                    <div class="modal-body">
                                                        <h4 class="mb-5">Edit Data Pengeluaran</h4>
                                                        <div class="form-group">
                                                            <select placeholder="Pilih Jenis" name="jenisk_id" id="jenisk_id" class="form-control" required>
                                                                <option value=""></option>
                                                                @foreach($jenispengeluaran as $jenisk)
                                                                    @if($jenisk->id == $non_rutin->jenisk_id)
                                                                        <option value="{{$jenisk->id}}" selected>{{$jenisk->nama}}</option>
                                                                    @else
                                                                        <option value="{{$jenisk->id}}">{{$jenisk->nama}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <small>Jika tidak ada di pilihan, silahkan tambah terlebih dahulu <a href="/jenisk">di sini</a></small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nominal">Nominal</label>
                                                            <input name="nominal" id="nominal" type="number" class="form-control" step="1" value="{{$non_rutin->nominal}}" required>
                                                            <small>Isi dengan angka tanpa tanda baca apapun.</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal Masuk</label>
                                                            <input name="tanggal" id="tanggal" type="date" class="form-control" value="{{$non_rutin->tanggal}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <input name="keterangan" id="keterangan" type="text" class="form-control" maxlength="80" value="{{$non_rutin->keterangan}}" placeholder="Keterangan Pengeluaran." required>
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
            
                                        <div class="modal fade" id="delete{{$non_rutin->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h4 class="mb-5">Konfirmasi</h4>
                                                        <p>Apakah anda yakin ingin menghapus data pengeluaran ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!!Form::open(['action' => ['PengeluaranNonRutinController@destroy', $non_rutin->id], 'method' => 'POST'])!!}
                                                            {{Form::hidden('_method', 'DELETE')}}
                                                                <button type="button" class="btn btn-md btn-primary" data-dismiss="modal">Batal</button>
                                                                {{Form::submit('Ya', ['class' => 'btn btn-md btn-default'])}}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        @foreach($pengeluaran as $non_rutin)
                        <tr>
                            <td>{{date('20y/m/d', strtotime($non_rutin->tanggal))}}</td>
                            <td>{{$non_rutin->jenisk->nama}}</td>
                            <td>Rp. {{ number_format($non_rutin->nominal,0,",",".") }}</td>
                            <td>{{$non_rutin->keterangan}}</td>
                            <td>{{$non_rutin->status}}</td>
                            <td class="text-center">                   
                                @if(auth()->user()->role == 'Admin')
                                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{$non_rutin->id}}" href="#"><i class="fa fa-trash"></i></a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>                  
                        @if(auth()->user()->role == 'Admin')
                            <div class="modal fade" id="delete{{$non_rutin->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h4 class="mb-5">Konfirmasi</h4>
                                            <p>Apakah anda yakin ingin menghapus data pengeluaran ini? Saldo akan bertambah sesuai dengan nominal data yang dihapus.</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!!Form::open(['action' => ['PengeluaranNonRutinController@destroy', $non_rutin->id], 'method' => 'POST'])!!}
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
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tanggal Masuk</th>  
                            <th>Perihal</th> 
                            <th>Nominal</th>     
                            <th>Keterangan</th> 
                            <th>Status</th> 
                            <th class="text-center">Opsi</th>
                        </tr>
                    </tfoot>
                </table>
                @if(count($pending) > 0)
                    @foreach($pending as $non_rutin)
                        @if((auth()->user()->role == 'Kepala Sekolah') && ($non_rutin->status == 'Menunggu Konfirmasi'))
                            <div class="modal fade" id="terima{{$non_rutin->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        {!! Form::model($non_rutin, array('route' => array('terima', $non_rutin->id), 'method' => 'PUT')) !!}
                                        <div class="modal-body">
                                            <h4 class="mb-5">Terima Pengeluaran Non Rutin</h4>
                                            <p class="mb-3">Apakah anda yakin untuk menerima pengeluaran berikut?</p>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Tanggal Pengeluaran</td>
                                                        <td>: {{date('20y/m/d', strtotime($non_rutin->tanggal))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Perihal</td>
                                                        <td>: {{$non_rutin->jenisk->nama}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nominal</td>
                                                        <td>: Rp. {{ number_format($non_rutin->nominal,0,",",".") }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan</td>
                                                        <td>: {{$non_rutin->keterangan}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                                            {{Form::submit('Terima', ['class' => 'btn btn-md btn-primary'])}}
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="tolak{{$non_rutin->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        {!! Form::model($non_rutin, array('route' => array('tolak', $non_rutin->id), 'method' => 'PUT')) !!}
                                        <div class="modal-body">
                                            <h4 class="mb-5">Tolak Pengeluaran Non Rutin</h4>
                                            <p class="mb-3">Apakah anda yakin untuk menolak pengeluaran berikut?</p>
                                            <table class="table table-borderless mb-5">
                                                <tbody>
                                                    <tr>
                                                        <td>Tanggal Pengeluaran</td>
                                                        <td>: {{date('20y/m/d', strtotime($non_rutin->tanggal))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Perihal</td>
                                                        <td>: {{$non_rutin->jenisk->nama}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nominal</td>
                                                        <td>: Rp. {{ number_format($non_rutin->nominal,0,",",".") }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan</td>
                                                        <td>: {{$non_rutin->keterangan}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                                <label for="alasan">Alasan Penolakan</label>
                                                <textarea name="alasan" id="alasan" rows="3" class="form-control" maxlength="191" required></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                                            {{Form::submit('Tolak', ['class' => 'btn btn-md btn-danger'])}}
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
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
        "order": [[ 4, "desc" ]]
    });
} );
</script>
@endsection