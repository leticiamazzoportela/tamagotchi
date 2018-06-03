<?php
    $idP = $_GET['idP'];
    require '../php/minigamesClass.php';
    $game = new Minigame();
    $box = array('','','','','','','','','');

    if(isset($_POST['play'])){
        //$game->jogar('jv', $_POST['play'], $idP);
        //Dessa parte para baixo, passar pro outro arquivo depois
        
        $box = $game->jogarVelha($box, $idP);

        
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
                    <div class="jumbotron text-center" style="width: 60%; margin-left: 20%;">
                        <h1>Jogo da Velha</h1>
                        <br />
                        <p class="text-center font-weight-bold"> Usuário: X <br>
                                Computador: O <p>
                        <style type="text/css">
                            #box{
                                height: 80px;
                                width: 80px;
                                text-align: center;
                                font-size: 60px;
                                color: green;
                            }
                        </style>
                        <form name="exibe" action="jogo-da-velha.php?idP=<?= $idP?>" method="post">
                            <?php
                                for($i = 0; $i <= 8; $i++){
                                    printf('<input type="text" name="box%s" value="%s" id="box">', $i, $box[$i]);
                                    if($i == 2 || $i == 5 || $i == 8){
                                        printf('<br>');
                                    }
                                }
                            ?>
                            <br>
                            <button onmousedown="btnPlim.play()" name="play" class="btn btn-lg btn-outline-success rounded-circle" type="submit">
                                <i class="fas fa-play"></i>
                            </button>
                        </form>
                        <br><br>
                    </div>
                </div>
        </body>
</html>