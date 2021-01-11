<?php
[ "id","pass","nombre","mail","plan","estado"];

class Usuario
{
    private $id;
    private $pass;
    private $nombre;
    private $mail;
    private $plan;
    private $estado;
    
    // Getter con método mágico
    public function __get($atributo){
        if(property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }
    // Setter con método mágico
    public function __set($atributo,$valor){
        if(property_exists($this, $atributo)) {
            $this->$atributo = $valor;
        }
    }
    
}