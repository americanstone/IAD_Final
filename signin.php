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
	<script type="text/javascript" src="script/signin.js"></script>
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
					<h2> Sign in</h2>
					<p>Sign in with an email and a previously chosen password.</p>
				</div>
			</div>
			<div class = "main-content">
				<div id = "main-content-left">
					<form id="signinform" action="" method="post" >
						<table  align="center" id = "signin-table" cellpadding="5px">
							<tr>
							<td><label for="email"> Email address</label></td>
							<td><input id="email" type="email" class="text" size="16" name="email" maxlength="30" /></td>
							</tr>
							<tr>
							<td><label for="password">Password</label></td>
							<td><input id="passwd" type="password" class="password" name="passwd" size="16" maxlength="16" /></td>
							</tr>
							<tr>
                                                            <td></td>
							<td align="left"><input class="normal-size-button" id="signin-sub" type="button" value="Sign in"  /></td>
							</tr>
						</table>
					</form>
				</div>
				<div id = "main-content-right">
					<h3>Not Have an Account Yet?</h3>
					<p><a href ="signup.php">Sign Up</a> today.</p>
				</div>
			</div>
		</div>

	</div>
	<!-- Script for registering the event handlers-->
	<script type="text/javascript" src="script/signinr.js"></script>
</body>
</html>