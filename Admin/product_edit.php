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

  $id= $_POST['id'];
  $name=$_POST['name'];
  $description =$_POST['description'];
  $category =$_POST['category'];
  $quantity =$_POST['quantity'];
  $price =$_POST['price'];
  $image =$_FILES['image']['name'];

  if(empty($name) || empty($description) || empty($category) || empty($quantity) || empty($price)){
    //we don't have to validate the empty image or not in product edit page.

    if(empty($name)){
      $nameError ='Name is required';
    }
    if(empty($description)){
      $descError ='Description is required';
    }
     if(empty($category)){
      $catError ='Category is required';
    }
     if(empty($quantity)){
      $qtyError ='Quantity is required';
    }elseif ((!empty($quantity)) && is_numeric($quantity) != 1) {
      $qtyError ='Quantity should be number';
    }
     if(empty($price)){
      $priceError ='Price is required';
    }elseif ((!empty($price)) && is_numeric($price) != 1) {
      $priceError ='Price should be number';
    }

  }else{

      if (!empty($_FILES['image']['name'])) {
        $file ='images/'.($_FILES['image']['name']);
        $imageType =pathinfo($file,PATHINFO_EXTENSION);

        if($imageType !='png' && $imageType !='jpg' && $imageType !='jpeg'){
            echo "<script>alert('Image should be png,jpg,jpeg')</script>";

        }else{
          $image =$_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'], $file);

          $stmt = $pdo->prepare("UPDATE products SET name=:name, description=:description, category_id=:category,
            quantity=:quantity, price=:price, image=:image WHERE id=:id ");
          $result = $stmt->execute(
              array(':name'=>$name,
                ':description'=>$description,
                ':category'=>$category,
                ':quantity'=>$quantity,
                ':price'=>$price,
                ':image'=>$image,
                ':id'=>$id));

          if($result){
              echo "<script>alert('Product Updated');window.location.href='index.php'</script>";
          }
        }    
      }else{
          $stmt = $pdo->prepare("UPDATE products SET name=:name, description=:description, category_id=:category,
            quantity=:quantity, price=:price WHERE id=:id ");
          $result = $stmt->execute(
            array(':name'=>$name,
              ':description'=>$description,
              ':category'=>$category,
              ':quantity'=>$quantity,
              ':price'=>$price,
              ':id'=>$id));

          if($result){
              echo "<script>alert('Product Updated');window.location.href='index.php'</script>";
          }   
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
                <h3 class="card-title">New Product</h3>
              </div>
               <?php 
          
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']); 
                $stmt->execute();
                $result =$stmt->fetchAll();

                $catstmt =$pdo->prepare("SELECT * FROM categories");
                $catstmt->execute();
                $catresult = $catstmt->fetchAll();      
                ?>
              <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">

                  <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">

                  <div class="form-group">
                    <label>Name</label>
                    <p style="color:red;"><?php echo empty($nameError) ? '': '*'.$nameError ?></p>
                    <input type="text" name="name" class="form-control" value="<?php echo escape($result[0]['name'])?>">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <p style="color:red;"><?php echo empty($descError) ? '': '*'.$descError ?></p>
                    <textarea class="form-control" name="description"><?php echo escape($result[0]['description'])?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Category</label>
                    <p style="color:red;"><?php echo empty($catError) ? '': '*'.$catError ?></p>
                    <select class="form-control" name="category">
                      <option>SELECT CATEGORY</option>

                      <?php foreach ($catresult as $value) { ?>
                        <?php if($value['id'] == $result[0]['category_id']) :?>
                          <option value="<?php echo $value['id']?>" selected><?php echo $value['name']?></option>
                        <?php else :?>
                          <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                        <?php endif ?>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <p style="color:red;"><?php echo empty($qtyError) ? '': '*'.$qtyError ?></p>
                    <input type="number" name="quantity" class="form-control" value="<?php echo escape($result[0]['quantity'])?>">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <p style="color:red;"><?php echo empty($priceError) ? '': '*'.$priceError ?></p>
                    <input type="number" name="price" class="form-control" value="<?php echo escape($result[0]['price'])?>">
                  </div>
                  <div class="form-group">
                    <label>Image</label>
                    <img src="images/<?php echo $result[0]['image']?>" width="150" height="150">
                    <input type="file" name="image">
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Update">
                    <a href="index.php" type="button" class="btn btn-primary">Back</a>
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

<?php include('footer.php'); ?>