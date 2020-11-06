<!DOCTYPE html>
<html lang="en">

<head>
   <?php include('./includes/header.inc');
  $page = "home"; 
  require_once "settings.php";	// Load MySQL log in credentials
  $conn = mysqli_connect ($host,$user,$pwd,$sql_db);	// Log in and use database

 
  
  
  
  
  ?>
</head>
<!-- Body begin -->

<body>
   <!-- Navigation -->
   <header id="nav-bar">
      <?php include('./includes/nav.inc') ?>
   </header>
   <!-- About -->
   <section id="about">
      <div class="container">
         <div class="col-md-12">
            <h2>My Friend System Assignment Home Page</h2>
            <p><strong>Name: </strong>Divanshu Verma</p>
            <p><strong>Student ID: </strong>103063941</p>
            <p><strong>Email: </strong><a href="mailto:103063941@student.swin.edu.au">103063941@student.swin.edu.au</a>
            </p>
            <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied
               from any other student’s work or from any other source.</p>
            <p>Tables successfully created and populated.</p>
            <a href="sign-up.php" class="btn btn-primary col-md-3">Sign Up</a>
            <a href="login.php" class="btn btn-primary col-md-3">Log In</a>
            <a href="about.php" class="btn btn-primary col-md-3">About</a>
         </div>
      </div>
   </section>
   <!-- Top Users -->
   <section id="testimonials">
      <div class="container">
         <h2>Our Top Users of The Month</h2>
         <div class="row">
            <!-- Top Users Left Column -->
            <div class="col-md-4 text-center">
               <div class="customer">
                  <img src="images/user1.jpg" class="user" alt="Man Smiling Portrait">
                  <h3>John Smith</h3>
               </div>
            </div>
            <!-- Top Users Center Column -->
            <div class="col-md-4 text-center">
               <div class="customer">
                  <img src="images/user2.jpg" class="user" alt="Man Smiling Portrait">
                  <h3>Bob Brown</h3>
               </div>
            </div>
            <!-- Top Users Right Column -->
            <div class="col-md-4 text-center">
               <div class="customer">
                  <img src="images/user3.jpg" class="user" alt="Woman Smiling Portrait">
                  <h3>Hannah Castillo</h3>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Footer -->
   <footer>
      <?php include('./includes/footer.inc') ?>
   </footer>
</body>

</html>