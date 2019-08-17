<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/storage/img/storage-icon.png"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <style>
    html {
        position: relative;
        min-height: 100%;
    }

    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
    }
    .table {
      width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
    }

    .table th,
    .table td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }

    .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6;
    }

    .table tbody + tbody {
      border-top: 2px solid #dee2e6;
    }

    .table .table {
      background-color: #fff;
    }

    .table-sm th,
    .table-sm td {
      padding: 0.3rem;
    }

    .table-bordered {
      border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #dee2e6;
    }

    .table-bordered thead th,
    .table-bordered thead td {
      border-bottom-width: 2px;
    }

    .table-borderless th,
    .table-borderless td,
    .table-borderless thead th,
    .table-borderless tbody + tbody {
      border: 0;
    }
    .table-condensed tbody>tr>td {
    padding-top: 0;
    padding-bottom: 0;
    }

    .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    }
    </style>

</head>
<body style="margin:0; padding:0;">
      <h3 style="text-align: center">LAPORAN PENGELUARAN NON RUTIN<br>
      SMA MAARIF NURUL HIDAYAH CIKELET <br>
      PERIODE {{strtoupper($bln->nama)}} {{$tahun}} - {{strtoupper($bln1->nama)}} {{$tahun1}}</h3>
      <hr>
      @if(count($pengeluaran) > 0)
      <table id="example" class="table table-bordered" style="width:100%">
          <thead>
              <tr>
                  <th>Tanggal Keluar</th>
                  <th>Jenis Pengeluaran</th>
                  <th>Keterangan</th>
                  <th>Nominal</th>   
              </tr>
          </thead>
          <tbody>
              @foreach($pengeluaran as $keluar)
                  <tr>
                      <td>{{date('20y/m/d', strtotime($keluar->tanggal))}}</td>
                      <td>{{$keluar->jenisk->nama}}</td>
                      <td>{{$keluar->keterangan}}</td>
                      <td>Rp. {{ number_format($keluar->nominal,0,",",".") }}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <p style="text-align: right"><strong>Total : Rp. {{ number_format($total,0,",",".") }}</strong></p>
      <br>
      <table class="table table-borderless">
        <tr>
          <td style="width: 400px">

          </td>
          <td style="text-align: center">
            <br><br>
            <p>Kasubag Keuangan</p>
            <br>
            <img src="{{asset('img/ttd/'.$keuangan->ttd)}}" width="250px">
            <br><br>
            <p>{{$keuangan->name}}</p>
            <p>{{$keuangan->no_induk}}</p>
          </td>
        </tr>
      </table>
      @else
      <p>Tidak ada data yang tersedia.</p>
      @endif
</body>
</html>
