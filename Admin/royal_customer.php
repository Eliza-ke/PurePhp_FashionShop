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
  unset($_COOKIE['search']);
  setcookie('search',$_POST['search'],time() + (84600 * 30),"/");
}else{
  //remove cookie when pageno is empty because first time page cannot contain pageno and click pagination next or last, it will set pageno.
  if(empty($_GET['pageno'])) { 
    setcookie('search',null,-1 ,'/');
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
                <h3 class="card-title"> Royal Customer</h3>
              </div>
               
                <?php 
                      $currentDate = date("Y-m-d");
                      $fromDate = date("Y-m-d",strtotime($currentDate . '+1 day'));
                      $toDate = date("Y-m-d",strtotime($currentDate . '-1 month'));

                      $stmt =$pdo->prepare("SELECT * FROM sale_orders WHERE total_price >= 40000 ORDER BY id DESC");
                      $stmt->execute();
                      $result = $stmt->fetchAll();

                  ?>
              <div class="card-body">

                <table class="table table-bordered" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>UserName/th>
                      <th>TotalAmount</th>
                      <th>Order Date</th>
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
                      <td> <?php echo $i; ?></td>
                      <td><?php echo escape($userResult[0]['name'])?></td>
                      <td><?php echo escape($value['total_price'])?></td>
                      <td><?php echo escape(date("Y-m-d",strtotime($value['order_date'])))?></td>

                    <?php 
                      $i++; 
                        }
                      }
                    ?>
                  </tbody>
                          
                </table>
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

<script>
$(document).ready(function() {
    $('#d-table').DataTable();
} );
</script>