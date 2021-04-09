

<?php

    include 'empresa.php';
    $empCNPJ = listarEmpresas();
    //print_r($empCNPJ);
    $nomeGeral = '';
    $cnpjGeral = '';
    foreach ($empCNPJ as $key => $i) { 
        if (!($key % 2)) 
            $cnpjGeral = $i;
        else 
            $nomeGeral = $i;
    }


    # Inicializando a variável $_POST['cnpj']
    $_POST['cnpj'] = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;


?>


<!DOCTYPE html>

<?php include 'functions.php';?>
<?php include 'table_month.php';?>
<?php include 'tableYear.php';?>

<html xmlns="http://www.w3.org/1999/xhtml">

<?php include 'head.php';?>

<body>
    <div id="wrapper">
        <?php include 'body_left.php';?>
        <!-- /. NAV TOP  -->

<?php            
//buscar nos arquivos dataXXX o somatório dos valores
$path = "./final/";

$diretorio = dir($path);

$empresa = '';
$cnpj='';
$meses=0;
$total=0;

$empresaFinal = '';
$cnpjFinal = '';

//echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
while($arquivo = $diretorio -> read()){
    //echo 'Leitura do arquivo de entrada  - '.$path.$arquivo.'<br /><br />';

    //processar apenas os arquivos data - resumo
    if(str_starts_with($arquivo, 'data')) {
        // Abre o Arquivo no Modo r (para leitura)

        if(($input = fopen($path.$arquivo, 'r')) !== FALSE) {
            //pegar o nome e cnpj da empresa
            $empresa = fgets($input, 1024);
            $cnpj = fgets($input, 1024);
            if($cnpj == $_POST['cnpj']) {
                $empresaFinal = $empresa;
                $cnpjFinal = $cnpj;
                $meses++;
                while(!feof($input)) {
                    $linha = fgets($input, 1024);
                    $campos = explode('|', $linha);
                    if(str_starts_with($linha , "|Total")) { 
                        //echo '<h1>Total = '.floatval($campos[2]).'/<h1>';
                        $total += floatval($campos[2]);
                    }
                }
            }
        }
    }
}
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <center>
                       <?php 
                            echo'<h2>'.$empresaFinal.'</h2>';   
                            echo'<h3> CNPJ '.formatar_cpf_cnpj($cnpjFinal).'</h3>';
                        ?>
                    </center>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">

                <div class="col-md-6 col-sm-6 col-xs-6">           
                    <div class="panel panel-back noti-box">
                        <span class="icon-box bg-color-blue set-icon">
                            <i class="fa fa-bell-o"></i>
                        </span>
                        <div class="text-box" >
                            <p class="main-text"><?php echo $meses ?></p>
                            <p class="text-muted">Meses processados</p>
                        </div>
                     </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">           
                    <div class="panel panel-back noti-box">
                        <span class="icon-box bg-color-brown set-icon">
                            <i class="fa fa-rocket"></i>
                        </span>
                        <div class="text-box" >
                            <p class="main-text"><?php echo formatReal($total) ?></p>
                            <p class="text-muted">Total em subvenção</p>
                        </div>
                    </div>
                </div>

 
               </div>
                 <!-- /. ROW  -->
            <hr />                
            <div class="row">

<?php
    # Caso o valor de $_POST seja verdadeiro (diferente de "" ou null)
    # executaremso o bloco if
    if ($_POST['cnpj']) {
        for($i=2021; $i>2015; $i--) 
            if(existeAno($i)) {
                tableData($_POST['cnpj'], $i);
                //echo "armazenar '{$_POST['cnpj']}'";
            }
    } else 
        echo "Erro!";
?>
                <!-- /. ROW  >
             <-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER -->
         </div>  
         <!-- /. WRAPPER  -->

    
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $("#dataTables-example").dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
       
</body>
</html>
