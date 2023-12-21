<?php

class Medio{
    public $id;
    public $titulo;
    public $ADE;
    public $medio;

    public function __construct( int $id, string $titulo, string $ADE, string $medio){
        $this->id=$id;
        $this->titulo=$titulo;
        $this->ADE=$ADE;
        $this->medio=$medio;
    }

    public function mostrarMedio(){
        echo "ID: ".$this->id."<br>";
        echo "Titulo: ".$this->titulo."<br>";
        echo "ADE: ".$this->ADE."<br>";
        echo "Medio: ".$this->medio."<br>";
    }
    public function getId(){
        return $this->id;
    }

    public function actualizarTitulo($data){
        $this->titulo=$data;
    }
    public function actualizarADE($data){
        $this->ADE=$data;
    }
    public function actualizarMedio($data){
        $this->medio=$data;
    }
}
?>