<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>SIKES</title>
<meta content="width=device-width, initial-scale=0.8" name="viewport">

<!-- Fav and touch icons -->
<link href="{{asset('img/icon.jpg')}}" rel="shortcut icon">

<!-- Google Fonts -->
<link href="{{asset('lib/fonts-googleapi/roboto.css')}}" rel="stylesheet">

<!-- Bootstrap CSS File -->
<link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"> 

<!-- Libraries CSS Files -->
<link href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/owlcarousel/owl.carousel.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/owlcarousel/owl.theme.min.css')}}" rel="stylesheet">
<link href="{{asset('lib/owlcarousel/owl.transitions.min.css')}}" rel="stylesheet">

<!-- Main Stylesheet File -->
<link href="{{asset('css/style.css')}}" rel="stylesheet">
<link href="{{asset('css/colour-green.css')}}" rel="stylesheet">
@yield('css')

<!-- =====================================================================================
    Theme Name: Flexor
    Theme URL: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
====================================================================================== -->
</head>

<body>
    
    <div id="background-wrapper" class="buildings" data-stellar-background-ratio="0.1">
        <div id="navigation" class="wrapper">
            <div class="header">
                <div class="header-inner container">
                    <a class="navbar-brand" href="#" title="Home">
                        <h1 class="hidden">
                            SIKES
                        </h1>
                    </a>
                    <div class="navbar-slogan">
                        Sistem Informasi Keuangan SMA Maarif Nurul Hidayah Cikelet
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="navbar navbar-default">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <div class="navbar-text social-media social-media-inline pull-right">
                        <a href="http://www.smanurulhidayah042.mysch.id/" target="_blank"><i class="fa fa-globe"></i></a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav" id="main-menu">
                            <li class="icon-link">
                                <a href="/"><i class="fa fa-home"></i></a>
                            </li>

                            @include('inc.navbar')

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Profil<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/user/{{auth()->user()->id}}" tabindex="-1" class="menu-item">Lihat Profil</a></li>
                                    <li><a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" 
                                        tabindex="-1" class="menu-item">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')
    <div class="footer" style="background-image:url('{{asset("/img/bg_footer-map.png")}}')">
        <div class="container">
        <br>
        <div class="row">
            <div class="col-md-7">
                <p>Copyright © Sekolah Tinggi Teknologi Garut</p>
            </div>
            <div class="col-md-5">
                <ul class="list-inline pull-right">
                    Tema Flexor Didesain oleh <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </ul>
            </div>
        </div>
        <br>

        <a href="#top" class="scrolltop">Top</a>

        </div>
    </div>

    <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('lib/stellar/stellar.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    @yield('script')

</body>

</html>
