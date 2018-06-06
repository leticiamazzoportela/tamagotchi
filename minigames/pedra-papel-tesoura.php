<?php
    $idP = $_GET['idP'];
    require '../php/minigamesClass.php';
    $game = new Minigame();
    if(isset($_POST['pedra']))
        $game->jogar($_POST['pedra'], $idP);
    else if(isset($_POST['papel']))
        $game->jogar($_POST['papel'], $idP);
    else if(isset($_POST['tesoura']))
        $game->jogar($_POST['tesoura'], $idP);
    else if(isset($_POST['lagarto']))
        $game->jogar($_POST['lagarto'], $idP);
    else if(isset($_POST['spock']))
        $game->jogar($_POST['spock'], $idP);
    
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
            
            var btnsMenu = new Audio();
            btnsMenu.src = "../songs/options.wav";

            var btnNS = new Audio(); 
            btnNS.src = "../songs/novo.wav";
        </script>

        <audio id="bg" autoplay="autoplay" loop="loop">
            <source src="../songs/bg.mp3" type="audio/mp3" />
            seu navegador não suporta HTML5
        </audio>

        <!-- MODAL -->
        <div class="modal fade" id="info-jogo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary" style="color: white;">
                        <h4 class="modal-title" id="modalLabel">Instruções</h4>
                        <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p style="font-style: italic" class="text-center"> Tesoura corta papel <br>
                        Papel cobre pedra <br>
                        Pedra esmaga lagarto <br>
                        Lagarto envenena Spock <br>
                        Spock esmaga (ou derrete) tesoura <br>
                        Tesoura decapita lagarto <br>
                        Lagarto come papel <br>
                        Papel refuta Spock <br>
                        Spock vaporiza pedra <br>
                        Pedra quebra tesoura <p>
                    </div>
                </div>
            </div>
        </div> <!-- Fim Modal -->
        
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
                        <a style="float: right" onmousedown="btnsMenu.play()" id="infos" class="btn btn-outline-danger" role="button" href="#info-jogo" data-toggle="modal">
                            <i class="fas fa-info"></i>
                        </a>
                        <h3>Pedra - Papel - Tesoura - Lagarto - Spock </h3>
                        <br />
                        <form action="pedra-papel-tesoura.php?idP=<?= $idP?>" method="post">
                                <button onmousedown="btnPlim.play()" name="pedra" type="submit" class="btn btn-outline-secondary" alt="pedra" value="pedra"><img class="btn-lg" src="https://png.icons8.com/color/40/000000/hand-rock.png"></img></button> <br><br>
                                <button onmousedown="btnPlim.play()" style="float: left" name="papel" class="btn btn-outline-danger" type="submit" alt="papel" value="papel"><img class="btn-lg" src="https://png.icons8.com/color/40/000000/hand.png"></button>
                                <button onmousedown="btnPlim.play()" style="float: right" class="btn btn-outline-info" name="tesoura" type="submit" alt="tesoura" value="tesoura"><img class="btn-lg" src="https://png.icons8.com/color/40/000000/hand-scissors.png"></button> <br><br><br><br>
                                <button onmousedown="btnPlim.play()" style="margin-right: 10%; margin-top: 10%" class="btn btn-outline-success" name="lagarto" type="submit" alt="lagarto" value="lagarto"><img class="btn-lg" src="https://png.icons8.com/color/40/000000/hand-lizard.png"></button>
                                <button onmousedown="btnPlim.play()" style="margin-left: 10%; margin-top: 10%" class="btn btn-outline-warning" name="spock" type="submit" alt="spock" value="spock"><img class="btn-lg" src="https://png.icons8.com/color/40/000000/star-trek-gesture.png"></button>
                        </form>
                        <br><br>
                    </div>
                </div>
        </body>
</html>