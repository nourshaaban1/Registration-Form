<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" description" content="Registration Form">
    <title>Registration Form</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <style>
        .error {
            font-size: 0.8em;
            margin-top: 5px;
            display: block;
        }
        .available {
            color: green;
        }
        .taken {
            color: red;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="heading">
            <h1>Welcome to Registration Form</h1>
            <p>Please fill out the form below to get into our hilarious community.</p>
        </div>
    </div>

    <form action="DB_Ops.php" method="post">
        <div class="form">
            <div class="left">
                <div class="form-group">
                    <input type="text" id="full_name" name="full_name" placeholder="Full Name">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="text" id="user_name" name="user_name" placeholder="User Name" required>
                    <span class="error" id="username-error"></span>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="text" id="password" name="password" placeholder="Password">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="text" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="text" id="address" name="address" placeholder="Address">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="text" id="phone" name="phone" placeholder="Phone">
                    <span class="error"></span>
                </div>
            </div>
            <div class="right">
                <div class="form-group whatsapp">
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="Whatsapp">
                    <span class="error"></span>
                    <button type="button" id="whatsapp-button">✔</button>
                </div>
                <div class="upload-container">
                    <input type="file" id="fileInput" name="image" accept="image/*" class="file-input" />
                    <label for="fileInput" class="upload-box">
                        <div class="preview-container">
                            <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#008F17">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <div class="upload-text">
                                <span class="upload-title">Upload Profile Picture</span>
                                <span class="upload-subtitle">Click to browse or drag & drop</span>
                            </div>
                        </div>
                    </label>
                    <p class="file-size-text">JPG, PNG (Max. 10MB)</p>
                </div>

                <div class="submit-btn">
                    <button type="submit" id="submit" name="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        const usernameInput = document.getElementById('user_name');
        const usernameError = document.getElementById('username-error');
        let typingTimer;

        async function checkUsername() {
            const username = usernameInput.value.trim();
            
            if (username.length < 3) {
                usernameError.textContent = '';
                return;
            }

            try {
                const response = await fetch(`DB_Ops.php?username=${encodeURIComponent(username)}`);
                const result = await response.json();
                usernameError.textContent = result.message;
                usernameError.className = result.available ? 'available' : 'taken';
            } catch (error) {
                usernameError.textContent = 'Error checking username';
                usernameError.className = 'error';
                console.error('Error:', error);
            }
        }

            usernameInput.addEventListener('input', function() {
                clearTimeout(typingTimer);
                usernameError.textContent = 'Checking...';
                usernameError.className = 'error';
                typingTimer = setTimeout(checkUsername, 500);
            });

        usernameInput.addEventListener('blur', checkUsername);
    </script>
</body>
</html>