<!DOCTYPE html>

<?php include 'functions.php';?>
<?php include 'parser.php';?>
<?php include 'parserData.php';?>

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
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Upload de arquivos XXX
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">

<?php
 
// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = './uploads/';
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 10; // 2Mb
 // Array com as extensões permitidas
$_UP['extensoes'] = array('txt', 'php');
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = false;
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
 
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
    die("<h3>Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']].'</h3>');
    exit; // Para a execução do script
}
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

// Faz a verificação da extensão do arquivo
//$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
//if (array_search($extensao, $_UP['extensoes']) == false) {
//  echo "Por favor, envie arquivos com as seguintes extensões: txt ou php";
//}
    
// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
    echo "<h3>O arquivo enviado é muito grande, envie arquivos de até 4Mb.</h3>";
}
 
// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
    // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
    $nome_final = time().'.txt';
} else {
// Mantém o nome original do arquivo
$nome_final = $_FILES['arquivo']['name'];
}

// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
    echo "<h3>Upload efetuado com sucesso!</h3>";
    echo '<br /><h4><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a></h4>';
} else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
    echo "<h3>Não foi possível enviar o arquivo, tente novamente.</h3>";
}
 
}
?>

                                    </div>
                                </div>
                            </div>
                        </div>
                     <!-- End Form Elements -->
                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <!--h3>Parser</h3>
                         <p> </p-->
                         <?php parserData();?>
                    </div>
                </div>
                <!-- /. ROW  -->
            </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>

     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
