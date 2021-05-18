<?php 
    require('db.inc.php');
    require('function.php');
    if (isset($_POST['update_post'])) {
        $post_id = $_POST['post_id_for_modify'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category_id = $_POST['category_id'];
       
        if (isset($_FILES['post_update_image'])) {
            print_r($_FILES['post_update_image']);
            // delete image in server storage
            $query = "SELECT image FROM images WHERE post_id = '$post_id'";
            $run = $conn->query($query);
            while ($d = $run->fetch_assoc()) {
                unlink('../images/'. $d['image']);
            }

            // delete image in Database
            $query = "DELETE FROM images WHERE post_id = '$post_id'";
            $run = $conn->query($query);

            $image_name = $_FILES['post_update_image']['name'];
            $image_tmp = $_FILES['post_update_image']['tmp_name'];

            foreach ($_FILES["post_update_image"]["tmp_name"] as $key => $tmp_name){
                move_uploaded_file($_FILES['post_update_image']['tmp_name'][$key], '../images/' . $_FILES['post_update_image']['name'][$key]);
                $query = "INSERT INTO images(post_id, image) VALUES ('$post_id', '$image_name[$key]');";
                $run = $conn->query($query);
            }
        }

        $query = "UPDATE posts SET title = '$title', content = '$content', category_id = $category_id WHERE id = $post_id";
        if (mysqli_query($conn, $query)) {
            redirect('../post.php?id='. $post_id);
        }
        else  {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>