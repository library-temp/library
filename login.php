<?php
session_start();
include_once "connection.php";
require_once "check_logged_in.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // prepare a select statement
  $sql = "SELECT * FROM user WHERE email=? AND password=? ;";

    /** @var mysqli $link */
    if($stmt = mysqli_prepare($link, $sql)){
    
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email != "" && $password != "") {
      if(mysqli_stmt_execute($stmt)) {

        $result = $stmt->get_result(); // get the mysqli result

        $row = mysqli_fetch_array($result);
        $count = isset($row) ? count($row) : null;

        if (isset($count) && $count > 0 ) {

            // Vulnerable code
            $sql_query = "SELECT id FROM sessions ORDER BY id DESC limit 1";
            $result = mysqli_query($link, $sql_query);
            $row2 = mysqli_fetch_array($result);

            $sql_query = "INSERT INTO sessions VALUES ('')";
            $result = mysqli_query($link, $sql_query);

            $cookie_value = md5($row2['id']);

            // Countermeasure code
            //$cookie_value = sha1(mt_rand() . time());

            session_id($cookie_value);
            session_start();

            $_SESSION["logged_in"] = true;
            $_SESSION["id"] = $row['id'];
            $_SESSION["fname"] = $row['fname'];
            $_SESSION["lname"] = $row['lname'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["role"] = $row['role_id'];
            $_SESSION["status"] = $row['status'];

            switch ($_SESSION["role"])
            {
                case 1:
                    header('Location: admin-dashboard.php');
                    break;
                case 2:
                    header('Location: librarian-dashboard.php');
                    break;
                case 3:
                    header('Location: customer-dashboard.php');
                    break;
                default:
                    header('Location: homepage.php');
            }
        } else {
            $_SESSION['error_login'] = "Invalid username or password";
        }
      }
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
  <title>Library App - Login</title>
</head>
<body>
  
<?php require_once('nav.php'); ?>

  <!-- login card with tabs to switch between different actors -->
  <div class="mt-5" style="min-height: 81vh;">
    <div class="col-md-3 m-auto">
      <div class="card text">

        <div class="card-body">
          <h1 class="text-center mb-3"><i class="fa fa-sign-in"></i> Login</h1>          
          <!-- TODO: add flash messages -->
            <?php
              if(isset($_SESSION['error_login']))
                echo '<div id="msg" class="alert alert-danger" role="alert">' .$_SESSION['error_login']. '</div>';
            ?>

            <?php 
            if(isset($_GET['success']))
              echo '<div id="msg" class="alert alert-success" role="alert">' ."You are now a member! sign in now.".'</div>';
            ?>

          <div class="tab-content mt-3">
            <div class="tab-pane active" id="member" role="tabpanel">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                  <label for="email">email</label>
                  <input
                    name="email"
                    type="email"
                    class="form-control"
                    placeholder="Enter Your email"
                    required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
              </form>
              <p class="lead mt-4">you don't have an account? <a href="register.php" class="text-primary">register now</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('footer.php') ?>

  <!-- bootstrap javascript files-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/9e12db6cc8.js" crossorigin="anonymous"></script>
  <script>
    // this is to clear query params after refresh
    $(document).ready(function(){
      var uri = window.location.toString();
      if (uri.indexOf("?") > 0) {
        var clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
      }
    });
  </script>
  <script>
    setTimeout(function(){
      document.getElementById('msg').style.display = 'none';
      }, 8000);
  </script>
</body>
</html>