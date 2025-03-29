<?php

if(isset($_POST['add_to_wishlist'])){

    if($slemania_id == ''){
        header('location:slemania_login.php');
    }else{
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND slemania_id = ?");
        $check_wishlist_numbers->execute([$name, $slemania_id]);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND slemania_id = ?");
        $check_cart_numbers->execute([$name, $slemania_id]);

        if($check_wishlist_numbers->rowCount() > 0){
            $message[] = 'sudah ada dalam wishlist!';
        }elseif($check_cart_numbers->rowCount() > 0){
            $message[] = 'sudah ada dalam keranjang belanja!';
        }else{
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(slemania_id, pid, name, price, image) VALUES(?,?,?,?,?)");
            $insert_wishlist->execute([$slemania_id, $pid, $name, $price, $image]);
            $message[] = 'selesai ditambahkan ke wishlist!';
        }
    }
}

if(isset($_POST['add_to_cart'])){

    if($slemania_id == ''){
        header('location:slemania_login.php');
    }else{
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);
        $selected_size = isset($_POST['selected_size']) ? $_POST['selected_size'] : 'Default';
        $selected_size = filter_var($selected_size, FILTER_SANITIZE_STRING);

        $get_seller_id = $conn->prepare("SELECT seller_id FROM products WHERE id = ?");
        $get_seller_id->execute([$pid]);
        $product_data = $get_seller_id->fetch(PDO::FETCH_ASSOC);

        if($product_data){
            $seller_id = $product_data['seller_id'];
        } else {
            $seller_id = null; // Jika produk tidak ditemukan
        }

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND slemania_id = ?");
        $check_cart_numbers->execute([$name, $slemania_id]);

        if($check_cart_numbers->rowCount() > 0){
            $message[] = 'sudah ada pada keranjang belanja!';
        }else{
            $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND slemania_id = ?");
            $check_wishlist_numbers->execute([$name, $slemania_id]);

            if($check_wishlist_numbers->rowCount() > 0){
                $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND slemania_id = ?");
                $delete_wishlist->execute([$name, $slemania_id]);
            }

            $insert_cart = $conn->prepare("INSERT INTO `cart`(slemania_id, pid, name, price, quantity, image, seller_id, size) VALUES(?,?,?,?,?,?,?,?)");
            $insert_cart->execute([$slemania_id, $pid, $name, $price, $qty, $image, $seller_id, $selected_size]);
            $message[] = 'selesai ditambahkan ke keranjang belanja!';
        }
    }
}

?>