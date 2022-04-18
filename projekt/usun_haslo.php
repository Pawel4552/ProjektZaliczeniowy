<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuwanie hasła</title>
    <link rel="stylesheet" href="style.css" type="text/css"></style>
</head>
<body>
    <main>
    <?php
    define('serwer', 'localhost');
    define('user', "root");
    define('pass', '');
    $conn=mysqli_connect(serwer, user, pass);
    if(mysqli_connect_errno())
    {
    echo "Nie nawiązano połączenia";
    }
    else{
        mysqli_select_db($conn, 'wspoldzielnia');
       if(isset($_GET['id']))
       {
           $id=$_GET['id'];
           $kwerenda="update konto set haslo=null where id_czlonka='$id'";
           mysqli_query($conn, $kwerenda);
           echo "Poprawnie usunięto hasło urzytkownika o id $id <meta http-equiv='refresh' content='5;url=dane.php'>";
       }
}
mysqli_close($conn);
?>
</main>
</body>
</html>