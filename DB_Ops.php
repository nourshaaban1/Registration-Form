<?php
header("Content-Type: application/json");
$servername = "localhost";
$admin_username = "root";
$admin_password = "";
#$dbname = "ur_wp";
$dbname = "registration_db";

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) { //username check ajax request
    $username = trim($_GET['username']);

    $conn = new mysqli($servername, $admin_username, $admin_password, $dbname);

    $stmt = $conn->prepare("SELECT id FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['available' => false, 'message' => 'Username already taken']);
    } else {
        echo json_encode(['available' => true, 'message' => 'Username available']);
    }

    $stmt->close();
    $conn->close();
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') { //form submit
    $conn = new mysqli($servername, $admin_username, $admin_password, $dbname);
    if ($conn->connect_error) {
        die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]));
    }

    $username = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $image = $_FILES['image']['name'] ?? null;

    if (empty($username)) { //validation
        $errors['username'] = "Username is required";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errors['username'] = "Username must be 3-20 characters";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    }

    if (empty($full_name)) {
        $errors['full_name'] = "Full name is required";
    }

    if (!$image) {
        $errors['image'] = "Image upload failed or no file selected";
    }

    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `users` (`user_name`, `email`, `password`, `full_name`, `address`, `phone`, `whatsapp`, `image`) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssss", $username, $email, $hashed_password, $full_name, $address, $phone, $whatsapp, $image);

        if ($stmt->execute()) {
            $success = true;
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES['image']['name']);
            echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        } else {
            throw new Exception("Insert failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Registration failed: ' . $e->getMessage()
        ]);
    } finally {
        if (isset($check_stmt)) $check_stmt->close();
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
    exit();
}
