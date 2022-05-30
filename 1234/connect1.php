<?php

session_start();

//Initialising variables
$firstName = " ";
$lastName = " ";
$gender = " ";
$email = " ";
$password = " ";
$number = " ";

$errors = array();

//connect to db

$db=mysqli_connect('localhost','root','','test1') or die("could not connect to database");

//Register users
if(isset($_POST['reg_user'])){
    $firstName= mysqli_real_escape_string($db, $_POST['firstName']);
    $lastName= mysqli_real_escape_string($db, $_POST['lastName']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $number = mysqli_real_escape_string($db, $_POST['number']);

//for validation

    if(empty($password)) {array_push($errors,"Password is required");}
    if(empty($email)) {array_push($errors,"Email is required");}
    if(empty($firstName)) {array_push($errors,"First Name  is required");}
    if(empty($lastName)) {array_push($errors,"Last Name is required");}
    if(empty($gender)) {array_push($errors,"Gender is required");}
    if(empty($number)) {array_push($errors,"Number is required");}

}
//Check db for existing user with same username

$user_check_query = "SELECT *  FROM registration WHERE email='$email' LIMIT 1";

$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if($user){
    if($user['email'] === $email){array_push($errors,"This email id already has registered");}

}

//Register user if no error

if(count($errors) == 0 ){
    $password =md5($password_1); //this will encrypt the password
    $query = "INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES ('$firstName', '$lastName', '$gender', '$email', '$password', '$number')";
    mysqli_query($db,$query);
    $_SESSION['email']=$email;
    $_SESSION['success']= "You are now logged in";

    header('location: index.html');

}

//LOGIN USER

if(isset($_POST['login_user'])){
	$email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,$_POST['password']);

    if(empty($username)) {
		 array_push($errors,"email is required");
	}
         if(empty($password)){
		    array_push($errors,"password is required");
	     }
	
    if(count($errors) == 0 ){
		 $password = md5($password);
         $query = "SELECT * FROM registration WHERE email='$email' AND password='$password' ";
         $results = mysqli_query($db,$query);

         if(mysqli_num_rows($results)) {
		    $_SESSION['email'] = $email;
            $_SESSION ['success'] = "logged in successfully";
            header('location: index.html');

         }
	     
         else{
                array_push($errors, "wrong username/password combination.please try again");
            }
        
		
	}
}

?>