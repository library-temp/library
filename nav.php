<?php if(isset($_SESSION['logged_in'])) { ?>
<?php if ($_SESSION['role'] == 3) { ?>
    <!-- customer navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex align-items-med-center justify-content-med-center align-content-med-center">
            <a class="navbar-brand" href="homepage.php">Library App</a>

            <!-- The hamburger menu -->
            <button class="navbar-toggler" 
                type="button" 
                data-toggle="collapse" 
                data-target="#navbarColor01" 
                aria-controls="navbarColor01" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto d-flex bg-primary align-items-md-center justify-content-md-center w-100">

                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="customer-dashboard.php">Dashboard</a>
                    </li>
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="browse-books.php">browse books</a>
                    </li>
                    <li class="nav-item dropdown lead ml-md-auto">
                        <a class="nav-link dropdown-toggle" 
                        data-toggle="dropdown" 
                        href="#" 
                        role="button" 
                        aria-haspopup="true" 
                        aria-expanded="true"><?php echo $_SESSION['fname'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-dark bg-light" href="account-info.php">Account information</a> 
                            <a class="dropdown-item text-white bg-danger" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<?php 
} elseif ($_SESSION['role'] == 2) { ?>
    <!-- customer navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex align-items-med-center justify-content-med-center align-content-med-center">
            <a class="navbar-brand" href="homepage.php">Library App</a>
            
            <!-- The hamburger menu -->
            <button class="navbar-toggler" 
                    type="button" 
                    data-toggle="collapse" 
                    data-target="#navbarColor01" 
                    aria-controls="navbarColor01" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto d-flex bg-primary align-items-md-center justify-content-md-center w-100">
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="librarian-dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown lead ml-md-auto">
                        <a class="nav-link dropdown-toggle" 
                        data-toggle="dropdown" 
                        href="#" 
                        role="button" 
                        aria-haspopup="true" 
                        aria-expanded="true"><?php echo $_SESSION['fname'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-dark bg-light" href="account-info.php">Account information</a>
                            <a class="dropdown-item text-white bg-danger" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<?php
} else { ?>
    <!-- admin navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container d-flex align-items-med-center justify-content-med-center align-content-med-center">
            <a class="navbar-brand" href="homepage.php">Library App</a>
            
            <!-- hamburger menu -->
            <button class="navbar-toggler" 
                    type="button" 
                    data-toggle="collapse" 
                    data-target="#navbarColor01"
                    aria-controls="navbarColor01"
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto d-flex bg-primary align-items-md-center justify-content-md-center w-100">
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="admin-dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown lead ml-md-auto">
                        <a class="nav-link dropdown-toggle" 
                           data-toggle="dropdown" 
                           href="#" 
                           role="button" 
                           aria-haspopup="true" 
                           aria-expanded="true"><?php echo $_SESSION['fname'] ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-dark bg-light" href="account-info.php">Account information</a>
                            <a class="dropdown-item text-white bg-danger" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<?php   
} } else { ?>
    <!-- Logged out navbar -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">Library App</a>

            <!-- hamburger menu -->
            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarColor01"
                    aria-controls="navbarColor01"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li id="homeLi" class="nav-item">
                        <a id="home" class="nav-link" href="homepage.php">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav d-flex justify-content-end">
                    <li class="nav-item nav-link">
                        <a class="btn btn-light" href="login.php">Login</a>
                    </li>
                    <li class="nav-item nav-link">
                        <a class="btn btn-light" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>