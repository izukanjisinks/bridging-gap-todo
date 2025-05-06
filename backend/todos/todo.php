<?php class TODO {
    private $title;
    private $description;
    private $completed;

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCompleted($completed) {
        $this->completed = $completed;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getCompleted() {
        return $this->completed;
    }

}

?>