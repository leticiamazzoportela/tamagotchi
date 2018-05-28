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
            $ppt="INSERT INTO minigames (nomeMinigame, pontuacao, idPet) VALUES ('Pedra - Papel - Tesoura', 0, '$petAtual')";
            // $forca="INSERT INTO minigames (nomeMinigame, pontuacao, idPet) VALUES ('Forca', 0, '$idPet')";
            $mysql=$this->mysql->prepare($ppt);
            // $mysql=$this->mysql->prepare($forca);
            try{
                $mysql->execute();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
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

        protected function calcPontuacao($idPet){
            $sql = "SELECT pontuacao FROM minigames WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $antigo = $mysql->fetchColumn();

            $novaPont = $antigo+1;

            $ppt="UPDATE minigames SET pontuacao = '$novaPont' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($ppt);
            $mysql->execute();
        }
        
        public function jogar($item, $idPet){
            if(!empty($item)){
                $itens = array('pedra', 'papel', 'tesoura');

                $user_item = $item;
                $comp_item = $itens[rand(0, 2)];

                //Pedra > Tesoura
                //Tesoura > Papel
                //Papel > Pedra
                if(($user_item == 'pedra' && $comp_item == 'tesoura') || ($user_item == 'tesoura' && $comp_item == 'papel') || ($user_item == 'papel' && $comp_item == 'pedra')){
                    $this->calcPontuacao($idPet);
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
    }

?>