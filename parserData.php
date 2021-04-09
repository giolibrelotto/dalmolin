<?php

	//include 'functions.php';

	function parserData() {

	$path = "./uploads/";
	$diretorio = dir($path);

	//echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
	while($arquivo = $diretorio -> read()) {
		//echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
		//echo 'Leitura do arquivo de entrada  - '.$path.$arquivo.'<br /><br />';

		if (($arquivo != '.') && ($arquivo != '..')) {
			// Abre o Arquivo no Modo r (para leitura)
			$input = fopen($path.$arquivo, 'r');
			$linha = fgets($input, 1024);
			$campos = explode('|', $linha);
		    // buscar dados da empresa - nome e CNPJ
			$empresa = $campos[6];
			$cnpj = substr($campos[7], 0, 14);
			$data = substr($campos[4], 2, 6);

			if($input){
				// Abre o Arquivo no Modo w (para escrita)
				$output = fopen ('./temp/temp1-'.$cnpj.'-'.$data.'.txt', 'w');
			    // Lê o conteúdo do arquivo
			    while(!feof($input)) {		        
			        //se linha começa com 1, printar
			        if((str_starts_with($linha , "|0000"))  || (str_starts_with($linha , "|C100")) || (str_starts_with($linha , "|C190|020|5102")) || (str_starts_with($linha , "|C190|520|5102")) || (str_starts_with($linha , "|C190|040|5102")) || (str_starts_with($linha , "|C190|020|5117")) || (str_starts_with($linha , "|C190|040|5117")) || (str_starts_with($linha , "|C190|520|5117"))) {
			            //echo $linha.'<br />';
			            fwrite($output, $linha);
			        }
		   			$linha = fgets($input, 1024);
			    }
			    // Fecha arquivo aberto
			    fclose($input);
			    fclose($output);
			    //echo 'Arquivo temp1.txt gerado <br /><br />';
			}

			//eliminar as C100 que não tem C190 na sequencia
			$input = fopen('./temp/temp1-'.$cnpj.'-'.$data.'.txt', 'r');
			$output = fopen ('./temp/temp2-'.$cnpj.'-'.$data.'.txt', 'w');

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
			        else {
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
			$input = fopen('./temp/temp2-'.$cnpj.'-'.$data.'.txt', 'r');

			if($input){
				$output = fopen ('./temp/temp3-'.$cnpj.'-'.$data.'.txt', 'w');
				// copiar a primeira linha - 0000
			    $linha = fgets($input, 1024);
			    fwrite($output, $linha);

			    // CNPJ rais
			    $cnpjRaiz = substr($cnpj, 0, 8);
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
						if($cnpjRaiz == $cnpj_nota) {
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
			$input = fopen('./temp/temp3-'.$cnpj.'-'.$data.'.txt', 'r');

			if($input){
			    $output = fopen('./final/out-'.$cnpj.'-'.$data.'.txt', 'w');

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
			//gerar os arquivos data, com o resumo da empresa
			
			$input = fopen('./final/out-'.$cnpj.'-'.$data.'.txt', 'r');
			if($input){
				$output = fopen('./final/data-'.$cnpj.'-'.$data.'.txt', 'w');
				// copiar a primeira linha - 0000
			    $linha = fgets($input, 1024);
			    //echo 'Empresa = '.$empresa.'. CNPJ = '.$cnpj.'</br>';
			    fwrite($output, $empresa);
			    fwrite($output, "\n");
			    fwrite($output, $cnpj);
			    fwrite($output, "\n");
			    fwrite($output, $data);
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


			//array com todos os CFOP e CST que interessam
			$cfop = array("5101", "5102", "5103", "5104", "5105", "5106", "5109", "5110", "5111", "5112", "5113", "5114", "5115", "5116", "5117", "5118", "5119", "5120", "5122", "5123", "5129", "5651", "5652", "5653", "5654", "5655", "5656", "5667", "5910", "6910", "6100", "6101", "6102", "6103", "6104", "6105", "6106", "6107", "6108", "6109", "6110", "6111", "6112", "6113", "6114", "6115", "6116", "6117", "6118", "6119", "6120", "6122", "6123", "6129", "6651", "6652", "6653", "6654", "6655", "6656", "6667");

			$cst = array("020", "040", "120", "140", "220", "240", "320", "340", "420", "440", "520", "540", "620", "640", "720", "740");

			$input = fopen('./final/out-'.$cnpj.'-'.$data.'.txt', 'r');
			if($input){
				$output = fopen('./final/dataNew-'.$cnpj.'-'.$data.'.txt', 'w');
				// copiar a primeira linha - 0000
			    $linha = fgets($input, 1024);
			    //echo 'Empresa = '.$empresa.'. CNPJ = '.$cnpj.'</br>';
			    fwrite($output, $empresa);
			    fwrite($output, "\n");
			    fwrite($output, $cnpj);
			    fwrite($output, "\n");
			    fwrite($output, $data);
			    fwrite($output, "\n");

			    // ler primeiro C100
			    $linha = fgets($input, 1024);

			    $combine = array();

			    //inicializar com todas as combinações de CFOP e CST e com os valores do vetor em 0 de VC e BC
			    foreach($cfop as $cfop_data) {
			 		foreach ($cst as $cst_data) {
			 			array_push($combine, array("CST" => $cst_data, "CFOP" => $cfop_data, "VC" => 0.0, "BC" => 0.0));
			 		}
			 	}

			 	//echo var_export($combine);
			    while(!feof($input)) {
					//se for produto de uma nota de mesmo CNPJ da empresa
					if(str_starts_with($linha, "|C190")) {
			            $campos = explode('|', $linha);

			            $i = 0;
						foreach ($combine as &$notas) {
						  if (($notas["CST"] == $campos[2]) && ($notas["CFOP"] == $campos[3])) {
						    $notas["VC"] += floatval($campos[5]);
						    $notas["BC"] += floatval($campos[6]);
						  }
						  $i++;
						}

			 	    }
			        $linha = fgets($input, 1024);
			    }
			    //var_dump($combine);

			    $total = 0.0;
				foreach ($combine as &$notas) {
					if ($notas["VC"] > 0) {
			    		if(str_contains($notas["CST"], '20')) {
			    			fwrite($output, '|C190|'.$notas["CST"].'|'.$notas["CFOP"].'|'.$notas["VC"].'|'.$notas["BC"].'|'.$notas["VC"]-$notas["BC"].'|17.5|'.number_format(($notas["VC"]-$notas["BC"])*0.175, 2, '.', ''));

			    			$total += (($notas["VC"] - $notas["BC"])*0.175); 
			    		}
			    		if(str_contains($notas["CST"], '40')) {
			    			fwrite($output, '|C190|'.$notas["CST"].'|'.$notas["CFOP"].'|'.$notas["VC"].'|'.$notas["BC"].'|'.$notas["VC"]-$notas["BC"].'|12|'.number_format(($notas["VC"]-$notas["BC"])*0.12, 2, '.', ''));

			    			$total += (($notas["VC"] - $notas["BC"])*0.12); 
			    		}
			    		fwrite($output, "\n");
						//var_dump($notas);
					}
				}
				fwrite($output, '|Total|'.number_format($total, 2, '.', ''));
				// Fecha arquivo aberto
			    fclose($input);
			    fclose($output);
			}
		}
	  }
	  $diretorio -> close();
	}

	parserData();

?>
