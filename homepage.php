<?php session_start() ?>

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
    <title>Library App - Home</title>
</head>
<body>

    <?php include('nav.php') ?>
    <?php if(isset($_SESSION['logged_in'])) { ?>
    <?php if ($_SESSION["role"] == 3) { ?>
        <header id="showcase">
        <div class="container">
            <div class="showcase-container">
            <div class="showcase-content">
                <h2 class="mr-5">Welcome Again, <?php echo $_SESSION["fname"]?></h2>
                <p>Enjoy our amazing collection of books!</p>
                <a class="btn btn-outline-light rounded mt-4" href="browse-books.php">Browse books</a>
            </div>
            </div>
        </div>
        </header>
    <?php } else { ?>
        <header id="showcase">
            <div class="container">
                <div class="showcase-container">
                <div class="showcase-content">
                    <h2 class="mr-5">Welcome Again, <?php echo $_SESSION["fname"]?></h2>
                    <p>Go to your Dashboard to manage the platform..</p>
                </div>
                </div>
            </div>
        </header>
    <?php } } else { ?>
    <header id="showcase">
        <div class="container">
            <div class="showcase-container">
                <div class="showcase-content">
                    <h1>Welcome</h1>
                    <p class="hero-text">Login to your account to browse the library
                        and borrow books.</p>
                    <a class="btn btn-outline-light rounded mt-4" href="login.php">Start</a>
                </div>
            </div>
        </div>
    </header>
    <?php } ?>

    <?php include('footer.php') ?>

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
</body>
</html>