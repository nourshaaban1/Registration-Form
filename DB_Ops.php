<?php
// Database configuration
header("Content-Type: application/json");
$servername = "localhost";
$admin_username = "root";
$admin_password = "";
$dbname = "ur_wp";

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new mysqli($servername, $admin_username, $admin_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $username = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');

    // TODO: Image handling
    $image = $_POST['image'] ?? '';

    // Validation
    if (empty($username)) {
        $errors['username'] = "Username is required";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errors['username'] = "Username must be 3-20 characters (letters, numbers, underscore)";
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


    try {
        if ($conn->connect_error) {
            throw new Exception('Connection Failed: ' . $conn->connect_error);
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `users` (`user_name`, `email`, `password`, `full_name`, `address`, `phone`, `whatsapp`, `image`) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssss", $username, $email, $hashed_password, $full_name, $address, $phone, $whatsapp, $image);

        if ($stmt->execute()) {
            $success = true;
            $username = $email = $password = $full_name = $address = $phone = $whatsapp = $image = '';
        } else {
            throw new Exception("Insert failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        $errors['database'] = "Database error: " . $e->getMessage();
        if ($e->getCode() === 1062) {
            $data = array("status" => "failed", "message" => "Username already exists");
            echo json_encode($data);
            exit();
        }
    } finally {
        $stmt->close();
        $conn->close();

        if ($success) {
            echo "Registration successful!";
        } else {
            echo "Registration failed! <br>";
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }
}
