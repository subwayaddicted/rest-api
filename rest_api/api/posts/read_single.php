<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Database creation and connection
$database = new \DB\Database();

// Blog post object
$post = new \Models\Post($database);

// Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$post->getSingle();

// Create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'content' => $post->content,
    'author' => $post->author
);

// Make JSON
print_r(json_encode($post_arr));