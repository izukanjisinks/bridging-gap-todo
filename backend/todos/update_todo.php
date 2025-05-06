<?php
require_once '../cors/cors.php';
require_once 'todo_db_connection.php';

class UPDATE_TODO {
    private $todo;
    private $pdo;
    
    function __construct($pdo, $todo) {
        $this->todo = $todo;
        $this->pdo = $pdo;
    }

    function update_todo(): void {
        $sql = "UPDATE todos SET title = :title, description = :description, completed = :completed WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $this->todo['id'], PDO::PARAM_INT);
        $stmt->bindParam(':title', $this->todo['title']);
        $stmt->bindParam(':description', $this->todo['description']);
        $stmt->bindParam(':completed', $this->todo['completed']);
        $stmt->execute();
        
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if($data){

        //sanitize user input data from our frontend
        $id = $data['id'];
        $title = htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');
        $completed = filter_var($data['completed'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
   
   
   
       $todoHandler = new UPDATE_TODO($pdo, [
           'id' => $id,  
           'title' => $title,
           'description' => $description,
           'completed' => $completed
        ]);
       $todoHandler->update_todo();
       echo json_encode($data);
   }

}

?>