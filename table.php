<!DOCTYPE html>

<?php include 'functions.php';?>

<html xmlns="http://www.w3.org/1999/xhtml">

<?php include 'head.php';?>

<body>
    <div id="wrapper">
        <?php include 'body_left.php';?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <?php include 'body_top.php';?>
                <!-- /. ROW  -->
                <hr />

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Produtos em possível subvenção
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">CNPJ</th><th style="text-align:center;">Cod</th><th style="text-align:center;">CST</th><th style="text-align:center;">CFOP</th><th style="text-align:center;">Alíquota</th><th style="text-align:center;">Total</th><th style="text-align:center;">Base ICMS Red</th><th style="text-align:center;">Débito ICMS</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    //buscar nos arquivos dataXXX o somatório dos valores
                                    $path = "./final/";
                                    $diretorio = dir($path);
                                    while($arquivo = $diretorio -> read()){
                                        //echo 'Leitura do arquivo de entrada  - '.$path.$arquivo.'<br /><br />';
                                        //processar apenas os arquivos data - resumo
                                        if(str_starts_with($arquivo, 'out')) {
                                            // Abre o Arquivo no Modo r (para leitura)
                                            if(($input = fopen($path.$arquivo, 'r')) !== FALSE){
                                                $nota = TRUE;
                                                $cnpj = substr($arquivo, 4, 14);
                                                while(!feof($input))
                                                {
                                                    $linha = fgets($input, 1024);
                                                    $campos = explode('|', $linha);
                                                    //se for linha com C100
                                                    //se for linha com C190
                                                    if(str_starts_with($linha , "|C190")) {
                                                        echo '<tr class="odd gradeX"><td style="text-align:center;">'.$cnpj.'</td><td style="text-align:center;">'.$campos[1].'</td><td style="text-align:center;">'.$campos[2].'</td><td style="text-align:center;">'.$campos[3].'</td><td style="text-align:center;">'.$campos[4].'%</td><td style="text-align:right;">'.formatReal($campos[5]).'</td><td style="text-align:right;">'.formatReal($campos[6]).'</td><td style="text-align:right;">'.formatReal($campos[7]).'</td></tr>';
                                                    }
                                                }
                                                fclose($input);        
                                            }
                                        }    
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            <!-- /. ROW  -->
        </div>               
    </div>
    <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
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
