<?php
 require 'config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
	header('Location: login.php');
}
$stmt=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();

$blogId=$_GET['id'];
$stmtcmt=$pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
$stmtcmt->execute();
$cmResult=$stmtcmt->fetchAll();
$auResult=[];
if($cmResult){
	foreach($cmResult as $key=>$value){
$authorId= $cmResult[$key]['author_id'];
$stmtau=$pdo->prepare("SELECT * FROM users WHERE id=$authorId");
$stmtau->execute();
$auResult[]=$stmtau->fetchAll();
	}

}
if($_POST){
	$comment=$_POST['comment'];

	
		
		$stmt=	$pdo->prepare("INSERT INTO comments (content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
		$result=$stmt->execute(
		array(':content'=>$comment,
			  ':author_id'=>$_SESSION['user_id'],
			  ':post_id'=>$blogId
			 )
		);
		if($result){
				header('Location: blogDetail.php?id='.$blogId);
			
		}
	
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | <?php echo $result[0]['title']; ?> </title>
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
  <div class="content-wrapper" style="margin-left: 0px !important">
    

    <!-- Main content -->
    <section class="content">
		<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active"> <?php echo $result[0]['title']; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="row">
          <div class="col-md-12" >
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
               
                <div style="text-align: center; float: none;" class="card-title">
				  <h4><?php echo $result[0]['title']; ?></h4>
					  
				  </div>
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image'];?>" alt="Photo" style="height: auto !important">
				<br><br>
                <p style="font-size: 18px;"><?php echo $result[0]['content']; ?></p>
				  <hr>
				  <h4>Comments</h4><hr>
              </div>
              
              <div class="card-footer card-comments">
                
                <?php
				  if($cmResult){  ?>
				<div class="card-comment">
				  <div class="comment-text" style="margin-left: 0px !important">
					<?php
					foreach ($cmResult as $key=>$value){?>
					 <span class="username">
					<?php echo $auResult[$key][0]['name'] ;?>
                     <span class="text-muted float-right"><?php echo $value['created_at']; ?></span>
                    </span><!-- /.username -->
                    <?php echo $value['content']; ?>
 
				<?php	}
					  
					  ?>
                  </div>
                  <!-- /.comment-text -->
                </div>
				  <?php
				  }
				  ?>
                
               
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          
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
