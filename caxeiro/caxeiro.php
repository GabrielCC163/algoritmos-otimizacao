<?php
// para gerar a prieira solucao: 
// quando encontrar um caminho que deu errado, guardar em um array de caminhnos errados
// entao retornar ate encontrar um caminho que de certo
// quando der errado novamente, colocar no array de caminho errado.
    class Caxeiro{
        private $firstNodo;
        private $caminho = array();
        private $nodosLength;
        private $distanciaTotal;
        private $forbidenPaths = array();

        public function __construct($nodo, $nodosLength){            
            $this->firstNodo = $nodo;
            $this->nodosLength = $nodosLength;        
            
            array_push($this->caminho, $this->firstNodo);   

        }
        
        public function GenerateFirstSolution($nodo = null, $caminhoConnectedToFirst = 0){
            
            if($nodo == null){
                $conectados = $this->firstNodo->getNodosConectados();                
            }else{
                $conectados = $nodo->getNodosConectados();
 
            }                
            
            $menorDistancia = 0;
        
            foreach ($conectados as $conectado) {

                if($conectado['nodo']->getName() != $this->firstNodo->getName()){
                    
                    if ($conectado['nodo']->getVisited() == false){

                        if($this->itsInForbidenArray($conectado) == false){

                            if($menorDistancia == 0){
                            
                                $menorDistancia = $conectado['distancia'];
                                $bestNodo = $conectado;
                            }
                            elseif($menorDistancia >= $conectado['distancia']){
                                
                                $menorDistancia = $conectado['distancia'];
                                $bestNodo = $conectado;                            
                            }

                        }
                    }
                }                
                elseif($this->nodosLength == sizeof($this->caminho)){
                     $this->setToCaminho($conectado);
                     $this->distanciaTotal = $this->CalculaDistancia($this->caminho);
                    return true;
                } 
            }
            if(!empty($bestNodo)){
                $this->setToCaminho($bestNodo);
            }
            elseif ($menorDistancia == 0){                
                $bestNodo = $this->VoltaCaminho();
            }
                 if($this->isConnectedTo($bestNodo['nodo'], $this->firstNodo) == true){
                    $caminhoConnectedToFirst++; 
                    if($caminhoConnectedToFirst == sizeof($this->firstNodo->getNodosConectados())){
                        $caminhoConnectedToFirst = 0;
                        $bestNodo = $this->VoltaCaminho();
                    }
                       }
                 $this->GenerateFirstSolution($bestNodo['nodo'], $caminhoConnectedToFirst);
             
        }    

        private function isConnectedTo($nodo, $connectedTo){
            foreach($nodo->getNodosConectados() as $conectado){
                if($conectado['nodo']->getName() == $connectedTo->getName()){
                    return true;
                }
            }   
            return false;
            
        }
        

        public function getCaminho(){
            return $this->caminho;
        }

        public function Permutation($permNum = null, $bestCaminho = null){
            if($bestCaminho == null){
                $bestCaminho = $this->caminho;
            }
            
            if($permNum == null){
                $permNum=2;
            }
            if ($permNum == sizeof($bestCaminho) -1){                
                $this->caminho = $bestCaminho;
                return;
            }
            $lastPos = 2;
            $start = 1;
            
            $x = 1;
            $continue = 1;
            while ($continue == 1) {
                
                $newCaminho = array();
                $lastPos = $x;
                if($lastPos != 1 && $lastPos  <2){                
                    $start = $lastPos; 
                }                
                $reverse = array();
                for ($i=0; $i<$permNum; $i++){
                    array_push($reverse, $this->caminho[$lastPos]);
                    if ($this->caminho[$lastPos+1] == $this->firstNodo){
                        $continue = 0;
                    }
                    $lastPos++;
                }

                $count = 0;
                

                for ($i=0; $i< sizeof($bestCaminho); $i++){
                    if($i>=$start && $count<$permNum){
                        array_push($newCaminho, array_pop($reverse));
                        $count++;
                    }else{
                        array_push($newCaminho, $this->caminho[$i]);
                    }
                    

                }
   
                $newCaminhoDist = $this->CalculaDistancia($newCaminho);
                if ($newCaminhoDist<$this->distanciaTotal){
                    $bestCaminho = $newCaminho;
                    $this->distanciaTotal = $newCaminhoDist;
                }
                // echo 'Permutacao com '. $permNum;
                // foreach($newCaminho as $nodo){
                //     echo $nodo->getName() . "-> ";
                // }
                // echo "distancia = $newCaminhoDist <br>";
                $start++;
                $x++;
            }
            $permNum++;
            $this->Permutation($permNum, $bestCaminho);
        }




        private function CalculaDistancia($caminho){
            $distanciaTotal = 0;
            $i=0;
            foreach ($caminho as $nodo) {
                $found = false;

                foreach($nodo->getNodosConectados() as $conectado){
                    if (sizeof($this->caminho) > $i+1){
                        if ($conectado['nodo'] == $caminho[$i+1] && $found == false){
                                $distanciaTotal = $distanciaTotal + $conectado['distancia'];
                                $found = true;
                            }                     
                        }                        
                    }
                    $i++;

 
            }

            return $distanciaTotal;
        }
        public function getDistanciaTotal(){
            return $this->distanciaTotal;
        }
        private function itsInForbidenArray($nodoToConnect){
            $caminho = $this->getNodosNamesAndPutIntoArray($this->caminho);
            array_push($caminho, $nodoToConnect['nodo']->getName());
            foreach ($this->forbidenPaths as $forbidenArray){

                if ($forbidenArray == $caminho){
                    return true;
                }
            }

            return false;

        }

        public function getForbidenPaths(){
            return $this->forbidenPaths;
            
        }

        private function VoltaCaminho(){
            array_push($this->forbidenPaths, $this->getNodosNamesAndPutIntoArray($this->caminho));

            $first = array_pop($this->caminho);
            $sec = array_pop($this->caminho);
            if($sec == null){
                $this->setToCaminho(array('nodo' => $first));
                return array('nodo' => $first);
            }
            $first->setVisited(false);
            $this->setToCaminho(array('nodo' => $sec));
            return array('nodo' => $sec);

        }

        private function getNodosNamesAndPutIntoArray($nodos){

            $array = array();
            foreach($nodos as $nodo){
                array_push($array, $nodo->getName());
            }

            return $array;

        }
        private function searchNodoByName($arrayNodos, $nodoName){
            foreach($arrayNodos as $nodo){
                if ($nodo->getName() == $nodoName){
                    return true;
                }
            }
            return false;
        }

        private function setToCaminho($conectado){
            $conectado['nodo']->setVisited(true);
            array_push($this->caminho, $conectado['nodo']);                        
        }

    }
?>