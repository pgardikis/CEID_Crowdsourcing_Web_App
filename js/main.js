function openLoginForm() {
  document.getElementById("loginForm").style.display = "block";
}
function closeLoginForm() {
  document.getElementById("loginForm").style.display = "none";
}
function openSignupForm() {
  document.getElementById("signupForm").style.display = "block";
}
function closeSignupForm() {
  document.getElementById("signupForm").style.display = "none";
}

function openNav() {
  document.getElementById("mySidebar").style.width = "234px";
  document.getElementById("main").style.marginLeft = "234px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}