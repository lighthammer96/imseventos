<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IMS Eventos | Soporte</title>
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
    <div class="login-box" style="width: 700px;">
        <div class="login-logo">
            <a href="../../index2.html"><b>IMS Eventos</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" >
            <p class="login-box-msg">¿Cómo usar el app?</p>

            <p>
                Ingresar Usuario: admin<br>
                Ingresar Contraseña: 1235<br>

                <p>En la opción de Control de Asistencias:<br>
                deberá selecionar en Evento la opción "WORLD ASSEMBLY PUBLIC CONFERENCE, PERU 2023",<br>
                luego seleccionar en Tipo de Programa la opción "Coliseo",<br>
                luego seleccionar en Programa la opción "ASISTENCIA",<br>
                posteriormente presionar el botón "Escanear QR" y escanear la imagen del QR adjuntado,<br>
                finalmente Guardar.</p>

                <p>Luego en la opción Control de Llegadas de Visitantes:<br>
                deberá selecionar en Evento la opción "WORLD ASSEMBLY PUBLIC CONFERENCE, PERU 2023",<br>
                posteriormente presionar el botón "Escanear QR" y escanear la imagen del QR adjuntado,<br>
                finalmente Guardar.</p>

                <p>Luego en la opción Configuración, en input radio podrá seleccionar el idioma de su preferencia.<br>
                y Por ultimo la opción cerrar sesión, eliminara la sesión y volverá al formulario de login.</p>

                <center>
                    <h3>Imagen del QR a Escanear</h3>
                    <img title="Código QR" style="cursor: pointer;height: 165px !important; width: 165px !important;" src="{{ URL::asset('QR/2-4629-4591.png') }}" class="thumb-lg img-thumbnail usuario_foto" alt="profile-image" id="cargar_qr">
                </center>
                <h4>Preguntas Adicionales</h4>
                <p>1. ¿Su aplicación está restringida a usuarios que forman parte de una sola empresa?<br>
                Si solo lo pueden usar usuarios de la empresa Sociedad Misionera Internacional Iglesia Adventista.<br>

                2. ¿Su aplicación está diseñada para ser utilizada por un grupo limitado o específico de empresas?<br>
                Si solo lo utiliza la empresa Sociedad Misionera Internacional Iglesia Adventista.<br>

                3. ¿Qué funciones de la aplicación, si las hay, están destinadas al público en general?<br>
                No las hay<br>

                4. ¿Cómo obtienen los usuarios una cuenta?<br>
                Se le asigna un usuario y una contraseña desde el sistema web de la empresa.<br>

                5. ¿Hay contenido pago en la aplicación y, de ser así, quién lo paga?<br>
                La aplicación de no es de pago.</p>
            </p>


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





</body>


</html>
