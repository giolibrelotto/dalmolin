<?php function tableData($cnpj,$year) { 

    $meses = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
?>
                <div class="col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><b><?php echo($year) ?></b></center>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">

                                <?php for ($i = 1; $i <= 12; $i++) { 
                                    if($i==1) 
                                        echo ('<li class="active"><a href="#D'.(str_pad($i, 2, '0', STR_PAD_LEFT).$year.'" data-toggle="tab">'));
                                    if($i>1) 
                                        echo ('<li class=""><a href="#D'.(str_pad($i, 2, '0', STR_PAD_LEFT).$year.'" data-toggle="tab">'));
                                    if(existeData(str_pad($i, 2, '0', STR_PAD_LEFT).$year, $cnpj))
                                        echo ('<b>'.$meses[$i].'</b>');
                                    else
                                        echo ($meses[$i]);
                                    echo ('</a></li>');
                                } ?> 
                            </ul>

                            <div class="tab-content">
                                <?php for ($i = 1; $i <= 12; $i++) { 
                                    if($i==1) 
                                        echo ('<div class="tab-pane fade active in" id="D01'.($year).'">');
                                    if($i>1) 
                                        echo ('<div class="tab-pane fade" id="D'.(str_pad($i, 2, '0', STR_PAD_LEFT).($year).'">'));
                                       
                                    table_month("-".$cnpj."-".str_pad($i, 2, '0', STR_PAD_LEFT).$year.".txt"); 
                                    //echo ("-".$cnpj."-".$i.$year.".txt"); 
                                    echo ("</div>");
                                } ?> 
                            </div>
                        </div>
                    </div>
                </div>

<?php
} 
?>
