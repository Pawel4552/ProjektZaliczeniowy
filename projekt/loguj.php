<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loguj</title>
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
    else 
    {
        mysqli_select_db($conn, 'wspoldzielnia');
        if(isset($_POST['log-in']) && isset($_POST['pass-in']))
        {
            $login=mysqli_real_escape_string($conn, addslashes(trim($_POST['log-in'])));
            $pass=mysqli_real_escape_string($conn, addslashes(trim($_POST['pass-in'])));
            $kwerenda="select login, haslo from konto where login='".$login."'";
        $wynik=mysqli_query($conn, $kwerenda);
        if(mysqli_num_rows($wynik)==1)
        {
            echo '<p>Znaleziono dane logowania!</p><br>';
            $wiersz=mysqli_fetch_row($wynik);
            if(password_verify($pass, $wiersz[1]))
            {
                session_start();
                $_SESSION['id']=$wiersz[0];
                echo "<h1'>Zalogowano użytkownika</h1>";
                echo "<meta http-equiv='refresh' content='5;url=spr_rach.php'>";   
            }
            else
            {
                echo "Błędne hasło";
                echo "<meta http-equiv='refresh' content='5;url=logowanie.php'>";
            }
        }
        } 
}
mysqli_free_result($wynik);
        mysqli_close($conn);
    ?>
    </main>
</body>
</html>