<?php
 require 'config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
	header('Location: login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <h1 style="text-align: center">Blog</h1>
          <!--<div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Widgets</li>
            </ol>
          </div>-->
        </div>
     <!-- /.container-fluid -->
    </section>
	<?php
	  $stmt= $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
				$stmt->execute();
				$result= $stmt->fetchAll();
	  
	  ?>
    <!-- Main content -->
    <section class="content">
    <div class="row">
		 <?php
					  if ($result){
						  $i=1;
						  foreach ($result as $value){?>
			<div class="col-md-4">
            
            <div class="card card-widget">
              <div class="card-header">
				 <div style="text-align: center; float: none;" class="card-title">
				  <h4><?php echo $value['title']; ?></h4>
					  
				  </div>
              </div>
              
              <div class="card-body">
               <!-- <img class="img-fluid pad" src="dist/img/photo2.png" alt="Photo">-->
				<a href="blogDetail.php?id=<?php echo $value['id']; ?>" ><img class="img-fluid pad" src="admin/images/<?php echo $value['image'];?>" style="height: 300px !important"> </a>
                <p>I took this photo this morning. What do you guys think?</p>
              </div>
				
			</div>
            <!-- /.card -->
          </div>

							  <?php
							  $i++;
						  }
					  }
					  ?>
          
          <!-- /.col -->
     
		
        </div>
		
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0px !Important;">
    <div class="float-right d-none d-sm-block">
     <a href="logout.php" type="button" class="btn btn-danger">
		  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg>Logout
		  </a>
    </div>
        <strong>Copyright &copy; 2021-2022<a href="https://www.facebook.com/jeremie7577"> HeinHtetKyaw</a>.</strong> All rights reserved.

  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
