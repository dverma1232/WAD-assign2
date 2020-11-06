<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('./includes/header.inc');
  $page = "about"; ?>
</head>
<!-- Body begin -->

<body>
  <!-- Navigation -->
  <header id="nav-bar">
    <?php include('./includes/nav.inc') ?>
  </header>
  <!-- Breadcrumbs -->
  <section id="breadcrumb-section">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="true">PHP Enhancements</li>
      </ol>
    </nav>
  </section>

  <!-- About Details -->
  <section id="enhancements">
    <div class="container">
      <h2>About</h2>
      <ul>
        <li>
          <strong>What tasks you have not attempted or not completed?</strong>
          <p>I have attempted and completed all tasks.</p>
        </li>
        <li>
          <strong>What special features have you done, or attempted, in creating the site that we should know about? </strong>
          <p>I have added validation for the friend add and friend list pages, so that only logged in users are able to access it and if not logged in they are redirected to the log in page. I have also changed the nav menu so that it shows log out instead of login/sign up if the user is already logged in. Furthermore I have added animations/transitions on each page to give the pages a clean user interface.</p>
        </li>
        <li>
          <strong>Which parts did you have trouble with? </strong>
          <p>I think the most challenging part was the SQL queries as I have not made something this complex before using SQL.</p>
        </li>
        <li>
          <strong>What would you like to do better next time? </strong>
          <p>I think I did pretty good, not sure what I would improve.</p>
        </li>
        <li>
          <strong>What additional features did you add to the assignment? (if any) </strong>
          <p>As stated above.</p>
        </li>
      </ul>
    </div>
  </section>
  <!-- Footer -->
  <footer>
    <?php include('./includes/footer.inc'); ?>
  </footer>
</body>

</html>