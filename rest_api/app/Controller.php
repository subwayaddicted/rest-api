<?php
/**
 * Created by PhpStorm.
 * User: VN
 * Date: 24.08.2018
 * Time: 20:12
 */

namespace App;


class Controller
{
    public function create()
    {
        // Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

        include_once '../config/Database.php';
        include_once '../models/Post.php';

        // Database creation and connection
        $database = new \DB\Database();

        // Blog post object
        $post = new \Models\Post($database);

        // Get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        $post->title = $data->title;
        $post->content = $data->content;
        $post->author = $data->author;

        if ($post->post())
        {
            echo json_encode(
                array('message' => 'Post Created')
            );
        } else
        {
            echo json_encode(
                array('message' => 'Post Not Created')
            );
        }
    }

    public function delete()
    {
        // Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

        include_once '../config/Database.php';
        include_once '../models/Post.php';

        // Database creation and connection
        $database = new \DB\Database();

        // Blog post object
        $post = new \Models\Post($database);

        // Get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        // Set ID to update
        $post->id = $data->id;

        // Delete post
        if ($post->delete())
        {
            echo json_encode(
                array('message' => 'Post Deleted')
            );
        } else
        {
            echo json_encode(
                array('message' => 'Post Not Deleted')
            );
        }
    }

    public function read()
    {
        // Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        include_once '../config/Database.php';
        include_once '../models/Post.php';

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
    }

    public function read_single()
    {
        // Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        include_once '../config/Database.php';
        include_once '../models/Post.php';

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
    }

    public function update()
    {
        // Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');

        include_once '../config/Database.php';
        include_once '../models/Post.php';

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
    }
}