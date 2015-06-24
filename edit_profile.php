<?php

require 'db_connect.php';
session_start();
ob_start();

$user_email = $_SESSION['user_email'];

?>

<html>
<head>
<title>Edit Profile</title>
<?php include 'css_links.php'; ?>
<link rel="stylesheet" href="css/jquery-ui.css">
  <script src="javascript/jquery.js"></script>
  <script src="javascript/jquery-ui.js"></script>
<style type="text/css">
/* Custom Styles */
ul.nav-tabs {
  margin-top: 20px;
  border-radius: 4px;
  border: 1px solid #ddd;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
}
ul.nav-tabs li {
  margin: 0;
  border-top: 1px solid #ddd;
}
ul.nav-tabs li:first-child {
  border-top: none;
}
ul.nav-tabs li a {
  margin: 0;
  padding: 8px 16px;
  border-radius: 0;
}
ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover {
  color: #337AB7;
  background: #fff;
  border: 1px solid #fff;
}
ul.nav-tabs li:first-child a {
  border-radius: 4px 4px 0 0;
}
ul.nav-tabs li:last-child a {
  border-radius: 0 0 4px 4px;
}
ul.nav-tabs.affix {
  top: 30px; /* Set the top position of pinned element */
}
</style>

 <script>
  $(function() {
    $( ".datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  </script>

</head>
<body data-spy="scroll" data-target="#myScrollspy">
<?php include "header.php" ?>
<div class="container">
    <div class="row">
        <div class="col-xs-3" id="myScrollspy">
            <ul class="nav nav-tabs nav-stacked affix-top" data-spy="affix" data-offset-top="125">
                <li class="active"><a href="#section-1">Personal Information</a></li>
                <li><a href="#section-2">Find Me On</a></li>
                <li><a href="#section-3">Professional Information</a></li>
                <li><a href="#section-4">Change Password</a></li>
            </ul>
        </div>
        <div class="col-xs-9">
            <h2 id="section-1">Personal Information</h2>
            <!--Display Picture form-->
    
            <form action="#" method="post" enctype="multipart/form-data">
    
            <legend>Change Display Picture:</legend>
    
            <input type="file" name="fileToUpload" id="fileToUpload">
            <br>
    
            <!--Submit Button-->
            <input type="hidden" name="upload_image" value="Upload Image">
            <button type="submit" class="btn btn-primary" >Upload Image</button><br><br>
    
           </form>

          <!--name form-->
            <form action="#" method="post">
            <br>
            <legend>Update Name</legend>

            <!--input first name disabled as first name cannot change-->
            <input name="first_name" type="text" placeholder="First Name" disabled />
            <!--input last Name-->
            <input name="last_name" type="text" placeholder="Last Name" required /><br>
            <br>

            <!--Submit Button-->
            <input type="hidden" name="update_name" value="update_name">
            <button type="submit" class="btn btn-primary" >Update Name</button><br><br>
            </form>

            <?php
            #Backend For Name Update
            if(isset($_POST['update_name'])){
                $last_name = $_POST['last_name'] ; 

                $update_name_query = "UPDATE `user_master` SET `last_name`='".$last_name."' WHERE `user_email` = '".$user_email."'";
                if($update_name_result = mysqli_query($con , $update_name_query)){
                    echo "<script>alert('Name Successfully Updated.');</script>";
                }
                else{
                    echo "<script>alert('Sorry!! Error occurred in updating last name.');</script>";
                }
            }

            ?>

            <?php
            #if dob is present then dob form will not be shown to user
            #as dob cann't change

            #therefore, when dob is present as 0000-00-00 then dob will be updated

            $get_dob_query = "SELECT `dob` FROM user_master WHERE user_email = '$user_email'";
            $get_dob_result = mysqli_query($con , $get_dob_query) ;

            $row = mysqli_fetch_array($get_dob_result);
            $dob = $row['dob'];

            if($dob == '0000-00-00'){

            if($_POST['update_dob']){
                $dob =  date("Y-m-d", strtotime($_POST['dob']));

                $update_dob_query = "UPDATE `user_master` SET `dob`='".$dob."' WHERE `user_email` = '".$user_email."'";
                if($update_dob_result = mysqli_query($con , $update_dob_query)){
                    echo "<script>alert('Date of Birth Successfully Updated.');</script>";
                }
                else{
                    echo "<script>alert('Sorry!! Error occurred in updating date of birth.');</script>";
                }
            }    
            ?>
            <!--dob form-->
            <form action="#" method="post">
            <br>
            <legend>Update Birthday</legend>
            <!--Input for date of birthday-->
            <label>Date of Birthday</label><br>
             <input type="text" name="dob" class="datepicker" required>
            
            <br>
            <br>

            <!--Submit Button-->
            <input type="hidden" name="update_dob" value="update_dob">
            <button type="submit" class="btn btn-primary" >Update Birthday</button><br><br>
            </form>
            <?php
            }
            ?>

            <?php
            //backend for martial status

              if(isset($_POST['update_martial_status'])){
                
                if (!empty($_POST['martial_status']) || !empty($_POST['date_of_anniversary'])) {
                
                  $martial_status = $_POST['martial_status'];
                  $date_of_anniversary = date("Y-m-d",strtotime($_POST['date_of_anniversary']));

                  $martial_status_query = "UPDATE `user_master` SET `martial_status`='".$martial_status."',`date_of_anniversary`='".$date_of_anniversary."' WHERE `user_email` ='".$user_email."'";
                  if($martial_status_result = mysqli_query($con,$martial_status_query)){
                    echo "<script>alert('Your martial status updated successfully.')</script>";
                  }
                  else{
                    echo "<script>alert('Error in updating martial status.')</script>";
                  }
                }
              }
            ?> 


            <!--Update martial status-->
            <form action="#" method="post">
            <!-- Form Name -->
            <legend>Update Martial Status</legend>

            <!-- Multiple Radios -->
            <!--Married Radio-->
            <input name="martial_status" value="Married" checked="checked" type="radio">
            Married
            <br>
            <!--Unmarried Radio-->
            <input name="martial_status" value="Unmarried" type="radio">
            Unmarried
            <br>
            <br>

            <!--Input for date of anniversary-->
            <label>Date of Anniversary</label><br>
             <input type="text" class="datepicker" name="date_of_anniversary">
            <br>
            <br>
            <!-- Button -->
            <input type="hidden" name="update_martial_status" value="update_martial_status">
            <button type="submit" class="btn btn-primary" >Update Status</button><br><br>

            </form>

            <br>
            
            <?php
            # back end for updating address

            if(isset($_POST['update_address'])){
                
                $starting_address = $_POST['starting_address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $country = $_POST['country'];
                $pincode = $_POST['pincode'];

                $address_query = 'UPDATE `user_master` SET `starting_address`="'.$starting_address.'",`city`="'.$city.'",`state`="'.$state.'",`country`="'.$country.'",`pincode`="'.$pincode.'" WHERE `user_email` = "'.$user_email.'"';   
                if($address_result  = mysqli_query($con , $address_query)){
                    echo "<script>alert('Address updated successfully.')</script>";
                }
                else{
                    echo "<script>alert('Error in updating address.')</script>";
                }
            }

            ?>

            <form action="#" method="post">
            <legend>Change Address</legend>
            
            <!--input for  starting address-->
            <label>Starting Address</label><br>
            <input class="form-control" id="starting_address" name="starting_address">
          
            <table class="table-condensed">
            
            <tr>
            <!--input for  city-->
            <td><label >City </label></td> 
            <td><input id="city" name="city" placeholder="Indore" required type="text"></td>
            </tr>
            
            <tr>
            <!--input for  state-->
            <td><label>State</label></td>  
            <td><input id="state" name="state" placeholder="MP" required type="text"></td>
            </tr>
         
            <tr>
            <!--input for  country-->
            <td><label>Country</label></td>  
            <td><input id="country" name="country" placeholder="India" required type="text"></td>
            </tr>

            <tr>
            <!--input for  address pincode-->
            <td><label>Pincode</label></td>
            <td><input id="pincode" name="pincode" placeholder="452010" type="text"></td>
            </tr>
            
            <tr>
            <!-- Submit Button -->
            <td>
            <input type="hidden" name="update_address" value="update_address">
            <button type="submit" class="btn btn-primary" >Update Address</button></td>
            </tr>

            </table>
            </form>

            <?php

            #backend for updating social links
            if(isset($_POST['update_web_links'])){
                echo $update_query  =  "UPDATE `user_master` SET ";
            }
            
            ?>
            
            <h2 id="section-2">Find Me On</h2>

            <!--Update Social Links-->
            <form action="#" method="post">
            <br>
            <legend>Update Find Me On</legend>
    
            <!--Input forlink to personal website-->
            <input name="personal_website" type="text" placeholder="Personal Website Link"/><br><br>

            <!--Input for link to linkedin Profile-->
            <input name="linkedin" type="text" placeholder="LinkedIn Profile Link" required/><br><br>
   
            <!--Input for link to twitter Profile-->
            <input name="twitter" type="text" placeholder="Twitter Profile Link" required/><br><br>
    
            <!--Input for link to facebook Profile-->
            <input name="facebook" type="text" placeholder="Facebook Profile Link" required/><br><br>
  
            <!--Submit Button-->
            <input type="hidden" name="update_web_links" value="update_web_links">
            <button type="submit" class="btn btn-primary" >Update Links</button><br><br>
            </form>

            <h2 id="section-3">Professional Information</h2>
            <form action="#" method="post">
            <!-- Form Name -->
            <legend>Update Professional Information</legend>
            <!-- input company Name -->  
            <label>Company Name</label><br>
            <input id="org_name" name="org_name" placeholder="TCS" required type="text">
            <br>
            <br>

            <!-- input job title -->
            <label >Job Title</label><br>
            <input id="job_title" name="job_title" placeholder="CEO" required type="text">
            <br>
            <br>

            <!-- input office email address -->
            <label >Office Email Address</label><br>
            <input id="office_email" name="office_email" placeholder="mark@tcs.in" type="email">
            <br>
            <br>

            <!-- Organisation Address-->
            <label>Office Address</label><br>
            <table class="table-condensed">
            
            <tr>
            <!--input for organisation address starting address-->
            <td><label >Starting Address </label></td> 
            <td><input id="org_starting_address" name="org_starting_address" placeholder="101,Ahinsa Tower" type="text"></td>
            </tr>

            <tr>
            <!--input for organisation address city-->
            <td><label >City </label></td> 
            <td><input id="org_city" name="org_city" placeholder="Indore" type="text"></td>
            </tr>
          
            <tr>
            <!--input for local address pincode-->
            <td><label>Pincode</label></td>
            <td><input id="local_pincode" name="local_pincode" placeholder="452010" type="text"></td>
            </tr>
            
            <tr>
            <!--input for organisation address state-->
            <td><label>State</label></td>  
            <td><input id="org_state" name="org_state" placeholder="MP" type="text"></td>
            </tr>
         
            <tr>
            <!--input for local address country-->
            <td><label>Country</label></td>  
            <td><input id="org_country" name="org_country" placeholder="India" type="text"></td>
            </tr>

            </table>
            <br>
            <input type="checkbox" name="business_owner" value="1" />
            <label>Owns a business</label>

            <br>
            
            <!--Submit Button-->
            <input type="hidden" name="update_professional_info" value="update_professional_info">
            <button type="submit" class="btn btn-primary" >Update Professional Information</button><br>
            </form>

            <h2 id="section-4">Change Password</h2>
            <!--Update password -->
            <form action="#" method="post">
            <!-- Form Name -->
            <legend>Change Password</legend>
            
            <!-- input present password -->  
            <label>Present Password</label><br>
            <input id="old_password" name="old_password"  required placeholder="Password" type="password">
            <br>
            <br>

            <!-- input new password -->
            <label >New Password</label><br>
            <input id="new_password" name="new_password" required  placeholder="New Password" type="password">
            <br>
            <br>

            <!-- Password input-->
            <label>Re-enter Password</label><br>
            <input id="re_password" name="re_password" required placeholder="Re-enter Password" type="password">
            <br>
            <br>

            <!--Submit Button-->
            <input type="hidden" name="update_password" value="update_password">
            <button type="submit" class="btn btn-primary" >Update Password</button><br>

            </form>

            <hr>
        </div>
    </div>
</div>


</body>
<script src="javascript/bootstrap.min.js"></script>

</html>
