        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Dalmolin</a> 
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"> 
                Último acesso: <?php date_default_timezone_set('UTC'); 
                date_default_timezone_set('America/Sao_Paulo');
                echo date('l jS \of F Y h:i:s A');?> &nbsp; 
                <a href="#" class="btn btn-danger square-btn-adjust">Logout</a> 
            </div>
        </nav>   
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
    				<li class="text-center">
                        <!--img src="assets/img/find_user.png" class="user-image img-responsive"/-->
                        <img src="assets/img/dalmolin.png" class="user-image img-responsive"/>
					</li>
                    <li>
                        <a class="active-menu"  href="index.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="table.php"><i class="fa fa-table fa-3x"></i> Tabela com os Produtos</a>
                    </li>
                    <li>
                        <a href="file_upload.php"><i class="fa fa-upload fa-3x"></i> Upload de Arquivos</a>
                    </li>
                    <li>
                        <a href="clearData.php"><i class="fa fa-archive fa-3x"></i> Limpar Dados</a>
                    </li>
                </ul>               
            </div>            
        </nav>