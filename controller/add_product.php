<?php

session_start();

if(isset($_SESSION['id_utente']) && isset($_POST['add_to_cart']) ){

   {
    $userID = $_SESSION['id_utente'];
    $prodID = $_POST['id_prodotto'];
    $qty = $_POST['qty'];

    echo $userID, $prodID, $qty ;

    require '../model/conndb.php';

    $stmt = $conn->prepare("SELECT  id, quantita 
    from ecommercedb5.carello 
    where id_utente=? and id_prodotto=?");

    $stmt->bind_param("ii", $userID, $prodID);
    $stmt->execute();
    $resultC = $stmt->get_result();
    $res = $resultC->fetch_assoc();
   if($res){
    $id_carello = $res["id"];
    $current_qty = $res["quantita"];
    $current_qty += $qty;

    $stm2 = $conn ->prepare("UPDATE ecommercedb5.carello
                        SET quantita =? 
                        where id = ? ");
     $stmt2-> bind_param("ii", $prodID, $qty);                   
     $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        header("Location: ../view/carrello.php"); 
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
    //echo "inserimento avvenuto con successo!";
    header("Location: ../view/carrello.php"); 
    die();

   }
   

}

}
?>