<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
	header('Location: login.php');
}
if($_SESSION['role']!=1){
		header('Location: login.php');
}
if ($_POST){
	
	if(empty($_POST['title']) ||  empty($_POST['content']) || empty($_FILES['image'])){

		if(empty($_POST['title'])){
			$titleError='Title cannot be null';
		}
		if(empty($_POST['content'])){
			$contentError='Content cannot be null';
		}
		if(empty($_FILES['image'])){
			$imageError='Image cannot be null';
		}
	}else{

		$file= "images/" .($_FILES['image']['name']);
		$imageType=pathinfo($file,PATHINFO_EXTENSION);
		if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg' ){
			echo  "<script>alert('Image Extension must be jpeg,jpg,png')</script>";
		}else{
			move_uploaded_file($_FILES['image']['tmp_name'],$file);
			$title=$_POST['title'];
			$content=$_POST['content'];
			$image=$_FILES['image']['name'];
			$stmt=	$pdo->prepare("INSERT INTO posts (title,content,image,author_id) VALUES (:title,:content,:image,:author_id)");
			$result=$stmt->execute(
			array(':title'=>$title,
				  ':content'=>$content,
				  ':image'=>$image,
				  ':author_id'=>$_SESSION['user_id']
				 )
			);
			if($result){
				echo  "<script>alert('Your Post is added to the Blog');window.location.href='index.php';</script>";

			}
		}
	}
}

?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Blog</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
	  <ul class="navbar-nav ml-auto">
	   
	  </ul>

   
  
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user_name']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Blogs
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-">BLOGGER MM</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>-->
				
            </ol>
          </div> <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
         <div class="col-md-12">
            
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">What's on your mind?</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="" action="add.php" method="POST" enctype="multipart/form-data">
				 <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label><p style="color: red"><?php echo empty($titleError)? '': '*'. $titleError; ?></p>
                    <input type="text" class="form-control" name="title" placeholder="Title"  >
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label><p style="color: red"><?php echo empty($contentError)? '': '*'.$contentError; ?></p>
                    <input type="text" class="form-control" name="content" placeholder="" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label><p style="color: red"><?php echo empty($imageError)? '': '*'.$imageError; ?></p>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" required>
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                      
                    </div>
                  </div>
					<!--<div class="form-group">
					<label for="image">Photo</label><br>
					<input type="file" name="image" value="" required>
					</div>-->
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="Submit">
					   <a href="index.php" type="button" class="btn btn-secondary">Back</a>
                </div>
              </form>
            </div>

            
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 
<footer class="main-footer">
    
   <div class="float-right d-none d-sm-inline">
	  <a href="logout.php" type="button" class="btn btn-danger">
		  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg>Logout
		  </a>	 
	  </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021-2022<a href="https://www.facebook.com/jeremie7577"> HeinHtetKyaw</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>