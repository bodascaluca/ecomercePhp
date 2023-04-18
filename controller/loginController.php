<?php 
    session_start(); //1 22

     require '../model/conndb.php';
    
    if(isset($_SESSION["username"])){
        echo "<h1>Ciaooooooo </h1>";
        echo "<a href=\"../view/index.php\">HOME</a>" ;

    }else if (isset($_POST["username"]) && isset($_POST["password"])){

        $username = $_POST["username"];
        $password = $_POST["password"];
        $userMd5Pass = md5($password);

        $stmt2 = $conn->prepare("SELECT username, password, id, indirizzoSpedizione FROM ecommercedb5.utenti WHERE username = ?  and password = ? ");
        $stmt2->bind_param("ss", $username, $userMd5Pass);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $conn->close();

        if($result2->num_rows > 0){
            if($row = $result2->fetch_assoc()){
                echo "Ciao: ".$row["username"];

                $_SESSION['username']=$row["username"];
                $_SESSION['id_utente']=$row["ID"];
                $_SESSION['spedizione'] = $row["indirizzoSpedizione"];
                header("Location: ../view/index.php"); 
                die();
            }
        }else{
            echo "<br> <h2> Cdredenziali non valide </h2> <br>";
        }
    }
?>