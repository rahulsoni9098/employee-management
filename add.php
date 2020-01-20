<?php
include "sessionFile.php";

$nameErr = $emailErr = $mobErr = $cityErr =   $stateErr = $photoErr = "";

?>

<?php
include "conn.php";
if (isset($_POST["done"])) {
  $name = $_POST["user_name"];
  $email = $_POST["user_email"];
  $mob = $_POST["user_mobile"];
  $city = $_POST["user_city"];
  $state = $_POST["user_state"];
  $files = $_FILES["user_photo"];
  $filename = $files["name"];
  $filetmp = $files["tmp_name"];
  $fileext = explode('.',$filename);
  $filecheck = strtolower(end($fileext));
  $fileextstored = array("png","jpg","jpeg");
  if (in_array($filecheck,  $fileextstored)) {
    $destinatonfile = "emp_image/".$filename;
    move_uploaded_file($filetmp,$destinatonfile);
  }

  $email = filter_var($email, FILTER_SANITIZE_EMAIL);

  if ((empty($name) or strlen($name)>10)) {
    $nameErr = "please enter a valid name";
  }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "please enter a valid email";
  }elseif (strlen($mob)!==10) {
    $mobErr = "please enter 10 digit mobile number";
  }elseif (empty($city)) {
    $cityErr = "please enter a city";
  }elseif (empty($state)) {
    $stateErr = "please enter a state";
  }elseif (empty($filename)) {
    $photoErr = "choose a pic";
  }else {
    $sql = "INSERT INTO details (name, email, mobile, image_url, city, state)
    VALUES ('$name', '$email', '$mob', '$destinatonfile', '$state', '$state')";
    $result = $conn->query($sql);
    header("location:information_page.php");
  }
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add</title>
    <link rel="stylesheet" href="add.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
 $("#myform").validate({
   rules: {
     user_name : {
       required: true,
       minlength: 3
     },
     user_mobile: {
       required: true,
       minlength: 10,
       maxlength:10
     },
     user_email: {
       required: true,
       email: true
     },
     user_city: {
       required: true,
     },
     user_state: {
       required: true,
     },
     user_photo: {
       required: true,
     },
   }
 });
});

  </script>
  <body>
    <br>
    <div class="container">
      <button type="button" name="button" class="btn btn-success pull-right"><a href="backForAddAndUpdate.php" class="text-color">Back</a></button>
      <br><br>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" name="user_name">
          <span class="error"><?php echo $nameErr;?></span>
        </div>
        <div class="form-group">
          <label for="email">Email address:</label>
          <input type="text" class="form-control" id="email" name="user_email">
          <span class="error"><?php echo $emailErr;?></span>
        </div>
        <div class="form-group">
          <label for="mob">Mobile No :</label>
          <input type="number" class="form-control" id="mob" name="user_mobile">
          <span class="error"><?php echo $mobErr;?></span>
        </div>
        <?php
        $query = "SELECT city FROM tbl_area_master GROUP BY city ORDER BY city";
        $res = $conn->query($query);
         ?>
         <div class="form-group">
           <label>city :</label><br>
           <select class="selectpicker form-control" data-show-subtext="true" data-live-search="true" name="user_city">
             <option></option>
           <?php while($req = $res->fetch_assoc()){ ?>
             <option value="<?php echo $req['city'];?>"><?php echo $req['city'];?></option>
           <?php } ?>
         </select>
         <span class="error"><?php echo $cityErr;?></span>
         </div>
        <?php
        $query = "SELECT state FROM tbl_area_master GROUP BY state order by state";
        $res = $conn->query($query);
        ?>
        <div class="form-group">
          <label>State :</label><br>
          <select class="selectpicker form-control" data-show-subtext="true" data-live-search="true" name="user_state">
            <option></option>
          <?php while($req = $res->fetch_assoc()){ ?>
            <option value="<?php echo $req['state'];?>"><?php echo $req['state'];?></option>
          <?php } ?>
        </select>
        <span class="error"><?php echo $stateErr;?></span>
        </div>
        <div class="form-group">
          <label for="exampleFormControlFile1">Upload photo:</label>
          <input type="file" class="form-control-file" id="exampleFormControlFile1" name="user_photo">
          <span class="error"><?php echo $photoErr;?></span>
        </div>
        <button name="done" type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

  </body>
</html>
