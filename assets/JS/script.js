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
const usernameError = document.getElementById("username-error");
let typingTimerUsername;
let isValid = true;

// Listen for file input changes to remove error if an image is selected
fileInput.addEventListener("change", function () {
  if (fileInput.files.length > 0) {
    removeError(fileInput);
  }
});

form.addEventListener("submit", async (event) => {
  isValid = true; // Reset validation state

  // Reset all error messages
  document.querySelectorAll(".error").forEach((el) => (el.textContent = ""));

  // Full Name Validation
  if (fullName.value.trim() === "") {
    showError(fullName, "Full Name is required");
    isValid = false;
  }

  // User Name Validation
  if (userName.value.trim() === "") {
    showError(userName, "User Name is required");
    isValid = false;
  } else if (!/^[a-zA-Z0-9_]{3,20}$/.test(userName.value)) {
    showError(
      userName,
      "Username must be 3-20 characters (letters, numbers, underscore)"
    );
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
  } else if (confirmPassword.value.trim() === "") {
    showError(confirmPassword, "Confirm Password is required");
    isValid = false;
  }

  // Phone, WhatsApp, and Address Validation
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
  } else {
    removeError(fileInput);
    isValid = true;
  }

  // Prevent form submission if validation fails
  if (!isValid) {
    event.preventDefault();
  }
});

// Show error message
function showError(input, message) {
  let errorSpan = input.nextElementSibling;
  if (errorSpan) {
    errorSpan.textContent = message;
    errorSpan.style.color = "#D40D0D";
    errorSpan.style.fontSize = "14px";
  }
  if (message === "Username available") {
    errorSpan.style.color = "#008F17";
  }
}

// Remove error message
function removeError(input) {
  let errorSpan = input.nextElementSibling;
  if (errorSpan) {
    errorSpan.textContent = "";
  }
}

// Email Validation Function
function validateEmail(email) {
  const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return re.test(email);
}

// Username availability check
async function checkUsername() {
  const username = userName.value.trim();

  if (username.length < 3) {
    usernameError.textContent = "";
    return;
  }

  try {
    const response = await fetch(
      `DB_Ops.php?username=${encodeURIComponent(username)}`
    );
    const result = await response.json();
    usernameError.textContent = result.message;
    usernameError.className = result.available ? "available" : "taken";
    isValid = result.available;
  } catch (error) {
    usernameError.textContent = "Error checking username";
    usernameError.className = "error";
    console.error("Error:", error);
  }
}

userName.addEventListener("keyup", function () {
  clearTimeout(typingTimerUsername);
  usernameError.textContent = "Checking...";
  usernameError.className = "error";
  typingTimerUsername = setTimeout(checkUsername, 500);
});

userName.addEventListener("blur", checkUsername);
