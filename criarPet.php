<?php

    require 'php/userClass.php';    
    $usuarios=new User();

    require 'php/petClass.php';
	  $pets=new Pet();
    $pets->criarPet();
    
    if(isset($_POST['criar']))
      header('Location: ./listagem-pet.php');
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
    <body>
        <div class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="listagem-pet.php">Visualizar Pets</a>
            </div>
          </div>
        </div>
    
        <div class="container">
          <div class="jumbotron text-center">
            <h1>Crie seu Pet!</h1>
            <p>Digite abaixo um nome para seu pet!</p>
            <p>
            <form action="criarPet.php" method="post" class="form-horizontal form-style">
                <div class="form-group">
                   	<input type="text" class="form-control" id="inputNome" name="nomePet" placeholder="Nome:" required>
                </div>
                <button name="criar" class="btn btn-lg btn-danger btn-block" type="submit">
                	<span class="glyphicon glyphicon-circle-arrow-right"></span> Criar!
                </button>
            </form>
            </p>
          </div>
    
        </div> <!-- /container -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
    </body>
</html>