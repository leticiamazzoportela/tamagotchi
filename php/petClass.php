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
            //ARRUMAR ESSA FUNÇÃO QUANDO ARRUMAR O TEMPO, PRA NÃO DAR CONFLITO DE ESTADO
            //DÁ PRA CONSULTAR MAIS DE UMA COISA AO MESMO TEMPO COM FETCHCOLUMN
            //FUNÇÃO DE SUJEIRA FAZER COM O TEMPO
            $sql = "SELECT hungerPet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $fomeAntiga = $mysql->fetchColumn();

            $age = "SELECT idade FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($age);
            $mysql->execute();
            $idade = $mysql->fetchColumn();

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

                $queryDoente="UPDATE pet SET healthPet = '$doenteAtual' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($queryDoente);
                $mysql->execute();

                if($doenteAtual <= 20){
                    $qDoente="UPDATE pet SET statePet = 'doente' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($qDoente);
                    $mysql->execute();
                
                    if($idade >= 4){
                        $aparencia = "UPDATE pet SET imagem = 'tails-triste.gif' WHERE idPet = $idPet";
                        $mysql=$this->mysql->prepare($aparencia);
                        $mysql->execute();
                    }
                }
            }
            
            $query="UPDATE pet SET hungerPet = '$fome' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();

            if($fome >= 50 && $fome < 90){
                $qfome="UPDATE pet SET statePet = 'normal' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($qfome);
                $mysql->execute();

                if($idade >= 4){
                    $aparencia = "UPDATE pet SET imagem = 'tails-normal.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
            }
            else if($fome >= 90){
                $qfome="UPDATE pet SET statePet = 'feliz' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($qfome);
                $mysql->execute();

                if($idade >= 4){
                    $aparencia = "UPDATE pet SET imagem = 'tails-feliz.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
            }

            header('Location: ./listagem-pet.php');
        }

        public function banhar($idPet){
            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $estado = $mysql->fetchColumn();

            $age = "SELECT idade FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($age);
            $mysql->execute();
            $idade = $mysql->fetchColumn();

            if($estado == 'sujo'){
                $query="UPDATE pet SET statePet = 'normal' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();

                if($idade >= 4){
                    $aparencia = "UPDATE pet SET imagem = 'tails-normal.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
                
                header('Location: ./listagem-pet.php');
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

            $age = "SELECT idade FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($age);
            $mysql->execute();
            $idade = $mysql->fetchColumn();

            $fome = $this->hungry($Dtime, $state);
            $felicidade = $this->happy($Dtime, $state);
            $sono = $this->sleep($Dtime, $state);
            $saude = $this->health($Dtime, $state);

            $estado = 'normal';
            $src = 'tails-normal.gif';

            if ($fome < 50){
                $estado = 'fome';
                $src = 'tails-bravo.gif';
            }
            if($felicidade < 50){
                $estado = 'triste';
                $src = 'tails-triste.gif';                
            }
            else if(($felicidade > 90) && ($fome > 80) && ($sono > 80) && ($saude > 80)){
                $estado = 'feliz';
                $src = 'tails-feliz.gif';
            }
            if ($sono < 50){
                $estado = 'cansado'; 
                $src = 'tails-dormir.gif';               
            }
            if ($saude <= 20){
                $estado = 'doente';
                $src = 'tails-triste.gif';
            }

            $queryState="UPDATE pet SET healthPet = $saude, happyPet = $felicidade, hungerPet = $fome, sleepPet = $sono, statePet = '$estado' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($queryState);
            $mysql->execute();

            if($idade >= 4){
                $aparencia = "UPDATE pet SET imagem = '$src' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($aparencia);
                $mysql->execute();
            }

            $_SESSION["tempo"] = time();
        }

        public function hungry($Dtime, $state){
            if ($state == 'normal'){
                $fome = $Dtime/120;
            }
            if ($state == 'feliz'){
                $fome = $Dtime/180;
            }
            if ($state == 'cansado'){
                $fome = $Dtime/100;
            }
            if ($state == 'triste'){
                $fome = $Dtime/120;
            }
            if ($state == 'fome'){
                $fome = $Dtime/60;
            }
            if ($state == 'doente'){
                $fome = $Dtime/120;
            }
            return $fome;
        }

        public function happy($Dtime, $state){
            if ($state == 'normal'){
                $felicidade = $Dtime/180;
            }
            if ($state == 'feliz'){
                $felicidade = $Dtime/250;
            }
            if ($state == 'cansado'){
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
            return $felicidade;
        }

        public function sleep($Dtime, $state){
            if ($state == 'normal'){
                $sono = $Dtime/250;
            }
            if ($state == 'feliz'){
                $sono = $Dtime/300;
            }
            if ($state == 'cansado'){
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
            return $sono;
        }

        public function health($Dtime, $state){
            if ($state == 'normal'){
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
            if ($state == 'doente'){
                $saude = $Dtime/60;
            }
            return $saude;
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
            error_log($estado);

            $age = "SELECT idade FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($age);
            $mysql->execute();
            $idade = $mysql->fetchColumn();
            

            if($statusDoente <= 20){
                $novoHealth = $statusDoente + 10;
                if($novoHealth > 20){
                    $novoStatus = 'normal';
                    if($idade >= 4){
                        $aparencia = "UPDATE pet SET imagem = 'tails-normal.gif' WHERE idPet = $idPet";
                        $mysql=$this->mysql->prepare($aparencia);
                        $mysql->execute();
                    }
                }
                else
                    $novoStatus = 'doente';
        
            }
            else if($estado != 'doente'){
                $novoHealth = 20;
                $novoStatus = 'doente';

                if($idade >= 4){
                    $aparencia = "UPDATE pet SET imagem = 'tails-triste.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
            }
            else{
                $novoHealth = $statusDoente;
                $novoStatus = $estado;
            }
            
            $queryHealth="UPDATE pet SET healthPet = $novoHealth, statePet = '$novoStatus' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($queryHealth);
            $mysql->execute();

            header('Location: ./listagem-pet.php');

            
        }

        public function ninar($idPet){
            $sql = "SELECT statePet FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sql);
            $mysql->execute();
            $estado = $mysql->fetchColumn();

            $age = "SELECT idade FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($age);
            $mysql->execute();
            $idade = $mysql->fetchColumn();

            if($estado == 'cansado'){
                //passa um tempo e aí atualiza, antes tem que colocar a imagem de cansado
                $query="UPDATE pet SET statePet = 'normal' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();

                if($idade >= 4){
                    $aparencia = "UPDATE pet SET imagem = 'tails-normal.gif' WHERE idPet = $idPet";
                    $mysql=$this->mysql->prepare($aparencia);
                    $mysql->execute();
                }
            }
            
            header('Location: ./listagem-pet.php'); 
        }

    }
?>