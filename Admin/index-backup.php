<?php 
                    if(!empty($_GET['pageno'])) {
                      $pageno =$_GET['pageno'];
                    }else{
                      $pageno =1;
                    }
                    $numOfrecs = 4; # how many records you want to show in a page
                    $offset =($pageno -1) * $numOfrecs;

                    if(empty($_POST['search']) && empty($_COOKIE['search'])){

                       $stmt =$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                       $stmt->execute();
                       $rawresult = $stmt->fetchAll();
                       $total_pages = ceil(count($rawresult) / $numOfrecs);
   
                       $stmt =$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,
                        $numOfrecs");
                       $stmt->execute();
                       $result = $stmt->fetchAll();

                     } else{

                      if(!empty($_POST['search'])){
                        $searchKey = $_POST['search'] ;
                      }else {
                        $searchKey = $_COOKIE['search'];
                      } 
                      $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                      $stmt->execute();
                      $rawresult = $stmt->fetchAll();
                       $total_pages = ceil(count($rawresult) / $numOfrecs);
   
                       $stmt =$pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                       $stmt->execute();
                       $result = $stmt->fetchAll();
                     } 
                  ?>



              <tbody>
                  <?php 
                      if($result){
                      $i = 1;
                        foreach($result as $value){  ?>
                    <tr>
                      <td> <?php echo $i; ?></td>
                      <td><?php echo escape($value['title'])?></td>
                      <td><?php echo escape(substr( $value['content'],0,80))?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                              <a href="edit.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-success">Edit</a>
                          </div>
                          <div class="container">
                               <a href="delete.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete')">Delete</a>
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







     if (!empty($_POST['search'])) {
    setcookie('search',$_POST['search'], time() + (86400 * 30),"/");
   }
else{
  if(empty($_GET['pageno'])){
      unset($_COOKIE['search']);
      setcookie('search',null, -1,'/');
  }
}