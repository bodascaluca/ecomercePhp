<?php

session_start();

if(isset($_SESSION['id_utente']) && isset($_POST['add_to_cart']) ){

   {
    $userID = $_SESSION['id_utente'];
    $prodID = $_POST['id_prodotto'];
    $qty = $_POST['qty'];

    echo $userID, $prodID, $qty ;

    require '../model/conndb.php';
//Faccio una query per vedere se ce un record per quel prodotto
    $stmt = $conn->prepare("SELECT  id, quantita 
                            from ecommercedb5.carello 
                            where id_utente=? and id_prodotto=?");

    $stmt->bind_param("ii", $userID, $prodID);
    $stmt->execute();
    $resultC = $stmt->get_result();//Mi prendo il risultato
    $res = $resultC->fetch_assoc();
   if($res){ // vedo se ho avuto qualche risultato, se è vero risolvo questa quantità
        $id_carrello = $res["id"];
        $current_qty = $res["quantita"];
        $current_qty += $qty;

        $stmt2 = $conn ->prepare("UPDATE ecommercedb5.carello
                            SET quantita =? 
                            where id = ? ");
        $stmt2-> bind_param("ii", $current_qty, $id_carrello);                   
        $stmt2->execute();
            $conn->close();
            header("Location: ../view/carrello.php"); 
            die();
   }else{

        $stmt3 = $conn->prepare("INSERT INTO ecommercedb5.carello
                                (id_utente, id_prodotto ,quantita)
                                VALUES(?,?,?)");
        //s sta per string, i per integer
        $stmt3->bind_param("iii", $userID, $prodID, $qty);
        $stmt3->execute();
        $conn->close();
        header("Location: ../view/carrello.php"); 
        die();

   }
   

}

}
?>