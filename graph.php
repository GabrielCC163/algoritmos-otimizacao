
<?php
  class Graph{
    private $nodos;
    private $jsonNodos;
    private $jsonConnections;
    private $netWorkId;

    public function __construct() {
      $this->netWorkId=0;
    }

    public function InsertNodos(){
      $this->jsonNodos = array();
      $json = array();
      foreach ($this->nodos as $nodo) {
        $json = array(
          "id" => $nodo->getName(),
          "label" => $nodo->getName()
        );   

        array_push($this->jsonNodos, $json);     
      }
     
      $this->jsonNodos = json_encode($this->jsonNodos);
    }
    
    
    public function setNodos($nodos){
      $this->nodos = $nodos;
    }


    public function setCaminho($caminho){
;
      $this->nodos = $caminho;
    }

    public function Connect(){
      $this->jsonConnections = array();
      $json = array();
      foreach ($this->nodos as $nodo) {
        $conectados = $nodo->getNodosConectados();
        
        foreach ($conectados as $conectado){

          $json = array(
            "from" => $nodo->getName(),
            "to" => $conectado['nodo']->getName()
          );
          array_push($this->jsonConnections, $json);          
        }
      }
      $this->jsonConnections = json_encode($this->jsonConnections);    
      
    }

    public function ConnectByCaminhoOrder(){
      $this->jsonConnections = array();
      $i = 1;
      foreach ($this->nodos as $nodo){
        if (sizeof($this->nodos) != $i){          
          $json = array(
            "from" => $nodo->getName(),
            "to" => $this->nodos[$i]->getName()
          );
          
        }
        else{
          $json = array(
            "from" => $nodo->getName(),
            "to" => $this->nodos[0]->getName()
          );
        }
        array_push($this->jsonConnections, $json);
        $i++;
      }
      $this->jsonConnections = json_encode($this->jsonConnections);      
      
    }

    public function PrintFaildAttempts($forbidenPaths){

      foreach ($forbidenPaths as $forbiden) {
        $this->jsonConnections = array();
        $this->jsonNodos = array();
        $i = 1;
        foreach ($forbiden as $f) {
          $jsonNodo = array(
            "id" => $f,
            "label" => $f
          );   
          array_push($this->jsonNodos, $jsonNodo);

          if(sizeof($forbiden) != $i){

              $jsonConnection = array(
                "from" => $f,
                "to" => $forbiden[$i]
              );
              array_push($this->jsonConnections, $jsonConnection);
          }
          $i++;
        }
        $this->jsonNodos = json_encode($this->jsonNodos);
        $this->jsonConnections = json_encode($this->jsonConnections);
        $this->PrintNodes();
      }
    }

    public function PrintNodes(){
      
      $this->netWorkId++;
      ?>

      <!doctype html>
      <html>
      <head>
        <title>Network | Basic usage</title>
      
        <script type="text/javascript" src="http://visjs.org/dist/vis.js"></script>
        <link href="http://visjs.org/dist/vis-network.min.css" rel="stylesheet" type="text/css" />
      
        <style type="text/css">
        html,body, body > div{
           height:100%;
           width: 100%;
        }

        </style>
      </head>
      <body>
      
      <p>
        Nodo network 
        
      </p>
      
      <div id="<?php echo 'mynetwork' . $this->netWorkId; ?>"></div>
      
      <script type="text/javascript">
        // create an array with nodes
        var nodes = new vis.DataSet(<?php echo $this->jsonNodos; ?>);
      
        // create an array with edges
        var edges = new vis.DataSet(<?php echo $this->jsonConnections; ?>);
      
        // create a network
        var container = document.getElementById("<?php echo 'mynetwork' . $this->netWorkId; ?>");
        var data = {
          nodes: nodes,
          edges: edges
        };
        var options = {};
        var network = new vis.Network(container, data, options);
      </script>
      
      
      </body>
      </html>


      <?php
    }
  }
?>

