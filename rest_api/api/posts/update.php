<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Database creation and connection
$database = new \DB\Database();

// Blog post object
$post = new \Models\Post($database);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$post->id = $data->id;

$post->title = $data->title;
$post->content = $data->content;
$post->author = $data->author;

// Update post
if ($post->put())
{
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else
{
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}