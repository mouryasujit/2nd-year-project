<?php

class Video {
    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj){
        // connection variable
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        // if it's an array then it's sqlData else it's an id
        if(is_array($input)) {
            $this->sqlData = $input;
        } else {
            // query to get user data from db
            $query = $this->con->prepare("SELECT * FROM videos WHERE id = :id");
            $query->bindParam(":id", $input);
            $query->execute();       
            // instead of making a query request every time data stored in sqlData variable
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getUploadedBy() {
        return $this->sqlData["uploadedBy"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getPrivacy() {
        return $this->sqlData["privacy"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getCategory() {
        return $this->sqlData["category"];
    }

    public function getUploadDate() {
        return $this->sqlData["uploadDate"];
    }

    public function getViews() {
        return $this->sqlData["views"];
    }

    public function getDuration() {
        return $this->sqlData["duration"];
    }

    // a simple function to increment the views
    public function incrementViews() {
        // Increment the views in db
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        
        $videoId = $this->getId();
        $query->bindParam(":id", $videoId);
        $query->execute();
        
        // Increment the views value in the array
        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }

    public function getLikes() {
        // Select the number of rows returned count(*) means number of rows it found
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM likes WHERE videoId = :videoId");
        $videoId = $this->getId();
        $query->bindParam(":videoId", $videoId);
    }

}
?>