<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} else {
    // since the username is not set in session, the user is not-logged-in
    // he is trying to access this page unauthorized
    // so let's clear all session variables and redirect him to index
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
}

?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!-- owl-carousel -->
    <link rel="stylesheet" href="owl-carousel/owl.carousel.min.css" />

  <title>Auburn university at Montgomery</title>
</head>
<body>

  <header>
    <div class="navbar-header">

      <a href="home.php" class="logo"><img src="assets/pics/AUM_schoolname_Black02.png"></a>

      <div class="navbar-header-right">
        <a class="active" href="home.php">Home</a>
        <a href="courses.php">Courses</a>
        <a href="studentEnrolledCourses.php">Enrolled Courses</a>
        <a href="profile.php">Profile</a>
		<a href="logout.php">Logout</a>
      </div>
    </div>
  </header>

  <img src="assets/pics/AUM.JPG" class="cover-img">

  
  <div class="extra"></div>

  <div class="footer">
    <img src="assets/pics/linkedin.JPG">
    <img src="assets/pics/facebook.JPG">
    <img src="assets/pics/google.JPG">
    <img src="assets/pics/insta.JPG">
    <img src="assets/pics/map.JPG">
    <p> Auburn University at Montgomery&#169;2020</p>
  </div>

</body>
</html>
