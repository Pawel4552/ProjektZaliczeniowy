<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opłacanie rachunków</title>
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
.lewy input, select{
    width:170px;
    margin-left:20px;
    margin-bottom:5px;
}
.lewy input[type='button']{
    width: 120px;
    text-align:center;
}
.prawy{
    padding-left:5px;
    padding-bottom:10px;
    width:40%;
    background-color: rgba(240, 164, 255, 0.767);
    padding-top:30px;
    vertical-align:middle;
}
fieldset{
    border:none;
    width:400px;
    margin:auto;
    text-align:right;
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
.OK{
    border:1px solid green;
    BOX-shadow: 1px 1px 5px GREEN;
}
.ERROR{
    border:1px solid red;
    BOX-shadow: 1px 1px 5px rgba(179, 255, 164, 0.788);
}
.visib{
    display: block;
}
.tabError, .ukryj{
    display: none;
}
.czysty_link{
    text-decoration: none;
    color:black;
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
        echo"<h1>Tutaj urzytkownicy opłacają swoje rachunki</h1></div>";
        ?>
        <div class='prawy'>
                   <h2>Zawartość nie jest przeznaczona dla ciebie, zmień stronę!</h2>
                   </div>
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
        if(isset($_GET['id_rach']))
        {
            $id_rach=$_GET['id_rach'];
            $kwerZaplRach="select kwota, id_oplaty, id_czlonka, miesiac from rachunek where id_rachunku='$id_rach'";
            $wynZaplRach=mysqli_query($conn, $kwerZaplRach);
            $wierZaplRach=mysqli_fetch_array($wynZaplRach);
            $id_czlonka=$wierZaplRach[2];
            $id_opl=$wierZaplRach[1];
            $kwota=$wierZaplRach[0];
            $miesiac=$wierZaplRach[3];
            $kwerCzl="select imie, nazwisko, nr_lokalu, blok from czlonek where id_czlonka='$id_czlonka'";
            $wynCzl=mysqli_query($conn, $kwerCzl);
            $wierCzl=mysqli_fetch_array($wynCzl);
            $imie=$wierCzl[0];
            $nazwisko=$wierCzl[1];
            $lokal=$wierCzl[2];
            $blok=$wierCzl[3];
            $kwerOpl="select rodzaj from oplaty where id_oplaty='$id_opl'";
            $wynOpl=mysqli_query($conn, $kwerOpl);
            $wierOpl=mysqli_fetch_array($wynOpl);
            $rodzaj=$wierOpl[0];
            $zlec=$imie .' ' .$nazwisko .' ' .$lokal .' ' .$blok;
            $tytul=$imie .$nazwisko .$lokal .$blok .$rodzaj .$miesiac;
            ?>
            <fieldset>
                <h3>Odbiorca:</h3><h2> Współdzielnia mieszkaniowa</h2><br>
               <h3>Nr rachunku odbiorcy:</h3><h2> 87235618263940173672871635</h2><br>
                <h3>Kwota:</h3><h2> <?php echo $kwota; ?></h2><br>
               <h3>Nazwa zleceniodawcy:</h3><h2><?php echo $zlec; ?></h2><br>
               <h3>Tytuł przelewu:</h3><h2><?php echo $tytul; ?></h2><br></fieldset>
    </div>
            <div class='prawy'>
           <h2>Na tej stronie:</h2>
           <ul><h3>
           <li>Masz wszytskie dane potrzebne do dokonania przelewu</li>
        <li>Przepisz je na blankiet wpłaty</li>
    <li>Wpłaty możesz dokonać również w kasie wspóldzielni</li></h3>
   </ul>
           </div>
            <?php
        }
    }
    }}
    mysqli_free_result($wynikTyp);
    mysqli_free_result($wynCzl);
    mysqli_free_result($wynOpl);
    mysqli_free_result($wynZaplRach);
    mysqli_close($conn);
    ?>
    </main>
    <footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
    </body>
    </html>
