<?php
session_start();
require '../config/config.php';
require '../config/common.php';
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
	header('Location: login.php');}
if($_SESSION['role']!=1){
		header('Location: login.php');
}

 if($_POST){
	 if(empty($_POST['name']) ||  empty($_POST['email'])  ){
		
		if(empty($_POST['name'])){
			$nameError='Title cannot be null';
		}
		if(empty($_POST['email'])){
			$emailError='Content cannot be null';
		}
		
		 
		 
		 
	}elseif(!empty($_POST['password']) && strlen($_POST['password'])<6){
		 $passwordError= 'Password Should be 5 characters at least';
	 }
	 else{
	 $id= $_POST['id'];
	 $name= $_POST['name'];
	$password=password_hash( $_POST['password'],PASSWORD_DEFAULT);
	 $email= $_POST['email'];
	 
	 if(empty($_POST['role'])){
		 $role=0;
	 }
	 else{
		 $role=1;
	 }
	 
	$stmt= $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
	$stmt->execute(array(':email'=>$email, ':id'=>$id));
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
	if($user){
		echo "<script>alert('Email already registered')</script>";
	}else{
		if($password!=null){
			$stmt=	$pdo->prepare("UPDATE users SET name='$name', email='$email',password='$password',role='$role' WHERE id='$id'");

		}else{
		$stmt=	$pdo->prepare("UPDATE users SET name='$name', email='$email',role='$role' WHERE id='$id'");

		}
		$result=$stmt->execute();
		if($result){
			echo  "<script>alert('Successfully Updated');window.location.href='users.php';</script>";
			
		}
	}
		 
	 }
	
 }
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();

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
    <form class="form-inline ml-3" action="index.php" method="post">
      <div class="input-group input-group-sm">
        <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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
    <a href="index.php" class="brand-link">
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
            <a href="index.php" class="nav-link">
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
				<!--<a href="add.php" type="button" class="btn btn-success"><i class="fa fa-plus">   </i> Create Posts</a>-->
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
              <form action="" method="post">
				   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
				  <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                <div class="form-group">
                    <label for="">Name</label><p style="color: red"><?php echo empty($nameError)? '': '*'.$nameError; ?></p>
                    <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name']; ?>">
                </div>
                <div class="form-group">
                    <label for="">Email</label><p style="color: red"><?php echo empty($emailError)? '': '*'.$emailError; ?></p>
                    <input type="email" class="form-control" name="email" value="<?php echo $result[0]['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="">Password</label><p style="color: red"><?php echo empty($passwordError)? '': '*'.$passwordError; ?></p>
                    <input type="password" class="form-control" name="password" value=""><span>This user already has password </span>
                </div>
                <div class="form-check mb-3">
					<input type="checkbox" name="role" value="1" <?php echo $result[0]['role'] == 1 ? 'checked':''?>>
                  <label class="form-check-label"> : Check Users will be ADMIN</label>
                </div>
                <input type="submit" class="btn btn-success">
                <a href="users.php" class="btn btn-warning">Back</a>
            </form>
           


           
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