<?php

namespace Models;

class Post
{
    // Database
    private $conn;
    private $table = 'posts';

    // Properties
    public $id;
    public $title;
    public $content;
    public $author;
    public $created_at;
    public $updated_at;

    // Constructor with Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts
    public function getAll()
    {
        // Query
        $query = "SELECT * FROM " . $this->table;

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post
    public function getSingle()
    {
        // Query
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch();

        // Set properties
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->title = $row['title'];
    }

    // Create Post
    public function post()
    {
        // Create query
        $query = "INSERT INTO " . $this->table . " SET title = :title, content = :content, author = :author";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':author', $this->author);

        //Execute query
        if ($stmt->execute())
        {
            return true;
        }

        // Print error if something goes wrong
        printf('Error: %s.\n', $stmt->error);

        return false;
    }

    // Update Post
    public function put()
    {
        // Create query
        $query = "UPDATE " . $this->table . " SET title = :title, content = :content, author = :author WHERE id = :id";

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':author', $this->author);

        //Execute query
        if ($stmt->execute())
        {
            return true;
        }

        // Print error if something goes wrong
        printf('Error: %s.\n', $stmt->error);

        return false;
    }

    // Delete Post
    public function delete()
    {
        // Create query
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind id
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if ($stmt->execute())
        {
            return true;
        }

        // Print error if something goes wrong
        printf('Error: %s.\n', $stmt->error);

        return false;
    }
}