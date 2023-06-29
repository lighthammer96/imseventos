<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IMS Eventos | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/iCheck/square/blue.css') }}">


    <link rel="stylesheet" href="{{ URL::asset('selectize/selectize.bootstrap2.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>IMS Eventos</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Inicie Sesión</p>

            <form action="#" method="post" id="formulario-login">
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Usuario" id="user" name="user">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Contraseña" id="pass" name="pass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!-- <div class="form-group has-feedback">
                    <select  name="pais_id" id="pais_id" class="selectizejs entrada">

                    </select>
                </div> -->

                <div class="row">
                    <div class="col-xs-4">
                        <div class="checkbox icheck">
                            <label>
                                <!-- <input type="checkbox"> Remember Me -->
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="button" id="btn-login" class="btn btn-primary btn-block btn-flat">Login</button>

                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <center><a href="{{ URL::asset('apk/imseventosapp.apk') }}" download="imseventosapp.apk"><strong>Descargar APK.</strong></a></center>
                    </div>
                </div>

            </form>

            <!-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
          Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
          Google+</a>
      </div> -->
            <!-- /.social-auth-links -->

            <!-- <a href="#">I forgot my password</a><br>
      <a href="register.html" class="text-center">Register a new membership</a> -->

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <script>
        var BaseUrl = "<?php echo URL::to('/'); ?>";
        var _token = "<?php echo csrf_token() ?>";

    </script>
    <!-- jQuery 3 -->
    <script src="{{ URL::asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ URL::asset('selectize/selectize.js') }}"></script>

    <script src="{{ URL::asset('app/js/layout.js') }}"></script>
    <script src="{{ URL::asset('app/js/BASE_JS.js') }}"></script>
    <script src="{{ URL::asset('app/js/login.js') }}"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
</body>


</html>
