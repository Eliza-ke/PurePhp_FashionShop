<?php include('header.php');

	require 'config/config.php'; 
	$id = $_GET['id'];

	$stmt =$pdo->prepare("SELECT * FROM products WHERE id=:id");
    $stmt->execute(array(':id'=>$id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $catstmt =$pdo->prepare("SELECT * FROM categories WHERE id=:id");
    $catstmt->execute(array(':id'=>$result['category_id']));
    $catresult = $catstmt->fetch(PDO::FETCH_ASSOC);
	
?>
<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="srequire 'config/config.php';_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="admin/images/<?php echo escape($result['image'])?>" alt="">
						</div>
					</div>
				</div>

				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo escape($result['name'])?></h3>
						<h2>$<?php echo escape($result['price'])?></h2>

						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> :<?php echo escape($catresult['name'])?> </a></li>
							<li><a href="#"><span>Availibility</span> : In Stock</a></li>
							<li><span>Description </span> : <?php echo escape($result['description'])?></li>
							</ul>
							<form method="POST" action="addtocart.php">
								<input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
								<input type="hidden" name="id" value="<?php echo escape($result['id']) ?>">
								<div class="product_count">
									
									<label for="qty">Quantity:</label>
									<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
									<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 			class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
									<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
							 			class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
							 	
								</div>
						
								<div class="card_area d-flex align-items-center">
									<button class="primary-btn" href="#" style="border: 0">Add to Cart</button>
									<a class="primary-btn" href="index.php">Back</a>
								</div>
						</form>
								
					</div>
				</div>
			</div>
		</div>
</div>
<br>
	<!--================End Single Product Area =================-->

<?php include('footer.php') ?>
