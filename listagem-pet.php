<?php
    require 'php/userClass.php';
    require 'php/petClass.php';

    $usuarios = new User();
    $usuarios->protege();

    $pets = new Pet();
    $resultado = $pets->listarPets();
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
        
        <body>
        <nav class="navbar navbar-dark bg-dark"> <!-- Menu --> 
            <div class="container">
                <div class="navbar-header">
                <a class="btn btn-outline-success menu-nav" href="criarPet.php" role="button">Criar</a>
                <a class="btn btn-outline-primary" href="#lista-pets" data-toggle="modal" role="button">Trocar Pet</a>
                <a class="btn btn-outline-danger" href="logout.php" role="button">Sair</a>
            </div>
        </div>
        </nav> <!-- Fim Menu -->

        <!-- Modal -->
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
                        A type of open-toed sandal.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> <!-- Fim Modal -->

        <br>

        <div class="container"> <!-- Área com dados do Pet -->
            <div align="center" style="width: 50%; margin-left: 25%;">
                <table class="table" align="center" style="width: 80%;">
                    <thead class="bg-success">
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
                        <?php foreach($resultado as $item){ ?>
                            <td>
                                <div class="progress">
                                    <?php if($item['happyPet'] < 50){?>
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$item['happyPet']; ?>%" aria-valuenow="<?=$item['happyPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['happyPet']; ?>%</div>
                                        <?php } else { ?>
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$item['happyPet']; ?>%" aria-valuenow="<?=$item['happyPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['happyPet']; ?>%</div>
                                            <?php } ?>
                                        </div>
                            </td>
                            <td>
                                <div class="progress">
                                    <?php if($item['hungerPet'] < 50){?>
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$item['hungerPet']; ?>%" aria-valuenow="<?=$item['hungerPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['hungerPet']; ?>%</div>
                                        <?php } else { ?>
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$item['hungerPet']; ?>%" aria-valuenow="<?=$item['hungerPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['hungerPet']; ?>%</div>
                                        <?php } ?>
                                    </div>
                            </td>
                            <td>
                                <div class="progress">
                                    <?php if($item['healthPet'] < 50){?>
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$item['healthPet']; ?>%" aria-valuenow="<?=$item['healthPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['healthPet']; ?>%</div>
                                            <?php } else { ?>
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$item['healthPet']; ?>%" aria-valuenow="<?=$item['healthPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['healthPet']; ?>%</div>
                                            <?php } ?>
                                </div>
                            </td>
                            <td>
                                <div class="progress">
                                        <?php if($item['sleepPet'] < 50){?>
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$item['sleepPet']; ?>%" aria-valuenow="<?=$item['sleepPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['sleepPet']; ?>%</div>
                                            <?php } else { ?>
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$item['sleepPet']; ?>%" aria-valuenow="<?=$item['sleepPet']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$item['sleepPet']; ?>%</div>
                                            <?php } ?>
                                        </div>
                            </td>
                            <td> <?php echo $item['statePet']; ?></td>
                            <td> <?php echo $item['idade']; ?></td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
                <?php foreach($resultado as $item){ ?>
                    <div class="container" align="center">
                        <img src="images/<?=$item['imagem']?>" />
                        <h1> <?php echo $item['nomePet']; ?></h1>
                    </div>
                    <?php } ?>
                    
                    <table class="table" align="center" style="width: 80%; margin-top: 8%;">
                        <thead class="bg-success">
                            <tr>
                                <th scope="col">
                                    <script>
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
                                    </script>

                                    <a id="alimentar" class="btn btn-outline-dark rounded-circle" role="button" data-toggle="popover" data-trigger="focus" tabindex="0" data-placement="bottom" title="Alimentar">
                                        <i class="fas fa-utensils"></i>
                                    </a>
                                </th>
                                <th scope="col">
                                    <button id="banho" class="btn btn-outline-dark rounded-circle" role="button">
                                        <i class="fas fa-shower"></i>
                                    </button>
                            </th>
                            <th scope="col">
                                <a id="minigame" class="btn btn-outline-dark rounded-circle" role="button" data-toggle="popover" data-trigger="focus" tabindex="0" data-placement="bottom" title="Minigames">
                                    <i class="fas fa-gamepad"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <button class="btn btn-outline-dark rounded-circle" href="criarPet.php">
                                    <i class="fas fa-bed"></i>
                                    </button>
                            </th>
                            <th scope="col">
                                <button class="btn btn-outline-dark rounded-circle" href="criarPet.php">
                                    <i class="fas fa-syringe"></i>
                                    </button>
                            </th>
                            <th scope="col">
                                <?php $pets->deletaPet()?>
                                <form action="listagem-pet.php" method="post">
                                    <button class="btn btn-outline-dark rounded-circle" type="submit">
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