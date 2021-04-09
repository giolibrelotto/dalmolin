<?php 

function table_month($month) {

    echo '                       <!-- Advanced Tables -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">';
                                                //echo $month;
                                                $total = 0;
                                                if(($input = @fopen('./final/data'.$month, 'r')) !== FALSE){
                                                    while(!feof($input))
                                                    {
                                                        $linha = fgets($input, 1024);
                                                        $campos = explode('|', $linha);
                                                        //se for linha com C100
                                                        //se for linha com C190
                                                        if(str_starts_with($linha , "|Total")) {
                                                            $total = $campos[2];
                                                        }
                                                    }
                                                    // Fecha arquivo aberto
                                                    fclose($input);
                                                }

                                                echo '<div class="panel-heading">
                                                        <center><b>Total = '.formatReal($total).'</b></center>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table  table-bordered ">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="text-align:center;">CFOP</th><th style="text-align:center;">CST</th><th style="text-align:center;">Tributação</th><th style="text-align:center;">Alíquota</th><th style="text-align:center;">Valor Contábil</th><th style="text-align:center;">Base ICMS Red</th><th style="text-align:center;">Diferença</th><th style="text-align:center;">Alíquota</th><th style="text-align:center;">Subvenção</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';

                                                                if(($input = @fopen('./final/data'.$month, 'r')) !== FALSE){
                                                                    while(!feof($input))
                                                                    {
                                                                        $linha = fgets($input, 1024);
                                                                        $campos = explode('|', $linha);
                                                                        //se for linha com C100
                                                                        //se for linha com C190
                                                                        if(str_starts_with($linha , "|C190")) {
                                                                            echo '<tr class="odd gradeX"><td style="text-align:center;">'.$campos[3].'</td><td style="text-align:center;">'.$campos[2].'</td><td style="text-align:center;">Redução</td><td style="text-align:center;">'.$campos[7].'%</td><td style="text-align:right;">'.formatReal($campos[4]).'</td><td style="text-align:right;">'.formatReal($campos[5]).'</td><td style="text-align:right;">'.formatReal($campos[6]).'</td><td style="text-align:center;">'.$campos[7].'%</td><td style="text-align:right;">'.formatReal($campos[8]).'</td></tr>';
                                                                        }
                                                                    }
                                                                    // Fecha arquivo aberto
                                                                    fclose($input);
                                                                }

                                            echo '             </tbody>
                                                            </table>
                                                        </div>
                                                    </div>';
                                                
                                                echo '</div>
                                        </div>
                                    </div>
                                    <!--End Advanced Tables -->';     
}

?>
