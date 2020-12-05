<?php
namespace Student;

class Member
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    /**
     * to check if the username already exists
     *
     * @param string $username
     * @return boolean
     */
    public function isUserIDExists($userid)
    {
        $query = 'SELECT * FROM student where userID = ?';
        $paramType = 's';
        $paramValue = array(
            $userid
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to check if the email already exists
     *
     * @param string $email
     * @return boolean
     */
    public function isEmailExists($email)
    {
        $query = 'SELECT * FROM student where email = ?';
        $paramType = 's';
        $paramValue = array(
            $email
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to signup / register a user
     *
     * @return string[] registration status message
     */
    public function registerMember()
    {
        $isUserIDExists = $this->isUserIDExists($_POST["userid"]);
        $isEmailExists = $this->isEmailExists($_POST["email"]);
        if ($isUserIDExists) {
            $response = array(
                "status" => "error",
                "message" => "Username already exists."
            );
        } else if ($isEmailExists) {
            $response = array(
                "status" => "error",
                "message" => "Email already exists."
            );
        } else {
            if (! empty($_POST["signup-password"])) {

                // PHP's password_hash is the best choice to use to store passwords
                // do not attempt to do your own encryption, it is not safe
                $hashedPassword = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);
            }
            $query = 'INSERT INTO student (name,gender,userID, password, email,dob) VALUES (?, ?, ?, ?, ?, ?)';
            $paramType = 'ssssss';
            $paramValue = array(
                $_POST["username"],
                $_POST["gender"],
                $_POST["userid"],
                $hashedPassword,
                $_POST["email"],
                '2019-05-21'
            );
            $memberId = $this->ds->insert($query, $paramType, $paramValue);
            if (!empty($memberId)) {
                $response = array(
                    "status" => "success",
                    "message" => "You have registered successfully."
                );
            }
        }
        return $response;
    }
    public function updateProfile()
    {
        $isUserIDExists = $this->isUserIDExists($_POST["userid"]);
        if ($isUserIDExists) {
            if (!empty($_POST["current-password"])) {
                $memberRecord = $this->getMember($_SESSION["user_id"]);
                $loginPassword = 0;
                if (!empty($memberRecord)) {
                    if (!empty($_POST["current-password"])) {
                        $password = $_POST["current-password"];
                    }
                    $hashedPassword = $memberRecord[0]["password"];
                    $loginPassword = 0;
                    if (password_verify($password, $hashedPassword)) {
                        $loginPassword = 1;
                    }else {
                    $response = array(
                    "status" => "error",
                    "message" => "Current password is not matched with user password, Please enter correct password."
                );
                 return $response;
                }
            }    
            }else{
                $response = array(
                    "status" => "error",
                    "message" => "Please enter current password."
                   
                );
                 return $response;
            }

            if ((!empty($_POST["update-password"])) and (!empty($_POST["confirm-password"]))) {
                if($_POST["update-password"]==$_POST["confirm-password"]){
                    $hashedPassword = password_hash($_POST["update-password"], PASSWORD_DEFAULT);
                    $query = 'update student set name= ?,gender = ?, password= ?,email = ?, dob= ? where userID=?';
                    $paramType = 'ssssss';
                    $paramValue = array(
                    $_POST["username"],
                    $_POST["gender"],
                    $hashedPassword,
                    $_POST["email"],
                    $_POST["dob"],
                    $_SESSION["user_id"],
                    );
                    $memberId = $this->ds->update($query, $paramType, $paramValue);
                    $response = array(
                    "status" => "success",
                    "message" => "Updated succesfully!!."
                     );
                return $response;
                }else{
                     $response = array(
                    "status" => "error",
                    "message" => "Both Entered Passwords must be same"
                );
                 return $response;
                }

            }else{
                 $response = array(
                    "status" => "error",
                    "message" => "Please enter new password"
                );
             return $response;
            }

        }
         $response = array(
                    "status" => "success",
                    "message" => "!!."
                );
        return $response;
    }

    public function isUserCourseEnrolled($course_id)
    {
        $userId=$_SESSION["user_id"];
        $query = 'SELECT * FROM course_enroll where user_id= ? and course_id = ?';
        $paramType = 'ss';
        $paramValue = array(
            $userId,
            $course_id
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function enroll_course()
    {
        $isUserCourseEnrolled = $this->isUserCourseEnrolled($_POST["course_id"]);
        if ($isUserCourseEnrolled) {
            $response = array(
                "status" => "error",
                "message" => "You are already enrolled in this course."
            );
        }
        else {
            $query = 'INSERT INTO course_enroll (user_id,course_id,instructor_id) VALUES (?, ?, ?)';
            $paramType = 'sss';
            $paramValue = array(
                $_SESSION["user_id"],
                $_POST["course_id"],
                $_POST["instructor_id"]
            );
            $memberId = $this->ds->insert($query, $paramType, $paramValue);
            $response = array(
                    "status" => "success",
                    "message" => "You have enrolled successfully for this course."
                );
        }
        return $response;
    }


    public function withdraw_course()
    {
        $isUserCourseEnrolled = $this->isUserCourseEnrolled($_POST["course_id"]);
        if ($isUserCourseEnrolled) {
            $query = 'delete  from course_enroll where user_id=? and course_id=? and instructor_id=?';
            $paramType = 'sss';
            $paramValue = array(
                $_SESSION["user_id"],
                $_POST["course_id"],
                $_POST["instructor_id"]);
            $memberId = $this->ds->delete($query, $paramType, $paramValue);
            $response = array(
                "status" => "success",
                "message" => "You are successfully withdrawed this course."
            );
            return $response;
        }
        
    }



   public function getIntsructorName($instructor_id){
       $query = 'SELECT * FROM instructor where ID = ?';
        $paramType = 's';
        $paramValue = array(
            $instructor_id
        );
        $memberRecord = $this->ds->select($query, $paramType, $paramValue);
        return $memberRecord[0]['name'];
   }





    public function getMember($username)
    {
        
        $query = 'SELECT * FROM student where userID = ? or email = ?';
        $paramType = 'ss';
        $paramValue = array(
            $username,
            $username
        );
        $memberRecord = $this->ds->select($query, $paramType, $paramValue);
        return $memberRecord;
    }

    public function getCourses()
    {
        $query = 'select * from courses where
(course_id,instructor_id) NOT IN ( select course_id,instructor_id from course_enroll where user_id= ?);';
        $paramType = 's';
        $paramValue = array(
            $_SESSION["user_id"]
        );
        $courses = $this->ds->select($query, $paramType, $paramValue);
        return $courses;
    }

    public function getEnrolledCourses()
    {
        $query = 'SELECT * FROM courses c, course_enroll enroll, instructor i WHERE 1=1 and  c.course_id = enroll.course_id
        AND c.instructor_id = i.ID AND enroll.instructor_id = i.ID and enroll.user_id=?';
        $paramType = 's';
        $paramValue = array(
            $_SESSION["user_id"]
        );
        $enrolledcourses = $this->ds->select($query, $paramType, $paramValue);
        return $enrolledcourses;
    }

    public function getUserProfileInformation()
    {
        $query = 'SELECT * FROM student where  userID=?';
        $paramType = 's';
        $paramValue = array(
            $_SESSION["user_id"]
        );
        $user_info = $this->ds->select($query, $paramType, $paramValue);
        return $user_info[0];
    }


    public function getInstructorID($instructor_name)
    {
        $query = 'SELECT * FROM instructor where name=?';
        $paramType = 's';
        $paramValue = array(
            $instructor_name
        );
        $instructors = $this->ds->select($query, $paramType, $paramValue);
        return $instructors[0]['ID'];
    }

    public function search_courses_info()
    {
        $query = 'SELECT * FROM courses where (course_name=? or course_id =? or  instructor_id=? or semester=? or time=? or classroom=?) and (course_id,instructor_id) NOT IN ( select course_id,instructor_id from course_enroll where user_id=?)';
        $paramType = 'sssssss';
        $paramValue = array(
            $_POST["courses_search"],
            $_POST["courses_search"],
            $this->getInstructorID($_POST["courses_search"]),
            $_POST["courses_search"],
            $_POST["courses_search"],
            $_POST["courses_search"],
            $_SESSION["user_id"]

        );
        $courses = $this->ds->select($query, $paramType, $paramValue);
        return $courses;
    }

    /**
     * to login a user
     *
     * @return string
     */
    public function loginMember()
    {
        $memberRecord = $this->getMember($_POST["username"]);
        $loginPassword = 0;
        if (! empty($memberRecord)) {
            if (! empty($_POST["login-password"])) {
                $password = $_POST["login-password"];
            }
            $hashedPassword = $memberRecord[0]["password"];
            $loginPassword = 0;
            if (password_verify($password, $hashedPassword)) {
                $loginPassword = 1;
            }
        } else {
            $loginPassword = 0;
        }
        if ($loginPassword == 1) {
            // login sucess so store the member's username in
            // the session
            session_start();
            $_SESSION["username"] = $memberRecord[0]["name"];
            $_SESSION["user_id"] = $memberRecord[0]["userID"];
            session_write_close();
            $url = "./home.php";
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Invalid username or password.";
            return $loginStatus;
        }
    }
}
