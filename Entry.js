function showSignUp() {
    document.getElementById("login_Body").style.display = "none";
    document.getElementsByClassName("signup_Body", "signup_Form")[0].style.display = "block";
  }

  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var showPasswordButton = document.getElementById("showPasswordButton");

    // working on this
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordButton.textContent = "Hide";
    } else {
      passwordInput.type = "password";
      showPasswordButton.textContent = "Show";
    }
}