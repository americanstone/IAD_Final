<?php
/*
 * Created on 2012-7-12
 *
 * User sign in or sign up page
 */
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" />
	<link rel = "stylesheet" href = "css/signin.css" type = "text/css" media = "screen" />
	<title>Studio online LAB</title>
	<script type="text/javascript" src="script/signup.js"></script>
</head>
<body>
	<div class = "display-region">
		<div id = "header">
			<?php include("header.php") ?>
		</div>
		<div id = "content">
                    <div class="leftrow"> left</div>
			<div class = "row">
				<div id = "title-container">
					<h2> Sign up</h2>
					<p>Sign up to explore the online studio based learning system.</p>
				</div>
			</div>
			<div class = "main-content">
				<div id = "main-content-left">
					<form id="signupform" action="server/signup.php" method="post" >
						<table id="signup-table" align="center" cellpadding="5px">
							<tr>
								<td><label for="username">Your name <span style="color:red">*</span></lable></td>
								<td><input id="username" type="text" class="text" name="username" size="20" maxlength="30"/></td>
							</tr>
							<tr>
								<td><label for="email"> Email address <span style="color:red">*</span></label></td>
								<td><input id="signupemail" type="text" class="text" name="signupemail" size="20" maxlength="30" /></td>
							</tr>
							<tr>
								<td><label for="password">Password <span style="color:red">*</span></label></td>
								<td><input id="initialpasswd" type="password" class="password" name="initialpasswd" size="20" maxlength="16"/></td>
							</tr>
							<tr>
								<td><label for="password">Confirm password <span style="color:red">*</span></label></td>
								<td><input id="confirmpasswd" type="password" class="password" size="20" maxlength="16" /></td>
							</tr>
							<tr>
								<td><label for="role">Your role <span style="color:red">*</span></lable></td>
								<td><select id="role" name="role" size="1">
									<option value="student">Student</option>
									<option value="ta">TA</option>
									<option value="Professor">Professor</option>
									</select></td>
							</tr>
							<tr>
                                                            <td></td>
								<td><input align="left"class="normal-size-button" id="signupsub" type="submit" value="Sign Up" /></td>
							</tr>
						</table>
					</form>
					<table align="center" id="error_reg" >
						<tr >
							<td id="info"> </td>
						</tr>
					</table>
				</div>
			</div>
			
			<div id = "main-content-right">
				<h2>Already Have an Account?</h2>
				<p> Just <a href = "signin.php">Sign In</a> </p>			
			</div>
		</div>
	</div>
	<!-- Script for registering the event handlers-->
	<script type="text/javascript" src="script/signupr.js"></script>
</body>
</html>