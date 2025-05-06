<?php
require_once '../cors/cors.php';
require_once '../users/users_db_connection.php';

    // Function to sanitize input
    function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*
        sanitize the data
        from frontend to remove 
        any unwanted characters
        */

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $username = sanitizeInput($data['username'] ?? '');
        $email = sanitizeInput($data['email'] ?? '');
        $password = sanitizeInput($data['password'] ?? '');

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if($existingUser && $existingUser['email'] == $email){
            echo json_encode(['status' => 'error', 'message' => 'This email is already in use!']);
            exit;
        }else{

        try {
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {

                echo json_encode(['status' => 'success', 'message' => 'User registered successfully.']);          
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
            }
        } catch (PDOException $e) {
            echo 'Database error: ';
        }
        }

        
    } 
?>