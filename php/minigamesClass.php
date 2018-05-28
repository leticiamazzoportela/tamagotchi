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


        // protected function retPetMinigame($petAtual){
        //     $sql = "SELECT * FROM minigames WHERE idPet = '$petAtual'";
        //     $mysql = $this->mysql->prepare($sql);
        //     $mysql->bindValue(':idPet', $petAtual,PDO::PARAM_STR);
        //     $mysql->execute();
        //     return $mysql->fetch(PDO::FETCH_ASSOC);
        // }

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
                $itens = array(
                    'pedra'   => '<a href="?item=pedra"><img src="https://vignette.wikia.nocookie.net/sonicboombrasilbr/images/c/c7/Pedra_da_justi%C3%A7a.png/revision/latest?cb=20150905020413&path-prefix=pt-br" width="135" height="135" alt="pedra"></img></a>',
                    'papel'   => '<a href="?item=papel" style="margin-left: 2%;"><img src="https://78.media.tumblr.com/cfc5ea8cc7b3708950a37c93b25b6d34/tumblr_p4fbotLnzJ1uke6wjo1_1280.png" width="135" height="135" alt="papel"></img> </a>',
                    'tesoura' => '<a href="?item=tesoura" style="margin-left: 2%;"><img src="http://worldartsme.com/images/scissor-cartoon-clipart-1.jpg" width="135" height="140" alt="tesoura"></img> </a>'
                );

                if($item == null)
                    foreach($itens as $item => $valor){
                        echo $valor;
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
            // MANDAR ESSA PARTE PARA PPT, MUDAR O MÉTODO PRA POST $query = "SELECT LAST_INSERT_ID()";
            // $mysql=$this->mysql->prepare($query);
            // $mysql->execute();
            // $idPet = $mysql->fetchColumn();

            $sql = "SELECT pontuacao FROM minigames WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $antigo = $mysql->fetchColumn();

            $novaPont = $antigo+1;

            $ppt="UPDATE minigames SET pontuacao = '$novaPont' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($ppt);
            $mysql->execute();
        }
        
        public function jogar(){
            //por enquanto, apenas ppt
            if(isset($_GET['item'])){
                $itens = array('pedra', 'papel', 'tesoura');

                $user_item = $_GET['item'];
                $comp_item = $itens[rand(0, 2)];

                if(!in_array($user_item, $itens)){
                    echo "O jogo é Pedra - Papel - Tesoura. Você não pode escolher outra coisa!!!";
                    die;
                }

                //Pedra > Tesoura
                //Tesoura > Papel
                //Papel > Pedra
                if(($user_item == 'pedra' && $comp_item == 'tesoura') || ($user_item == 'tesoura' && $comp_item == 'papel') || ($user_item == 'papel' && $comp_item == 'pedra')){
                    $this->calcPontuacao(69);
                    echo "<h2> Você venceu! </h2>";
                }
                else if ($user_item == $comp_item){
                    echo "<h2> Eita, deu empate! </h2>";
                }
                else{
                    echo "<h2> Você perdeu! </h2>";
                }

               // $this->mostrarJogo('pedra-papel-tesoura', $user_item);
                //$this->mostrarJogo('pedra-papel-tesoura', $comp_item);

                echo '<br><br> <a class="btn btn-outline-success menu-nav" href=""./pedra-papel-tesoura.php"" role="button">Jogar de Novo!</a>';
            }
            else{
                echo $this->mostrarJogo('pedra-papel-tesoura');
            }
        }
    }

?>