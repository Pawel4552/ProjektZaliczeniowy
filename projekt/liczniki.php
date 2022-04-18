<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liczniki</title>
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
    $kwerenda="select typ_konta, id_czlonka from konto where login='$login'";
    $wynikTyp=mysqli_query($conn, $kwerenda);
    $wierszTyp=mysqli_fetch_array($wynikTyp);
    if($wierszTyp[0]=='A')
    {
        ?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
        <a href='dane.php'><input type='button' class='navButon' value='Wszystkie konta'></a>
        <a href='oplaty.php'><input type='button' class='navButon' value='Opłaty'></a>
        <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki'></a>
        <a href='rejestracja.php'><input type='button' class='navButon' value='Zarejestruj nowego użytkownika'></a>
        </nav><main>
        <?php
        echo '<center><h1>Zawartość dla członków, tutaj wpisują stan swoich liczników</h1></center>';}
    else
    {   
        ?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
        <a href='dane.php'><input type='button' class='navButon' value='Moje konto'></a>
        <a href='liczniki.php'><input type='button' class='navButon' value='Wpisz liczniki' id='liczniki'></a>
        <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki' id='rachunki'></a>
        <a href='cennik.php'><input type='button' class='navButon' value='Cennik opłat'></a>
        </nav><main><div class='lewy'>
            <?php
        $kwerendaRodzaj="select rodzaj, id_oplaty from oplaty where typ='za m^3'";
        $wyniki=mysqli_query($conn, $kwerendaRodzaj);
        if(isset($_POST['oplata']))
        {
            $id_oplaty=$_POST['oplata'];
            $id_czlonka=$wierszTyp[1];
            $kw_l_stan="select count(stan) from licznik where id_czlonka='$id_czlonka' and id_oplaty='$id_oplaty'";
            $w_l_stan=mysqli_query($conn, $kw_l_stan);
            $wi_l_stan=mysqli_fetch_array($w_l_stan);
            if($wi_l_stan[0]!=0)
            {
                $kwerendaPopStan="select stan from licznik where id_czlonka='$id_czlonka' and id_oplaty='$id_oplaty' order by data_odczytu desc limit 1";
                $wynikPoStan=mysqli_query($conn, $kwerendaPopStan);
                $wierszPopStan=mysqli_fetch_array($wynikPoStan);
                $PopStan=$wierszPopStan[0];
            }
            else
            {
                $PopStan=0;
            }
            $kwL="select rodzaj from oplaty where id_oplaty='$id_oplaty'";
            $wynikL=mysqli_query($conn, $kwL);
            $wierszL=mysqli_fetch_array($wynikL);
            $licznik=$wierszL[0];
            echo "<form action='licznik_zap.php' method='POST' id='li_form'><fieldset><legend><h3>Stan liczników</h3></legend>Licznik: <input type='text' name='oplata' id='oplata' value='$licznik' readonly>
            <input type='hidden' name='id_op' id='id_op' value='$id_oplaty'>";
            echo '<br>Stan licznika<input type="text" name="stan" id="stan"><br>
            Poprzedni stan licznika: <input type="text" id="popStan" name="popStan" value="'.$PopStan.'" readonly><br>
            <input type="button" id="btn1" value="Zapisz stan">
            </fieldset></form><div id="tabError" class="tabError">
            <p id="errors"></p>
            </div></div>';
            ?>
                <div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Podać wskazanie wybranego licznika</li></h3>
   </ul>
           </div>
            <?php
        }
        else
        {
            echo "<form action='liczniki.php' method='POST' id='li_form'><fieldset><legend>Stan liczników</legend><select name='oplata' id='oplata'><option value='none'>Wybierz licznik</option>";
            $wyniki2=$wyniki;
            while($wiersz=mysqli_fetch_array($wyniki))
            {
                echo "<option value='".$wiersz[1] ."'>".$wiersz[0] ."</option>";
            }
            echo '</select><br>
            <input type="button" id="btn" value="OK">
            </fieldset></form></div>'; 
            ?>
                <div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Wybrać ktorego licznika stan będzięsz podawał</li></h3>
   </ul>
           </div>
            <?php
        }
    }
}
else
{
    echo "<h1>Zawartośc dla zalogowanych użytkowników!</h1>";
}
}
mysqli_free_result($wyniki);
mysqli_free_result($wyniki2);
mysqli_free_result($wynikL);
mysqli_free_result($wynikPoStan);
mysqli_free_result($wynikTyp);
mysqli_close($conn);
?>
</main>
<footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</body>
</html>
<script>
var valid=false;
function sub1()
{
    let li_form=document.getElementById('li_form');
    li_form.submit();
}
function walid()
{
    let stan=document.getElementById('stan').value;
    let popStan=document.getElementById('popStan').value;
    let RegStan= new RegExp("^[0-9]{1,6}");
    let wynStan=RegStan.test(stan);
    if(wynStan)
    {
        stan=parseInt(stan);
        if(stan>popStan)
    {
        document.getElementById('tabError').classList.remove('pokaz');
            document.getElementById('tabError').classList.add('tabError');
            document.getElementById('stan').classList.remove('ERROR');
            document.getElementById('stan').classList.add('OK');
        valid=true;
    }
    else
    {
            document.getElementById('stan').classList.remove('OK');
            document.getElementById('stan').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            let errors=document.getElementById('errors');
            errors.innerHTML=("Aktualny stan licznika musi być większy niż poprzedni!<br>");
    }
    }
    else
    {
        document.getElementById('stan').classList.remove('OK');
            document.getElementById('stan').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            let errors=document.getElementById('errors');
            errors.innerHTML=("Stan licznika musi być liczbą!<br>");
    }
    
}
function sub2()
{
    if(valid)
    {
        let li_form=document.getElementById('li_form');
        li_form.submit();
    }
}
var btn=document.getElementById('btn');
btn.addEventListener("click", sub1);

var stn=document.getElementById("stan");
stn.addEventListener("blur", walid);

var btn1=document.getElementById('btn1');
btn1.addEventListener("click", sub2);
</script>