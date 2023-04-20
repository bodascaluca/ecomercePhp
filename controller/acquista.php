<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>      
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php 
    session_start();
    require '../model/conndb.php';

    if(isset($_SESSION['id_utente'])){

        echo "Andata bene";

            $idUtente = $_SESSION['id_utente'];

            $dataCorrente = date("Y-m-d");
            $stmt2 = $conn->prepare("UPDATE ecommercedb5.ordini 
                                    SET order_date = ? , acquisto=1
                                    WHERE id_utente= ? and acquisto=0");
            $stmt2->bind_param("si", $dataCorrente, $idUtente);
            $stmt2->execute();
            echo $stmt2->error;
            echo $conn->connect_error;
            $conn->close();

            header("Location: ../view/prodotti.php");
            die();
            
        }else{
            echo "errore";
        }
?>


<!-- //prendo tutti i prodotti presenti nel carello dell'utente leggato
        $stmt = $conn->prepare("SELECT c.id, c.id_prodotto, c.quantita, p.prezzo
                                FROM ecommercedb5.carello c, ecommercedb5.prodotti p
                                WHERE c.id_utente=? AND c.id_prodotto = p.id");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $resultC = $stmt->get_result();  -->