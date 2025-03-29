<?php

if(isset($_POST['post_likes'])){

    if($slemania_id != ''){
        
        $post_id = $_POST['post_id'];
        $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
        $author_id = $_POST['author_id'];
        $author_id = filter_var($author_id, FILTER_SANITIZE_STRING);
        
        $select_post_like = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ? AND slemania_id = ?");
        $select_post_like->execute([$post_id, $slemania_id]);

        if($select_post_like->rowCount() > 0){
            $remove_like = $conn->prepare("DELETE FROM `likes` WHERE post_id = ? AND slemania_id = ?");
            $remove_like->execute([$post_id, $slemania_id]);
            $message[] = 'Berhasil hapus dari likes';
        }else{
            $add_like = $conn->prepare("INSERT INTO `likes`(slemania_id, author_id, post_id) VALUES(?,?,?)");
            $add_like->execute([$slemania_id, $author_id, $post_id]);
            $message[] = 'Berhasil ditambah ke likes';
        }
        
    }else{
            $message[] = 'harap login terlebih dahulu!';
    }

}

?>