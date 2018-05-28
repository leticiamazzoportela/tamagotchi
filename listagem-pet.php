<?php
    require 'php/userClass.php';
    require 'php/petClass.php';
    require 'php/minigamesClass.php';
    
    $usuarios = new User();
    $usuarios->protege();
    
    $pets = new Pet();
    $resultado = $pets->listarPets();

    if(isset($_POST['petAtual']))  
        $teste = $_POST['petAtual'];
    else if(count($resultado) > 0)
            $teste = $resultado[0]['idPet'];

    if(!empty($teste))
        $petAtual = $pets->retPet($teste);
    else
        header('Location: ./criarPet.php');

    if(isset($_POST['deletar']))
        $pets->deletaPet();

    $game = new Minigame();
    $resGame = $game->listarMinigames($teste);

    if(isset($_POST['petM']) && isset($_POST['minigameAtual'])){
        $idP = $_POST['petM'];
        $idM = $_POST['minigameAtual'];
    }

    if(!empty($idP) && !empty($idM)){ //talvez mover essa parte pro pedra-papel-tesoura
        //$minigameAtual = $game->retGame($idP, $idM);
        if($idM == 'Pedra - Papel - Tesoura')
            header('Location: minigames/pedra-papel-tesoura.php');
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
        
        <body style="background-image: url(https://i.pinimg.com/originals/61/eb/53/61eb53cd52828503dd2dd8cc3d6abc9e.png); background-size: 100%; background-position: center top; background-repeat: no-repeat;">
        <nav class="navbar navbar-dark bg-dark"> <!-- Menu --> 
            <div class="container">
                <div class="navbar-header">
                    <a class="btn btn-outline-success menu-nav" href="criarPet.php" role="button">Criar</a>
                    <a class="btn btn-outline-primary" href="#lista-pets" data-toggle="modal" role="button">Trocar Pet</a>
                    <a class="btn btn-outline-danger" href="logout.php" role="button">Sair</a>
                </div>
                    <h1 style="color: white;"> <?php echo $petAtual['nomePet']; ?></h1>
            </div>
        </div>
        </nav> <!-- Fim Menu -->

        <!-- Modal Pets -->
        <div class="modal fade" id="lista-pets" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Meus Pets</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                            foreach($resultado as $name){ 
                                //$teste = $name['idPet'];
                                ?>
                                <form action="listagem-pet.php" method="post">
                                    <input type="hidden" id="petAtual" name="petAtual" value="<?=$name['idPet']?>"></input>
                                    <button type="submit" class="btn btn-success">
                                        <?php echo $name['nomePet'];?>
                                    </button>
                                    <a href=></a>
                                </form>
                                <br><br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> <!-- Fim Modal -->
        
        <!-- Modal Minigames -->
        <div class="modal fade" id="lista-minigames" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Minigames</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                            foreach($resGame as $minigame){ 
                                $idP = $minigame['idPet']; //é = ao $teste
                                $idM = $minigame['nomeMinigame'];
                                ?>
                                <form action="listagem-pet.php" method="post">
                                    <input type="hidden" id="petM" name="petM" value="<?=$minigame['idPet']?>"></input>
                                    <input type="hidden" id="minigameAtual" name="minigameAtual" value="<?=$minigame['nomeMinigame']?>"</input>
                                    <button type="submit" class="btn btn-success">
                                        <?php echo $minigame['nomeMinigame'];?>
                                    </button>
                                    <a href=></a>
                                </form>
                                <br><br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> <!-- Fim Modal Minigames -->

        <br>

        <div class="container" style="margin-left: 5%;"> <!-- Área com dados do Pet -->
            <div align="center" style="width: 50%; margin-left: 25%;">
                <table class="table" align="center" style="width: 80%; margin-top: 2%;">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Happy</th>
                            <th scope="col">Hunger</th>
                            <th scope="col">Health</th>
                            <th scope="col">Sleep</th>
                            <th scope="col">State</th>
                            <th scope="col">Age</th>
                        </tr>
                </thead>
                <tbody>
                    <tr>
                            <td>
                                <div class="progress">
                                    <?php if($petAtual['happyPet'] < 50){?>
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petAtual['happyPet']; ?>%" aria-valuenow="<?=$petAtual['happyPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['happyPet']; ?>%</div>
                                        <?php } else { ?>
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petAtual['happyPet']; ?>%" aria-valuenow="<?=$petAtual['happyPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['happyPet']; ?>%</div>
                                            <?php } ?>
                                        </div>
                            </td>
                            <td>
                                <div class="progress">
                                    <?php if($petAtual['hungerPet'] < 50){?>
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petAtual['hungerPet']; ?>%" aria-valuenow="<?=$petAtual['hungerPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['hungerPet']; ?>%</div>
                                        <?php } else { ?>
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petAtual['hungerPet']; ?>%" aria-valuenow="<?=$petAtual['hungerPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['hungerPet']; ?>%</div>
                                        <?php } ?>
                                    </div>
                            </td>
                            <td>
                                <div class="progress">
                                    <?php if($petAtual['healthPet'] < 50){?>
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petAtual['healthPet']; ?>%" aria-valuenow="<?=$petAtual['healthPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['healthPet']; ?>%</div>
                                            <?php } else { ?>
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petAtual['healthPet']; ?>%" aria-valuenow="<?=$petAtual['healthPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['healthPet']; ?>%</div>
                                            <?php } ?>
                                </div>
                            </td>
                            <td>
                                <div class="progress">
                                        <?php if($petAtual['sleepPet'] < 50){?>
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petAtual['sleepPet']; ?>%" aria-valuenow="<?=$petAtual['sleepPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['sleepPet']; ?>%</div>
                                            <?php } else { ?>
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petAtual['sleepPet']; ?>%" aria-valuenow="<?=$petAtual['sleepPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petAtual['sleepPet']; ?>%</div>
                                            <?php } ?>
                                        </div>
                            </td>
                            <td> <?php echo $petAtual['statePet']; ?></td>
                            <td> <?php echo $petAtual['idade']; ?></td>
                            <?php// } ?>
                        </tr>
                    </tbody>
                </table>
                <?php //foreach($resultado as $item){ ?>
                    <div class="container" align="center" style="margin-top: 21%;">
                        <img src="images/<?=$petAtual['imagem']?>" />
                    </div>
                    <?php// } ?>
                    
                    <table class="table" align="center" style="width: 80%; margin-top: 8%;">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">
                                    <!-- <script>
                                        $(function () {
                                            $('#alimentar').popover({
                                                html: true,
                                                content: '<a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/flat_round/30/000000/rabbit.png"></img></a><a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/flat_round/30/000000/mouse-animal.png"></img></a> <a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/flat_round/30/000000/bird.png"></img></a> <a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/color/30/000000/strawberry.png"></img></a> <a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/flat_round/30/000000/insect.png"></img></a>'
                                            })
                                        })

                                        $(function(){
                                            $('#minigame').popover({
                                                html: true,
                                                content: '<a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/dusk/30/000000/music.png"></img></a> <a class="btn rounded-circle" href="criarPet.php" role="button"><img src="https://png.icons8.com/dusk/30/000000/puzzle.png"></img></a>'
                                            })
                                        })
                                    </script> -->

                                    <a id="alimentar" class="btn btn-outline-danger rounded-circle" role="button" href="#lista-minigames" data-toggle="modal">
                                        <i class="fas fa-utensils"></i>
                                    </a>
                                </th>
                                <th scope="col">
                                    <button id="banho" class="btn btn-outline-primary rounded-circle" role="button">
                                        <i class="fas fa-shower"></i>
                                    </button>
                            </th>
                            <th scope="col">
                                <a id="minigame" class="btn btn-outline-success rounded-circle"  role="button" href="#lista-minigames" data-toggle="modal">
                                    <i class="fas fa-gamepad"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <button class="btn btn-outline-info rounded-circle" href="criarPet.php">
                                    <i class="fas fa-bed"></i>
                                    </button>
                            </th>
                            <th scope="col">
                                <button class="btn btn-outline-danger rounded-circle" href="criarPet.php">
                                    <i class="fas fa-syringe"></i>
                                    </button>
                            </th>
                            <th scope="col">
                                <form action="listagem-pet.php" method="post">
                                    <button name="deletar" class="btn btn-outline-secondary rounded-circle" type="submit">
                                        <i class="fas fa-skull"></i>
                                    </button>
                                </form>
                                
                            </th>
                        </tr>
                    </thead>
                </table>    
            </div>
        </div> <!-- Fim área com dados do Pet -->
    </body>

</html>