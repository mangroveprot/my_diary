//Eye Icon toggle password
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
//End Of Function for toggle password

//Back to previous page
function goBack() {
    window.history.back();

}
//Diarys entry validation 
function SubmitEntryValidation() {
      var title = document.getElementById("title").value;
      var content = document.getElementById("content").value;
      var errorMessage = document.getElementById("error_message");
      errorMessage.textContent = '';
      
      if (title === "" || content === "") {
      errorMessage.textContent = "Please fill out all required fields.";
        return false;
      }
      return true;
    }
//End of entry Function

//Login Validation
function LoginValidateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      
      if (username === "" || password === "") {
      document.getElementById("notification").style.display = "block";
      return false;
      } else {
      document.getElementById("notification").style.display = "none";
      return true;
      }
 }
 //End Of Log in validation form 
 
 // Sign Up Validation
 function SignUpValidateForm() {
            var requiredFields = ["username", "password", "confirm_pass", "first_name", "last_name", "gender"];
            var errorMessage = document.getElementById("error_message");
            errorMessage.textContent = '';

            for (var i = 0; i < requiredFields.length; i++) {
                var field = document.getElementById(requiredFields[i]);
                if (!field.value.trim()) {
                    errorMessage.textContent = "Please fill out all required fields.";
                    return false;
                }
            }
            return true;
 }
 //End of sugn up validation
 
//Modals Function
function openEditModal() {

    document.getElementById("editModal").style.display = "block";

}

function closeEditModal() {

    document.getElementById("editModal").style.display = "none";

}

function openDeleteModal() {

    document.getElementById("deleteModal").style.display = "block";

}

function closeDeleteModal() {

    document.getElementById("deleteModal").style.display = "none";

}
//End Of Modals