<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
</head>
<body>
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
        $db=mysqli_select_db($conn, 'wspoldzielnia');
        $imie=mysqli_real_escape_string($conn, addslashes(trim($_POST['imie'])));
        $nazwisko=mysqli_real_escape_string($conn, addslashes(trim($_POST['nazwisko'])));
        $lokal=mysqli_real_escape_string($conn, addslashes(trim($_POST['lokal'])));
        $blok=mysqli_real_escape_string($conn, addslashes(trim($_POST['blok'])));
        $metraz=mysqli_real_escape_string($conn, addslashes(trim($_POST['metraz'])));
        $dataZam=mysqli_real_escape_string($conn, addslashes(trim($_POST['Dat_zam'])));
        $login=mysqli_real_escape_string($conn, addslashes(trim($_POST['login'])));
        $kwerenda="insert into czlonek values(null, '$imie', '$nazwisko', '$lokal', '$blok', '$metraz', '$dataZam', null)";
        mysqli_query($conn, $kwerenda);
        $kwerenda2="select id_czlonka from czlonek where nr_lokalu='$lokal' and blok='$blok'";
        $wynik=mysqli_query($conn, $kwerenda2);
        $wiersz=mysqli_fetch_array($wynik);
        $id_czlonka=$wiersz['id_czlonka'];
        $kwerenda3="insert into konto values('$login', null, 'U', '$id_czlonka')";
        mysqli_query($conn, $kwerenda3);
        echo "<H1>Pomyślnie dodano członka wspóldzielni i utworzono konto użytkownika!<h1><br>
        <h2>Login użytkownika to: $login <br><a href='glowna.php'><input type='button' value='Przejdź do panelu głownego'></a>";
    }

    mysqli_free_result($wynik);
    mysqli_close($conn);
    ?>
</body>
</html>