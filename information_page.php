<?php
include "sessionFile.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>user information</title>
    <link rel="stylesheet" href="information_page.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    console.log(value);
    $.ajax({
     type : 'POST',
     url : 'filter4backend.php',
     data : 'check='+value,
     dataType: 'json',
     success : function(data){
          console.log(data);
          var content = '';

         jQuery.each(data, function(i, v){
            content +='<tr class="text-center"><td><img src =' + v.image_url +' </td><td>xelp-'+v.id+'</td><td>'+v.name+'</td><td>'+v.email+'</td><td>'+v.mobile+'</td><td>'+v.city+'</td><td>'+v.state+'</td><td><button class="btn-primary"><a class="text-white" href="update.php?id="'+v.id+'>Update</a></button></td><td><button class="btn-danger"><a class="text-white" href="delete.php?id="'+v.id+'>Delete</a></button></td></tr>';
         });
         /* like this the results won't cummulate */
         console.log(content);
         jQuery("#myTable").html(content);
          //$('#data-div').html(data);
     }
    });

  });
});

</script>



    <!-- <script>
      $(document).ready(function(){
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
      </script> -->
  </head>
  <body>
    <div class="container-fluid">
      <h1 class="text-center">Details</h1>
      <h3>Employee Details:</h3>

        <div class="form-group">
          <label class="mt-2" for="fil"><h4>Filter :-</h4></label>
          <input type="text" name="filter" id="myInput">
         <button type="button" name="button" class="btn btn-success float-right ml-2"><a href="add.php" class="text-white">Add</a></button>
         <button type="button" name="button" class="btn btn-danger float-right mb-4"><a href="logout.php" class="text-white">Log Out</a></button>
      </div>
    </div>
      <table class="table table-striped">
        <thead>
        <tr class="text-center">
          <th>Photo</th>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>City</th>
          <th>State</th>
          <th>Update</th>
          <th>Delete</th>
        </tr>
      </thead>
    <?php
    include "conn.php";
      $sql = "SELECT * FROM details";
      $result = $conn->query($sql);
      ?>
      <tbody id="myTable">
        <?php
      while ($row = $result->fetch_assoc()) {
      ?>

          <tr class="text-center">
            <td><img src="<?php echo $row["image_url"];?>"></td>
             <td> xelp-<?php echo $row["id"]; ?></td>
             <td><?php echo $row["name"]; ?></td>
             <td><?php echo $row["email"]; ?></td>
             <td><?php echo $row["mobile"]; ?></td>
             <td><?php echo $row["city"]; ?></td>
              <td><?php echo $row["state"]; ?></td>
             <td><button class="btn-primary"><a href="update.php?id=<?php echo $row["id"]; ?>" class="text-white">Update</a></button></td>
             <td><button class="btn-danger"><a href="delete.php?id=<?php echo $row["id"]; ?>" class="text-white">Delete</a></button></td>
          </tr>

      <?php
      }
       ?>
       </tbody>
        </table>
    </div>

  </body>
</html>
