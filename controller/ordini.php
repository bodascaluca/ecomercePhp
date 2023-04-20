
    <?php 
        session_start();
        //include("../view/header.html");

        if(isset($_SESSION['id_utente']) && isset($_POST['order_confirm'])){ // se hai cliccato order confirm
            
            
            $username = $_SESSION["username"];
            echo " <h1> Ordini di $username </h1>";
            
            $userID=$_SESSION['id_utente'];

            require '../model/conndb.php';
            //prendo tutti i prodotti
            $stmt = $conn->prepare(" SELECT c.id, c.id_prodotto, c.quantita, p.nome, p.prezzo
                                    FROM ecommercedb5.carello c, ecommercedb5.prodotti p 
                                    WHERE c.id_utente=? and c.id_prodotto= p.id");
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $resultC= $stmt->get_result();//ci prendiamo il risultato

            if($resultC->num_rows>0){

                $dataOrdine=""; 

                $stmt2 = $conn->prepare("INSERT INTO ecommercedb5.ordini
                                        (id_utente,order_date)
                                        VALUES(?,?)");
                $stmt2->bind_param("is", $userID,$dataOrdine);
                $stmt2->execute();

                $stmt2 = $conn->prepare("SELECT LAST_INSERT_ID();");
                $stmt2->execute();

                $orderId = $stmt2 -> get_result()->fetch_array()[0]; //prima posizione dell'array
                
                while($row = $resultC->fetch_assoc()){
                    $stmt3 = $conn->prepare("INSERT INTO ecommercedb5.ordini_prodotti
                                            (id_ordine, id_prodotto, quantita, prezzo)
                                            VALUES(?,?,?,?);");
                    $stmt3->bind_param("iiid", $orderId, $row['id_prodotto'], $row['quantita'], $row['prezzo']);
                    $stmt3->execute();
                }

                $stmt4 = $conn->prepare("DELETE FROM ecommercedb5.carello WHERE id_utente=?");
                $stmt4->bind_param("i", $userID);
                $stmt4->execute();
                $conn->close();

                header("Location: ordini.php");
                die();

            }
            else
            {
                $conn->close();
            }
        }
            else if(isset($_SESSION['id_utente'])){
                ?>

                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="../view/prodotti.css">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                    <title>Ordini</title>
                </head>
                <body>

               <?php 
                include("../view/header.html");
                require '../model/conndb.php';

                $username = $_SESSION["username"];
                echo " <h1> Ordini di $username </h1>";
                ?>

                <?php
                require '../model/conndb.php';
                $userID=$_SESSION['id_utente'];

                // $spedizione=$_SESSION["spedizione"];

                // echo "<h1> Ordini di $username </h1>";
                // echo "<p> <b> Indirizzo di spedizione:  $spedizione </b></p>";
                // echo "<p> <b> Tipo di pagamento: PayPal </b></p>";

                $userID = $_SESSION['id_utente'];

                $stmt2 = $conn->prepare("SELECT p.nome, o.order_date, op.quantita, op.prezzo
                                        FROM ecommercedb5.ordini o,
                                             ecommercedb5.ordini_prodotti op,
                                             ecommercedb5.prodotti p
                                            WHERE o.id_utente=?
                                            and op.id_ordine = o.id
                                            and p.id = op.id_prodotto
                                            and o.acquisto = 0");
                $stmt2->bind_param("i", $userID);
                $stmt2->execute();

                $result2 = $stmt2->get_result();
                $totale =0; 

                if($result2->num_rows > 0){
                    ?>
                    <div class="container">
                        <h2>In Corso</h2>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nome</th>
                                <th>Quantita</th>
                                <th>Prezzo</th>
                            </tr>
                            <?php
                            
                            $idOrdine;
                            while($row = $result2->fetch_assoc()){
                               // $idOrdine = $row["id"];

                                echo "<tr>";
                                echo  "<td>" .$row["nome"]." </td>" ;
                                echo  "<td>" .$row["quantita"]." </td>" ;
                                echo  "<td>" .$row["prezzo"]." euro  </td>" ;
                                echo "</tr>";

                                $totale += ($row["prezzo"] * $row["quantita"]);
                            }
                            ?>
                        </table>
                    </div>
                    <div class="row">
                            <form class="" action="../controller/annula_ordine.php" method="post">
                                <button name="annulla_ordine" class="btn btn-primary">Annula ordine</button>
                            </form>

                            <form class="" action="../controller/acquista.php" method="post">
                                <button name="acquista" class="btn btn-primary">Acquista</button>
                            </form>
                    </div>
                    </body>
            </html>

                <?php 
                }
            }
        else{
            echo" <br> <h3>Nessuno prodotto nel carello</h3><br>";
        }
    ?>
