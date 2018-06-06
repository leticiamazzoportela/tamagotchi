<?php

    class Minigame{
        protected $mysql;
        protected $db = array(
            'servidor'=>'localhost',
            'database'=>'tamagotchi-db',
            'usuario'=>'root',
            'senha'=>'',
        );
        
        public function __construct(){
            $this->conectaBd();
        }

        protected function conectaBd(){
            $this->mysql = new PDO(
                'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
            );
            $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function criaMinigame($petAtual){
            $ppt = "INSERT INTO minigames (nomeMinigame, pontuacao, idPet) VALUES ('Pedra - Papel - Tesoura', 0, $petAtual)";
            $mysql = $this->mysql->prepare($ppt);
            $mysql->execute();
            
            $velha = "INSERT INTO minigames (nomeMinigame, pontuacao, idPet) VALUES ('Jogo da Velha', 0, $petAtual)";
            $mysql = $this->mysql->prepare($velha);
            $mysql->execute();
        }

        public function listarMinigames($petAtual){
            $sql = "SELECT * FROM minigames WHERE idPet = '$petAtual'";
            $mysql=$this->mysql->prepare($sql);
            $mysql->execute();
            return $mysql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function retGame($idPet, $nome){
            $sql = "SELECT * FROM minigames WHERE idPet = '$idPet' AND nomeMinigame = '$idMinigame'";
            $mysql = $this->mysql->prepare($sql);
            $mysql->bindValue(':idPet', $idPet, PDO::PARAM_INT);
            $mysql->bindValue(':nomeMinigame', $nome, PDO::PARAM_STR);
            $mysql->execute();
            return $mysql->fetch(PDO::FETCH_ASSOC);
        }
   
        public function mostrarJogo($nomeJogo, $item = null){
            if($nomeJogo == 'pedra-papel-tesoura'){
                $itens = array('pedra', 'papel', 'tesoura');

                 if($item == null)
                     foreach($itens as $item){
                         echo $item;
                    }
                else{
                    echo str_replace("?item{$item}", "#", $itens[$item]);              
                }   
            }
            else if($nomeJogo == 'forca'){
                echo "Não existe ainda";
            }
            else if($nomeJogo == 'jogo-da-velha'){
                echo "Não existe ainda";
            }
        }

        public function animar($idPet){
            $pontos = "SELECT SUM(pontuacao) FROM minigames WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($pontos);
            $mysql->execute();
            $happy= $mysql->fetchColumn();
            echo $happy;

            $hp = "SELECT happyPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($hp);
            $mysql->execute();
            $antigo= $mysql->fetchColumn();

            $hunger = "SELECT hungerPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($hunger);
            $mysql->execute();
            $antigoHunger = $mysql->fetchColumn();

            $kg = "SELECT peso FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($kg);
            $mysql->execute();
            $peso = $mysql->fetchColumn();

            $antigo = $antigo + $happy*2;
            if($antigo > 100){
                $antigo = 100;
            }

            $antigoHunger = $antigoHunger - $happy*2;
            if($antigoHunger < 0)
                $antigoHunger = 0;

            $peso -= 2;
            if($peso < 0)
                $peso = 0;

            $query = "UPDATE pet SET happyPet = $antigo, hungerPet = $antigoHunger, peso = $peso WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();
            
            return $happy;
            // if($antigo > 50){
            //     $query = "UPDATE pet SET statePet = 'feliz' WHERE idPet = $idPet";
            //     $mysql=$this->mysql->prepare($query);
            //     $mysql->execute();
            // }
        }

        protected function calcPontuacao($minigame, $idPet){
            $sql = "SELECT pontuacao FROM minigames WHERE idPet = $idPet AND nomeMinigame = '$minigame'";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $antigo = $mysql->fetchColumn();

            $novaPont = $antigo+1;

            $ppt="UPDATE minigames SET pontuacao = $novaPont WHERE idPet = $idPet AND nomeMinigame = '$minigame'";
            $mysql=$this->mysql->prepare($ppt);
            $mysql->execute();

            $oi = $this->animar($idPet);
            echo $oi;

        }
        
        public function jogar($item, $idPet){
            if(!empty($item)){
                $itens = array('pedra', 'papel', 'tesoura', 'lagarto', 'spock');

                $user_item = $item;
                $comp_item = $itens[rand(0, 4)];

                // Tesoura corta papel
                // Papel cobre pedra
                // Pedra esmaga lagarto
                // Lagarto envenena Spock
                // Spock esmaga (ou derrete) tesoura
                // Tesoura decapita lagarto
                // Lagarto come papel
                // Papel refuta Spock
                // Spock vaporiza pedra
                // Pedra quebra tesoura

                if(($user_item == 'pedra' && $comp_item == 'tesoura') ||
                   ($user_item == 'tesoura' && $comp_item == 'papel') ||
                   ($user_item == 'papel' && $comp_item == 'pedra') ||
                   ($user_item == 'pedra' && $comp_item == 'lagarto') ||
                   ($user_item == 'lagarto' && $comp_item == 'spock') ||
                   ($user_item == 'spock' && $comp_item == 'tesoura') ||
                   ($user_item == 'tesoura' && $comp_item == 'lagarto') ||
                   ($user_item == 'lagarto' && $comp_item == 'papel') ||
                   ($user_item == 'papel' && $comp_item == 'spock') ||
                   ($user_item == 'spock' && $comp_item == 'pedra')){
                    $this->calcPontuacao('Pedra - Papel - Tesoura', $idPet);
                   echo "<script type='text/javascript'>alert('Você: $user_item \\nComputador: $comp_item \\nVocê venceu!');javascript:window.location='pedra-papel-tesoura.php?idP=$idPet';</script>";
                }
                else if ($user_item == $comp_item){
                    echo "<script type='text/javascript'>alert('Você: $user_item \\nComputador: $comp_item \\nEmpate!');javascript:window.location='pedra-papel-tesoura.php?idP=$idPet';</script>";
                }
                else{
                    echo "<script type='text/javascript'>alert('Você: $user_item \\nComputador: $comp_item \\nVocê perdeu!');javascript:window.location='pedra-papel-tesoura.php?idP=$idPet';</script>";
                }

               echo $user_item;
               echo $comp_item;

                //echo '<br><br> <a class="btn btn-outline-success menu-nav" href=""./pedra-papel-tesoura.php"" role="button">Jogar de Novo!</a>';
            }
            //else{
              //  echo $this->mostrarJogo('pedra-papel-tesoura');
            //}
        }

        public function jogarVelha($box, $idPet){
            $campeao = 'n';

            $jogada = 0;
            for($j = 0; $j <= 8; $j++){
                if($_POST["box".$j] != 'x' && $_POST["box".$j] != '' && $_POST["box".$j] != 'o' || strlen($_POST["box".$j]) > 1)
                    echo "<script type='text/javascript'>alert('Operação inválida!');</script>";
                else{
                    $box[$j] = $_POST["box".$j];
                        if($box[$j] != '')
                            $jogada++;
                }
            }

            //Daqui em diante as posições são preenchidas conforme o usuario joga, o computador é a bolinha.
            if($jogada == 1 || $jogada == 3 || $jogada == 5 || $jogada == 7 || $jogada == 9){
                $blank = 0;
                for($i = 0; $i <= 8; $i++){
                    if($box[$i] == ''){
                        $blank = 1;
                    }
                }
                if($blank == 1){
                    $i = rand() % 8;
                    while($box[$i] != ''){
                        $i = rand() % 8;
                    }
                    $box[$i] = 'o';
                }
            }
            else
                echo "<script type='text/javascript'>alert('É a sua vez de jogar!');</script>";

            if($box[0] == 'x' && $box[1] == 'x' && $box[2] == 'x' ||
                $box[3] == 'x' && $box[4] == 'x' && $box[5] == 'x' ||
                $box[6] == 'x' && $box[7] == 'x' && $box[8] == 'x' ||
                $box[0] == 'x' && $box[4] == 'x' && $box[8] == 'x' ||
                $box[2] == 'x' && $box[4] == 'x' && $box[6] == 'x' ||
                $box[0] == 'x' && $box[3] == 'x' && $box[6] == 'x' ||
                $box[1] == 'x' && $box[4] == 'x' && $box[7] == 'x' ||
                $box[2] == 'x' && $box[5] == 'x' && $box[8] == 'x'){
                    echo "<script type='text/javascript'>alert('Você venceu!');javascript:window.location='jogo-da-velha.php?idP=$idPet';</script>";
                    $campeao = 'x';
                    $this->calcPontuacao('Jogo da Velha', $idPet);
            }
            else if($box[0] == 'o' && $box[1] == 'o' && $box[2] == 'o' ||
                    $box[3] == 'o' && $box[4] == 'o' && $box[5] == 'o' ||
                    $box[6] == 'o' && $box[7] == 'o' && $box[8] == 'o' ||
                    $box[0] == 'o' && $box[4] == 'o' && $box[8] == 'o' ||
                    $box[2] == 'o' && $box[4] == 'o' && $box[6] == 'o' ||
                    $box[0] == 'o' && $box[3] == 'o' && $box[6] == 'o' ||
                    $box[1] == 'o' && $box[4] == 'o' && $box[7] == 'o' ||
                    $box[2] == 'o' && $box[5] == 'o' && $box[8] == 'o'){
                        echo "<script type='text/javascript'>alert('O computador venceu!');javascript:window.location='jogo-da-velha.php?idP=$idPet';</script>";
                        $campeao = 'o';
            }
            else if($campeao == 'n' && $jogada >= 8)
                echo "<script type='text/javascript'>alert('Empate!');javascript:window.location='jogo-da-velha.php?idP=$idPet';</script>";

            return $box;
        }

        public function ranking(){
            ///$id = $_SESSION["id_usuario"];
            $sql = "SELECT DISTINCT pet.idUsuario, pet.nomePet, minigames.nomeMinigame, minigames.pontuacao FROM pet, minigames ORDER BY minigames.pontuacao DESC";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            return $mysql->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>