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

// Blog post query
$result = $post->getAll();
// Get row count
$num = $result->rowCount();

// Check if any posts
if ( $num > 0 )
{
    // Post array
    $post_arr = array();
    $posts_arr['data'] = array();

    while ( $row = $result->fetch())
    {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'content' => html_entity_decode($content),
            'author' => $author
        );

        // Push to 'data'
        array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON and output
    echo json_encode($posts_arr);
} else
{
    // No Posts message
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}