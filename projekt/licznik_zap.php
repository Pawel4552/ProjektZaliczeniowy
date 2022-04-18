<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapis liczników</title>
    <link rel="stylesheet" href="style.css" type="text/css"></style>
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
    mysqli_select_db($conn, 'wspoldzielnia');
session_start();
if(isset($_SESSION['id']))
{   
    $login=$_SESSION['id'];
    $kwerenda="select id_czlonka from konto where login='$login'";
    $wynikTyp=mysqli_query($conn, $kwerenda);
    $wierszTyp=mysqli_fetch_array($wynikTyp);
    if(isset($_POST['stan']))
    {
        $oplata=$_POST['oplata'];
        $stan=$_POST['stan'];
        $popStan=$_POST['popStan'];
        $roznica=$stan-$popStan;
        $id_op=$_POST['id_op'];
        $id_czlonka=$wierszTyp[0];
        $kwer_zap="insert into licznik values(null, '$stan', '$id_czlonka', '$id_op', current_date())";
        mysqli_query($conn, $kwer_zap);
        echo "Pomyślnie dodano odczyt licznika $oplata<br>";
        $dzisMiesiac="select date_format(current_date(), '%m')";
        $wynikDzis=mysqli_query($conn, $dzisMiesiac);
        $wierszDzis=mysqli_fetch_array($wynikDzis);
        switch ($wierszDzis[0])
        {
            case '01':
                $miesiac="Styczeń";
            break;
            case '02':
                $miesiac="Luty";
            break;
            case '03':
                $miesiac="Marzec";
            break;
            case '04':
                $miesiac="Kwiecień";
            break;
            case '05':
                $miesiac="Maj";
            break;
            case '06':
                $miesiac="Czerwiec";
            break;
            case '07':
                $miesiac="Lipiec";
            break;
            case '08':
                $miesiac="Sierpień";
            break;
            case '09':
                $miesiac="Wrzesień";
            break;  
            case '10':
                $miesiac="Październik";
            break;
            case '11':
                $miesiac="Listopad";
            break;
            case '12':
                $miesiac="Grudzień";
            break;
            default:
        break;
        }
        $kwK="select koszt from oplaty where id_oplaty='$id_op'";
        $wK=mysqli_query($conn, $kwK);
        $wiK=mysqli_fetch_array($wK);
        $kwota=$wiK[0];
        $kwIdStan="select distinct id_stanu from licznik where id_oplaty='$id_op' and id_czlonka='$id_czlonka'";
        $wIdStan=mysqli_query($conn, $kwIdStan);
        $wiIdStan=mysqli_fetch_array($wIdStan);
        $id_stan=$wiIdStan[0];
        $kwerTerm="select DATE_ADD(CURRENT_DATE(), INTERVAL 14 day)";
        $wTerm=mysqli_query($conn, $kwerTerm);
        $wiTerm=mysqli_fetch_array($wTerm);
        $kwerenda1="select count(id_rachunku) from rachunek where id_czlonka='$id_czlonka' and id_oplaty='$id_op'";
            $wynik1=mysqli_query($conn, $kwerenda1);
            $wiersz1=mysqli_fetch_array($wynik1);
        if($wiersz1[0]>0)
        {
            $kwerOdsetki="select odsetki from rachunek where id_czlonka='$id_czlonka' and id_oplaty='$id_op' order by termin_platnosci desc limit 1";
            $wynOdsetki=mysqli_query($conn, $kwerOdsetki);
            $wieOdsetki=mysqli_fetch_array($wynOdsetki);
            $odsetki=$wieOdsetki[0];
        }
        else{
            $odsetki=0;
        }
        $term=$wiTerm[0];
        $koszt=round(($roznica*$kwota)+$odsetki, 2);
        $kwer_rach="insert into rachunek values(null, '$miesiac', '$term', $koszt, 'N', null, 0.00, '$id_czlonka', '$id_op', '$id_stan')";
        mysqli_query($conn, $kwer_rach);
        echo "<p>Pomyślnie dodano rachunek!</p><meta http-equiv='refresh' content='5;url=glowna.php'>";
    }
}}
mysqli_free_result($wynikTyp);
mysqli_free_result($wynikDzis);
mysqli_free_result($wK);
mysqli_free_result($wIdStan);
mysqli_free_result($wTerm);
mysqli_free_result($wynik1);
mysqli_free_result($wynOdsetki);
mysqli_close($conn);
?>
</main>
</body>
</html>