<?php
session_start();
require ('../config/config.php');
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
	header('Location: login.php');}
if($_SESSION['role']!=1){
		header('Location: login.php');
}
 if($_POST){
	 $name= $_POST['name'];
	  $password= $_POST['password'];
	  $email= $_POST['email'];
	 if(empty($_POST['role'])){
		 $role=0;
	 }
	 else{
		 $role=1;
	 }
	 	$stmt= $pdo->prepare("SELECT * FROM users WHERE email=:email");
	$stmt->bindValue(':email',$email);
	$stmt->execute();
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
	if($user){
		echo "<script>alert('Email already registered')</script>";
	}else{
		
		$stmt=	$pdo->prepare("INSERT INTO users (name,password,email,role) VALUES (:name,:password,:email,:role)");
		$result=$stmt->execute(
		array(':name'=>$name,
			  ':email'=>$email,
			  ':password'=>$password,
			  ':role'=>$role
			 )
		);
		if($result){
			echo  "<script>alert('Successfully registered, Please Login');window.location.href='login.php';</script>";
			
		}
	}
 }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
  <b>BLOG | Admin </b>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="user-add.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="name" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
         <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" class="form-check-input" name="role" value="1">
				<input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label class="form-check-label">
               User is <a href="#">ADMIN</a>?
              </label>
            </div>
          </div>-->
			 <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="role" value="1">
              <label for="agreeTerms">
               User will be <a href="#">ADMIN</a>?
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

     
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>