<?php
use Student\Member;
session_start();
require_once __DIR__ . '/Model/Member.php';
$member = new Member();
if (! empty($_POST["withdraw-btn"])) {
    require_once __DIR__ . '/Model/Member.php';
    $member = new Member();
    $enrollResult = $member->withdraw_course();
}

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    require_once __DIR__ . '/Model/Member.php';
    $member = new Member();
    $enrolledcourses = $member->getEnrolledCourses();
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Auburn university at Montgomery</title>
</head>
<body>

  <header>
    <div class="navbar-header">
      <a href="home.php" class="logo"><img src="assets/pics/AUM_schoolname_Black02.png"></a>
      <div class="navbar-header-right">
        <a href="home.php">Home</a>
        <a href="courses.php">Courses</a>
        <a class="active" href="studentEnrolledCourses.php">Enrolled Courses</a>
         <a href="profile.php">Profile</a>
		    <a href="logout.php">Logout</a>
      </div>
    </div>
  </header>
  <br><br><br><br><br>

  
<div class="section">
  	<form id="tab" method="POST">
      <div> 
                  <table class="tableStyle">
                    <tbody>
                      <tr>
                        <th class="thStyle">Course Name</th>
                        <th class="thStyle">Instructor</th>
                        <th class="thStyle">Time</th>
                        <th class="thStyle">Classroom</th>
                        <th class="thStyle">Semester</th>
                        <th class="thStyle"></th>
                      </tr>

                       <?php foreach((array)$enrolledcourses as $enrolledcourse){ ?>
                      <tr>
                        <td class="tdStyle"><?php echo $enrolledcourse['course_name']; ?></td>
                        <td class="tdStyle"><?php echo $member->getIntsructorName($enrolledcourse['instructor_id']) ?></td>
                        <td class="tdStyle"><?php echo $enrolledcourse['time']; ?></td>
                        <td class="tdStyle"><?php echo $enrolledcourse['classroom']; ?></td>
                        <td class="tdStyle"><?php echo $enrolledcourse['semester']; ?></td>
                        <td class="tdStyle"><form action="" method="post">
                          <input type="hidden" name="course_id"
                                value="<?php echo $enrolledcourse['course_id'];?>">
                          <input type="hidden" name="instructor_id"
                                value="<?php echo $enrolledcourse['instructor_id'];?>">
                          <input class="btn" type="submit" name="withdraw-btn"
                          id="withdraw-btn" value="withdraw" 
                           class="btn btn-info btn-lg" >
                      </form></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    
                  </table>
                  
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $enrollResult['message'];?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
      </div>
      </form>
      <div class="error-success">
      <?php if(!empty($enrollResult)){?>
       <?php echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';?>
        <?php }?>
      </div>
</div>

<div>
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
