<?php
include 'config.php';
session_start();
if(isset($_POST['submit'])){
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $pass=mysqli_real_escape_string($conn,($_POST['pass']));
    $user_type=$_POST['user_type'];

    $select_users= mysqli_query($conn,"SELECT * FROM `users` WHERE (email='$email' AND pass='$pass')") or die(' اتصال کوئری ناموفق بود');
    

    if(mysqli_num_rows($select_users)>0){
       $row=mysqli_fetch_assoc($select_users);
       if($row['user_type']=='admin'){
        $_SESSION['admin_name']=$row['namee'];
        $_SESSION['admin_email']=$row['email'];
        $_SESSION['admin_id']=$row['id'];
        header('location:admin_page.php');
       }
    }elseif($row['user_type']=='user'){
         $_SESSION['user_name']=$row['namee'];
         $_SESSION['user_email']=$row['email'];
         $_SESSION['user_id']=$row['id'];
         header('location:home.php');
        }
     }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta cpass$cpass="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

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
        <form action="" method="post" >
            <h3>وارد حساب شوید</h3>
           
            <input type="email" name="email" placeholder="لطفا ایمیل خود را وارد کنید." required class="box">
            <input type="pass" name="pass" placeholder="لطفا رمز خود را وارد کنید." required class="box">
            
            <input type="submit" name="submit" value="وارد شوید" class="btn">
            <p>حسابی ندارید؟  <a href="register.php">عضو شوید</a></p>
        </form>
    </div>
    
</body>
</html>