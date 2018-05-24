<?php
    require 'php/userClass.php';
	$usuarios=new User();
	$usuarios->cadastrar();
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
    <body style="background-image: url(https://i.pinimg.com/originals/61/eb/53/61eb53cd52828503dd2dd8cc3d6abc9e.png); background-size: 100%; background-position: center top; background-repeat: no-repeat;">
        <div class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="index.html">Página Inicial</a>
            </div>
          </div>
        </div>
    
        <div class="container">
          <div class="jumbotron text-center" style="width: 50%; margin-left: 25%;">
            <h1>Cadastre-se!</h1>
            <p>Preencha os dados abaixo para se cadastrar no sistema e poder cuidar de vários pets virtuais!</p>
            <p>
            <form action="cadastrar.php" method="post" class="form-horizontal" style="width: 60%; margin-left: 20%;">
                <div class="form-group">
                   	<input type="text" class="form-control" id="inputUsuario" name="usuario" placeholder="Usuário" required>
                </div>
                <div class="form-group">
                   	<input type="password" class="form-control" id="inputSenha" name="senha" placeholder="Senha" required>
                </div>
                <button class="btn btn-lg btn-danger btn-block" type="submit">
                	<span class="glyphicon glyphicon-circle-arrow-right"></span> Cadastrar!
                </button>
            </form>
            </p>
          </div>
    
        </div> <!-- /container -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
    </body>
</html>