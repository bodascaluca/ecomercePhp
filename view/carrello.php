<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/carrello.css">
    <title>Carello</title>
</head>
<body>


<?php 
        session_start();
        include("./header.html");
        require '../model/conndb.php';
 
        if(!isset($_SESSION["id_utente"])){
            echo "<br> Effettuaare il login <br>";
            $conn->close();
            header("Location: login.php");
            die();
        }else{
            $username = $_SESSION["username"];
            echo " <h1> Carello di $username </h1>";
            $id_utente = $_SESSION["id_utente"];
            $stmt2 = $conn->prepare("SELECT ca.id_utente, ca.id_prodotto,
                                             ca.quantita, p.nome,
                                              p.immagine as immagine, p.prezzo, ca.id   
                                    from ecommercedb5.carello ca, ecommercedb5.prodotti p
                                    where ca.id_utente = ? and ca.id_prodotto = p.id ");
            $stmt2->bind_param("i", $id_utente);
            $stmt2->execute(); 
            $result2 = $stmt2->get_result();
            $conn->close();

            if($result2->num_rows > 0){
                echo "<h2> Prodotti aggiunti: </h2>";
                while ($row = $result2 -> fetch_assoc()){

                    ?>
                    <ul class=" cart d-flex justify-content-around ">
                        <li>
                            <?php echo $row["quantita"]. " X "  ?>
                        </li>

                        <li>
                            <?php echo $row["nome"]  ?>
                        </li>

                        <li>
                            <img class="imgProdotto" src="../img/<?php echo $row["immagine"] ?>" alt="">
                        </li>

                        <li>
                            <?php echo $row["prezzo"]. " euro"  ?>
                        </li>

                        <li>
                            <form action="../controller/remove_product.php" method="POST">
                                <input name="id_carrello" hidden value="<?php echo $row["id"]; ?>">  
                                <button id="elimina" class="btn btn-primary" name="remove_from_cart">Rimuovi</button>
                            </form>
                        </li>
                    </ul>

                <?php                     
                 }
                ?>

                 <form action="../controller/ordini.php" method="post">
                    <button name="order_confirm" class="btn btn-primary" type="submite">Conferma ordine</button>
                 </form>
                 <?php 
                }else{
                echo "<br> Nessun Prodotto trovato </br>";
            }
            ?>

            <?php
        }
        ?>
</body>
</html>