@extends('layouts.app')

@section('content')
<div id="content">
    <div class="mission text-center block block-pd-sm block-bg-noise">
        <div class="container">
            @include('inc.messages')
            <h2 class="text-shadow-white">
                Selamat Datang, {{auth()->user()->name}} <br> <br>
                <img src="{{asset('img/icon.jpg')}}" width="20%" class="center" alt="Logo">
            </h2>
        </div>  
    </div>
</div>
@endsection
