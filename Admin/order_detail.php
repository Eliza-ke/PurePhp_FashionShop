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

    $stmt =$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']);
    $stmt->execute();
    $rawresult = $stmt->fetchAll();

    $total_pages = ceil(count($rawresult) / $numOfrecs);
   
    $stmt =$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']." LIMIT $offset,$numOfrecs");
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
                <h3 class="card-title">Order Detail</h3>
              </div>
               
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th> Quantity</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                   <tbody>
                  <?php 
                      if($result){
                      $i = 1;
                        foreach($result as $value){
                          $pstmt =$pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                          $pstmt->execute();
                          $pResult = $pstmt->fetchAll();

                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($pResult[0]['name'])?></td>
                      <td><?php echo escape($value['quantity'])?></td>
                      <td><?php echo escape(date('Y-m-d',strtotime($value['order_date'])))?></td>
                    </tr>
                  </tbody>
                  <?php
                      $i++;
                      }
                    }
                  ?>                
                </table>
                <ul class="pagination justify-content-end" style="margin:10px">
                  <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&pageno=1">First</a></li>

                  <li class="page-item <?php if($pageno <= 1) {echo 'disabled';} ?>">
                  <a class="page-link" href="<?php if ($pageno <= 1) { echo '#';} else{echo "?id=".$_GET['id']."&pageno=".($pageno - 1);} ?>">Previous</a>
                  </li>

                  <li class="page-item"><a class="page-link" href="#"><?php echo $pageno ?></a></li>

                  <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                    <a class="page-link" href="<?php if ($pageno >= $total_pages) { echo '#';} else{echo "?id=".$_GET['id']."&pageno=".($pageno + 1);} ?>">Next</a>
                  </li>

                  <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&pageno=<?php echo $total_pages ?>">Last</a></li>
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

