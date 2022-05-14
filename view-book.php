<?php 
  session_start(); 
  include_once "config.php"; 
  include_once "connection.php";
  include_once "auth_customer.php";

  $user_id = $_SESSION['id'];
  echo $user_id;

  $book_id = $_GET['id'];
  echo $book_id;

  if (isset($_POST['addComment'])) {

    // prepare an insert statement
    $insert_comment_sql = "INSERT INTO comment (id, user_id, book_id, comment_text, date) VALUES
    (default, ?, ?, ?, now());";

    if($stmt = mysqli_prepare($link, $insert_comment_sql)){

      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sss", $user_id, $book_id, $comment);
      
      $comment = $_POST['textArea'];
      
      if(mysqli_stmt_execute($stmt)) {
        $successfulQuery = true;
      }
    }
  }

  if (isset($_POST['borrow'])) {
    $borrowing_query = "INSERT INTO borrowing (id, user_id, book_id, date) VALUES
    (default, $user_id, $book_id, now());";

    mysqli_query($link, $borrowing_query);
    header('Location: customer-dashboard.php?success=true');
  }

  $sql_query = "SELECT * FROM book WHERE id='{$book_id}'";
  $result = mysqli_query($link, $sql_query);
  $row = mysqli_fetch_array($result);

  $image_url = $row["image_url"]; 
  $author_name_query = "SELECT * FROM author WHERE id='{$row["author_id"]}'";
  $author_name_result = mysqli_query($link, $author_name_query);
  $author_name = mysqli_fetch_array($author_name_result);

  $genre_name_query = "SELECT * FROM genre WHERE id='{$row["genre_id"]}'";
  $genre_name_result = mysqli_query($link, $genre_name_query);
  $genre_name = mysqli_fetch_array($genre_name_result);
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
    <title>Library App - <?php echo $row["title"] ?></title>
</head>
<body>

  <?php include('nav.php') ?>

  <div class="container" 
      style=" 
      height: 100vh;
      display: grid;
      grid-template-columns: repeat(2, 1fr); grid-gap: 2em;">
      

      <img src="<?php echo htmlspecialchars($image_url); ?>" alt="laws of power" width="500" height="600" style="margin-top: 10em;">

      <div id="book-info" style="background-color: #fff; height: 70%; margin-top: 10em; padding: 1em; overflow: none;">
        <h3><?php echo $row["title"] ?></h3>
          <p class="text-muted">By <?php echo $author_name["name"] ?></p>
        <!-- <p class="text-muted">Psychology</p> -->
        <hr>
        <!-- <p class="lead"><span style="font-weight: bold;">Author: </span>Robert Greene </p> -->
        <p class="lead"><span style="font-weight: bold;">Description: </span><?php echo $row["description"] ?></p>
        <span class="badge bg-secondary text-white p-2"><?php echo $genre_name["name"] ?></span>
        <p class="mt-5">Read about the author</p>
        <a class="text-primary mt-0" target="_blank" href="<?php echo htmlspecialchars($author_name["wiki_page"]); ?>"><?php echo $author_name["name"]?></a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?id=" .$_GET['id']); ?>" method="POST">
          <button type="submit" name="borrow" class="btn btn-lg btn-dark d-block w-50 mt-4">Borrow Now</button>
        </form>
      </div>

  </div>
    
  <div class="container" style="height: 100vh;">
    <hr>
    <h2>Comments</h2>
    <div style="display: flex; flex-direction: column; justify-content: center; padding-bottom: 10em; padding-top: 1em; background-color: #f4f4f4; padding-left: 2em;">
      <?php 

        $comments_query = "SELECT * FROM comment WHERE book_id='{$book_id}'";
        $comments_result = mysqli_query($link, $comments_query);
        $comments = mysqli_fetch_array($comments_result);

        $user_query = "SELECT * FROM user WHERE id='{$comments["user_id"]}'";
        $user_result = mysqli_query($link, $user_query);
        $user = mysqli_fetch_array($user_result);
      
        if ($comments_result->num_rows > 0) {

          // output data of each row
          while($comments = $comments_result->fetch_assoc()) { ?>
            <div style="background-color: #fff; width: 90%; margin-top: 1em; padding: 1em;">
              <strong><?php echo $user["fname"]. ' ' .$user["lname"] ?></strong>
              <p class="mt-2"> <?php echo $comments["comment_text"]?> </p>
            </div>
          <?php } ?>
      <?php } ?>

      <h5 class="mt-5">Add comment</h5>
      <form 
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]. "?id=" .$_GET['id']); ?>" 
        method="POST" 
        id="addCommentForm"
        class="form-group" 
        style="width: 89%;">
        <div id="nameArea" class="input-group input-group-lg">
          <textarea 
            class="form-control" 
            style="width: 100%; height: 8em;" 
            name="textArea" 
            id="textArea">
          </textarea>
        </div>
      
        <div class="my-4 d-flex justify-content-end input-group input-group-lg">
          <button id="clear" type="button" class="btn btn-lg btn-danger">Clear</button>
          <button type="submit" name="addComment" class="ml-3 btn btn-lg btn-primary">Submit</button>
        </div>
        
    </form>
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
    function clearField() {
      document.getElementById('textArea').value = '';
    }

    const clearBtn = document.getElementById('clear');
    clearBtn.addEventListener('click', clearField);
  </script>
</body>
</html>