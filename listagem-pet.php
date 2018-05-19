<?php
    require 'php/userClass.php';
    require 'php/petClass.php';

    $usuarios=new User();
    $usuarios->protege();

    $pets=new Pet(); //mudar aqui, pois o usuario que escolhe quando cria seus pets.
    $pets->listarPets();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/general.css">
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <div class="jumbotron">
                <form action="listagem-pet.php" method="post">

                </form>
                <p>
                    <a class="btn btn-lg btn-primary" href="logout.php" role="button">Sair</a>
                </p>
            </div>
        </div>
    </body>

</html>