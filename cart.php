<?php 
include ('header.php'); 
?>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                  <?php if (!empty($_SESSION['cart'])) : ?>

                      <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            require 'config/config.php';
                            $total =0;
                            foreach ($_SESSION['cart'] as $key => $qty) : 
                                $id = str_replace('id','', $key); # id3 -> id = null ,$key = 3

                                $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                $stmt->execute();
                                $result=$stmt->fetch(PDO::FETCH_ASSOC);

                                $total += $result['price'] * $qty;
                            ?>
                            
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/images/<?php echo $result['image'] ?>" width="110" height="120" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price']); ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" class="input-text qty" maxlength="12" value="<?php echo $qty?>" title="Quantity " readonly>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price'] * $qty)?></h5>
                                </td>
                                <td><a class="primary-btn" style="line-height: 30px" href="cart_item_clear.php?pid=<?php echo $result['id'] ?>">Clear</a></td>
                            </tr>

                            <?php endforeach; ?>
                            
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h4>Subtotal</h4>
                                </td>
                                <td>
                                    <h4><?php echo $total ?></h4>
                                </td>
                            </tr>

                            <tr class="out_button_area">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="primary-btn" href="sale_order.php">Order Submit</a>
                                        <a class="gray_btn" href="clear.php">Clear All</a>
                                    <?php endif;  ?>
                                        <a class="gray_btn" href="index.php">Continue Shopping >></a>
                                        
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    

                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================--> 

<?php include 'footer.php'; ?>