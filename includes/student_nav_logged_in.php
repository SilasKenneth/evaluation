<nav class="navbar  navbar-expand-lg navbar-light bg-primary text-white justify-content-between">
    <a class="navbar-brand text-white" href="home.php"><i class="fa fa-school"></i> <span class="font-weight-light">Lecturer evaluation</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-0 ml-auto">
      <li class="nav-item dropdown float-left">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
          $student = Student::getById($_SESSION['id']);
          $fullname = $student->getfirstname()." ". $student->getlastname();
          echo $fullname; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Profile</a>
            <a class="dropdown-item" href="studentpassword.php">Change password</a>
            <a class="dropdown-item" href="logout.php">Log out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
