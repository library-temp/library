<?php session_start();
require "auth_admin.php";
require_once "connection.php";

$successfulQuery = false;
$wikipedia_error = false;
$librarian_email_error = false;

// add a book to database
if (isset($_POST["submit"])) {

  $target_dir = "./assets/img/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }


  // Prepare an insert statement
  $sql_insert_query = "INSERT INTO book (id, title, author_id, genre_id, image_url, description) VALUES
  (default, ?, ?, ?, ?, ?);";

  if($stmt = mysqli_prepare($link, $sql_insert_query)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sssss", $title, $author, $genre, $image_url, $description);

    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $image_url = $target_dir . basename( $_FILES["fileToUpload"]["name"]);

    $genre_query = "SELECT * FROM genre WHERE name='$genre'";
    $genre_result = mysqli_query($link, $genre_query);
    $genre_row = mysqli_fetch_array($genre_result);

    $author_query = "SELECT * FROM author WHERE name='$author'";
    $author_result = mysqli_query($link, $author_query);
    $author_row = mysqli_fetch_array($author_result);

    $author = $author_row['id'];
    $genre = $genre_row['id'];

    if(mysqli_stmt_execute($stmt)) {
      $successfulQuery = true;

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }
    };

  }
  
}

if (isset($_POST['addAuthor'])) {

  // prepare an insert statement
  $insert_author_sql = "INSERT INTO author (id, name, wiki_page) VALUES
  (default, ?, ?);";

  if($stmt = mysqli_prepare($link, $insert_author_sql)){
    
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $author_name, $wiki);

    $author_name = $_POST['authorName'];
    $wiki = $_POST['wiki'];

    $pattern = "/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]wikipedia+)\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/";

    $result = preg_match($pattern, $wiki);

    if($result === 1) {
      if(mysqli_stmt_execute($stmt)) {
        $successfulQuery = true;
      }
    } else {
      $wikipedia_error = true;
    }
    
  }
}

if (isset($_POST['addGenre'])) {

  // prepare an insert statement
  $insert_genre_sql = "INSERT INTO genre (id, name) VALUES
  (default, ?);";

  if($stmt = mysqli_prepare($link, $insert_genre_sql)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $genre_name);
    
    $genre_name = $_POST['genreName'];
    
    if(mysqli_stmt_execute($stmt)) {
      $successfulQuery = true;
    }
  }

}

if (isset($_POST['addLibrarian'])) {

  // prepare an insert statement
  $insert_librarian_sql = "INSERT INTO user (id, role_id, status, email, password, fname, lname) VALUES
  (default, 2, 1, ?, ?, ?, ?);";

  if($stmt = mysqli_prepare($link, $insert_librarian_sql)){
    
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssss", $email, $tmp_password, $fname, $lname);

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $tmp_password = $_POST['tmpPassword'];

    // first check the database to make sure 
    // a user does not already exist with the same email
    $user_check_query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = mysqli_query($link, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { // if user exists
      if ($user['email'] === $email) {
        $librarian_email_error = true;
      } else {
        if(mysqli_stmt_execute($stmt)) {
          $successfulQuery = true;
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
    <title>Library App - Dashboard</title>
</head>
<body>

  <?php include('nav.php') ?>

  <div class="container" style="min-height: 85vh;">
    <br>

    <h1 class="mb-2 mt-4 d-flex justify-content-between"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></h1>

    <!-- 
      ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
      ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Flash messages ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
      ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
     -->
    <?php
    if(isset($_GET['addBook']) && $successfulQuery){
      echo '<div id="msg" class="alert alert-success" role="alert">' ."You just added a new book!".'</div>';
    } else if(isset($_GET['addBook']) && !$successfulQuery){
      echo '<div id="msg" class="alert alert-danger" role="alert">' ."adding a new book failure. please try again later".'</div>';
    }

    if(isset($_GET['addedAuthor']) && $successfulQuery) {
      echo '<div id="msg" class="alert alert-success" role="alert">' ."You just added a new author".'</div>';
    } else if(isset($_GET['addedAuthor']) && !$successfulQuery){
      if($wikipedia_error) {
        echo '<div id="msg" class="alert alert-danger" role="alert">' ."Please enter a valid Wikipedia URL".'</div>';
      } else {
        echo '<div id="msg" class="alert alert-danger" role="alert">' ."adding a new author failure. please try again later".'</div>';
      }
    }
    
    if(isset($_GET['addedGenre']) && $successfulQuery) {
      echo '<div id="msg" class="alert alert-success" role="alert">' ."You just added a new genre".'</div>';
    } else if(isset($_GET['addedGenre']) && !$successfulQuery) {
      echo '<div id="msg" class="alert alert-danger" role="alert">' ."adding a new genre failure. please try again later".'</div>';
    }

    if(isset($_GET['addedLibrarian']) && $successfulQuery) {
      echo '<div id="msg" class="alert alert-success" role="alert">' ."You just added a new librarian".'</div>';
    } else if(isset($_GET['addedLibrarian']) && !$successfulQuery){
      if($librarian_email_error){
        echo '<div id="msg" class="alert alert-danger" role="alert">' ."the librarian already exists".'</div>';
      } else {
        echo '<div id="msg" class="alert alert-danger" role="alert">' ."adding a new librarian failure. please try again later".'</div>';
      }
    }

    if(isset($_GET['cancelledBorrow']))
      echo '<div id="msg" class="alert alert-danger" role="alert">' ."You just deleted a borrow".'</div>';
    if(isset($_GET['bookDeleted']))
      echo '<div id="msg" class="alert alert-danger" role="alert">' ."You just deleted a book".'</div>';
    if(isset($_GET['librarianDeleted']))
      echo '<div id="msg" class="alert alert-danger" role="alert">' ."You just deleted a librarian".'</div>';
    if(isset($_GET['customerDeleted']))
      echo '<div id="msg" class="alert alert-danger" role="alert">' ."You just deleted a customer".'</div>';

    ?>

    
    <!-- 
      ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
      ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Customers Table ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
      ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
     -->
    <br>
    <h1 class="mt-4 mb-3">List Of customers</h1>
    <div class="row">
      <div class="mb-5 col-9">
        <!-- customers table -->
        <table id="customerTable" class="table table-hover mb-4" id="table">
          <thead>
            <tr class="header">
              <th scope="col">ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Email</th>
              <th scope="col"> </th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $sql_query = "SELECT * FROM user WHERE role_id=3";
            $result = mysqli_query($link, $sql_query);

            if ($result->num_rows > 0) {

              // output data of each row
              while($row = $result->fetch_assoc()) { ?>
                <tr class="table-light">
                  <td class="row-data">
                  <?php echo htmlspecialchars($row["id"]); ?>
                  </td>
                  <td class="row-data" id="title"><?php echo $row["fname"] ?></td>
                  <td class="row-data"><?php echo $row["lname"] ?></td>
                  <td class="row-data"><?php echo $row["email"] ?></td>
                  <td><button type="button" class="btnDeleteCustomer btn btn-danger">Delete</button></td>
                </tr>
              <?php } ?>
            <?php } ?>
          </tbody>
        </table>


        <!-- 
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Librarians Table ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        -->
        <h1 class="mt-4 mb-3">List of librarians</h1>
        <!-- librarians table -->
        <table id="librarianTable" class="table table-hover mb-4" id="table">
          <thead>
            <tr class="header">
              <th scope="col">ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Email</th>
              <th scope="col"> </th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $sql_query = "SELECT * FROM user WHERE role_id=2";
            $result = mysqli_query($link, $sql_query);

            if ($result->num_rows > 0) {

              // output data of each row
              while($row = $result->fetch_assoc()) { ?>
                <tr class="table-light">
                  <td class="row-data">
                  <?php echo htmlspecialchars($row["id"]); ?>
                  </td>
                  <td class="row-data" id="title"><?php echo $row["fname"] ?></td>
                  <td class="row-data"><?php echo $row["lname"] ?></td>
                  <td class="row-data"><?php echo $row["email"] ?></td>
                  <td><button type="button" class="btnDeleteLibrarian btn btn-danger">Delete</button></td>
                </tr>
              <?php } ?>
            <?php } ?>
          </tbody>
        </table>
        
        <!-- 
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Books Table ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        -->
        <h1 class="mt-4 mb-3">List of Books</h1>
        <form>
        <!--  -->
          <table id="booksTable" class="table table-hover mb-4">
            <thead>
              <tr class="header">
                <th scope="col">ID</th>
                <th scope="col">title</th>
                <th scope="col">genre</th>
                <th scope="col">author</th>
                <th scope="col"> </th>
              </tr>
            </thead>
            <tbody>
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
                  <tr class="table-light">
                    <td class="row-data">
                    <?php echo htmlspecialchars($row["id"]); ?>
                    </td>
                    <td class="row-data" id="title"><?php echo $row["title"] ?></td>
                    <td class="row-data"><?php echo $genre_name["name"] ?></td>
                    <td class="row-data"><?php echo $author_name["name"] ?></td>
                    <td><button id="deleteBtn" type="button" class="btnDelete btn btn-danger">Delete</button></td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </form>

        <!-- 
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Borrows Table ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
          ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        -->
        <h1 class="mb-3 mt-4">Borrows</h1>  
        <table class="table table-hover" id="borrowTable">
          <thead>
            <tr class="header">
              <th scope="col">id</th>
              <th scope="col">user</th>
              <th scope="col">book</th>
              <th scope="col">borrowing date</th>
              <th scope="col"> </th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $borrowing_query = "SELECT * FROM borrowing";
              $borrowing_query_result = mysqli_query($link, $borrowing_query);

              if ($borrowing_query_result->num_rows > 0) {
                
                while($borrowing_result = $borrowing_query_result->fetch_assoc()) {

                  $books_query = "SELECT * FROM book WHERE id='{$borrowing_result["book_id"]}'";
                  $books_query_result = mysqli_query($link, $books_query);
                  $books_result = mysqli_fetch_array($books_query_result);
                  
                  $users_query = "SELECT * FROM user WHERE id='{$borrowing_result["user_id"]}'";
                  $users_query_result = mysqli_query($link, $users_query);
                  $users_result = mysqli_fetch_array($users_query_result);
                  ?>
                  <tr class="table-light" id="">
                    <td class="title row-data" id="<?php echo $borrowing_result["id"] ?>"><?php echo $borrowing_result["id"] ?></td>
                    <td class="lang row-data"><?php echo $users_result["fname"]. ' ' .$users_result["lname"] ?></td>
                    <td class="subject row-data"><?php echo $books_result["title"] ?></td>
                    <td class="subject row-data"><?php echo date('Y-m-d', strtotime($borrowing_result["date"])) ?></td>
                    <td><button type="button" 
                      class="btnCancel btn btn-danger">cancel</button></td>
                  </tr>
              <?php } ?>
            <?php } ?>
          </tbody>
        </table>

      </div>


      <!-- 
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Add a new book Form ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
      -->
      <div id="addBook" class="col-3">

      <h3 class="font-weight-bold">Add a new book</h3>
        <form 
          class="mb-4" 
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?addBook'); ?>" 
          method="POST" 
          enctype="multipart/form-data">

          <div class="form-group">
            <label class="col-form-label" for="title">Title</label>
            <input class="form-control form-control-sm"
                    required
                    name="title" 
                    type="text" 
                    id="title">
          </div>

          <div class="form-group">
            <label for="select" class="form-label mt-4">Genre</label>
            <select class="form-select form-control form-control-sm" name="genre">
              <?php 
                $genre_query = "SELECT * FROM genre";
                $genre_query_result = mysqli_query($link, $genre_query);

                if ($genre_query_result->num_rows > 0) {
                  
                  while($genre_result = $genre_query_result->fetch_assoc()) { ?>

                    <option id="<?php echo $genre_result["id"] ?>">
                      <?php echo $genre_result["name"] ?>
                    </option>
                    <?php } ?>
                  <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label for="select" class="form-label mt-4">Author</label>
            <select class="form-select form-control form-control-sm" name="author">
              <?php 
                $author_query = "SELECT * FROM author";
                $author_query_result = mysqli_query($link, $author_query);

                if ($author_query_result->num_rows > 0) {
                  
                  while($author_result = $author_query_result->fetch_assoc()) { ?>

                    <option id="<?php echo $author_result["id"] ?>">
                      <?php echo $author_result["name"] ?>
                    </option>
              <?php } ?>
            <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleTextarea" class="form-label mt-4">Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
          </div>
          
          <div class="form-group">
            <label class="col-form-label" for="pic">Choose a picture</label>
            <input class="form-control form-control"
                    style="min-height: 4em;"
                    name="fileToUpload" 
                    id="fileToUpload"
                    type="file" 
                    accept="image/*"
                    required>
          </div>
          <button type="submit" id="addBookBtn" name="submit" class="btn btn-dark d-block w-100">Add book</button>
        </form>

        <br>
        <!-- 
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Add a new author Form ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        -->
        <h3 class="font-weight-bold mt-3">Add a new Author</h3>
        <form 
          class="mb-4" 
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?addedAuthor'); ?>" 
          method="POST">

          <div class="form-group">
            <label class="col-form-label" for="authorName">Name</label>
            <input class="form-control"
                    name="authorName" 
                    type="text" 
                    required>
          </div>
          <div class="form-group">
            <label class="col-form-label" for="wiki">Wikipedia page</label>
            <input class="form-control"
                    name="wiki" 
                    type="text" 
                    required>
          </div>
          <button type="submit" name="addAuthor" class="btn btn-dark d-block w-100">Add Author</button>
        </form>

        <br>
        <!--
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Add a new genre Form ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        -->
        <h3 class="font-weight-bold mt-3">Add a new Genre</h3>
        <form 
          class="mb-4" 
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?addedGenre'); ?>" 
          method="POST">

          <div class="form-group">
            <label class="col-form-label" for="genreName">Name</label>
            <input class="form-control"
                    name="genreName" 
                    type="text" 
                    required>
          </div>
          <button type="submit" name="addGenre" class="btn btn-dark d-block w-100">Add Genre</button>
        </form>
        
        <br>
        <!-- 
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼ Add a new librarian Form ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        ◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼◼
        -->
        <h3 class="font-weight-bold mt-3">Add a new Librarian</h3>
        <form 
          action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?addedLibrarian'); ?>" 
          method="POST">

          <div class="form-group">
            <label class="col-form-label" for="fname">First Name</label>
            <input class="form-control"
                    name="fname" 
                    type="text" 
                    required>
          </div>
          <div class="form-group">
            <label class="col-form-label" for="lname">Last Name</label>
            <input class="form-control"
                    name="lname" 
                    type="text" 
                    required>
          </div>
          <div class="form-group">
            <label class="col-form-label" for="email">Email</label>
            <input class="form-control"
                    name="email" 
                    type="email" 
                    required>
          </div>
          <div class="form-group">
            <label class="col-form-label" for="tmpPassword">Temporary Password</label>
            <input class="form-control"
                    name="tmpPassword" 
                    type="password" 
                    required>
          </div>
          <button type="submit" name="addLibrarian" class="btn btn-dark d-block w-100">Add Librarian</button>
        </form>
        <br>
      
      </div>

    </div>  
    
  </div>

  <?php include('footer.php') ?>

  <!-- bootstrap javascript files-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

      // this is for deleting a customer
      $(document).ready(function(){
        // code to read selected table row cell data (values).
        $("#customerTable").on('click','.btnDeleteCustomer',function(){
          // get the current row
          var currentRow = $(this).closest("tr"); 
          
          var col1 = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
          
          $.ajax({
            type: "POST",
            url: "delete-user.php",
            data: { rowId: col1 },
            success: function(d){     
              window.location.href= "admin-dashboard.php?customerDeleted";     
            }
          });
        });
      });

      // this is for deleting a librarian
      $(document).ready(function(){
        // code to read selected table row cell data (values).
        $("#librarianTable").on('click','.btnDeleteLibrarian',function(){
          // get the current row
          var currentRow = $(this).closest("tr"); 
          
          var col1 = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
          
          $.ajax({
            type: "POST",
            url: "delete-user.php",
            data: { rowId: col1 },
            success: function(d){     
              window.location.href= "admin-dashboard.php?librarianDeleted";   
            }
          });
        });
      });

      // this is for deleting a book
      $(document).ready(function(){
        // code to read selected table row cell data (values).
        $("#booksTable").on('click','.btnDelete',function(){
          // get the current row
          var currentRow = $(this).closest("tr"); 
          
          var col1 = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
          
          $.ajax({
            type: "POST",
            url: "delete-book.php",
            data: { rowId: col1 },
            success: function(d){     
              window.location.href= "admin-dashboard.php?bookDeleted";     
            }
          });
        });
      });

    
    // this is for cancelling a borrow
    $(document).ready(function(){
      // code to read selected table row cell data (values).
      $("#borrowTable").on('click','.btnCancel',function(){
        // get the current row
        var currentRow = $(this).closest("tr"); 
        
        var col1 = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
        
        $.ajax({
          type: "POST",
          url: "cancel-borrow.php",
          data: { rowId: col1 },
          success: function(d){     
            window.location.href= "admin-dashboard.php?cancelledBorrow";  
          }
         });
      });
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