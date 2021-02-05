<?php include('header.php') ?>
<?php
	require 'config/config.php'; 
	$id = $_GET['id'];

	$stmt =$pdo->prepare("SELECT * FROM products WHERE id=:id");
    $stmt->execute(array(':id'=>$id));
    $result = $stmt->fetchAll();

    $catstmt =$pdo->prepare("SELECT * FROM categories WHERE id=:id");
    $catstmt->execute(array(':id'=>$result[0]['category_id']));
    $catresult = $catstmt->fetchAll();
	
?>
<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="srequire 'config/config.php';_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="admin/images/<?php echo escape($result[0]['image'])?>" alt="">
						</div>
					</div>
				</div>

				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo escape($result[0]['name'])?></h3>
						<h2>$<?php echo escape($result[0]['price'])?></h2>

						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> :<?php echo escape($catresult[0]['name'])?> </a></li>
							<li><a href="#"><span>Availibility</span> : In Stock</a></li>
							<li>Description : <?php echo escape($result[0]['description'])?></li>
							<li>Quantity : <?php echo escape($result[0]['quantity'])?></li>
						</ul>
						<br>
						<div class="card_area d-flex align-items-center">
							<a class="primary-btn" href="#">Add to Cart</a>
							
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<br>
	<!--================End Single Product Area =================-->

<?php include('footer.php') ?>
