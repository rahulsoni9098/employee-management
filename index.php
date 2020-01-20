<?php
include "conn.php";
session_start();
if (isset($_POST["done"])) {
  $u_name = $_POST["username"];
  $pas_wrd = md5($_POST["pass"]);
  if (empty($u_name) || empty($pas_wrd)){
    echo "please fill all fields";
  }else {
    $sql = "SELECT * FROM login WHERE user_name = '$u_name'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user_check = $row["user_name"];
    $pass_check = $row["password"];
    if (($u_name === $user_check) && ($pas_wrd === $pass_check)) {
      $_SESSION['user_name'] = $u_name;
      header("location:information_page.php");
    }else {
      echo "incorrect information";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script>
         $(document).ready(function() {
      $("#myform").validate({
        rules: {
          username: {
            required: true,
            minlength:1
          },
          pass: {
            required: true,
            minlength:1
          },
        }
      });
    });
    </script>
  </head>
  <body>
    <div class="container">
      <form method="POST" id="myform">
        <div class="form-group">
          <label for="exampleInputEmail1">User Name</label>
          <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" maxlength="30" required>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="pass" class="form-control" id="exampleInputPassword1" maxlength="30" required>
        </div>
        <button type="submit" name = "done" class="btn btn-primary">Submit</button>
      </form>
    </div>


  </body>
</html>
