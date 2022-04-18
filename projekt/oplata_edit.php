<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja opłat</title>
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
   height:300px;
    background-color:rgba(179, 255, 164, 0.788);
    overflow:auto;
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
       if(isset($_GET['id']))
       {
           $id=$_GET['id'];
           $kwerenda2="select rodzaj, typ, koszt from oplaty where id_oplaty=$id";
           $wynik=mysqli_query($conn, $kwerenda2);
           $wiersz2=mysqli_fetch_array($wynik);
           $rodzaj=$wiersz2[0];
           $typ=$wiersz2[1];
           $kwota=$wiersz2[2];
           echo "<form action='oplata_edit.php' method='POST' id='opl1'>
           <fieldset><legend><h3>Edycja opłaty</h3></legend>
           <input type='hidden' name='id' value='$id'>
           $rodzaj (opłata $typ):<br><input type='text' name='kwota' id='kwota' value='$kwota'><br>
           <input type='button' id='btn1' value='Zmień kwotę'>
           </fieldset></form><div id='tabError' class='tabError'>
           <p id='errors'></p>
   </div></div>";
   ?>
<div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Zmienić i zapisać ceny poszczególnych opłat</li></h3>
   </ul>
           </div>
<?php
       }
       if(isset($_POST['id']))
       {
           $id=$_POST['id'];
           $kwota=mysqli_real_escape_string($conn, addslashes(trim($_POST['kwota'])));
           $kwerenda3="update oplaty set koszt='$kwota' where id_oplaty=$id";
           mysqli_query($conn, $kwerenda3);
           echo "Poprawnie zmieniono kwotę dla opłaty o id $id <meta http-equiv='refresh' content='5;url=oplaty.php'>";
       }
    }
    else{
        ?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
        <a href='dane.php'><input type='button' class='navButon' value='Moje konto'></a>
        <a href='liczniki.php'><input type='button' class='navButon' value='Wpisz liczniki' id='liczniki'></a>
        <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki' id='rachunki'></a>
        <a href='cennik.php'><input type='button' class='navButon' value='Cennik opłat'></a>
        </nav><main><div class='lewy'>
            <?php
        echo '<h1>Zawartość tylko dla administracji, jeśli jesteś administartorem, zmień konto!</h1></div>';
        ?>
<div class='prawy'>
           <h2>Zawartość nie jest przeznaczona dla ciebie, zmień stronę!</h2>
           </div>
<?php
    }
}
}
mysqli_free_result($wynik);
mysqli_free_result($wynikTyp);
mysqli_close($conn);
?>
</main>

</body>
<footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</html>
<script>
function valid()
{
    var valid=false;
    let kwota=document.getElementById('kwota').value;
    kwota=kwota.replace(',', '.');
        kwota=parseFloat(kwota).toFixed(2); 
        document.getElementById('kwota').value=kwota;
let RegKw= new RegExp("^[0-9]{1,3}[.][0-9]{1,2}$");
        wynikKw=RegKw.test(kwota);
        if(wynikKw)
        {
            document.getElementById('kwota').classList.remove('ERROR');
            document.getElementById('kwota').classList.add('OK');
            valid=true;
            document.getElementById('tabError').classList.remove('pokaz');
            document.getElementById('tabError').classList.add('tabError');
            document.getElementById('errors').innerHTML=("");
        }
        else{
            document.getElementById('kwota').classList.remove('OK');
            document.getElementById('kwota').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            document.getElementById('errors').innerHTML=("Kwota powinna być liczbą dodatnią, mniejszą od 1000zł!<br>");
        }
}
function sub()
{
    alert(valid);
    if(valid)
    {
        let op_form=document.getElementById('opl1');
        op_form.submit();
    }
}
var kw1=document.getElementById('kwota');
kw1.addEventListener('blur', valid)
var btn1=document.getElementById('btn1');
btn1.addEventListener('click', sub);
</script>