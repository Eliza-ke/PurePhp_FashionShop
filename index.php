<?php 
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

<?php include('header.php') ;
	require 'config/config.php';

     if(!empty($_GET['pageno'])) {
       $pageno =$_GET['pageno'];
     }else{
       $pageno =1;
     }
     $numOfrecs = 6; # how many records you want to show in a page
     $offset =($pageno -1) * $numOfrecs;

     if(empty($_POST['search']) && empty($_COOKIE['search'])){

     	if(!empty($_GET['category_id'])){

     		$categoryId = $_GET['category_id'];

        	$stmt =$pdo->prepare("SELECT * FROM products WHERE category_id=:category_id AND quantity >0 ORDER BY id DESC");
       		$stmt->execute(array(':category_id'=>$categoryId));
        	$rawresult = $stmt->fetchAll();
        	$total_pages = ceil(count($rawresult) / $numOfrecs); 

        	#pagination
        	$stmt =$pdo->prepare("SELECT * FROM products WHERE category_id=:category_id AND quantity >0 ORDER BY id DESC LIMIT 
        		$offset,$numOfrecs");
        	$stmt->execute(array(':category_id'=>$categoryId));
        	$result = $stmt->fetchAll();
        }else{

        	$stmt =$pdo->prepare("SELECT * FROM products WHERE quantity >0  ORDER BY id DESC");
       		$stmt->execute();
        	$rawresult = $stmt->fetchAll();
        	$total_pages = ceil(count($rawresult) / $numOfrecs);

        	$stmt =$pdo->prepare("SELECT * FROM products WHERE quantity >0  ORDER BY id DESC LIMIT $offset,$numOfrecs");
        	$stmt->execute();
        	$result = $stmt->fetchAll();
        }

      }else{
        	if(!empty($_POST['search'])){
            	$searchKey = $_POST['search'] ;
       		 }else {
                $searchKey = $_COOKIE['search'];
             } 

             if(!empty($_GET['category_id'])){

             	$categoryId = $_GET['category_id'];
        		$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=:category_id AND quantity >0  AND name LIKE '%$searchKey%' ORDER BY id DESC");
        		$stmt->execute(array(':category_id'=>$categoryId));
        		$rawresult = $stmt->fetchAll();
        		$total_pages = ceil(count($rawresult) / $numOfrecs);

        		
        		$stmt =$pdo->prepare("SELECT * FROM products WHERE category_id=:category_id AND quantity >0 AND name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
        		$stmt->execute(array(':category_id'=>$categoryId));
        		$result = $stmt->fetchAll();
        	}else{

        		$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity >0 ORDER BY id DESC");
        			$stmt->execute();
        		$rawresult = $stmt->fetchAll();
        		$total_pages = ceil(count($rawresult) / $numOfrecs);

        		$stmt =$pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity >0  ORDER BY id DESC LIMIT $offset,$numOfrecs");
        		$stmt->execute();
        		$result = $stmt->fetchAll();
        }   
     }         
?>

	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list">
						<?php

							$catstmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
							$catstmt->execute();
							$catresult = $catstmt->fetchAll();
							?>
						<?php foreach ($catresult as $key => $value) {  ?> 
							<li class="main-nav-list">
							<a href="index.php?category_id=<?php echo $value['id']; ?>"><span class="lnr lnr-arrow-right"></span>
								<?php echo $value['name'] ?></a>
						</li>	
						<?php } ?>
						
					</ul>
				</div>				
			</div>

			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">									
					<div class="pagination">
						<?php if (!empty($_GET['category_id'])) { ?>
							 
						<a href="?pageno=1&category_id=<?php echo $_GET['category_id'] ?>" class="active">First
						</a>
						<a <?php if($pageno <= 1) {echo 'disabled';} ?>
						href="<?php if ($pageno <= 1) { echo '#';}else{echo "?pageno=".($pageno - 1)."&category_id=".$_GET['category_id'];} ?>" 
						class="prev-arrow" >
						 <i class="fa fa-arrow-left" aria-hidden="true"></i>
						</a>
						<a href="#" class="active"><?php echo $pageno; ?></a>
						<a <?php if($pageno >= $total_pages) {echo 'disabled';} ?>
						href="<?php if ($pageno >= $total_pages) { echo '#';} else{echo "?pageno=".($pageno + 1)."&category_id=".$_GET['category_id'];} ?>" class="next-arrow">
						<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</a>
						<a href="?pageno=<?php echo $total_pages ?>&category_id=<?php echo $_GET['category_id'] ?>" class="active">Last</a>


						<?php }else { ?>

						<a href="?pageno=1" class="active">First</a>
						<a <?php if($pageno <= 1) {echo 'disabled';} ?>
						href="<?php if ($pageno <= 1) { echo '#';}else{echo "?pageno=".($pageno - 1);} ?>" 
						class="prev-arrow" >
						 <i class="fa fa-arrow-left" aria-hidden="true"></i>
						</a>
						<a href="#" class="active"><?php echo $pageno; ?></a>
						<a <?php if($pageno >= $total_pages) {echo 'disabled';} ?>
						href="<?php if ($pageno >= $total_pages) { echo '#';} else{echo "?pageno=".($pageno + 1);} ?>" class="next-arrow">
						<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</a>
						<a href="?pageno=<?php echo $total_pages ?>" class="active">Last</a>

					<?php } ?>
					</div>
				</div>
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						<?php
							if ($result) {
								foreach ($result as $key => $value) { ?>
									<div class="col-lg-4 col-md-6">
									<div class="single-product">
										<img class="img-fluid" src="admin/images/<?php echo escape($value['image'])?>" alt="" style="width: 180px; height: 182px !important">
										<div class="product-details">
											<h6><?php echo escape($value['name'])?></h6>
											<h6><?php echo escape($value['price'])?></h6>

											<div class="prd-bottom">
											<form action="addtocart.php" method="post">
												<input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
												<input type="hidden" name="id" value="<?php echo $value['id'] ?>">
												<input type="hidden" name="qty" value="1">
												<div class="social-info">
													<button style="display:contents" class="social-info" type="submit">
														<span class="ti-bag"></span>
														<p class="hover-text" style="left: 25px">add to bag</p>
													</button>
												</div>
												<a href="product_detail.php?id=<?php echo $value['id']; ?>" class="social-info">
													<span class="lnr lnr-move"></span>
													<p class="hover-text">view more</p>
												</a>
											</form>
											</div>
										</div>
									</div>
								</div>

						<?php	
								}
							}
						?>
						
					</div>
				</section>
				<!-- End Best Seller -->

<?php include('footer.php') ?>
