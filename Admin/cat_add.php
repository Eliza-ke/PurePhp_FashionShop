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
if($_POST){
  $name=$_POST['name'];
  $description =$_POST['description'];

  if(empty($name) || empty($description)){
    if(empty($name)){
      $nameError ='Name is required';
    }
    if(empty($description)){
      $descError ='Description is required';
    }
  }else{
    $stmt = $pdo->prepare("INSERT INTO categories(name,description) VALUES (:name,:description)");
    $result = $stmt->execute(array(':name'=>$name,':description'=>$description));
    if($result){
      echo "<script>alert('category added');window.location.href='category.php'</script>";
    }
  }
}
?>

<?php include('header.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header"></div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">New Category</h3>
              </div>
               
              <div class="card-body">
                  <form action="cat_add.php" method="post">
                  <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
                  <div class="form-group">
                    <label>Name</label>
                    <p style="color:red;"><?php echo empty($nameError) ? '': '*'.$nameError ?></p>
                    <input type="text" name="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <p style="color:red;"><?php echo empty($descError) ? '': '*'.$descError ?></p>
                    <textarea class="form-control" name="description"></textarea>
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Add">
                    <a href="category.php" type="button" class="btn btn-primary">Back</a>
                  </div>
                </form>
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