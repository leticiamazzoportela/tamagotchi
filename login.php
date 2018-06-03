<?php
    require 'php/userClass.php';
	$usuarios=new User();
	$usuarios->login();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/general.css">
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <script type="text/javascript">
      var btnNS = new Audio(); 
      btnNS.src = "songs/novo.wav";
   </script>

   <audio id="bg" autoplay="autoplay" loop="loop">
        <source src="songs/bg.mp3" type="audio/mp3" />
        seu navegador não suporta HTML5
    </audio>

    <body style="background-image: url(https://i.pinimg.com/originals/61/eb/53/61eb53cd52828503dd2dd8cc3d6abc9e.png); background-size: 100%; background-position: center top; background-repeat: no-repeat;">
        <div class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <a onmousedown="btnNS.play()" class="navbar-brand" href="index.html">Página Inicial</a>
            </div>
          </div>
        </div>

        <div class="container">
            <div class="jumbotron text-center" style="width: 50%; margin-left: 25%;">
                <h1>Login</h1>
                <p>Acessar Meus Pets</p>
                <p>
                    <form action="login.php" method="post" class="form-signin" style="width: 60%; margin-left: 20%;">
                        <div class="form-group">
                            <input type="text" class="form-control" name="usuario" placeholder="Usuário" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                        </div>
                        <button onmousedown="btnNS.play()" class="btn btn-lg btn-primary btn-block" type="submit">
                            <span class="glyphicon glyphicon-circle-arrow-right"></span> Acessar!
                        </button>
                    </form>
                </p>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
    </body>
</html>