<?php 

//varrer todo os arquivos ./final/data*, e listar os CNPJ (pares) e nomes (impares) no array $empresasCNPJ
function listarEmpresas() {

    $path = "./final/";
    $diretorio = dir($path);

    $empresasCNPJ = array();
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
                fclose($input);

                $flagEmpresa = 0;
                foreach ($empresasCNPJ as $i) {
                    //echo $i;
                    if ($i == $cnpj)
                        $flagEmpresa = 1;
                }
                if ($flagEmpresa == 0) {
                    array_push($empresasCNPJ, $cnpj);              
                    array_push($empresasCNPJ, $empresa);              
                }
            }
        }
    }
    //print_r($empresasCNPJ);
    return ($empresasCNPJ);
}

//cria um link para cada empresa única encontrada pela função listarEmpresas()
function listaCNPJ() {

    $empCNPJ = listarEmpresas();
    //print_r($empCNPJ);
    $cnpj = '';
    foreach ($empCNPJ as $key => $i) { 
        if (!($key % 2)) 
            $cnpj = $i;
        else {
        ?>

        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><b><a href="indexNew?cnpjGlobal=<?php echo($cnpjGlobal)?>.php"><?php echo('CNPJ: '.$cnpj.' - '.$i) ?></a></b></center>
                </div>
            </div>
        </div>
<?php
        }
    }
}
?>
