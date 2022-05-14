<?php
  session_start();
  include_once('connection.php');
  require_once 'auth_customer.php'; 
  
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
    <title>Library App - Dashboard</title>
</head>
<body>

<?php include('nav.php') ?>

<div class="container mb-5" style="min-height: 79vh;">
  <h1 class="my-4 d-flex justify-content-between">
    <?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?>
    <span class="lm-5 mb-2 lg-sm badge rounded-pill bg-warning">Member</span>
  </h1>
  <hr>

  <?php 
  $borrowing_query = "SELECT * FROM borrowing WHERE user_id='{$_SESSION["id"]}'";
  $borrowing_query_result = mysqli_query($link, $borrowing_query);
  ?>

  <h1 class="mb-4 ml-4">Borrows</h1>  
  <?php 
  if(isset($_GET['success']))
    echo '<div id="msg" class="alert alert-success" role="alert">' ."You just borrowed a new book!".'</div>';
  ?>

  <!-- 
    ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
    ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Borrows Table ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
    ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
    -->
  <table class="table table-hover" id="table2">
    <thead>
      <tr class="header">
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Author</th>
        <th scope="col">Genre</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
    <tbody class="items">
    
      <?php 
      if ($borrowing_query_result->num_rows > 0) {
        
        while($borrowing_result = $borrowing_query_result->fetch_assoc()) {

          $books_query = "SELECT * FROM book WHERE id='{$borrowing_result["book_id"]}'";
          $books_query_result = mysqli_query($link, $books_query);
          $books_result = mysqli_fetch_array($books_query_result);

          $genre_query = "SELECT * FROM genre WHERE id='{$books_result["genre_id"]}'";
          $genre_result = mysqli_query($link, $genre_query);
          $genre_row = mysqli_fetch_array($genre_result);
      
          $author_query = "SELECT * FROM author WHERE id='{$books_result["author_id"]}'";
          $author_result = mysqli_query($link, $author_query);
          $author_row = mysqli_fetch_array($author_result);
      
          $author = $author_row['name'];
          $genre = $genre_row['name'];  
          
        ?>

        <tr class="table-light">
          <td class="row-data"> <?php echo $books_result["id"] ?> </td>
          <td class="row-data"> <?php echo $books_result["title"] ?> </td>
          <td class="row-data"> <?php echo $author ?> </td>
          <td class="row-data"> <?php echo $genre ?> </td>
          <td class="row-data"> <?php echo date('Y-m-d', strtotime($borrowing_result["date"])) ?> </td>
        </tr>

      <?php } ?>
    <?php } ?>
    </tbody>
  </table>
</div>

<?php include('footer.php'); ?>

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
  setTimeout(function(){
    document.getElementById('msg').style.display = 'none';
    }, 8000);
</script>
</body>
</html>