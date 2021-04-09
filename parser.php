<?php


function parser() {

$path = "./uploads/";
$diretorio = dir($path);

//echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
while($arquivo = $diretorio -> read()) {
	//echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
	//echo 'Leitura do arquivo de entrada  - '.$path.$arquivo.'<br /><br />';

	if (($arquivo != '.') && ($arquivo != '..')) {
		// Abre o Arquivo no Modo r (para leitura)
		$input = fopen ($path.$arquivo, 'r');

		if($input){
			// Abre o Arquivo no Modo w (para escrita)
			$output = fopen ('./temp/temp1'.$arquivo, 'w');
		    // Lê o conteúdo do arquivo
		    while(!feof($input)) {
		        //Mostra uma linha do arquivo
		        $linha = fgets($input, 1024);
		        //se linha começa com 1, printar
		        if((str_starts_with($linha , "|0000"))  || (str_starts_with($linha , "|C100")) || (str_starts_with($linha , "|C190|020|5102")) || (str_starts_with($linha , "|C190|520|5102")) || (str_starts_with($linha , "|C190|040|5102")) || (str_starts_with($linha , "|C190|020|5117")) || (str_starts_with($linha , "|C190|040|5117")) || (str_starts_with($linha , "|C190|520|5117"))) {
		            //echo $linha.'<br />';
		            fwrite($output, $linha);
		        }
		    }
		    // Fecha arquivo aberto
		    fclose($input);
		    fclose($output);
		    //echo 'Arquivo temp1.txt gerado <br /><br />';
		}

		//eliminar as C100 que não tem C190 na sequencia
		$input = fopen('./temp/temp1'.$arquivo, 'r');
		$output = fopen ('./temp/temp2'.$arquivo, 'w');

		if($input){
			// copiar a primeira linha - 0000
		    $linha1 = fgets($input, 1024);
		    fwrite($output, $linha1);

		    $linha1 = fgets($input, 1024);
		    $nota = TRUE;
		    while(!feof($input))
		    {
		        //Mostra uma linha do arquivo
		        $linha2 = fgets($input, 1024);
		        if((str_starts_with($linha2 , "|C100")) && ($nota==TRUE)) {
		            $linha1 = $linha2;    
		        }
		        else{
		            if((str_starts_with($linha2 , "|C100")) && ($nota==FALSE)) {
		                $nota = TRUE;
		                $linha1 = $linha2;    
		            }
		            else {
		                if(($nota == TRUE) && (strlen($linha1))>0) {
		                    fwrite($output, $linha1);
		                    $nota = FALSE;
		                }
		                if(!(str_starts_with($linha2 , "|C100")) && (strlen($linha2))>0) {
		                    fwrite($output, $linha2);
		                }
		                $linha1 = $linha2;
		            }
		        }
		    }
		    // Fecha arquivo aberto
		    fclose($input);
		    fclose($output);
			//echo 'Arquivo temp2.txt gerado <br /><br />';
		}

		//eliminar as C100 que não o mesmo CNPJ da empresa
		$input = fopen('./temp/temp2'.$arquivo, 'r');
		$output = fopen ('./temp/temp3'.$arquivo, 'w');

		if($input){
			// copiar a primeira linha - 0000
		    $linha = fgets($input, 1024);
		    fwrite($output, $linha);

		    // buscar dados da empresa - nome e CNPJ
			$campos = explode('|', $linha);
			$empresa = $campos[6];
		    $cnpj = substr($campos[7], 0, 8);
		    //echo 'Empresa = '.$empresa.'. CNPJ = '.$cnpj.'</br>';

		    // ler primeiro C100
		    $linha = fgets($input, 1024);

		 	//total de notas no arquivo  
		    $total_notas = 0;
		    //total de notas do mesmo CNPJ
		    $total_notas_cnpj = 0;
		    //total de notas na saída
		    $total_notas_output = 0;
		    //linha do arquivo de entrada
		    $line=2;
		    //0 - nota não vai pra saída / 1 - vai para a saída, pois é do mesmo CNPJ
		    $nota_output=0;
		    while(!feof($input)) {
		    	//se for nota C100 do mesmo CNPJ
				if(str_starts_with($linha, "|C100")) {
			        // buscar o CNPJ de cada nota C100
					$campos = explode('|', $linha);
					$cnpj_nota = substr($campos[9],6,8);
					// se eh uma nota fical - C100 e o CNPJ da nota é igual o da empresa
					if($cnpj == $cnpj_nota) {
						//copia C100 para saída
			            fwrite($output, $linha);
		                //confirma que eh nota de saída
						$nota_output=1;
						$total_notas_cnpj++;
					}
					else
						$nota_output=0;
					$total_notas++;
					//echo '</br>CNPJ da empresa = '.$cnpj.' e CNPJ da nota = '.$cnpj_nota.' da linha '.$line.' e nota_output = '.$nota_output.'</br>';
				}
				//se for produto de uma nota de mesmo CNPJ da empresa
				if(str_starts_with($linha, "|C190")) {
		            if($nota_output)
		            	fwrite($output, $linha);
		 	    }
			    if(!(str_starts_with($linha, "|C190")) && !(str_starts_with($linha, "|C100"))){
			    	echo '</br>ERRO = '.$linha.'</br>'; 
			    }
		        $linha = fgets($input, 1024);
		        $line++;
		        //echo $linha;
		    }
		    // Fecha arquivo aberto
		    fclose($input);
		    fclose($output);
			//echo 'Arquivo temp3.txt gerado <br />. total_notas = '.$total_notas.'. total_notas_cnpj = '.$total_notas_cnpj.'.<br/> total_notas_output = '.$total_notas_output.'.<br/><br/>';
		}

		//formatar os floats BR para float US
		$input = fopen('./temp/temp3'.$arquivo, 'r');
		$output = fopen ('./final/out'.$arquivo, 'w');

		if($input){
		    // copiar primeira linha - 0000
		    $linha = fgets($input, 1024);
		    fwrite($output, $linha);

		    $linha = fgets($input, 1024);
		    while(!feof($input))
		    {
		        $campos = explode('|', $linha);
		        fwrite($output, '|');
		        if(str_starts_with($linha , "|C100")) {
		            for($i = 1; $i <= 29; $i++) {
		                if($i<12) {
		                    fwrite($output, $campos[$i]);
		                    fwrite($output, '|');
		                    //echo $campos[$i].'|';
		                }
		                else {
		                    fwrite($output, floatValue($campos[$i]));
		                    fwrite($output, '|');
		                    //echo floatValue($campos[$i]).'|';                    
		                }
		            }
		        }
		        else {
		            for($i = 1; $i <= 12; $i++) {
		                if($i<4) {
		                    fwrite($output, $campos[$i]);
		                    fwrite($output, '|');
		                }
		                else {
		                    fwrite($output, floatValue($campos[$i]));
		                    fwrite($output, '|');		                    
		                }
		            }
		        }
		        fwrite($output, "\n");
		        $linha = fgets($input, 1024);
		    }
		    // Fecha arquivo aberto
		    fclose($input);
		    fclose($output);
			//echo 'Arquivo output.txt gerado <br /><br />';
		}

		//eliminar as C100 que não o mesmo CNPJ da empresa
		$input = fopen('./final/out'.$arquivo, 'r');
		$output = fopen ('./final/data'.$arquivo, 'w');
		if($input){
			// copiar a primeira linha - 0000
		    $linha = fgets($input, 1024);

		    // buscar dados da empresa - nome e CNPJ
			$campos = explode('|', $linha);
			$empresa = $campos[6];
		    $cnpj = substr($campos[7], 0, 14);
		    //echo 'Empresa = '.$empresa.'. CNPJ = '.$cnpj.'</br>';
		    fwrite($output, $empresa);
		    fwrite($output, "\n");
		    fwrite($output, $cnpj);
		    fwrite($output, "\n");

		    // ler primeiro C100
		    $linha = fgets($input, 1024);

		    //acumuladores dos Valor Contábil de mesmo tipo
		    $vc_020_5102 = 0;
		    $vc_520_5102 = 0;
		    $vc_040_5102 = 0;
		    $vc_020_5117 = 0;
		    $vc_520_5117 = 0;
		    $vc_040_5117 = 0;

		    //acumuladores dos Base Contábil de mesmo tipo
		    $bc_020_5102 = 0;
		    $bc_520_5102 = 0;
		    $bc_040_5102 = 0;
		    $bc_020_5117 = 0;
		    $bc_520_5117 = 0;
		    $bc_040_5117 = 0;
		 
		    while(!feof($input)) {
				//se for produto de uma nota de mesmo CNPJ da empresa
				if(str_starts_with($linha, "|C190")) {
		            $campos = explode('|', $linha);
		            if(str_starts_with($linha, "|C190|020|5102|")) {
		            	$vc_020_5102+=floatval($campos[5]);
		            	$bc_020_5102+=floatval($campos[6]);            	
		            }
		            if(str_starts_with($linha, "|C190|520|5102|")) {
		            	$vc_520_5102+=floatval($campos[5]);
		            	$bc_520_5102+=floatval($campos[6]);
		            }
		            if(str_starts_with($linha, "|C190|040|5102|")) {
		            	$vc_040_5102+=floatval($campos[5]);
		            	$bc_040_5102+=floatval($campos[6]);
		            }
		            if(str_starts_with($linha, "|C190|020|5117|")) {
		            	$vc_020_5117+=floatval($campos[5]);
		            	$bc_020_5117+=floatval($campos[6]);
		            }
		            if(str_starts_with($linha, "|C190|520|5117|")) {
		            	$vc_520_5117+=floatval($campos[5]);
		            	$bc_520_5117+=floatval($campos[6]);
		            }
		            if(str_starts_with($linha, "|C190|040|5117|")) {
		            	$vc_040_5117+=floatval($campos[5]);
		            	$bc_040_5117+=floatval($campos[6]);            
		            }
		 	    }
		        $linha = fgets($input, 1024);
		    }

			fwrite($output, '|C190|020|5102|'.$vc_020_5102.'|'.$bc_020_5102.'|'.$vc_020_5102-$bc_020_5102.'|17.5|'.number_format(($vc_020_5102-$bc_020_5102)*0.175, 2, '.', ''));
		    fwrite($output, "\n");
			fwrite($output, '|C190|520|5102|'.$vc_520_5102.'|'.$bc_520_5102.'|'.$vc_520_5102-$bc_520_5102.'|17.5|'.number_format(($vc_520_5102-$bc_520_5102)*0.175, 2, '.', ''));
		    fwrite($output, "\n");
			fwrite($output, '|C190|040|5102|'.$vc_040_5102.'|'.$bc_040_5102.'|'.$vc_040_5102-$bc_040_5102.'|12|'.number_format(($vc_040_5102-$bc_040_5102)*0.12, 2, '.', ''));
		    fwrite($output, "\n");
			fwrite($output, '|C190|020|5117|'.$vc_020_5117.'|'.$bc_020_5117.'|'.$vc_020_5117-$bc_020_5117.'|17.5|'.number_format(($vc_020_5117-$bc_020_5117)*0.175, 2, '.', ''));
		    fwrite($output, "\n");
			fwrite($output, '|C190|520|5117|'.$vc_520_5117.'|'.$bc_520_5117.'|'.$vc_520_5117-$bc_520_5117.'|17.5|'.number_format(($vc_520_5117-$bc_520_5117)*0.175, 2, '.', ''));
		    fwrite($output, "\n");
			fwrite($output, '|C190|040|5117|'.$vc_040_5117.'|'.$bc_040_5117.'|'.$vc_040_5117-$bc_040_5117.'|12|'.number_format(($vc_040_5117-$bc_040_5117)*0.12, 2, '.', ''));
		    fwrite($output, "\n");
			fwrite($output, '|Total|'.number_format(($vc_020_5102-$bc_020_5102)*0.175 + ($vc_520_5102-$bc_520_5102)*0.175 + ($vc_040_5102-$bc_040_5102)*0.12 + ($vc_020_5117-$bc_020_5117)*0.175 + ($vc_040_5117-$bc_040_5117)*0.12, 2, '.', ''));

		    // Fecha arquivo aberto
		    fclose($input);
		    fclose($output);
			//echo 'Arquivo data.txt gerado <br />.';
		}
	}
  }
  $diretorio -> close();

}

?>