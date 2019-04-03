<?php
include("Nodo.php");

use PHPUnit\Framework\TestCase;

final class NodoTest extends TestCase{
    private $nodo;

    public function setUp(){
        $this->nodo = new Nodo("Nodo");
        $nodo = new Nodo("conectado");
        $this->nodo->setNodoConectado($nodo, 50);
        $nodo = new Nodo("segundo");
        $this->nodo->setNodoConectado($nodo, 100);
    }


    public function testGetName(){
        $this->assertEquals("Nodo", $this->nodo->getName());
    }

    public function testGetNodoConectado(){ 
        $nodos = $this->nodo->getNodosConectados();
        $firtNodoName = $nodos[0]['nodo']->getName();
        $this->assertEquals('conectado', $firtNodoName);

        $fistNodoDistancia = $nodos[0]['distancia'];
        $this->assertEquals(50, $fistNodoDistancia);

        $secondNodoName = $nodos[1]['nodo']->getName();;
        $this->assertEquals('segundo', $secondNodoName);

        $secondNodoDistancia = $nodos[1]['distancia'];
        $this->assertEquals(100, $secondNodoDistancia);
    }

}
