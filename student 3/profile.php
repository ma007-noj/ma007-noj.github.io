<?php
use Student\Member;
session_start();
require_once __DIR__ . '/Model/Member.php';
$member = new Member();

if (!empty($_POST["update-btn"])) {
    require_once './Model/Member.php';
    $member = new Member();
    $registrationResponse = $member->updateProfile();
}
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $profile_info = $member->getUserProfileInformation();
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
<link href="assets/css/student-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
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
        <a href="studentEnrolledCourses.php">Enrolled Courses</a>
         <a class="active" href="profile.php">Profile</a>
		    <a href="logout.php">Logout</a>
      </div>
    </div>
  </header>
  <br><br><br><br><br>

  
<div class="student-container">
		<div class="sign-up-container">
			<div class="">
				<form name="update-profile" action="" method="post"
					onsubmit="return formValidation()">
					<div class="signup-heading">Profile</div>
				<?php
    if (! empty($registrationResponse["status"])) {
        ?>
                    <?php
        if ($registrationResponse["status"] == "error") {
            ?>
				    <div class="server-response error-msg"><?php echo $registrationResponse["message"]; ?></div>
                    <?php
        } else if ($registrationResponse["status"] == "success") {
            ?>
                    <div class="server-response success-msg"><?php echo $registrationResponse["message"]; ?></div>
                    <?php
        }
        ?>
				<?php
    }
    ?>
				<div class="error-msg" id="error-msg"></div>
					<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Name<span class="required error" id="username-info"></span>
							</div>
							<input class="input-box-330" type="text" name="username"
								id="username" value="<?php echo $profile_info['name'];?>">
						</div>
					</div>

                    <div class="row1">
						<div class="inline-block">
							<div class="form-label">
								Gender<span class="required error" id="gender-info"></span>
							</div>
							<select class="input-box-330" name="gender" id="gender" required="">
								<option value="Male" <?php  if($profile_info['gender']=="Male") echo "selected=selected"; ?>>Male</option>
								<option value="Female" <?php  if($profile_info['gender']=="Female") echo "selected=selected"; ?>>Female</option>
								<option value="Other" <?php  if($profile_info['gender']=="Other") echo "selected=selected"; ?>>Other</option>
							</select>
						</div>
					</div>


							<input class="input-box-330" type="hidden" name="userid"
								id="userid" value="<?php echo $profile_info['userID'];?>">
          
          <div class="row">
						<div class="inline-block">
							<div class="form-label">
								Date<span class="required error" id="date-info"></span>
							</div>
							<input class="input-box-330" type="date" name="dob" id="dob" value="<?php echo $profile_info['dob'];?>">
						</div>
          </div>      
                
					<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Email<span class="required error" id="email-info"></span>
							</div>
							<input class="input-box-330" type="email" name="email" id="email" value="<?php echo $profile_info['email'];?>">
						</div>
          </div>
          
          	<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Current Password<span class="required error" id="current-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="current-password" id="current-password">
						</div>
          </div>
          
					<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Password<span class="required error" id="update-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="update-password" id="update-password">
						</div>
          </div>
          
					<div class="row">
						<div class="inline-block">
							<div class="form-label">
								Confirm Password<span class="required error"
									id="confirm-password-info"></span>
							</div>
							<input class="input-box-330" type="password"
								name="confirm-password" id="confirm-password" onChange="checkPasswordMatch();">
						</div>  <div class="registrationFormAlert" id="divCheckPasswordMatch"></div><br>
					</div>
					<div class="row">
						<input class="btn" type="submit" name="update-btn"
							id="update-btn" value="Update">
					</div>
				</form>
			</div>
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
<script>

		function checkPasswordMatch() {
			var password = $("#update-password").val();
			var confirmPassword = $("#confirm-password").val();

			if (password != confirmPassword)
				$("#divCheckPasswordMatch").html("Both passwords must be same.");
			else
				$("#divCheckPasswordMatch").html("Passwords match.");
		}

		
function formValidation() {
	var valid = true;

	$("#username").removeClass("error-field");
	$("#email").removeClass("error-field");
	$("#gender").removeClass("error-field");
	$("#userid").removeClass("error-field");
	$("#update-password").removeClass("error-field");
	$("#confirm-password").removeClass("error-field");
  $("#current-password").removeClass("error-field");


	var UserName = $("#username").val();
	var email = $("#email").val();
	var gender = $("#gender").val();
	var userid = $("#userid").val();
  var currentPassword= $("current-password").val();
	var Password = $('#update-password').val();
  var ConfirmPassword = $('#confirm-password').val();
	var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

	$("#username-info").html("").hide();
	$("#email-info").html("").hide();

	if (gender.trim() == "") {
		$("#gender-info").html("required.").css("color", "#ee0000").show();
		$("#username").addClass("error-field");
		valid = false;
	}
	if (userid.trim() == "") {
		$("#userid-info").html("required.").css("color", "#ee0000").show();
		$("#gender").addClass("error-field");
		valid = false;
	}

	if (UserName.trim() == "") {
		$("#username-info").html("required.").css("color", "#ee0000").show();
		$("#userid").addClass("error-field");
		valid = false;
	}
	if (email == "") {
		$("#email-info").html("required").css("color", "#ee0000").show();
		$("#email").addClass("error-field");
		valid = false;
	} else if (email.trim() == "") {
		$("#email-info").html("Invalid email address.").css("color", "#ee0000").show();
		$("#email").addClass("error-field");
		valid = false;
	} else if (!emailRegex.test(email)) {
		$("#email-info").html("Invalid email address.").css("color", "#ee0000")
				.show();
		$("#email").addClass("error-field");
		valid = false;
	}
  	if (currentPassword.trim() == "") {
		$("#current-password-info").html("required.").css("color", "#ee0000").show();
		$("#current-password").addClass("error-field");
		valid = false;
	}
	if (Password.trim() == "") {
		$("#update-password-info").html("required.").css("color", "#ee0000").show();
		$("#update-password").addClass("error-field");
		valid = false;
	}
	if (ConfirmPassword.trim() == "") {
		$("#confirm-password-info").html("required.").css("color", "#ee0000").show();
		$("#confirm-password").addClass("error-field");
		valid = false;
	}
	if(Password != ConfirmPassword){
        $("#error-msg").html("Both passwords must be same.").show();
        valid=false;
    }
	if (valid == false) {
		$('.error-field').first().focus();
		valid = false;
	}
	return valid;
}
</script>
</body>
</html>
