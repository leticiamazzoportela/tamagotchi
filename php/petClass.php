<?php 

    class Pet{
        var $idPet;
        var $nomePet;
        var $happyPet;
        var $hungerPet;
        var $healthPet;
        var $statePet;
        var $idUsuario;

        #Funções de get e set para a classe Pet
        function get_idPet(){
           return $this->idPet;
        }
        
        function set_nomePet($new_name){
            $this->nomePet = $new_name;
        }
        function get_nomePet(){
            return $this->nomePet;
        }

        function set_happyPet($happy){
            $this->happyPet = $happy;
        }
        function get_happyPet(){
            return $this->happyPet;
        }

        function set_hungerPet($hunger){
            $this->hungerPet = $hunger;
        }
        function get_hungerPet(){
            return $this->hungerPet;
        }

        function set_healthPet($health){
            $this->healthPet = $health;
        }
        function get_healthPet(){
            return $this->healthPet;
        }

        function set_statePet($state){
            $this->statePet = $state;
        }
        function get_statePet(){
            return $this->statePet;
        }

        function set_idUsuarioPet($idUsuario){
            $this->idUsuarioPet = $idUsuario;
        }
        function get_idUsuarioPet(){
            return $this->idUsuarioPet;
        }

    }

?>