function setErrReg(){
	document.getElementById("error_reg").style.display ="table";
	document.getElementById("error_reg").border = "1px";
	document.getElementById("error_reg").style.textAlign ="center";
	document.getElementById("error_reg").style.borderColor = "red";
	document.getElementById("error_reg").style.width = "300px";
	document.getElementById("error_reg").style.backgroundColor = "#FFA07A";
		
}
function unsetErrReg(){
	document.getElementById("error_reg").style.display ="none";
}
function cksignup(){
	//check sign up form
	var username = document.getElementById("username");
	var email = document.getElementById("signupemail");
	var initpasswd = document.getElementById("initialpasswd");
	var secondpasswd = document.getElementById("confirmpasswd");
	var posn = username.value.search(/^[A-Za-z][A-Za-z0-9 ]*$/);
	var posp = initpasswd.value.search(/^\S\S\S\S\S\S+$/);
	var pose = email.value.search(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\" +"".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
	//ensure all fields are fill in 
	if(username.value == "" || email.value == "" || initpasswd.value =="" || secondpasswd.value ==""){
		setErrReg();
		document.getElementById("info").innerHTML = ' Please enter all fields';
		return false;
	}else{
		//ensure user name is valid 
		if(posn != 0){
			setErrReg();
			document.getElementById("info").innerHTML = " Your name muse be start at character.";
			return false;
		}
		//ensure email address is valid
		if(pose != 0){
			setErrReg();
			document.getElementById("info").innerHTML = " Please enter a valid email address!";
			return false;
		}
		//ensure password is valid 	
		if(posp != 0){
			setErrReg();
			document.getElementById("info").innerHTML = " Your password must be at least 6 characters long. Please try another.";
			return false;
		}
		//ensure passwords are matched
		if(initpasswd.value !== secondpasswd.value){
			setErrReg();
			document.getElementById("info").innerHTML = " Your password must match.";
			return false;
		}
	}
	return true;
}

//check dup email during sign up
function cksignupemail(){
	//check email whether validate
	var emailElement = document.getElementById("signupemail");
	var pose = emailElement.value.search(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\" +"".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
	if(pose != 0){
		setErrReg();
		document.getElementById("info").innerHTML = " Please enter a valid email address.";
	} else {
		//unsetErrReg();
		//Ajax check whether used has been used
	
		xhr = new XMLHttpRequest();
		//register the embedded receiver function as the handler
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && xhr.status == 200){
				var result = xhr.responseText;
				if(result == "true"){
					setErrReg();
					document.getElementById("info").innerHTML = "This email address has been used. Please try another.";
					
				} else {
					unsetErrReg();
				}
			}
		};
		xhr.open("GET", "server/dup_user.php?email="+emailElement.value);
		xhr.send(null);
	}

	
}


