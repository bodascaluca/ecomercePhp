<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="./css/prodotti.css">
    <title>Prodotti</title>
</head>
<body>

<nav>
    <?php 
        session_start();
        include("./header.html");
        require '../model/conndb.php';

       
    ?>
</nav>

    

    <h1>Prodotti</h1>
    <div>
        <?php 
             if(isset($_SESSION["username"])){
                echo "Questi sono i prodotti che può aciqstare ".$_SESSION['username'];
            }
        ?>
    </div>
    <div class="container">
        <table class="table table-bordered">
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Prezzo</th>
                <th>Immagine</th>
            </tr>
        <?php 
            $stmt2 = $conn->prepare("SELECT p.nome as Prodotto, p.id as id_prodotto, p.prezzo as prezzo, p.immagine as immagine, c.nome as categoria
                                    FROM ecommercedb5.prodotti p, ecommercedb5.categorie c
                                    where p.id_categoria = c.id ");
            $stmt2->execute(); 
            $result2 = $stmt2->get_result();
            $conn->close();//Chiudiamo la conessione
            if($result2->num_rows > 0){//Se ha restituito almeno una riga fai questo
                while ($row = $result2 -> fetch_assoc()){//Cicliamo le righe che abbiamo
                    echo "<tr>";
                    echo "<td>".$row["Prodotto"]."</td>";
                    echo "<td> <b>".$row["categoria"]." </b> </td>";
                    echo "<td>".$row["prezzo"]." euro </td>";
                    echo " <td> <img src=\"../img/".$row["immagine"]."\" class=\"imgw\"></td> ";
                    ?>
                    <td>
                        <!-- ad_ product mandiamo id prodotto e quantità -->
                        <form action="../controller/add_product.php" method="POST">
                            <!-- HIDEN Questo imput l'utnte non lo vede, nella login si vede -->
                            <input name="id_prodotto" hidden type="<?php echo $row["id_prodotto"]; ?>">  
                            <select name="qty" class="quantitaStyle">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <button type="submite" class="btn btn-primary" name="add_to_cart">Aggiungi</button>
                        </form>
                    </td>
    
                    <?php 
                    echo "</tr>";
                 }

                }else{
                echo "<br> Nessun Prodotto trovato </br>";
            }
           ?>
        </table>
    </div>
    
</body>
</html>