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

		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if(empty($name) || empty($email) || empty($password) || empty($address) || empty($phone) || strlen($password)< 4){
  
      if(empty($name)){
        $nameError = 'Name is required';
      }
      if(empty($email)){
        $emailError ='Email is required';
      }
      if(empty($password)){
        $passwordError = 'Password is required';
      }
      if (strlen($password)) {
        $passwordError = 'Password must be more 4 characters';
      }
      if (empty($address)) {
         $addressError ='Address is required';
      }
      if (empty($phone)) {
        $phoneError = 'Phone is required';
      }
    }else{
      
      if(empty($_POST['role'])){
        $role = 0;
      }else {
        $role =1;
      }

      $stmt =$pdo->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if($user){
          echo "<script>alert('Email duplicate')</script>";
      }else{
    
      $stmt =$pdo->prepare("INSERT INTO users (name,email,password,address,phone,role) VALUES (:name ,:email,:password,:address,:phone,:role)");
      $result = $stmt->execute(
        array(
        ':name' => $name,
        ':email' => $email,
        ':password' => $passwordHash,
        ':address' => $address,
        ':phone' => $phone,
        ':role' => $role
        )
      );
      if ($result) {
        echo "<script>alert('Successfully Added!');window.location.href='user_list.php' </script>";
      }
    }
  }
}	
?>

<?php include ('header.php') ?>

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
              <div class="card-header" style="background: #eee">
                <h3 class="card-title">New User Account</h3>
              </div>              
              <!-- /.card-header -->

              <div class="card-body">
              	<form action="user_add.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
                  
              		<div class="form-group">
              			<label>Name</label>
                    <p style="color:red;"><?php echo empty($nameError) ? '': '*'.$nameError ?></p>
              			<input type="text" name="name" class="form-control" >
              		</div>
              		<div class="form-group">
              			<label>Email</label>
                    <p style="color:red;"><?php echo empty($emailError) ? '': '*'.$emailError ?></p>
              			<input type="email" name="email" class="form-control" >
              		</div>
              		<div class="form-group">
              			<label>Password</label>
                    <p style="color:red;"><?php echo empty($passwordError) ? '': '*'.$passwordError ?></p>
              			<input type="password" name="password" class="form-control" >
              		</div>
                  <div class="form-group">
                    <label>Address</label>
                    <p style="color:red;"><?php echo empty($addressError) ? '': '*'.$addressError ?></p>
                    <textarea class="form-control" name="address"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <p style="color:red;"><?php echo empty($phoneError) ? '': '*'.$phoneError ?></p>
                    <input type="text" name="phone" class="form-control" >
                  </div>
                  <div class="form-group">
                    <label>Admin</label>
                    <input type="checkbox" name="role">                   
                  </div>
              		<div class="form-group">
              			<input type="submit" class="btn btn-success" value="Add">
              			<a href="user_list.php" type="button" class="btn btn-primary">Back</a>
              		</div>
              	</form>
              </div>

<?php include ('footer.php') ?>