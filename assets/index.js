document
  .getElementById("togglePassword")
  .addEventListener("click", togglePasswordField);
document
  .getElementById("toggleConfirmPassword")
  .addEventListener("click", toggleConfirmPasswordField);

function togglePasswordField() {
  const passwordInput = document.getElementById("password");
  const toggleIcon = document.getElementById("togglePassword");
  passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  toggleIcon.classList.toggle("bi-eye-slash");
  toggleIcon.classList.toggle("bi-eye");
}

function toggleConfirmPasswordField() {
  const confirmPassInput = document.getElementById("confirm_pass");
  const toggleIcon = document.getElementById("toggleConfirmPassword");
  confirmPassInput.type =
    confirmPassInput.type === "password" ? "text" : "password";
  toggleIcon.classList.toggle("bi-eye-slash");
  toggleIcon.classList.toggle("bi-eye");
}
