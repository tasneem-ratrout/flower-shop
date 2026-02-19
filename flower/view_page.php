<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'already added to wishlist';
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist';
    }

}

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick View</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .quick-view {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 20px;
            display: flex;
            gap: 40px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.1);
        }

        .quick-view img {
            max-width: 600px;
            border-radius: 20px;
        }

        .quick-view form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 25px;
        }

        .quick-view .name {
            font-size: 30px !important;
            font-weight: bold;
            color: #222;
        }

        .quick-view .price {
            color: #e63946;
            font-size: 25px !important;
            font-weight: bold;
        }

        .quick-view .details {
            color: #555;
            font-size: 20px !important;
        }

        .quick-view .qty {
            width: 100px;
            padding: 10px;
            border-radius: 8px;
            font-size: 20px;
        }

        .quick-view .btn,
        .quick-view .option-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 30px;
            font-size: 20px;
            background: #9370db;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }

        .quick-view .option-btn {
            background: #dda0dd;
        }

        .quick-view .btn:hover,
        .quick-view .option-btn:hover {
            background: #ba55d3;
            opacity: 0.9;
        }

        .more-btn {
            text-align: center;
            margin: 30px;
        }

        .more-btn a {
            font-size: 22px;
            padding: 12px 28px;
            border-radius: 25px;
            background: #9370db;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .more-btn a:hover {
            background: #dda0dd;
        }

        .empty {
            text-align: center;
            font-size: 36px;
            color: #999;
        }

    </style>


</head>
<body>

<?php @include 'header.php'; ?>

<section class="quick-view">

    <?php
    if(isset($_GET['pid'])){
        $pid = $_GET['pid'];
        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
        if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
                ?>
                <div class="product-image">
                    <img src="flowers/<?php echo $fetch_products['image']; ?>" alt="">
                </div>
                <form action="" method="POST">
                    <div class="name"><?php echo $fetch_products['name']; ?></div>
                    <div class="price">$<?php echo $fetch_products['price']; ?></div>
                    <div class="details"><?php echo $fetch_products['details']; ?></div>
                    <input type="number" name="product_quantity" value="1" min="0" class="qty">
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                    <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                    <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                </form>
                <?php
            }
        }else{
            echo '<p class="empty">no products details available!</p>';
        }
    }
    ?>

</section>

<div class="more-btn" style="text-align:center; margin: 20px;">
    <a href="home.php" class="option-btn">Go to Home Page</a>
</div>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>