const form = document.querySelector("form");
const fullName = document.getElementById("full_name");
const userName = document.getElementById("user_name");
const email = document.getElementById("email");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm_password");
const phone = document.getElementById("phone");
const whatsapp = document.getElementById("whatsapp");
const address = document.getElementById("address");

const fileInput = document.getElementById("fileInput");
document.querySelectorAll(".error").forEach((el) => (el.textContent = ""));

form.addEventListener("submit", function (event) {
  let isValid = true;

  // Reset all error messages

  // Full Name Validation
  if (fullName.value.trim() === "") {
    showError(fullName, "Full Name is required");
    isValid = false;
  }

  // User Name Validation
  if (userName.value.trim() === "") {
    showError(userName, "User Name is required");
    isValid = false;
  }

  // Email Validation
  if (!validateEmail(email.value)) {
    showError(email, "Enter a valid email");
    isValid = false;
  }

  // Password Validation
  const passwordRegex = /^(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
  if (!passwordRegex.test(password.value)) {
    showError(
      password,
      "Password must be at least 8 characters, include 1 number & 1 special character"
    );
    isValid = false;
  }

  // Confirm Password Validation
  if (password.value !== confirmPassword.value) {
    showError(confirmPassword, "Passwords do not match");
    isValid = false;
  }

  if (phone.value.trim() === "") {
    showError(phone, "Phone number is required");
    isValid = false;
  }
  if (address.value.trim() === "") {
    showError(address, "Address is required");
    isValid = false;
  }
  if (whatsapp.value.trim() === "") {
    showError(whatsapp, "WhatsApp number is required");
    isValid = false;
  }
  // File Upload Validation
  if (fileInput.files.length === 0) {
    showError(fileInput, "Image upload is required");
    isValid = false;
  }

  // Prevent form submission if validation fails
  if (!isValid) {
    event.preventDefault();
  }
});

// Show error message
function showError(input, message) {
  const errorSpan = input.nextElementSibling;
  if (errorSpan) {
    errorSpan.textContent = message;
    errorSpan.style.color = "#D40D0D";
    errorSpan.style.fontSize = "14px";
  }
}

// Email Validation Function
function validateEmail(email) {
  const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return re.test(email);
}
