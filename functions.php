<?php

//Recebe uma string e insere os pontos e barras nos CPF e CNPJ
function formatar_cpf_cnpj($doc) {
    $doc = preg_replace("/[^0-9]/", "", $doc);
    $qtd = strlen($doc);

    if($qtd >= 11) {
        if($qtd === 11 ) {
            $docFormatado = substr($doc, 0, 3) . '.' .
            substr($doc, 3, 3) . '.' .
            substr($doc, 6, 3) . '.' .
            substr($doc, 9, 2);
        } else {
            $docFormatado = substr($doc, 0, 2) . '.' .
            substr($doc, 2, 3) . '.' .
            substr($doc, 5, 3) . '/' .
            substr($doc, 8, 4) . '-' .
            substr($doc, -2);
        }
        return $docFormatado;
    } else {
        return 'Documento invalido';
    }
}

//recebe um valor em float e apresenta em Real
function formatReal($val){
    //$val = str_replace(".", ",", $val);
    $val = number_format($val, 2, ',', '.');
    return 'R$ '.$val;
}

//recebe um float e apresenta em real, sem o R$
function floatValue($val){
    $val = str_replace(",",".",$val);
    $val = preg_replace('/\.(?=.*\.)/', '', $val);
    return floatval($val);
}

//apaga arquivos de uma pasta
function ApagaDir($dir) {
  if($objs = glob($dir."/*")){
    foreach($objs as $obj) {
      is_dir($obj)? ApagaDir($obj) : unlink($obj);
    }
  }
  //rmdir($dir);
} 

//recebe uma data e retorna 1 se existe o arquivo correspondente na pasta final e 0 se não
function existeData($data, $cnpj) {
    $path = "./final/";
    $diretorio = dir($path);

    //echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
    while($arquivo = $diretorio -> read()) 
        if(str_starts_with($arquivo, 'data')) 
            if((substr($arquivo, 20, 6) == $data) && (substr($arquivo, 5, 14) == $cnpj))
                return 1;
    return 0;
}

//recebe uma data e retorna 1 se existe um arquivo correspondente ao ano na pasta final e 0 se não
function existeAno($data) {
    $path = "./final/";
    $diretorio = dir($path);

    //echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
    while($arquivo = $diretorio -> read()) 
        if(str_starts_with($arquivo, 'data')) 
            if(substr($arquivo, 22, 4) == $data)
                return 1;
    return 0;
}

?>