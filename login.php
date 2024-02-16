<?
    require "config.php";
    require "classes/database.php";
    require "classes/user.php";
    require "classes/isFieldCheck.php";
    
    $conn = require "admin/inc/db.php";

        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           $checkField = new isFieldCheck();
           $errors = $checkField->checkLogin($email, $password);
           if (count($errors)>0) {
                foreach ($errors as  $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
           else {
                $user = new User($email, $password);
                try{
                    if ($user::authenticate($conn, $email, $password)) {
                        echo "Authentication Successful!";
                    } else {
                        echo "Authentication Failed!";
                    }
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                    // Có thể gọi trang xử lí lỗi
                    // Header('Location: error.php');
                }
           }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        // if (isset($_POST["login"])) {
        //    $email = $_POST["email"];
        //    $password = $_POST["password"];
        //     $sql = "SELECT * FROM users WHERE email = '$email'";
        //     $result = mysqli_query($conn, $sql);
        //     $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //     if ($user) {
        //         if (password_verify($password, $user["password"])) {
        //             session_start();
        //             $_SESSION["user"] = "yes";
        //             header("Location: index.php");
        //             die();
        //         }else{
        //             echo "<div class='alert alert-danger'>Password does not match</div>";
        //         }
        //     }else{
        //         echo "<div class='alert alert-danger'>Email does not match</div>";
        //     }
        // }
        ?>
      <div class="main-content">
          <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
          </form>
      </div>
     <div class="register">
        <p>Not registered yet <a href="addUser.php">Register Here</a></p>
    </div>
    </div>
</body>
</html>