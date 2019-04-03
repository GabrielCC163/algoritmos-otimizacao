<?php

    class Nodo{        
        private $name;
        private $nodosConectados = array();  
        private $pontox;
        private $pontoy;  
        private $visited;
        
    public function __construct($name) {
        $this->name = $name;
        $this->visited = false;
    }
        
        
    public function setNodoConectado(Nodo $nodo, $distancia){
        $newNodo = array(
            'nodo' => $nodo,
            'distancia' => $distancia
        );
        array_push($this->nodosConectados, $newNodo);
    }  

    public function getNodosConectados(){
        return $this->nodosConectados;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setVisited($var){
        $this->visited = $var;
    }

    public function getVisited(){
        return $this->visited;
    }

    public function getName(){
        return $this->name;
    }

    public function setPontox($pontox){
        $this->pontox = $pontox;
    }

    public function setPontoY($pontoy){
        $this->pontoy = $pontoy;
    }

    public function getPontox(){
        return $this->pontox;
    }

    public function getPontoy(){
        return $this->pontoy;
    }
}
    
?>