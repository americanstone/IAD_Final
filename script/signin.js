//check logon 
function cksignin(){
	var email = document.getElementById("email").value;
	var passwd = document.getElementById("passwd").value;
	//Ajax check email and password are matched
	
	var xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function (){
		if(xhr.readyState == 4 && xhr.status == 200){
			var result = xhr.responseText;
			//alert(result);
			if(result == "true"){
				window.location.replace("/sbls/mycourse.php");
			}
			else if(result == "false"){	
				document.getElementById("email").style.borderColor = "red";
				document.getElementById("passwd").style.borderColor = "red";
				alert("email & password wrong!");
				return false;
			}else{
				alert("[ERROR--logon.js]Something worng on server!");
				return false;
			}
		}
	};
	xhr.open("POST","server/signin.php?email="+email+"&passwd="+passwd);
	xhr.send(null);
	
}
