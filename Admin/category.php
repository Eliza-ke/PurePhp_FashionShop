<?php 

session_start();
require '../config/config.php';
require '../config/common.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
}
if($_SESSION['role'] != 1){
  header('location: login.php');
}
if(!empty($_POST['search'])){
  setcookie('search',$_POST['search'],time() + (84600 * 30),"/");
}else{
  //remove cookie when pageno is empty because first time page cannot contain pageno and click pagination next or last, it will set pageno.
  if(empty($_GET['pageno'])) { 
    unset($_COOKIE['search']);
    setcookie('search',null,-1 ,'/');
  }
}

if(!empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}
$numOfrecs = 5;
$offset = ($pageno - 1) * $numOfrecs;

if(empty($_POST['search']) && empty($_COOKIE['search'])){

    $stmt =$pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
    $stmt->execute();
    $rawresult = $stmt->fetchAll();

    $total_pages = ceil(count($rawresult) / $numOfrecs);
   
    $stmt =$pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();

  }else{
    if(!empty($_POST['search'])){
        $searchKey = $_POST['search'] ;
    }else {
        $searchKey = $_COOKIE['search'];
      }                    
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
  $stmt->execute();
  $rawresult = $stmt->fetchAll();

  $total_pages = ceil(count($rawresult) / $numOfrecs);
   
  $stmt =$pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
  $stmt->execute();
  $result = $stmt->fetchAll();
  
  } 
?>

<?php include('header.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Category</h3>
              </div>
               
              <div class="card-body">
                <!-- /Create new blog button -->
                <div style="margin-bottom: 13px">
                  <a href="cat_add.php" type="button" class="btn btn-success">New Category</a>
                </div>

                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                   <tbody>
                  <?php 
                      if($result){
                      $i = 1;
                        foreach($result as $value){  ?>
                    <tr>
                      <td> <?php echo $i; ?></td>
                      <td><?php echo escape($value['name'])?></td>
                      <td><?php echo escape(substr( $value['description'],0,80))?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                              <a href="cat_edit.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-success">Edit</a>
                          </div>
                          <div class="container">
                               <a href="cat_delete.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete')">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  <?php
                      $i++;
                      }
                    }
                  ?>                
                </table>
                <ul class="pagination justify-content-end" style="margin:10px">
                  <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>

                  <li class="page-item <?php if($pageno <= 1) {echo 'disabled';} ?>">
                  <a class="page-link" href="<?php if ($pageno <= 1) { echo '#';} else{echo "?pageno=".($pageno - 1);} ?>">Previous</a>
                  </li>

                  <li class="page-item"><a class="page-link" href="#"><?php echo $pageno ?></a></li>

                  <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                    <a class="page-link" href="<?php if ($pageno >= $total_pages) { echo '#';} else{echo "?pageno=".($pageno + 1);} ?>">Next</a>
                  </li>

                  <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a></li>
              </ul>

              </div>
              
            </div>
          </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->

<?php include('footer.php'); ?>