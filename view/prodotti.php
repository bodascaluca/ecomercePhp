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
        include("./header.html");
        require '../model/conndb.php';
    ?>
</nav>

    <h1>Prodotti</h1>
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
            $conn->close();
            if($result2->num_rows > 0){
                while ($row = $result2 -> fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row["Prodotto"]."</td>";
                    echo "<td> <b>".$row["categoria"]." </b> </td>";
                    echo "<td>".$row["prezzo"]." euro </td>";
                    echo " <td> <img src=\"../img/".$row["immagine"]."\" class=\"imgw\"></td> ";
                    ?>
                    <td>
                   
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