<?php

$vertices_a = ['1', '1', '1', '2', '3', '3', '3', '4', '5', '6'];
$vertices_b = ['2', '3', '4', '5', '4', '5', '6', '6', '7', '7'];
$final = $vertices_b[count($vertices_b)-1];

$cargas = [6, 4, 1, 4, 3, 1, 3, 4, 4, 9];

$vertices = [];
for ($i = 0; $i < count($vertices_a); $i++) {
    $vertices[] = [
        'a' => $vertices_a[$i],
        'b' => $vertices_b[$i],
        'carga' => $cargas[$i]
    ];
}

//para todos os caminhos a partir do 1, quanto de carga vai para as próximas conexões, onde as próximas de cada conexão carreguem toda a carga até o fim
//retorno vai ser de quanto q se pode passar de um vértice para o outro até chegar no final
//verificar carga total possível de todos os caominhos

$nodes = array_values(array_unique($vertices_a));
$vertices_result = $vertices;

for ($i = 0; $i < count($nodes); $i++) {
    $nodo = $nodes[$i];

    $conexoes = [];
    for ($x = 0; $x < count($vertices); $x++) {
        if ($nodo == $vertices[$x]['a']) {
            $conexoes[] = $vertices[$x];
        }
    }

    $proximos_nodos = [];
    foreach ($conexoes as $con) {
        $proximos_nodos[] = [
            'nodo' => $con['b']
        ];
    }

    foreach ($proximos_nodos as &$n) {
        $temp = $n;
        $cargas_seguintes = [];
        for ($y = 0; $y < count($vertices); $y++) {
            if ($vertices[$y]['a'] == $temp['nodo']) {
                $cargas_seguintes[] = $vertices[$y]['carga'];
            }
        }

        $n['carga_total'] = array_sum($cargas_seguintes);
    }

    foreach ($vertices_result as &$v) {
        if ($v['a'] == $nodo) {
            foreach ($proximos_nodos as $next) {
                if ($next['nodo'] == $v['b']) {
                    $carga_a = $v['carga'];
                    $carga_b = $next['carga_total'];
                    if ($carga_a > $carga_b) {
                        $v['carga_enviada'] = $next['carga_total'];
                    } else {
                        $v['carga_enviada'] = $v['carga'];
                    }
                }
            }
        }
    }
}

var_dump($vertices_result);
