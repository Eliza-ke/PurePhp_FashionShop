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

if(!empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}
$numOfrecs = 5;
$offset = ($pageno - 1) * $numOfrecs;

    $stmt =$pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
    $stmt->execute();
    $rawresult = $stmt->fetchAll();

    $total_pages = ceil(count($rawresult) / $numOfrecs);
   
    $stmt =$pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();

  
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
                <h3 class="card-title">Order Listing</h3>
              </div>
               
              <div class="card-body">

                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Customer</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th style="width:100px">Action</th>
                    </tr>
                  </thead>
                   <tbody>
                  <?php 
                      if($result){
                      $i = 1;
                        foreach($result as $value){
                          $userstmt =$pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                          $userstmt->execute();
                          $userResult = $userstmt->fetchAll();

                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($userResult[0]['name'])?></td>
                      <td><?php echo escape($value['total_price'])?></td>
                      <td><?php echo escape(date('Y-m-d',strtotime($value['order_date'])))?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                              <a href="order_detail.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-success">View Detail</a>
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

