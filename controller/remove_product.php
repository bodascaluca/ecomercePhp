<?php 
    session_start();

    if(isset($_SESSION['id_utente']) && isset($_POST['id_carrello']) && isset($_POST['remove_from_cart']) ){
       
        $userID = $_SESSION['id_utente'];
        $cartID = $_POST['id_carrello'];

        require '../model/conndb.php';

        $stmt = $conn->prepare("DELETE FROM ecommercedb5.carello where id =? ");
        $stmt->bind_param("i",$cartaID);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();

        header("Location: carrello.php");
        die();
    }



?>
