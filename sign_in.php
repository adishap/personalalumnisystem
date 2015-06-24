<?php
require 'db_connect.php';
session_start();
ob_start();

$db_err = "  ";
$email_err = "  ";

if(isset($_POST['sign_in'])){
  $user_name = $_POST['user_name'];
  $password = md5($_POST['password']);

  $check_user_query = "SELECT * FROM `user_master` WHERE (`user_email` = '".$user_name."' OR `mobile_number` = '".$user_name."' ) AND `password` = '".$password."' ";
  if($check_user_result = mysqli_query($con , $check_user_query)){
    if(mysqli_num_rows($check_user_result) == 1){
      $row = mysqli_fetch_array($check_user_result);
      $user_email = $row['user_email'];
      $_SESSION['user_email'] = $user_email;
      header('Location: profile.php');
    }
    else{
      $email_err = "Invalid username and password combination.";
    }
  }
  else{
    $db_err = "Error in checking username and password in database.";
  }


}

?>
<html>
<head>
<title>Sign In</title>
<?php
include 'css_links.php';
?>
</head>
<body>
<?php
include 'header.php';
?>
<div class="container">
  
  <form class="form-horizontal" action="#" method="post">
    <fieldset>
      
      <!-- Form Name -->
      <legend>Sign In</legend>
      
      <!--display error-->
      <?php echo $db_err; ?>

      <!-- Text input-->
      <div class="row">
        <div class="col-md-4">
          <label class="control-label" for="user_name">User Name</label>
          <input id="user_name" name="user_name" type="text" placeholder="Email Address or Mobile Number" class="form-control" required>
        </div>
        <div class="col-md-8"> </div>
      </div>
      <br>
      
     <!-- Password input-->
     <div class="row">
        <div class="col-md-4">
          <label class="control-label" for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Password" class="form-control" required>
        </div>
        <div class="col-md-8"> </div>
      </div>
      
      <!--display error-->
      <?php echo $email_err; ?>

      <br>
      
       <!-- Button -->
      <input type="hidden" name="sign_in" value="sign_in">
      <button type="submit" class="btn btn-primary">Sign In</button><br><br>
    </fieldset>
  	Not Registered Yet?<br>
	<a href="register.php">Register</a> today.
	
  </form>
</div>


<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

</body>
</html>
