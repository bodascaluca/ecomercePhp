
<?php 
    // session_start();
     require '../model/conndb.php';

    if($_SERVER['REQUEST_METHOD']== 'POST'){

        //é sttso cliccato il tasto registrati
        if(isset($_POST['registrati'])){

            if(isset($_POST["nome"])){
                $nome = $_POST["nome"];
                echo $nome."<br>";
            }else{
                echo "|".$nome."|";
                $nome = "";
            }

            if(isset($_POST["cognome"])){
                $cognome = $_POST["cognome"];
                echo $cognome."<br>";
            }else{
                echo "|".$cognome."|";
                $cognome = "";
            }

            if(isset($_POST["email"])){
                $email = $_POST["email"];
                echo $email."<br>";
            }else{
                echo "|".$email."|";
                $email = "";
            }

            if(isset($_POST["username"])){
                $username = $_POST["username"];
                echo $username."<br>";
            }else{
                echo "|".$username."|";
                $username = "";
            }

            if(isset($_POST["password"])){
                $password = $_POST["password"];
                echo $password."<br>";
            }else{
                echo "|".$password."|";
                $password = "";
            }
            $passwordMd5 = md5($password);

            if(isset($_POST["indirizzoDiSpedizione"])){
                $indirizzoDiSpedizione = $_POST["indirizzoDiSpedizione"];
                echo $indirizzoDiSpedizione."<br>";
            }else{
                echo "|".$indirizzoDiSpedizione."|";
                $indirizzoDiSpedizione = "";
            }

            $stmt = $conn->prepare("INSERT INTO ecommercedb5.utenti
            (nome,cognome,email, password,username,indirizzoSpedizione)
            VALUES(?,?,?,?,?,?)");
            //s sta per string, i per integer
            $stmt->bind_param("ssssss", $nome, $cognome, $email, $passwordMd5, $username,$indirizzoDiSpedizione);
            $stmt->execute();
            $result = $stmt->get_result();
            $conn->close();

            //INSERIMEnto completato con successo!
            //echo "inserimento avvenuto con successo!";
            header("Location: ../view/login.php"); // una volta inserita 
            die();
        
    
        }    
    }  
    
?> 
