<?php
@include 'config.php';
session_start();

if(isset($_POST['submit'])){


    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pass = md5($_POST['password']);

    $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";

    $result = mysqli_query($conn, $select);

    if( mysqli_num_rows( $result) > 0){

      $rows = mysqli_fetch_array($result);
      $_SESSION['user_type'] = $row['user_type'];
      $_SESSION['name'] = $row['name'];
      if($rows['user_type'] == 'admin'){
       
        header('location:home.php');

      }elseif ($rows['user_type'] == 'user'){
       
        header('location:books.html');

      }
    }else{
        $error[] = 'incorrect email or password!';
    }
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    

<div class="form_container">

<form action="" method="post">
    <h3>login now</h3>
    <?php
    if(isset($error)){
        foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
        };
    };
    ?>
    <input type="email" name="email" required placeholder="enter your email">
    <input type="password" name="password" required placeholder="enter your password">
    <input type="submit" name="submit"  value="login now" class="form-btn">
    <p>don't have an account? <a href="register_form.php">register now</a></p>
</form>


</div>
</body>
</html>