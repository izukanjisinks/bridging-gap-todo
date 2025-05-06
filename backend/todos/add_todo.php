<?php 
require_once 'todo_db_connection.php';
require_once '../cors/cors.php';


class ADD_TODO {
    private $todo;
    private $pdo;
    
    function __construct($pdo, $todo) {
        $this->todo = $todo;
        $this->pdo = $pdo;
    }

    function save_todo(): void {
        $sql = "INSERT INTO todos (title, description, completed, user_id) VALUES (:title, :description, :completed, :user_id)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $this->todo['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':title', $this->todo['title']);
        $stmt->bindParam(':description', $this->todo['description']);
        $stmt->bindParam(':completed', $this->todo['completed']);
        $stmt->execute();
        
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if ($data) {
        //sanitize user input data from our frontend
        $user_id = filter_var($data['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $title = htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');
        $completed = filter_var($data['completed'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

       $addTodoHandler = new ADD_TODO($pdo,[
        'user_id' => $user_id,  
        'title' => $title,
        'description' => $description,
        'completed' => $completed
     ]);

     $addTodoHandler->save_todo();

     //send a response back to the frontend
     echo json_encode([
        'user_id' => $user_id,  
        'title' => $title,
        'description' => $description,
        'completed' => $completed
     ]);
    }
}



?>