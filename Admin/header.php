<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Fashion Shopping</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <?php

      $link = $_SERVER['PHP_SELF']; 
      $link_array =explode('/', $link); // separate the url to get the page link
      $page =end($link_array);
    ?>

    <!-- SEARCH FORM -->
    <?php if ($page != 'order_list.php' && $page != 'weekly_report.php' && $page != 'monthly_report.php' && $page != 'royal_customer.php' && $page != 'best_seller.php' ) { ?>

      <form class="form-inline ml-3" method="post" $page != 'order_list.php' && 
      <?php if ($page == 'index.php') :?>
        action = "index.php"
      <?php elseif ($page == 'category.php') :?>
        action = "category.php"
      <?php elseif ($page == 'user_list.php') :?>
        action = "user_list.php"
      <?php endif; ?>
    >

      <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
      <div class="input-group input-group-sm">
        <input name="search" class="form-control form-control-navbar" type="search" aria-label="Search" value="" placeholder="search">

        <!--  
        <?php if(!empty ($_POST['search']) || !empty($_COOKIE['search'])) :?>
          <?php $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search']; ?>
            value="<?php echo $searchKey ?>"
        <?php else :?>
          placeholder=" <?php echo "search" ?>"  
        <?php endif; ?>
        >
        -->
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit href=">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  <?php } ?>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Shopping Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">   
          <li class="nav-item">
            <a href="index.php" class="nav-link"> <!-- use the js to onclick to remove cookie value -->
              <i class="nav-icon fas fa-th"></i>
              <p> Product </p>             
            </a>
          </li>
          <li class="nav-item">
            <a href="category.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p> Category </p>             
            </a>
          </li>
          <li class="nav-item">
            <a href="user_list.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p> User </p>             
            </a>
          </li>
          <li class="nav-item">
            <a href="order_list.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p> Sale Order </p>             
            </a>
          </li>
          <li class="nav-item has-treeview menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="royal_customer.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customers</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="best_seller.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Seller Items</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
