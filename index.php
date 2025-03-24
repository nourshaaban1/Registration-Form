<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" description" content="Registration Form">
    <title>Registration Form</title>
    <link rel="stylesheet" href="/assets/styles/style.css">
    <script defer src="/assets/JS/API_Ops.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="heading">
            <h1>Welcome to Registration Form</h1>
            <p>Please fill out the form below to get into our hilarious community.</p>
        </div>
    </div>
    <!-- <div class="container"> -->

    <form action="index.php" method="get">
        <div class="form">
            <div class="left">
                <div class="form-group">
                    <input type="text" id="full_name" name="full_name" placeholder="Full Name">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="text" id="user_name" name="user_name" placeholder="User Name">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
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
                        <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v4a2 2 0 002 2h12a2 2 0 002-2v-4m-4-4l-4-4m0 0l-4 4m4-4v12"></path>
                        </svg>
                        <span>Upload Additional File</span>
                    </label>
                    <p class="file-size-text">Attach file. File size of your documents should not exceed 10MB</p>
                </div>


                <div class="submit-btn">
                    <button type="submit" id="submit" name="submit">Submit</button>
                </div>
            </div>

        </div>

    </form>

    <!-- </div> -->
    <!-- <?php include 'footer.php'; ?> -->
    <script src="/assets/JS/script.js"></script>
</body>

</html>