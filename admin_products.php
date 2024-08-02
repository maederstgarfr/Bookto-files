<?php
include 'config.php';
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');

};
if(isset($_POST['add_product'])){
    $name=mysqli_real_escape_string($conn, $_POST['name']);
    $price=$_POST['price'];
    $image=$_FILES['image']['name'];
    $image_size=$_FILES['image']['size'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_folder='uploaded_img/'.$image;
    $select_product_name= mysqli_query($conn,"SELECT `name` FROM `products` WHERE `name`='name'")or die('query failed');
    if(mysqli_num_rows($select_product_name)>0){
        $message[]='این نام پروژه در حال حاضر وجود دارد ';
    
    }else{
        $add_product_query=mysqli_query($conn,"INSERT INTO `products`( `name`, `price`, `image`) VALUES ('$name','$price','$image')") or die('query failed');

        if($add_product_query){
            if($image_size>2000000){
               $message[]='اندازه عکس خیلی بزرگ است اندازه عکس $image-size  است' ;
            }else{
                 move_uploaded_file($image_tmp_name, $image_folder);
                $message[]='محصول موفقانه اضافه شد';
            }
        }else{
            $message[]='نمیتوان اضافه کرد';
        }
    }


}
if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
    mysqli_query($conn,"DELETE FROM `products` WHERE `id`='$delete_id'") or die('query failed');
    header('location:admin_products.php');}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محصولات</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <?php
    include 'admin_header.php';?>
    <!-- product crud(kham) session start -->
    <session class="add-producs">
        <h1 class="title">محصولات فروشگاه</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>اضافه کردن محصول</h3>
            <input type="text" name="name" class="box" placeholder="نام محصول را وارد کن" required >
            <input type="number" name="price" min="0" class="box" placeholder="قیمت محصول را وارد کن" required >
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="اضافه کردن محصول" name="add_product" class="btn">

        </form>
    </session>
    <!-- product crud(kham) session end -->
    <div class="space"></div>
    <!-- show product  -->
    <session class="show-product">
        <div class="box-container">
            <?php
            $select_products=mysqli_query($conn,"SELECT * FROM `products`") or die('query failed');
            if(mysqli_num_rows($select_products)>0){
                while($fetch_products= mysqli_fetch_assoc($select_products)){
              
            ?>
            <div class="box">
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">اپدیت</a>
                <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('حذف این محصول؟');">حذف</a>
            </div>

            <?php
                }

            }else{
                echo'<p class="empty">محصولی اضافه نشد</p>';
            }



            ?>
        </div>
    </session>
    <session class="edit_products_form">
        <?php
        if(isset($_GET['update'])){
            $update_id=$_GET['update'];
            $update_query=mysqli_query($conn, "SELECT * FROM `products` WHERE `id`='$update_id'") or die('query failed');
            if(mysqli_num_rows($update_query)>0){
                while($fetch_update=mysqli_fetch_assoc($update_query)){

             
        ?>
        <form action=""method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_products['id']; ?>" >
            <input type="hidden" name="update_old_image" value="<?php echo $fetch_products['image']; ?>" >
            
            <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
            <input type="text"name="update_name" value="<?php echo $fetch_products['name']; ?>" class="box" required placeholder="نام محصول را وارد کنید">
            <input type="number"name="update_price" value="<?php echo $fetch_products['price']; ?>" class="box" min="0" required placeholder="قیمت محصول را وارد کنید">
            <input type="file" class="box"name="update_image" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" value="update" name="update_product" class="btn">
            <input type="reset" value="کنسل" name="close_update" class="option-btn">
        </form>
        <?php
            }
                }else{
                    echo '<script> document.querySelector(".edit_products_form").style.display = "none"; </script>'

                }

            }
        ?>


    </session>



    <!-- costom admin js file link -->
    <script src="js/admin_script.js"></script>
    
    
</body>
</html>