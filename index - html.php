<?php

include('table_month.php');
include('formatar_cpf_cnpj.php');

// Initialize the session
/*session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}*/

/*function formatReal($real){
  return 'R$ '.sprintf('%0.2f', $real);
}*/

function formatReal($val){
    $val = str_replace(".", ",", $val);
    return 'R$ '.$val;
}

echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dalmolin : Admin</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Dalmolin</a> 
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"> Último acesso: 26 de Março de 2021 &nbsp; <a href="../logout.php" class="btn btn-danger ml-3">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->';
            
//buscar nos arquivos dataXXX o somatório dos valores
$path = "../parser/final/";
$diretorio = dir($path);

$empresa = '';
$cnpj='';
$meses=0;
$total=0;

//echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
while($arquivo = $diretorio -> read()){
    //echo 'Leitura do arquivo de entrada  - '.$path.$arquivo.'<br /><br />';

    //processar apenas os arquivos data - resumo
    if(str_starts_with($arquivo, 'data')) {
        // Abre o Arquivo no Modo r (para leitura)

        if(($input = fopen($path.$arquivo, 'r')) !== FALSE){
            //pegar o nome e cnpj da empresa
            $empresa = fgets($input, 1024);
            $cnpj = fgets($input, 1024);
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

echo  '<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                <li class="text-center">
                    <img src="assets/img/find_user.png" class="user-image img-responsive"/>
                    </li>
                    <li>
                        <a  class="active-menu"  href="index.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a  href="table.php"><i class="fa fa-table fa-3x"></i> Tabela com as Notas</a>
                    </li>
                    <li>
                        <a  href="file_upload.php"><i class="fa fa-upload fa-3x"></i> Upload de Arquivos</a>
                    </li>
                </ul>
            </div>
        </nav>';

echo '<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <center>
                       <h2>'.$empresa.'</h2>   
                       <h3> CNPJ '.formatar_cpf_cnpj($cnpj).'</h3>
                    </center>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-envelope-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">'.$empresa.'</p>
                    <p class="text-muted">Empresa</p>
                </div>
             </div>
             </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">'.$cnpj.'</p>
                    <p class="text-muted">CNPJ</p>
                </div>
             </div>
             </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">'.$meses.'</p>
                    <p class="text-muted">Meses processados</p>
                </div>
             </div>
             </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-rocket"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">'.formatReal($total).'</p>
                    <p class="text-muted">Total em subvenção</p>
                </div>
             </div>
             </div>
            </div>';

echo '                 <!-- /. ROW  -->
                <hr />                
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            2021
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#Jan2021" data-toggle="tab">Janeiro</a>
                                </li>
                                <li class=""><a href="#Fev2021" data-toggle="tab">Fevereiro</a>
                                </li>
                                <li class=""><a href="#Mar2021" data-toggle="tab">Março</a>
                                </li>
                                <li class=""><a href="#Abr2021" data-toggle="tab">Abril</a>
                                </li>
                                <li class=""><a href="#Mai2021" data-toggle="tab">Maio</a>
                                </li>
                                <li class=""><a href="#Jun2021" data-toggle="tab">Junho</a>
                                </li>
                                <li class=""><a href="#Jul2021" data-toggle="tab">Julho</a>
                                </li>
                                <li class=""><a href="#Ago2021" data-toggle="tab">Agosto</a>
                                </li>
                                <li class=""><a href="#Set2021" data-toggle="tab">Setembro</a>
                                </li>
                                <li class=""><a href="#Out" data-toggle="tab">Outubro</a>
                                </li>
                                <li class=""><a href="#Nov2021" data-toggle="tab">Novembro</a>
                                </li>
                                <li class=""><a href="#Dez2021" data-toggle="tab">Dezembro</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="Jan2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-jan2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Fev2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-fev2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Mar2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-mar2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Abr2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-abr2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Mai2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-mai2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Jun2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-jun2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Jul2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-jul2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Ago2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-ago2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Set2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-set2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Out2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-out2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Nov2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-nov2021.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Dez2021">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-dez2021.txt');
                                echo '</div>
                            </div>
                        </div>
                    </div>
                </div>';

echo '                 <!-- /. ROW  -->
                             
            <!--div class="row"-->
                <div class="col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            2020
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#Jan" data-toggle="tab">Janeiro</a>
                                </li>
                                <li class=""><a href="#Fev" data-toggle="tab">Fevereiro</a>
                                </li>
                                <li class=""><a href="#Mar" data-toggle="tab">Março</a>
                                </li>
                                <li class=""><a href="#Abr" data-toggle="tab">Abril</a>
                                </li>
                                <li class=""><a href="#Mai" data-toggle="tab">Maio</a>
                                </li>
                                <li class=""><a href="#Jun" data-toggle="tab">Junho</a>
                                </li>
                                <li class=""><a href="#Jul" data-toggle="tab">Julho</a>
                                </li>
                                <li class=""><a href="#Ago" data-toggle="tab">Agosto</a>
                                </li>
                                <li class=""><a href="#Set" data-toggle="tab">Setembro</a>
                                </li>
                                <li class=""><a href="#Out" data-toggle="tab">Outubro</a>
                                </li>
                                <li class=""><a href="#Nov" data-toggle="tab">Novembro</a>
                                </li>
                                <li class=""><a href="#Dez" data-toggle="tab">Dezembro</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="Jan">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-jan2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Fev">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-fev2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Mar">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-mar2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Abr">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-abr2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Mai">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-mai2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Jun">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-jun2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Jul">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-jul2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Ago">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-ago2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Set">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-set2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Out">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-out2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Nov">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-nov2020.txt');
                                echo '</div>
                                <div class="tab-pane fade" id="Dez">';
                                    table_month('SpedEFD-88579701000178-0650024230-Remessa de arquivo original-dez2020.txt');
                                echo '</div>
                            </div>
                        </div>
                    </div>
                <!--/div-->';


echo '   
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
</html>';

?>
