<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* تصغير الأيقونات */
        .icon img {
            width: 30px; /* تصغير حجم الأيقونات أكثر */
            height: 30px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        /* تكبير الأيقونات عند التمرير */
        .icon img:hover {
            transform: scale(1.2); /* تكبير الأيقونة عند التمرير */
        }

        /* تكبير الأزرار عند التمرير */
        .btn {
            transition: transform 0.3s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.1); /* تكبير الزر عند التمرير */
        }


        .about .flex .image img {
            transition: transform 0.4s ease-in-out, box-shadow 0.4s ease-in-out;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .about .flex .image img:hover {
            transform: scale(1.03);
        }

        /* تكبير الخط للنصوص */
        .about .flex .content h3 {
            font-size: 30px;
            font-weight: bold;
        }

        .about .flex .content p {
            font-size: 18px;
            line-height: 1.8;
        }

        /* تأثير الحركة عند التمرير */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .about .flex .image img,
        .about .flex .content h3,
        .about .flex .content p,
        .reviews .box {
            animation: fadeIn 1s ease-out forwards;
        }

        .about .flex .image img { animation-delay: 0.2s; }
        .about .flex .content h3 { animation-delay: 0.4s; }
        .about .flex .content p { animation-delay: 0.6s; }
        .reviews .box { animation-delay: 0.8s; }

        /* تأثير عند تمرير بطاقة التقييم */
        .reviews .box {
            transition: transform 0.3s ease-in-out;
        }

        .reviews .box:hover {
            transform: scale(1.05);
        }

        /* تأثير تدوير الأيقونات داخل التقييم */
        .reviews .box .icon img {
            transition: transform 0.3s ease-in-out;
        }

        .reviews .box:hover .icon img {
            transform: rotate(360deg);
        }

        /* تأثير النجوم */
        .reviews .stars i {
            color: #d1d1d1;
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .reviews .stars i:hover {
            color: #ffcc00;
            transform: scale(1.2);
        }
    </style>

</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="home.php">home</a> / about </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/about1.jpg" alt="red flowers">
        </div>

        <div class="content">
            <h3>Why Choose Us?</h3>
            <p>We offer the best quality flowers for every occasion, ensuring fast delivery and excellent customer service. Choose us for a memorable floral experience that will brighten your day.</p>

            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>What do we offer?</h3>
            <p>We offer a wide variety of premium flowers that suit every occasion, with fast delivery service ensuring you receive the highest quality flowers in the shortest time.</p>
            <a href="contact.php" class="btn">Contact us</a>

        </div>

        <div class="image">
            <img src="images/about2.jpg" alt="pink flower">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/about-img-3.jpg" alt="">
        </div>

        <div class="content">
            <h3>Who are we?</h3>
            <p>We are a passionate team dedicated to providing the most beautiful and fresh flowers for every occasion, ensuring satisfaction and excellent customer service every time.</p>
            <a href="#meet" class="btn">Meet the Founders</a>
        </div>


    </div>

</section>






<section id="meet" style="padding: 60px 20px; background: #f2f0fc;">

    <h2 style="text-align: center; font-size: 2.8rem; color: #6a0dad; margin-bottom: 40px; font-weight: bold;">
        Meet the Founders
    </h2>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 40px;">

        <!-- Founder 1 -->
        <div style="
      background: #fff;
      padding: 25px 20px;
      border-radius: 16px;
      max-width: 260px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    " onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'">

            <img src="images/beauty.png" alt="Tasneem Ratrout" style="
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #6a0dad22;
      ">

            <h3 style="font-size: 18px; color: #6a0dad; margin-bottom: 6px;">Tasneem Ratrout</h3>
            <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
                Web developer passionate about delivering floral joy and beauty.
            </p>

            <!-- Social icons -->
            <div style="display: flex; justify-content: center; gap: 12px;">
                <a href="https://www.facebook.com/tasneem.ratrout.2025" target="_blank" style="color: #6a0dad; font-size: 18px;"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/tasneem_ratrout/" target="_blank" style="color: #6a0dad; font-size: 18px;"><i class="fab fa-instagram"></i></a>

            </div>

        </div>

        <!-- Founder 2 -->
        <div style="
      background: #fff;
      padding: 25px 20px;
      border-radius: 16px;
      max-width: 260px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    " onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'">

            <img src="images/beauty.png" alt="Co-Founder" style="
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #6a0dad22;
      ">

            <h3 style="font-size: 18px; color: #6a0dad; margin-bottom: 6px;">nareman joma</h3>
            <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
                Floral artist turning bouquets into meaningful moments.
            </p>

            <!-- Social icons -->
            <div style="display: flex; justify-content: center; gap: 12px;">
                <a href="https://www.facebook.com/profile.php?id=100000177004006" target="_blank" style="color: #6a0dad; font-size: 18px;"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/nareman_joma/" target="_blank" style="color: #6a0dad; font-size: 18px;"><i class="fab fa-instagram"></i></a>

            </div>

        </div>

    </div>

</section>





<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
