<?php 
    session_start();
    if(isset($_SESSION['id_utente']) && isset($_POST['annulla_ordine'])){
        $userID = $_SESSION['id_utente'];
        require '../model/conndb.php';

        //prendiamo tutti gli id degli ordini per l'utente corrente
        $stmt = $conn->prepare("SELECT id 
                                FROM ecommercedb5.ordini
                                WHERE id_utente=?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

            while($row = $result->fetch_assoc()){

                //elimino le associzioni ordini prodotti
                $stmt2 = $conn->prepare("DELETE FROM ecommercedb5.ordini_prodotti WHERE id_ordine=? ") ;
                $stmt2->bind_param("i", $row["id"]);
                $stmt2->execute();

                //elimino l'ordine
                $stmt3 = $conn->prepare("DELETE FROM ecommercedb5.ordini WHERE id=? ") ;
                $stmt3->bind_param("i", $row["id"]);
                $stmt3->execute();
            }
        }
        $conn->close();
        header("Location: ../view/prodotti.php");
        die();
    }
?>