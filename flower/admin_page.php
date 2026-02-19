<?php

global $conn;
@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<style>


    .dashboard-image {
        margin-top: 40px;
        text-align: center;
    }

    .dashboard-image img {
        max-width: 90%;
        height: auto;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(179, 124, 212, 0.2);
        animation: fadeInUp 1s ease;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #fdf9ff;
        margin: 0;
        padding: 0;
    }

    .box {
        background: linear-gradient(135deg, #d8b4ef, #b37cd4); /* بنفسجي فاتح */
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(179, 124, 212, 0.2);
        padding: 24px;
        text-align: center;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        color: #4b006e; /* بنفسجي غامق للنص */
        animation: fadeInUp 0.8s ease-in-out;
    }

    .box:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 32px rgba(179, 124, 212, 0.4);
    }

    .box i {
        font-size: 36px;
        margin-bottom: 15px;
        color: #6a0dad;
    }

    .box h3 {
        font-size: 28px;
        margin: 10px 0;
        font-weight: bold;
    }

    .box p {
        font-size: 16px;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .box p img {
        width: 22px;
        height: 22px;
        vertical-align: middle;
        /* الصور بتضل بألوانها الأصلية */
    }

    .dashboard .dashboard-content {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-evenly;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .box {
            width: 100%;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .row {
        display: flex;
        gap: 50px;
        flex-wrap: wrap;
        max-width: 100%;
    }

    svg {
        width: 70px;
        height: 70px;
    }
</style>

<body>

<?php @include 'admin_header.php'; ?>

<section class="dashboard">
    <h1 class="title">Dashboard</h1>
    <div class="dashboard-content">
        <div class="box-container">

   <div class="box-container">
      <div class="box">

         <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
               $total_pendings += $fetch_pendings['total_price'];
            };
         ?>

         <h3>$<?php echo $total_pendings; ?></h3>

         <p   >  <img src="images/file.png">  total pendings</p>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            while($fetch_completes = mysqli_fetch_assoc($select_completes)){
               $total_completes += $fetch_completes['total_price'];
            };
         ?>
         <h3>$<?php echo $total_completes; ?></h3>
         <p><img src=" images/wallet.png">completed paymet</p>
      </div>

      <div class="box">
         <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p> <img src="images/requisition.png">orders placed</p>
      </div>

      <div class="box">
         <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p><img src="images/market.png">products added</p>
      </div>

      <div class="box">
         <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p> <img src="images/team.png"> normal users</p>
      </div>

      <div class="box">
         <?php
            $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admin = mysqli_num_rows($select_admin);
         ?>
         <h3><?php echo $number_of_admin; ?></h3>
         <p><img src="images/manager.png">admin users</p>
      </div>

      <div class="box">
         <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
         <h3><?php echo $number_of_account; ?></h3>
         <p><img src="images/accountant.png"> total accounts</p>
      </div>

      <div class="box">
         <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p><img src="images/add-massage.png">new messages</p>
      </div>



   </div>



</section>

<script src="js/admin_script.js"></script>




<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<!-- الزخرفة أسفل الصفحة -->
<div style="margin: 0; padding: 0; overflow: hidden; width: 100vw;">
    <svg viewBox="0 0 1440 320" preserveAspectRatio="none"
         style="display: block; width: 100%; height: 150px; transform: rotate(180deg);">
        <path fill="#e6ccff" fill-opacity="1"
              d="M0,192L60,176C120,160,240,128,360,106.7C480,85,600,75,720,101.3C840,128,960,192,1080,218.7C1200,245,1320,235,1380,229.3L1440,224L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
        </path>
    </svg>
</div>













</body>
</html>