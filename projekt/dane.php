<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dane</title>
</head>
<style>
*{
    box-sizing: border-box;
    margin:0;
}
html{
    height:100%;
}
body{
    min-height:100%;
    height:100%;
}
header{
    width:100%;
    background-color: lightblue;
    vertical-align:middle; 
    
}
.hedLew{
    width:60%;
    display:inline-block;
    padding:5px;
}
.hedPraw{
    width:40%;
    display:inline-block;
    vertical-align:top;
    text-align:right;
    padding-right:10px;
    padding-top:10px;
}
.hedPraw p{
    font-size:17px;
    font-weight:bold;
}
.log{
    font-weight:bold;
    background-color:white;
    border:2px solid darkgrey;
    font-family:georgia;
}
nav{
    background-color:rgb(0, 102, 255);
}
.navButon{
    height:35px;
    background:rgba(95, 3, 175, 0.562);
    color:rgb(255, 255, 255);
    border: 2px solid rgba(0, 0, 0, .0);
    border-radius:10px;
    margin:5px 0px 3px 5px;
    font-size:15px;
    font-family:verdana;
}
.navButon:hover{
    border:2px solid Yellow;
    box-shadow:2px 2px 5px silver;
}
main{
    display: table;
    width:100%;
}
main div{
    display:table-cell;
    height:100%;
}
.lewy{
    width:60%;
    background-color:rgba(179, 255, 164, 0.788);
}
.lewy p{
    font-size:20px;
    margin-left:15px;
}
.lewy input{
    width: 120px;
    text-align:center;
    margin-left:20px;
    margin-bottom:30px;
}
.prawy{
    padding-left:5px;
    padding-bottom:10px;
    width:40%;
    background-color: rgba(240, 164, 255, 0.767);
    padding-top:30px;
    vertical-align:middle;
}
footer{
    position:absolute;
    bottom:0px;
    height:30px;
    width:100%;
    background-color:rgba(93, 149, 223, 0.836);
    text-align:center;
    font-weight: bold;
    font-size:20px;
}
ul{
    margin-bottom:20px;
}
.czysty_link{
    text-decoration: none;
    color:black;
}
.malybuton{
    width:10px;
}
</style>
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
    echo "<header><div class='hedLew'><h1>Współdzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><div class='logOn hedPraw'><p>Jesteś zalogowany jako: $login
    <a href='logout.php'><input type='button' value='wyloguj' id='btn1' class='log'></a></p>
    </div></header><nav>";
    $kwerenda="select typ_konta from konto where login='$login'";
    $wynikTyp=mysqli_query($conn, $kwerenda);
    $wiersz=mysqli_fetch_array($wynikTyp);
    if($wiersz[0]=='A')
    {?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
        <a href='dane.php'><input type='button' class='navButon' value='Wszystkie konta'></a>
        <a href='oplaty.php'><input type='button' class='navButon' value='Opłaty'></a>
        <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki'></a>
        <a href='rejestracja.php'><input type='button' class='navButon' value='Zarejestruj nowego użytkownika'></a>
        </nav><main><div class='lewy'>
            <?php
        $kwerenda="select id_czlonka, imie, nazwisko, nr_lokalu, blok, metraz, data_zamieszkania, data_wyprowadzki from czlonek";
    $wynik=mysqli_query($conn, $kwerenda);
     while($wiersz=mysqli_fetch_array($wynik))
        {
           echo '<a href="edit.php?id='.$wiersz[0].'" class="czysty_link"><p>' .$wiersz[1] .' '.$wiersz[2] .' ' .$wiersz[3] .' ' .$wiersz[4].' ' .$wiersz[5] .' ' .$wiersz[6] .' ' .$wiersz[7].'</p></a><a href="usun_haslo.php?id='.$wiersz[0].'"><br><input type="button" value="Usuń hasło" class="malybuton"></a>';
        }?>
        </div><div class='prawy'>
        <h2>Tutaj możesz:</h2>
        <ul><h3>
        <li>Sprawdzić dane mieszkańców współdzielni</li><br>
        <li>Zmienić dane mieszkańców<br>(np wpisac datę wyprowadzki)</li><br>
        <li>Usunąć hasło użytkownika, na jego życzenie</li></h3>
        </ul>
        </div></main>
        <?php
    }
    else
    {?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
        <a href='dane.php'><input type='button' class='navButon' value='Moje konto'></a>
        <a href='liczniki.php'><input type='button' class='navButon' value='Wpisz liczniki' id='liczniki'></a>
        <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki' id='rachunki'></a>
        <a href='cennik.php'><input type='button' class='navButon' value='Cennik opłat'></a>
        </nav><main><div class='lewy'>
            <?php
        $kwerenda="select id_czlonka, imie, nazwisko, nr_lokalu, blok, metraz, data_zamieszkania, data_wyprowadzki from czlonek where id_czlonka=(select id_czlonka from konto where login='$login')";
    $wynik=mysqli_query($conn, $kwerenda);
     $wiersz=mysqli_fetch_array($wynik);
           echo '<p>Imię i nazwisko: <b>' .$wiersz[1] .' '.$wiersz[2] .'</b><br>Mieszkanie <b>' .$wiersz[3] .'</b> w bloku <b>' .$wiersz[4].'</b><br>Metraż: <b>' .$wiersz[5] .' m^2</b><br>Data zamieszkania: <u>' .$wiersz[6] .'</u><br>Data wyprowadzki: <u>' .$wiersz[7].'</u></p><br><a href="edit.php?id='.$wiersz[0].'" class="czysty_link"><input type="button" value="Edytuj dane"></a>';
           ?>
           </div><div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Sprawdzić swoje dane</li><br>
           <li>Zmienić swoje dane</li><br>
           <li>Zmienić swoje hasło</li></h3>
   </ul>
           </div></main>
           <?php
    }
    mysqli_free_result($wynikTyp);
}
else{
    ?>
    <header><div class='hedLew'><h1>Współdzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><p class='logOn'>Nie jesteś zalogowany
    <a href='logowanie.php'><input type='button' value='zaloguj' id='btn1'></a></div></header></p><main>";
        <?php
}

}
mysqli_close($conn);
?>
</main>
<footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</body>
</html>
