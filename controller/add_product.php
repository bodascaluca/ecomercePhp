<?php

session_start();

if(isset($_session['id_utente']) && isset($_post['add_to_cart']) ){

   {
    $userID = $_session['id_utente'];
    $prodID = $_POST['id_prodotto'];
    $qty = $_POST['qty'];

    require '../model/conndb.php';

    $stmt = $conn->prepare("SELECT  id, quantita 
    from ecomercedb5.carello 
    where id_utente? and id_prodotto=?");

    $stmt->bind_param("ii", $userID, $prodID);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $resultC->fetch_assoc();
   if($res){
    $id_carello = $res["id"];
    $current_qty = $res["quantita"];
    $current_qty += $qty;

    $stm2 = $conn ->prepare("UPDATE ecomercedb5.carello
                        SET quantita =? 
                        where id = ? ");
     $stmt2-> bind_param("ii", $current_qty, $id_carello);                   
     $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        header("Location: ../view/carello.php"); 
        die();
    
   }else{

    $stmt = $conn->prepare("INSERT INTO ecommercedb5.carello
    (id_utente, id_prodotto ,quantita)
    VALUES(?,?,?)");
    //s sta per string, i per integer
    $stmt->bind_param("iii", $userID, $prodID, $qty);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    header("Location: ../view/carello.php"); 
    die();

   }
   

}

}
?>