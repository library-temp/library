<?php 
  session_start(); 
  include_once "connection.php";
  include_once "auth_customer.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="//raw.github.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js"></script>
  <link rel="shortcut icon" href="#" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed&display=swap" rel="stylesheet">   
  <link rel="stylesheet" href="https://bootswatch.com/4/sandstone/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/stylesheet/stylesheet.css">
  <title>Library App - books</title>
</head>
<body>

  <?php require_once('nav.php') ?>

  <div class="container mb-5">

    <br>
    <br>
    <!-- 
    ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
    ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Books list ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
    ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
    -->
    <div id="content" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 1.5em;">

      <?php

        $sql_query = "SELECT * FROM book";
          $result = mysqli_query($link, $sql_query);

          if ($result->num_rows > 0) {
            
            // output data of each row
            while($row = $result->fetch_assoc()) {
              $image_url = $row["image_url"]; 
              $author_name_query = "SELECT * FROM author WHERE id='{$row["author_id"]}'";
              $author_name_result = mysqli_query($link, $author_name_query);
              $author_name = mysqli_fetch_array($author_name_result);

              $genre_name_query = "SELECT * FROM genre WHERE id='{$row["genre_id"]}'";
              $genre_name_result = mysqli_query($link, $genre_name_query);
              $genre_name = mysqli_fetch_array($genre_name_result);
              ?>

              <div class="card bg-light mb-3" style="max-width: 20rem;">
                <h3 class="card-header"><?php echo $genre_name["name"] ?></h3>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row["title"]?></h5>
                  <h6 class="card-subtitle text-muted"><?php echo $author_name["name"] ?></h6>
                </div>

                <img src="<?php echo htmlspecialchars($image_url); ?>" alt="<?php echo $row["title"]?>" style="height: 500px;">

                <div class="card-body mx-auto">
                  <a href="<?php echo "view-book.php?id=". $row["id"] ?>" class="btn btn-lg btn-dark">View Details</a>    
                </div>
              </div>
            <?php }
          } else {
              echo "0 results";
          }
        $link->close();
      ?>

    </div>

  </div>

  <?php require_once('footer.php'); ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/9e12db6cc8.js" crossorigin="anonymous"></script>

</body>
</html>