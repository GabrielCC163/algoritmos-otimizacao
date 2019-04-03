<?php

$vertices_a = ['1','1','1','1','1','2','2','2','2','2','3','3','3','3','3','4','4','4','4','4','4','4','5','5','5','6','6','6','6','6','7','7','7','7','7','7','7','7','8','8','8','8','8','8','8','8','8',
    '9','9','9','9','10','10','10','10','10','10','11','11','11','12','12','12','12','12','12','12','13','13','13','13','13','13','13','13','14','14','14','14','14','15','15','15','16','16','17','17','17','17',
    '18','18','18','19','19','19','19','20','20','20','20','21','21','21','21','22','23','24','24','25','26','26','26','27','27','27','27','28','28','28','29','29','29','30','30','30','30',
    '31','31','32','32','32','32','33','33','33','33','33','34','34','34','34','34','35','35','35','35','35','35','36','36','36','36','36','36','37','37','37','37','38','38','38','38'];

$vertices_b = ['2','4','10','15','17','16','3','7','10','11','12','18','28','27','29','11','19','22','13','14','6','16','27','29','30','31','33','34','17','8','8','9','10','38','3','26',
'13','37','4','7','15','17','25','29','28','34','35','37','23','21','11','21','23','24','38','22','17','5','4','2','1','19','29','27','26','36','34','33','32','23','26','26','28','19',
'21','7','6','3','2','9','10','11','14','16','23','34','33','37','38','21','20','19','17','16','2','8','14','3','2','6','5','11','16','22','28','26','32','31','27','29','30','20','10',
'22','23','7','9','12','15','19','20','22','11','23','29','12','23','33','27','17','14','16','16','2','7','8','9','10','9','15','28','38','27','23','32','12','11','8','6','23','34','33',
'2','37','25','23','12','9','23','15','18','22'];

//BASE DE TESTE
    //$vertices_a = ['1', '1', '1', '2', '2', '2', '3', '3', '3', '4', '4', '4', '4', '5'];
    //$vertices_b = ['2', '3', '4', '1', '3', '4', '1', '2', '4', '1', '2', '3', '5', '4'];

$distancias = [
    '290','628','437','903','1197','891','512','591','457','946','463','530','851','923','1154','620','623','603','375','702','199','592','857','1144','1068','1109','1100','1117','411','176','119','133','881','1335','182','600','206','1111','376','119','176','235','510','1016','558','968','994','1003','491','1200','255','354','681','897','1515','819','1102','423','620','946','1186','120','1145','488','638','913','877','904','901','335','395','395','500','310','1041','847','776','866','483','898','789','415','735','0','524','780','772','876','1076','1317','471','5','16','33','918','247','607','591','660','426','1219','1439','1308','978','306','77','684','688','632','510','353','158','1340','521','667','746','549','513','486','1058','613','690','1036','417','296','971','872','210','921','1013','853','1014','786','1472','1069','954','944','1461','958','909','422','354','709','605','287','1006','1060','994','1190','919','147','180','1598','440','638','695','980','1003','931','1130','1064','907'
];

$vertices = [];
$nodos = array_values(array_unique($vertices_a));
foreach ($nodos as $n) {
    $vertices[] = [
        'nodo' => $n
    ];
}

$conexoes = [];
for($i = 0; $i < count($vertices_a); $i++) {
    $conexoes[] = [
        'a' => $vertices_a[$i],
        'b' => $vertices_b[$i]
    ];
}

//BASE DE TESTE
/*
    $conexoes[0]['dist']  = 10;  // 1 - 2
    $conexoes[1]['dist']  = 30;  // 1 - 3
    $conexoes[2]['dist']  = 5;   // 1 - 4
    $conexoes[3]['dist']  = 10;  // 2 - 1
    $conexoes[4]['dist']  = 20;  // 2 - 3
    $conexoes[5]['dist']  = 50;  // 2 - 4
    $conexoes[6]['dist']  = 30;  // 3 - 1
    $conexoes[7]['dist']  = 20;  // 3 - 2
    $conexoes[8]['dist']  = 60;  // 3 - 4
    $conexoes[9]['dist']  = 5;   // 4 - 1
    $conexoes[10]['dist'] = 50;  // 4 - 2 
    $conexoes[11]['dist'] = 60;  // 4 - 3
    $conexoes[12]['dist'] = 8;   // 4 - 5
    $conexoes[13]['dist'] = 8;   // 5 - 4
  */

for($i = 0; $i < count($distancias); $i++) {
    $conexoes[$i]['dist'] = intval($distancias[$i]);
}

//atribui cada conexão ao vértice correspondente
foreach ($vertices as &$v) {
    foreach ($conexoes as $con) {
        if ($con['a'] === $v['nodo']) {
            $v['conexoes'][] = $con;
        }
    }
}

//conexões resultantes do caminho percorrido
$path_conexoes = [];

//já busca a primeira conexão, sendo a com menor distância do primeiro vértice
$path_conexoes[] = buscaMenorConexao($vertices[0]['conexoes']);

//vértices ainda não conectados
$nao_conectados = $nodos;

//remove primeiro vértice ('a') dos não_conectados pois sempre já será o primeiro utilizado na busca pela conexão com menor distância
array_shift($nao_conectados);

//remove o vértice 'b' dos não conectados, pois faz parte da primeira conexão
$nao_conectados = removeNaoConectados($path_conexoes[0]['b'], $nao_conectados);

arvoreGeradora($vertices, $nao_conectados, $path_conexoes);

print_r($path_conexoes);
echo '<br>';
foreach ($path_conexoes as $con) {
    echo $con['a'] . " - " . $con['b'];
    echo " // Distância = " . $con['dist'];
    echo "<BR>";
}


echo "<BR> Distância percorrida = " . distanciaPercorrida($path_conexoes);

function arvoreGeradora($vertices, $nao_conectados, &$path_conexoes) {
    //enquanto houver vértices não conectados
    while(!empty($nao_conectados)) {
        
        //busca os conectados
        $conectados = [];
        for ($i = 0; $i < count($vertices); $i++) { //foreach não funciona
            if (!in_array($vertices[$i]['nodo'], $nao_conectados)) {
                $conectados[] = $vertices[$i];
            }
        }

        //para cada vértice já conectado busca a conexão de menor distância com outro não conectado
        $conexoes_vertices = [];
        for ($i = 0; $i < count($conectados); $i++) {
            $conexao_menor = buscaMenorConexaoNaoConectado($conectados[$i]['conexoes'], $nao_conectados);
            if (!empty($conexao_menor)) {
                $conexoes_vertices[] = $conexao_menor;
            }
        }

        //dentre as encontradas, identifica a que possuir a menor distância
        $menor_conexao = buscaMenorConexao($conexoes_vertices);

        //remove o vértice dos não conectados
        $nao_conectados = removeNaoConectados($menor_conexao['b'], $nao_conectados);

        //adiciona a conexão no vetor de resultado
        $path_conexoes[] = $menor_conexao;
    }
}

function buscaMenorConexao($conexoes_nodo) {
    $menor_conexao = $conexoes_nodo[0];
    foreach($conexoes_nodo as $con) {
        if($con['dist'] < $menor_conexao['dist']) {
            $menor_conexao = $con;
        }
    }
    return $menor_conexao;
}

function buscaMenorConexaoNaoConectado($conexoes_nodo, $nao_conectados) {
    $conexoes_validas = [];
    foreach ($conexoes_nodo as $con) {
        if (in_array($con['b'], $nao_conectados)) {
            $conexoes_validas[] = $con;
        }
    }

    if (empty($conexoes_validas)) {
        return [];
    }
    
    $menor_conexao = $conexoes_validas[0];
    
    foreach($conexoes_validas as $con) {
        if ($con['dist'] < $menor_conexao['dist']) {
            $menor_conexao = $con;
        }
    }
    return $menor_conexao;
}

function removeNaoConectados($index, $nao_conectados) {
    for($i = 0; $i < count($nao_conectados); $i++) {
        if($nao_conectados[$i] === $index) {
            unset($nao_conectados[$i]);
            break;
        }
    }

    return array_values($nao_conectados);
}

function distanciaPercorrida($conexoes) {
    $dist = 0;
    foreach ($conexoes as $con) {
        $dist += $con['dist'];
    }

    return $dist;
}
?>