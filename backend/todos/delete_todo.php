<?php 

require_once 'todo_db_connection.php';
require_once '../cors/cors.php';

class DELETE_TODO {
    private $pdo;
    
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function delete($id): void {
        $this->delete_todo($id);
    }

    private function delete_todo($id): void {
        $sql = "DELETE FROM todos WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    $id = $data['id'] ?? null; // Get the id from the query string, if available
    if ($id) {
        $todoHandler = new DELETE_TODO($pdo);
        $todoHandler->delete($id);
        
        echo json_encode(["success" => "Todo deleted successfully"]);
    } else {
        echo json_encode(["error" => "No ID provided"]);
    }

}

?>