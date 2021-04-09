

<?php

    include 'empresa.php';
    $empCNPJ = listarEmpresas();
    print_r($empCNPJ);
    $nomeGeral = '';
    $cnpjGeral = '';
    foreach ($empCNPJ as $key => $i) { 
        if (!($key % 2)) 
            $cnpjGeral = $i;
        else {
            $nomeGeral = $i;
    


$html = "<!DOCTYPE html>";

$html .= "<?php include 'functions.php';?>";
$html .= "<?php include 'table_month.php';?>";
$html .= "<?php include 'tableYear.php';?>";
$html .= "<?php include 'empresa.php';?>";

$html .= "<html xmlns='http://www.w3.org/1999/xhtml'>";

$html .= "<?php include 'head.php';?>";

$html .= "<body>";
$html .= "  <div id='wrapper'>";
$html .= "      <?php include 'body_left.php';?>";

$html .= "<?php   ";         
$html .= "\$path = './final/';";
$html .= "\$diretorio = dir(\$path);";

$html .= "\$empresa = ''; \$cnpj=''; \$meses=0; \$total=0;";

$html .= "while(\$arquivo = \$diretorio -> read()){";
$html .= "    if(str_starts_with(\$arquivo, 'data')) {";

$html .= "        if((\$input = fopen(\$path.\$arquivo, 'r')) !== FALSE){";
$html .= "            \$empresa = fgets(\$input, 1024);";
$html .= "            \$cnpj = fgets(\$input, 1024);";
$html .= "            \$meses++;";
$html .= "            while(!feof(\$input)) {";
$html .= "                \$linha = fgets(\$input, 1024);";
$html .= "                \$campos = explode('|', \$linha);";
$html .= "                if(str_starts_with(\$linha , '|Total')) { ";
$html .= "                    \$total += floatval(\$campos[2]);";
$html .= "                }";
$html .= "            }";
$html .= "        }";
$html .= "    }";
$html .= "}";

$html .= "?>";
$html .= "        <div id='page-wrapper' >";
$html .= "            <div id='page-inner'>";
$html .= "                <div class='row'>";
$html .= "                    <div class='col-md-12>";
$html .= "                    <center>";
$html .= "                       <h2>Escritório Dalmolin</h2>";
$html .= "                       <h3> Empresas Subvenção</h3>";
$html .= "                    </center>";
$html .= "                    </div>";
$html .= "                </div>      ";        
$html .= "                  <hr />";
$html .= "                <div class='row'>";
$html .= "            </div>";

$html .= "            <hr />  ";              
$html .= "            <div class='row'>";
$html .= "                <?php ";

$html .= "                    for(\$i=2021; \$i>2015; \$i--) ";
$html .= "                        if(existeAno(\$i))";
$html .= "                            tableData(".$cnpjGeral.", \$i);";

$html .= "                ?>";
$html .= "            </div>";
$html .= "         </div>  ";

$html .= "    <script src='assets/js/jquery-1.10.2.js'></script>";
$html .= "    <script src='assets/js/bootstrap.min.js'></script>";
$html .= "    <script src='assets/js/jquery.metisMenu.js'></script>";
$html .= "    <script src='assets/js/dataTables/jquery.dataTables.js'></script>";
$html .= "    <script src='assets/js/dataTables/dataTables.bootstrap.js'></script>";
$html .= "        <script>";
$html .= "            $(document).ready(function () {";
$html .= "                $('#dataTables-example').dataTable();";
$html .= "            });";
$html .= "    </script>";
$html .= "    <script src='assets/js/custom.js'></script>";
       
$html .= "</body>";
$html .= "</html>";

//file_put_contents("$cnpjGeral", $html);

    echo quotemeta($html);

    if($output = fopen('./teste.txt', 'w') !== FALSE){
        fwrite($output, $html);
    }
    fclose($output);

}
}

?>
