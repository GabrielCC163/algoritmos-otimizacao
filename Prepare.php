<?php

require("Nodo.php");

class Prepare{
    private $nodos = array();

    public function getNodosFromFile($csvPath){
        
        $file = fopen($csvPath,"r");
        while($line = fgetcsv($file)){
            $nodo = new Nodo($line[0]);
            $nodo->setPontox($line[1]);
            $nodo->setPontoY($line[2]);           
            array_push($this->nodos, $nodo);
        }
        
                
        fclose($file);
    }

    public function getNodos(){
        return $this->nodos;
    }

    public function conectaNodos($csvPath){
        $file = fopen($csvPath,"r");
        while($line = fgetcsv($file)){
            $nodo = $this->getNodo($line[0]);
            $nodoToConnect = $this->getNodo($line[1]);
            $distancia = $this->CalculaDistanciaTo($nodo, $nodoToConnect);
            $nodo->setNodoConectado($nodoToConnect, $distancia);
            $nodoToConnect->setNodoConectado($nodo, $distancia);
        }

        fclose($file);

    }

    public function ConnectAllToAll(){
        foreach ($this->nodos as $nodo) {
            foreach ($this->nodos as $nodoToConnect) {
                if($nodo->getName() != $nodoToConnect->getName()){
                    $distancia = $this->CalculaDistanciaTo($nodo, $nodoToConnect);
                    $nodo->setNodoConectado($nodoToConnect, $distancia);
                }
            }
        }
    }



    public function CalculaDistanciaTo($nodo, $nodoTo){

        $x1 = $nodo->getPontox();
        $y1 = $nodo->getPontoy();

        $x2 = $nodoTo->getPontox();
        $y2 = $nodoTo->getPontoy();

        $a = pow(($x2 - $x1), 2);
        $b = pow(($y2 - $y1), 2);     

        $distancia = sqrt(($a+$b));

        return $distancia;
    }   

    public function getNodo($name){
        foreach ($this->nodos as $nodo) {            
            if($nodo->getName() == $name){
                return $nodo;
            }
        }
        return false;
    }

}
