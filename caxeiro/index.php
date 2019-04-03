<?php

include("../Prepare.php");
include("../graph.php");
include("caxeiro.php");
 
$prepare = new Prepare();
$prepare->getNodosFromFile('../pontos.csv');
$prepare->ConnectAllToAll();


$graph = new Graph();
$graph->setNodos($prepare->getNodos());
$graph->InsertNodos();
$graph->Connect();
$graph->PrintNodes();


$caxeiro = new Caxeiro($prepare->getNodo('1'), sizeof($prepare->getNodos()));
$caxeiro->GenerateFirstSolution();
$caminho = $caxeiro->getCaminho();
array_pop($caminho);
$graph->setNodos($caminho);

$graph->InsertNodos();

$graph->ConnectByCaminhoOrder();
echo 'Melhor distancia = ' . $caxeiro->getDistanciaTotal();
$graph->PrintNodes();

// $forbidenPaths = $caxeiro->getForbidenPaths();

// $graph->PrintFaildAttempts($forbidenPaths);


$caxeiro->Permutation();

$caminho = $caxeiro->getCaminho();
array_pop($caminho);
$graph->setNodos($caminho);

$graph->InsertNodos();

$graph->ConnectByCaminhoOrder();
echo 'Melhor distancia = ' . $caxeiro->getDistanciaTotal();
$graph->PrintNodes();
?>