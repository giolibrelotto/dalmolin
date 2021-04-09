<!DOCTYPE html>

<?php include 'functions.php';?>
<?php include 'parser.php';?>

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
                                Arquivos removidos!
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--?php unlinkRecursive( 'temp', false ); ?-->
                                        <?php 
                                            ApagaDir("temp"); 
                                            ApagaDir("uploads"); 
                                            ApagaDir("final"); 
                                        ?>
                                        Foi.
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!-- End Form Elements -->
                    </div>
                </div>
                <!-- /. ROW  -->
                <!--div class="row">
                    <div class="col-md-12">
                         <?php parser();?>
                    </div>
                </div-->
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
