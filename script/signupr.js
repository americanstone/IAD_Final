//signupr.js
//register the event handlers for sign up
//check sign up form 
document.getElementById("signupform").onsubmit = cksignup;
//check whether email has been used when sign up
document.getElementById("signupemail").onblur = cksignupemail;

