<?php
require_once '../cors/cors.php';
require_once '../users/users_db_connection.php';



// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);
    
    $email = trim($data['email']);
    $password = trim($data['password']);

   
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        echo json_encode(['status' => 'success', 'message' => 'Login successful.', 'user' => $user]);
    }else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }
} 
?>