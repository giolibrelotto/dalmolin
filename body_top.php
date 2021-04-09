                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <?php 
                            $path = "../parser/final/";
                            $diretorio = dir($path);
                            $empresa = '';
                            $cnpj='';
                            while($arquivo = $diretorio -> read()){
                                //processar apenas os arquivos data - resumo
                                if(str_starts_with($arquivo, 'data')) {
                                    if(($input = fopen($path.$arquivo, 'r')) !== FALSE) {
                                        //pegar o nome e cnpj da empresa
                                        $empresa = fgets($input, 1024);
                                        echo '<h2>'.$empresa.'</h2>';
                                        $cnpj = fgets($input, 1024);
                                        echo '<h3> CNPJ: '.formatar_cpf_cnpj($cnpj).'</h3>';
                                        break;
                                    }
                                }
                            }
                            ?>
                       </center>
                    </div>
                </div>