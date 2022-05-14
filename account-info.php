<?php 

session_start(); 

// Include config file and connection file
require_once "config.php";
require_once "connection.php";
 
// Define variables and initialize with empty values
$password = $password2 = "";
$successfulQuery = false;

// Change user password
if (isset($_POST['submit'])) {

  // Prepare an update statement
  $sql = "UPDATE user SET password=? WHERE id=? ;";

  if($stmt = mysqli_prepare($link, $sql)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $password, $user_id);

    // receive all input values from the form
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Get user id
    $user_id = $_SESSION['id'];

    if ($password == $password2) {
      if(mysqli_stmt_execute($stmt)) {
        $successfulQuery = true;
      };
    }  
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://bootswatch.com/4/sandstone/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/stylesheet/stylesheet.css">
    <title>Library App - account info</title>
</head>
<body>

  <?php include('nav.php') ?>

  <div class="container mt-4" style="min-height: 85vh;">
    <h1 class="text-dark">Account information</h1>
    <hr>

    <!-- Flash messages -->
    <?php
      if($successfulQuery && isset($_POST['submit'])){
        echo '<div id="msg" class="alert alert-success" role="alert">' ."Your password has changed successfully".'</div>';
      } else if(!$successfulQuery && isset($_POST['submit'])) {
        echo '<div id="msg" class="alert alert-danger" role="alert">' ."Something went wrong, please try again later".'</div>';
      }
    ?>

    <div class="col-12 col-lg-6">
      <form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <label class="h3" for="name">Name:</label>
        <div id="nameArea" class="input-group input-group-lg mb-3">
          <input 
            name="name" 
            type="text" 
            class="form-control py-4" 
            value="<?php echo htmlspecialchars($_SESSION["fname"]. " " .$_SESSION["lname"]); ?>" 
            disabled>
        </div>

        <label class="h3" for="email">Email:</label>
        <div id="emailArea" class="input-group input-group-lg mb-3">
          <input 
            name="email" 
            type="text" 
            class="form-control py-4" 
            value="<?php echo htmlspecialchars($_SESSION["email"]); ?>" 
            disabled>
        </div>

        <label class="h3" for="password">Password:</label>
        <div id="passwordArea" class="input-group input-group-lg mb-3">
          <input 
            id="password" 
            name="password" 
            type="password" 
            class="form-control py-4" 
            value="********"
            disabled
            required>
          <div id="edit-password" class="input-group-append">
            <a class="input-group-text" onclick="editPassword()">
              <i id="password-icon" class="fa fa-edit"></i>
            </a>
          </div>

          <div id="passwordConfirmation" class="input-group input-group-lg mt-2" style="display: none;">
          <label class="h3" for="password">Confirm password:</label>
            <input 
              id="password2" 
              name="password2" 
              type="password" 
              class="form-control py-4" 
              style="display: block; width: 100%;"
              required>
          </div>
          <button id="editBtn" name="submit" type="submit" class="btn btn-lg btn-dark w-50 mt-4 d-none">Edit Password</button>
        </div>

      </form>
      
      <button type="button" id="cancelBtn" class="d-none" onclick="cancelEdit()">cancel</button>
    </div>

  </div>

  <?php require_once('footer.php') ?>

  <!-- bootstrap javascript files-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/9e12db6cc8.js" crossorigin="anonymous"></script>
  
  <!-- this jquery for the hamburger menu -->
  <script>
    $('.dropdown-toggle').dropdown();
    $('#users-list a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
  </script>

  <script>
    editPassword = () => {
      document.getElementById("editBtn").classList = 'btn btn-lg btn-dark d-block w-50 mt-4';
      document.getElementById('passwordArea').appendChild(document.getElementById("editBtn"));
      document.getElementById('password').disabled = false;
      document.getElementById('password').value = '';
      document.getElementById('edit-password').classList = 'd-none';
      document.getElementById('passwordConfirmation').style.display = 'block';
      document.getElementById("cancelBtn").classList = 'btn btn-lg btn-danger w-50 mt-4';
    };

    cancelEdit = () => {
      document.getElementById("editBtn").classList = 'd-none';
      document.getElementById("cancelBtn").classList = 'd-none';
      document.getElementById('password').disabled = true;
      document.getElementById('password').value = '********';
      document.getElementById('edit-password').classList = 'input-group-append';
      document.getElementById('passwordConfirmation').style.display = 'none';
    }

    setTimeout(function(){
    document.getElementById('msg').style.display = 'none';
    }, 8000);
  </script>

</body>
</html>