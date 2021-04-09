

<?php

    include 'empresa.php';
    //include 'functions.php';

    $empCNPJ = listarEmpresas();
    //print_r($empCNPJ);
    $nomeGeral = '';
    $cnpjGeral = '';
    foreach ($empCNPJ as $key => $i) { 
        if (!($key % 2)) 
            $cnpjGeral = preg_replace( '/[^0-9]/', '', $i);
        else { 
            $nomeGeral = $i;
            $arrCNPJ[$cnpjGeral] = $cnpjGeral." - ".$nomeGeral;
        }
    }
    //print_r($arrCNPJ);
    //$arrCNPJ = array( 
    //"88579701000178" => "Schirmann Matriz",
    //"88579701000500"  => "Schirmann Filial",
    //);    

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

$cnpjGlobal = '';

?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <center>
                       <h2>Escritório Dalmolin</h2>
                       <h3> Empresas Subvenção</h3>
                    </center>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
            </div>
                 <!-- /. ROW  -->
            <hr />                
            <div class="row">

                <form action="indexNewRet.php" method="post">

                    <p><center>
                        <select name="cnpj">
                            <option></option>
                            <?php foreach ($arrCNPJ as $key => $value): ?>
                                <?php echo "<option value=\"$key\" >$value</option>"; ?>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="Pesquisar!" />
                    </center></p>
                </form>

                                        <!--div class="btn-group">
                                          <button class="btn btn-primary">CNPJ</button>
                                          <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                          <ul class="dropdown-menu">
                                            <?php foreach ($arrCNPJ as $key => $value): ?>
                                                 <li><?php echo "<option value=\"$key\" >$value</option>"; ?></li>
                                            <?php endforeach; ?>
                                          </ul>
                                            <input type="submit" value="Pesquisar!" />

                                        </div-->
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

