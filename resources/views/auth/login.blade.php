<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>SIKES</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">

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

<!-- =====================================================================================
    Theme Name: Flexor
    Theme URL: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
====================================================================================== -->
</head>

<body class="fullscreen-centered page-login">

<div id="background-wrapper" class="benches" data-stellar-background-ratio="0.8">
<div id="content">
    <div class="header">
        <div class="header-inner">
        <!--navbar-branding/logo - hidden image tag & site name so things like Facebook to pick up, actual logo set via CSS for flexibility -->
        <a class="navbar-brand center-block" href="#"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-6 center">
            @include('inc.messages')
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title">
                    Login
                    </h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                    
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Identitas') }}</label>
                    
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <small>Identitas dapat berupa username, e-mail, atau NIS</small>
                        <div class="form-group mb-0 pull-right mr-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
</div>

<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/stellar/stellar.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="js/custom.js"></script>


</body>

</html>
