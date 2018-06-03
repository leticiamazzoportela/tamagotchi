<?php
    $idP = $_GET['idP'];
    require '../php/minigamesClass.php';
    $game = new Minigame();
    if(isset($_POST['pedra'])){
        $pedra = $_POST['pedra'];
        $game->jogar($pedra, $idP);
    }
    else if(isset($_POST['papel'])){
        $papel = $_POST['papel'];
        $game->jogar($papel, $idP);
    }
    else if(isset ($_POST['tesoura'])){
        $tesoura = $_POST['tesoura'];
        $game->jogar($tesoura, $idP);
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <a href="https://icons8.com"></a>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/general.css">
        <link rel="stylesheet" type="text/css" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">


        <!--
            Fonte dos Gifs

         -->
        </head>

        <script type="text/javascript">
            var btnPlim = new Audio(); 
            btnPlim.src = "../songs/plim.wav";

            var btnNS = new Audio(); 
            btnNS.src = "../songs/novo.wav";
        </script>

        <audio id="bg" autoplay="autoplay" loop="loop">
            <source src="../songs/bg.mp3" type="audio/mp3" />
            seu navegador não suporta HTML5
        </audio>
        
        <body style="background-image: url(https://i.pinimg.com/originals/61/eb/53/61eb53cd52828503dd2dd8cc3d6abc9e.png); background-size: 100%; background-position: center top; background-repeat: no-repeat;">
            <div class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                <a onmousedown="btnNS.play()" class="navbar-brand" href="../listagem-pet.php">Voltar</a>
                </div>
            </div>
            </div>
                <div class="container" id="ppt">
                    <div class="jumbotron text-center" style="width: 50%; margin-left: 25%;">
                        <h1>Pedra - Papel - Tesoura</h1>
                        <br />
                        <form action="pedra-papel-tesoura.php?idP=<?= $idP?>" method="post">
                                <input onmousedown="btnPlim.play()" name="pedra" type="image" src="https://vignette.wikia.nocookie.net/sonicboombrasilbr/images/c/c7/Pedra_da_justi%C3%A7a.png/revision/latest?cb=20150905020413&path-prefix=pt-br" width="135" height="135" alt="pedra" value="pedra"></input>
                                <input onmousedown="btnPlim.play()" name="papel" type="image" src="https://78.media.tumblr.com/cfc5ea8cc7b3708950a37c93b25b6d34/tumblr_p4fbotLnzJ1uke6wjo1_1280.png" width="135" height="135" alt="papel" value="papel"></input>
                                <input onmousedown="btnPlim.play()" name="tesoura" type="image" src="http://worldartsme.com/images/scissor-cartoon-clipart-1.jpg" width="135" height="140" alt="tesoura" value="tesoura"></input>
                        </form>
                        <br><br>
                    </div>
                </div>
        </body>
</html>