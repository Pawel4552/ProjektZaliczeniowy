<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zmiana hasła</title>
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
        if(isset($_POST['log_zm_h']) && isset($_POST['pass_zm_h']))
    {
        if(isset($_POST['stare_haslo']))
        {
            $login=mysqli_real_escape_string($conn, addslashes(trim($_POST['log_zm_h'])));
            $kwerenda="select login, haslo from konto where login='".$login."'";
        $wynik=mysqli_query($conn, $kwerenda);
        if(mysqli_num_rows($wynik)==1)
        {
            echo '<p>Znaleziono dane logowania!</p><br>';
            $wiersz=mysqli_fetch_row($wynik);
            $pass=$_POST['stare_haslo'];
            if(password_verify($pass, $wiersz[1]))
            {
                $pass2=mysqli_real_escape_string($conn, addslashes(trim($_POST['pass_zm_h'])));
        $pass2=password_hash($pass2, PASSWORD_DEFAULT );
        $kwerenda="update konto set haslo='$pass2' where login='$login'";
        mysqli_query($conn, $kwerenda);
        echo "<h1>Poprawnie zmieniono hasło!</h1><br><meta http-equiv='refresh' content='10;url=logowanie.php'>";
            }
        }}
        else{
           $login=mysqli_real_escape_string($conn, addslashes(trim($_POST['log_zm_h'])));
        $pass=mysqli_real_escape_string($conn, addslashes(trim($_POST['pass_zm_h'])));
        $pass=password_hash($pass, PASSWORD_DEFAULT );
        $kwerenda="update konto set haslo='$pass' where login='$login'";
        mysqli_query($conn, $kwerenda);
        echo "<h1>Poprawnie zmieniono hasło!</h1><br><meta http-equiv='refresh' content='10;url=logowanie.php'>"; 
        }
        
    }
}
mysqli_free_result($wynik);
mysqli_close($conn);
?>
</main>
</body>
</html>