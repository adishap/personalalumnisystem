<?php
require 'db_connect.php';
session_start();
ob_start();
//defining error variable
$email_error = '  ';
$password_error = '  ';

if(isset($_POST['register'])){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email_id = $_POST['email_id'];
	$gender = $_POST['gender'];
	$mobile_no = $_POST['mobile_no'];
	$new_password = $_POST['new_password'];
	$entered_password = $_POST['entered_password'];

	if($new_password == $entered_password){
		//converting password in md5() hash
		$password = md5($new_password);

		$check_email_query = "SELECT * FROM `user_master` WHERE `user_email` = '".$email_id."'";
		if($check_email_result = mysqli_query($con , $check_email_query)){
			if(mysqli_num_rows($check_email_result) > 0){
				$email_error = "Oops !! email address already exists.";
			}
			else{
				if(!empty($mobile_no)){
					$check_mobile_query = "SELECT * FROM `user_master` WHERE `mobile_number` = '".$mobile_no."' ";
					if($check_mobile_result = mysqli_query($con , $check_mobile_query)){
						if(mysqli_num_rows($check_mobile_result) > 0){
							$email_error = "Oops !! mobile number already exists";
						}
						else{
							$insert_alum_query = "INSERT INTO `user_master`(`first_name` , `last_name` , `user_email` , `password` , `mobile_number`,`gender`) VALUES('".$first_name."','".$last_name."','".$email_id."','".$password."' , '".$mobile_no."','".$gender."')";
							if($insert_alum_result = mysqli_query($con , $insert_alum_query)){
								$_SESSION['user_email'] = $email_id;
								echo '<script>alert("You are successfully registered."); window.location.assign("edit_profile.php");</script>';
							}
							else{
								$password_error = "Oops..!! Error in inserting the details.";
							}
						}
					}
					else{
						$email_error = "Oops !! error in checking mobile number in database.";
					}
				}
				else{
					//insert query
					$insert_alum_query = "INSERT INTO `user_master`(`first_name` , `last_name` , `user_email` , `password`,`gender`) VALUES('".$first_name."','".$last_name."','".$email_id."','".$password."','".$gender."')";
					if($insert_alum_result = mysqli_query($con , $insert_alum_query)){
						$_SESSION['user_email'] = $email_id;
						echo '<script>alert("You are successfully registered."); window.location.assign("edit_profile.php");</script>';
					}
					else{
						$password_error = "Oops..!! Error in inserting the details.";
					}
				}
			}
		}
		else{
			$email_error = " Error in checking email address in database.";
		}
	}
	else{
		$password_error = "New password and Re-entered password don't match";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<?php include 'css_links.php';?>
</head>
<body>
<?php include 'header.php'; ?>


<div class="container">
  
  <form class="form-horizontal" action="#" method="post">
    <fieldset>
      
      <!-- Form Name -->
      <legend>Register</legend>

      <!-- Input For Name -->

	<div class="row">
	<!--Form input for name-->
	<label style="margin-left:20px">Name </label><br>

	<!--Input for first_name-->
	<div class="col-sm-2"  >
	<input name="first_name" type="text" placeholder="First Name"required />
	</div>

	<!--Input for last_name-->
	<div class="col-sm-2"  >
	<input name="last_name" type="text" placeholder="Last Name" required />
	</div>

	<div class="col-sm-8"  >
	<!--intentionally blank-->
	</div>


	</div >
	<br>

	<!--Input for gender-->
	<label>Gender</label><br>
	<div class="row">

	<!--Input for male-->
	<div class="col-sm-2"  >
	<input type="radio" name="gender" value="male" checked>Male
	</div>
	
	<!--Input for female-->
	<div class="col-sm-2"  >
	<input type="radio" name="gender" value="female">Female
	</div>
	<div class="col-sm-8">
		
	</div>
	</div>



	<div class="row">

	<!--Input for Email id-->
	<div class="col-sm-3">
	<label>Email Address</label><br>
	<input name="email_id" type="email" placeholder="abc@de.f" required /><br>
	</div>

	<!--Input for Mobile No-->	
	<div class="col-sm-9">
	<label>Mobile Number</label><br>
	<input name="mobile_no" type="text" placeholder="+91-9876543210" />
	</div>

	</div>
	<?php echo $email_error; ?>
	<br>

	<div class="row">

	<div class="col-md-3">
	<!--Input for Password-->
	<label>Choose Password</label><br>
	<input type="password" name="new_password" placeholder="Password" required>
	<br>
	</div>
	
	<div class="col-md-3">
	<!--Input for Re-entered Password-->
	<label>Re-enter Password</label><br>
	<input type="password" name="entered_password" placeholder="Re-enter Password" required>
	<br>
	</div>
	<div class="col-md-6">
	<!--Intentionally Blank-->
	</div>
 	
 	</div>
	<?php echo $password_error; ?>
	<br>

	<!--Submit button-->
    <input type="hidden" name="register" value="register">
	<button type="submit" class="btn btn-primary" >Register</button><br>
	
	Already registered?
	<a href="sign_in.php">Sign in</a> now.


    </fieldset>
  </form>
</div>

</body>
</html> 