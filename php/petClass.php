<?php

    class Pet{
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

        public function listarPets(){
            $id = $_SESSION["id_usuario"];
            $sql = "SELECT * FROM pet WHERE idUsuario = $id";
            $mysql=$this->mysql->prepare($sql);
            $mysql->execute();
            return $mysql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function retPet($petAtual){
            //if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql="SELECT * FROM `pet` WHERE `pet`.`idPet` = '$petAtual'";
                $mysql=$this->mysql->prepare($sql);
                $mysql->bindValue(':idPet', $petAtual,PDO::PARAM_INT);
                $mysql->execute();
                return $mysql->fetch(PDO::FETCH_ASSOC);
            //}
        }

        protected function conectaBd(){
            $this->mysql = new PDO(
                'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
            );
            $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function criarPet(){
            session_start();
            $id = $_SESSION["id_usuario"];
            $src = 'bb';

            error_log($id);             
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql="INSERT INTO pet (nomePet, happyPet, hungerPet, healthPet, sleepPet, statePet, imagem, idade, idUsuario) VALUES (:nomePet, 50, 50, 50, 50, 'normal', '$src', 0, '$id')";
                $mysql=$this->mysql->prepare($sql);
                $mysql->bindValue(':nomePet', $_POST['nomePet'],PDO::PARAM_STR);
                try{
                    $mysql->execute();
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        }

        public function retIDPet(){
            //$id = $_SESSION["id_usuario"];
            $query = "SELECT LAST_INSERT_ID()";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();
            $atual = $mysql->fetchColumn();
            
            if(!empty($atual))
                return $atual; 
                
        }

        public function deletaPet(){
            $id = $_SESSION["id_usuario"];
            //if ($_SERVER['REQUEST_METHOD']=='POST') {
                $query = "SELECT `idPet` FROM `pet` WHERE `idUsuario` = '".$id."'";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();
                $idPet = $mysql->fetch(PDO::FETCH_ASSOC);

                if(!empty($idPet)){
                    foreach($idPet as $atual){
                        $sql="DELETE FROM `pet` WHERE `idPet` = '".$atual."'";   
                        $mysql=$this->mysql->prepare($sql);
                        
                        try{
                            $mysql->execute();

                            echo "<script type='text/javascript'>alert('Pet assassinado com sucesso!');javascript:window.location='listagem-pet.php';</script>";
                        }catch(PDOException $e){
                            echo $e->getMessage();
                        }

                            $minigame = "DELETE FROM minigames WHERE idPet = $atual";
                            $mysql=$this->mysql->prepare($minigame);
                            $mysql->execute();
                    }    
                }
                else{
                    echo "<script type='text/javascript'>alert('Não há Pets para excluir!');javascript:window.location='listagem-pet.php';</script>";
                }
            //}
        }

        public function alimentar($tipoComida, $idPet){
            $sql = "SELECT hungerPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $fomeAntiga = $mysql->fetchColumn();

            $happy = "SELECT happyPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($happy);
            $mysql->execute();
            $felicidade = $mysql->fetchColumn();

            if($tipoComida == 'Coelho'){
                if($fomeAntiga <= 90)
                    $fome = $fomeAntiga+10;
                else
                    $fome = (100 - $fomeAntiga) + $fomeAntiga;
            }
            else if($tipoComida == 'Rato'){
                if($fomeAntiga <= 92)
                    $fome = $fomeAntiga+8;
                else
                    $fome = (100 - $fomeAntiga) + $fomeAntiga;
            }
            else if($tipoComida == 'Pássaro'){
                if($fomeAntiga <= 95)
                    $fome = $fomeAntiga+5;
                else
                    $fome = (100 - $fomeAntiga) + $fomeAntiga;
            }
            else if($tipoComida == 'Fruta'){
                if($fomeAntiga <= 97)
                    $fome = $fomeAntiga+3;
                else
                    $fome = (100 - $fomeAntiga) + $fomeAntiga;
            }
            else if($tipoComida == 'Inseto'){
                //Essa alimenta ele, mas deixa ele doentinho
                $doente = "SELECT healthPet FROM pet WHERE idPet = $idPet";
                $mysql = $this->mysql->prepare($doente);
                $mysql->execute();
                $doenteAntiga = $mysql->fetchColumn();

                if($fomeAntiga <= 99)
                    $fome = $fomeAntiga+1;
                else
                    $fome = (100 - $fomeAntiga) + $fomeAntiga;

                if($doenteAntiga >= 10)
                    $doenteAtual = $doenteAntiga-10;
                else
                    $doenteAtual = 0;

                $queryDoente="UPDATE pet SET healthPet = $doenteAtual WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($queryDoente);
                $mysql->execute();

                if($doenteAtual <= 30){
                    $qDoente="UPDATE pet SET statePet = 'doente' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($qDoente);
                    $mysql->execute();
                
                }
            }
            
            $query="UPDATE pet SET hungerPet = $fome WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();

            // if($fome >= 50 && $fome < 90){
            //     $qfome="UPDATE pet SET statePet = 'normal' WHERE idPet = $idPet";
            //     $mysql=$this->mysql->prepare($qfome);
            //     $mysql->execute();
            // }
            // else if($fome >= 90 && $felicidade >= 50){
            //     $qfome="UPDATE pet SET statePet = 'feliz' WHERE idPet = $idPet";
            //     $mysql=$this->mysql->prepare($qfome);
            //     $mysql->execute();
            // }

            header('Location: ./listagem-pet.php');
            $this->controleEstadosGerais($idPet);
        }

        public function banhar($idPet){
            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $estado = $mysql->fetchColumn();

            $sql = "SELECT healthPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $hp = $mysql->fetchColumn();


            $cons = "SELECT hungerPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($cons);
            $mysql->execute();
            $c = $mysql->fetchColumn();

            $novoHp = $hp + 5;
            $novoC = $c - 2;


            if($estado == 'sujo'){
                $query="UPDATE pet SET statePet = 'normal', healthPet = $novoHp, hungerPet = $novoC WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();
                header('Location: ./listagem-pet.php');
                $this->controleEstadosGerais($idPet);
            }
            else{
                echo "<script type='text/javascript'>alert('Eeei! Já estou limpo!');javascript:window.location='listagem-pet.php';</script>"; 
            }

            
        }

        public function controleEstadosGerais($idPet){
            $tempo = time();
            $Dtime = $tempo - $_SESSION["tempo"];

            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $state= $mysql->fetchColumn();

            $fome = $this->hungry($Dtime, $state, $idPet);
            $felicidade = $this->happy($Dtime, $state, $idPet);
            $sono = $this->sleep($Dtime, $state, $idPet);
            $saude = $this->health($Dtime, $state, $idPet);
            $idade = $this->age($Dtime, $idPet);

            if($fome < 0)
                $fome = 0;

            if($felicidade < 0)
                $felicidade = 0;
            else if($felicidade > 100)
                $felicidade = 100;
            
            if($sono > 100)
                $sono = 100;
            else if($sono < 0)
                $sono = 0;

            if($saude < 0)
                $saude = 0;
            else if($saude > 100)
                $saude = 100;

            $estado = 'normal';
            $src = 'tails-normal.gif';

            if ($fome < 50){
                $estado = 'fome';
                $src = 'tails-bravo.gif';
            }
            if($fome >= 100){
                $estado = 'sujo';
                $src = 'tails-sujo.gif';
                $fome = 100;
            }
            if($felicidade <= 30){
                $estado = 'triste';
                $src = 'tails-triste.gif';                
            }
            else if(($felicidade > 50) && ($fome >= 70) && ($sono >= 70) && ($saude >= 70)){
                $estado = 'feliz';
                $src = 'tails-feliz.gif';
            }
            if ($sono < 50){
                $estado = 'cansado'; 
                $src = 'tails-triste.gif';               
            }
            if ($saude <= 30 && $saude > 0){
                $estado = 'doente';
                $src = 'tails-doente.gif';
            }
            if($saude <= 0){
                $saude = 0;
                $estado = 'morto';
            }
            if($state == 'sujo'){
                $estado = 'sujo';
                $src = 'tails-sujo.gif';
            }
            if($state == 'dormindo'){
                $estado = 'dormindo';
                $src = 'tails-sleep.gif';
            }

            $queryState="UPDATE pet SET healthPet = $saude, happyPet = $felicidade, hungerPet = $fome, sleepPet = $sono, statePet = '$estado', idade = $idade WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($queryState);
            $mysql->execute();
            if($idade >= 4){
                $aparencia = "UPDATE pet SET imagem = '$src' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($aparencia);
                $mysql->execute();
            }
            else{
                if($estado == 'dormindo'){
                    $aparencia = "UPDATE pet SET imagem = 'bb-sleep.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
                else{
                    $aparencia = "UPDATE pet SET imagem = 'bb.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
            }

            $_SESSION["tempo"] = time();

            //header("Location: listagem-pet.php");
        }

        public function reiniciarPet($idPet){
            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $state= $mysql->fetchColumn();

            if($state == 'morto'){
                $queryNovo="UPDATE pet, minigames SET pet.healthPet = 50, pet.happyPet = 50, pet.hungerPet = 50, pet.sleepPet = 50, statePet = 'normal', pet.idade = 0, pet.imagem = 'bb.gif', minigames.pontuacao = 0 WHERE pet.idPet = $idPet AND minigames.idPet = $idPet AND minigames.nomeMinigame = 'Pedra - Papel - Tesoura' OR minigames.nomeMinigame = 'Jogo da Velha'";
                $mysql=$this->mysql->prepare($queryNovo);
                $mysql->execute();
                echo "<script type='text/javascript'>alert('Infelizmente seu Pet Morreu! Ele vai ser reiniciado e terá todo o progresso nos minigames zerado!');javascript:window.location='listagem-pet.php';</script>";
            }
        }

        public function age($Dtime, $idPet){
            $age = "SELECT idade FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($age);
            $mysql->execute();
            $idade = $mysql->fetchColumn();

            $state = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($state);
            $mysql->execute();
            $status = $mysql->fetchColumn();

            $id = $Dtime/600;
            $idade = $idade + $id;

            if($idade >= 8)
                $idade = 8;

            // if($idade >= 4){
            //     if($status == 'fome'){
            //         $src = 'tails-bravo.gif';
            //     }
            //     else if($status == 'cansado' || $status == 'triste'){
            //         $src = 'tails-triste.gif';
            //     }
            //     else if($status == 'sujo'){
            //         $src = 'tails-sujo.gif';
            //     }
            //     else if($status == 'feliz'){
            //         $src = 'tails-feliz.gif';
            //     }
            //     else if($status == 'normal'){
            //         $src = 'tails-normal.gif';
            //     }
            //     else if($status == 'doente'){
            //         $src = 'tails-doente.gif';
            //     }

            //     $aparencia = "UPDATE pet SET imagem = '$src' WHERE idPet = $idPet";
            //     $mysql=$this->mysql->prepare($aparencia);
            //     $mysql->execute();
            // }

            return $idade;
        }

        public function hungry($Dtime, $state, $idPet){
            $sql = "SELECT hungerPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $hunger= $mysql->fetchColumn();

            if ($state == 'normal' || $state == 'triste' || $state == 'doente'){
                $fome = $Dtime/120;
            }
            if ($state == 'feliz'){
                $fome = $Dtime/180;
            }
            if ($state == 'cansado' || $state == 'sujo' || $state == 'dormindo'){
                $fome = $Dtime/100;
            }
            if ($state == 'fome'){
                $fome = $Dtime/60;
            }
            if($state == 'morto')
                $fome = 0;
    
            $hunger = $hunger - $fome;
            return $hunger;
        }

        public function happy($Dtime, $state, $idPet){
            $sql = "SELECT happyPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $happy= $mysql->fetchColumn();

            if ($state == 'normal' || $state == 'sujo'){
                $felicidade = $Dtime/180;
            }
            if ($state == 'feliz'){
                $felicidade = $Dtime/250;
            }
            if ($state == 'cansado' || $state == 'dormindo'){
                $felicidade = $Dtime/100;
            }
            if ($state == 'triste'){
                $felicidade = $Dtime/60;
            }
            if ($state == 'fome'){
                $felicidade = $Dtime/80;
            }
            if ($state == 'doente'){
                $felicidade = $Dtime/80;
            }
            if($state == 'morto')
                $felicidade = 0;
            
            if($state == 'dormindo')
                $happy = $happy + $felicidade;
            else
                $happy = $happy - $felicidade;

            return $happy;
        }

        public function sleep($Dtime, $state, $idPet){
            $sql = "SELECT sleepPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $sleep= $mysql->fetchColumn();

            if ($state == 'normal' || $state == 'sujo'){
                $sono = $Dtime/250;
            }
            if ($state == 'feliz'){
                $sono = $Dtime/300;
            }
            if ($state == 'cansado' || $state == 'dormindo'){
                $sono = $Dtime/60;
            }
            if ($state == 'triste'){
                $sono = $Dtime/100;
            }
            if ($state == 'fome'){
                $sono = $Dtime/80;
            }
            if ($state == 'doente'){
                $sono = $Dtime/70;
            }
            if($state == 'morto')
                $sono = 0;
            
            if($state == 'dormindo')
                $sleep = $sleep + $sono;
            else
                $sleep = $sleep - $sono;

            return $sleep;
        }

        public function health($Dtime, $state, $idPet){
            $sql = "SELECT healthPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $health= $mysql->fetchColumn();

            if ($state == 'normal' || $state == 'sujo'){
                $saude = $Dtime/250;
            }
            if ($state == 'feliz'){
                $saude = $Dtime/300;
            }
            if ($state == 'cansado'){
                $saude = $Dtime/230;
            }
            if ($state == 'triste'){
                $saude = $Dtime/180;
            }
            if ($state == 'fome'){
                $saude = $Dtime/100;
            }
            if ($state == 'doente'  || $state == 'dormindo'){
                $saude = $Dtime/60;
            }
            if($state == 'morto')
                $saude = 0;
            
            if($state == 'dormindo')
                $health = $health + $saude;
            else
                $health = $health - $saude;
                
            return $health;
        }

        public function curar($idPet){
            $doente = "SELECT healthPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($doente);
            $mysql->execute();
            $statusDoente = $mysql->fetchColumn();

            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $estado = $mysql->fetchColumn();

            if($statusDoente <= 30){
                $novoHealth = $statusDoente + 10;
                if($novoHealth > 30){
                    $novoStatus = 'normal';
                }
                // else
                //     $novoStatus = 'doente';
        
            }
            else if($estado != 'doente'){
                $novoHealth = 30;
                $novoStatus = 'doente';
            }
            else{
                $novoHealth = $statusDoente;
                $novoStatus = $estado;
            }
            
            $queryHealth="UPDATE pet SET healthPet = $novoHealth, statePet = '$novoStatus' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($queryHealth);
            $mysql->execute();

            header('Location: ./listagem-pet.php');
            $this->controleEstadosGerais($idPet);

            
        }

        public function ninar($idPet){
            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $estado = $mysql->fetchColumn();

            $cans = "SELECT sleepPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($cans);
            $mysql->execute();
            $sleep = $mysql->fetchColumn();

            //if($estado == 'cansado'){
                $query="UPDATE pet SET statePet = 'dormindo' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();
            //}
            if($estado == 'dormindo'){
               if($sleep >= 50){
                    $query="UPDATE pet SET statePet = 'normal' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($query);
                    $mysql->execute();
               }
               else{
                    $query="UPDATE pet SET statePet = 'cansado' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($query);
                    $mysql->execute();
               }
            }
            // else{
            //     echo "<script type='text/javascript'>alert('Pet assassinado com sucesso!');</script>";
            // }
            
            header('Location: ./listagem-pet.php');
            $this->controleEstadosGerais($idPet); 
        }

    }
?>