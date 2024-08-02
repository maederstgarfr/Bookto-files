<?php
include 'config.php';
if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($conn,$_POST['namee']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $pass=mysqli_real_escape_string($conn,($_POST['pass']));
    $cpass=mysqli_real_escape_string($conn,($_POST['cpass']));
    $user_type=$_POST['user_type'];

    $select_users= mysqli_query($conn,"SELECT * FROM `users` WHERE (email='$email' AND pass='$pass')") or die(' اتصال کوئری ناموفق بود');
    

    if(mysqli_num_rows($select_users)>0){
        $message[]= 'حساب درحال حاضر وجود دارد.لطفا وارد حساب خود شوید.';
    }else{
        if($pass != $cpass){
            $message[]= 'تایید رمز با رمز یکسان نیست';

        }else{
           mysqli_query($conn,"INSERT INTO `users` (email, pass) VALUES ('maedehrastegarfar@gmail.com', '123456') ON DUPLICATE KEY UPDATE pass = '123456';") or die (' اتصال کوئری ناموفق بود');
           $message[]= 'ثبت نام با موفقیت انجام شد';
           header('location:login.php');
        }
        
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta cpass$cpass="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>



<?php
if(isset($message)){
    foreach($message as $message){
        echo '<div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
              </div>';
        
    }
}

?>
    <div class="form-container">
        <form action="" method="post">
            <h3>ثبت نام در سایت</h3>
            <input type="text" name="namee" placeholder="لطفا نام خود را وارد کنید." required class="box">
            <input type="email" name="email" placeholder="لطفا ایمیل خود را وارد کنید." required class="box">
            <input type="pass" name="pass" placeholder="لطفا رمز خود را وارد کنید." required class="box">
            <input type="cpass" name="cpass" placeholder="لطفا رمز خود را بار دیگر وارد کنید." required class="box">
            <select name="user_type" class="box">
                <option value="user">کاربر</option>
                <option value="admin">ادمین</option>
                
            </select>
            <input type="submit" name="submit" value="ثبت نام" class="btn">
            <p>اکانت دارید؟ <a href="login.php"> وارد شوید</a></p>
        </form>
    </div>
    
</body>
</html>