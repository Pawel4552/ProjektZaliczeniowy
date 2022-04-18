<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapłacone</title>
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
session_start();
if(isset($_SESSION['id']))
{
    $login=$_SESSION['id'];
    echo "<header><div class='hedLew'><h1>Współdzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><div class='logOn hedPraw'><p>Jesteś zalogowany jako: $login
    <a href='logout.php'><input type='button' value='wyloguj' id='btn1' class='log'></a></p>
    </div></header><nav>";
    $kwerenda="select typ_konta, id_czlonka, current_date() from konto where login='$login'";
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
        if(isset($_GET['id_rach']))
        {
            $id_rach=$_GET['id_rach'];
            $kwerSprRach="select termin_platnosci, current_date() from rachunek where id_rachunku='$id_rach'";
            $wynSprRach=mysqli_query($conn, $kwerSprRach);
            $wierSprRach=mysqli_fetch_array($wynSprRach);
            $termin=$wierSprRach[0];
            echo "<form action='zaplacone.php' method='POST' id='formSprRach'><fieldset>Termin płatności: <input type='text' readonly name='termin' id='termin' value='$termin'><br>
            Data wpłynięcia opłaty: <input type='text' name='dat_zap' id='dat_zap'><input type='button' id='zapDzis' value='Dzisiaj' class='malybuton'><br>
            <input type='hidden' name='id_rach' value='$id_rach'>
            <input type='button' id='btn2' value='Zmień na opłacone'></fieldset></form><div id='tabError' class='tabError'>
            <p id='errors'></p></div></div>";
            
        }
        if(isset($_POST['dat_zap']))
        {
            $id_rach=$_POST['id_rach'];
            $data_zap=$_POST['dat_zap'];
            $kwerZaplac="update rachunek set data_oplaty='$data_zap', uregulowane='T' where id_rachunku='$id_rach'";
            mysqli_query($conn, $kwerZaplac);
            $kwerOdsetki="update rachunek set odsetki='(select round((kwota*0.005)*datediff(data_oplaty, termin_platnosci), 2) as 'odsetki' from rachunek where id_rachunku='$id_rach' having odsetki>0)' where id_rachunku='$id_rach'";
            mysqli_query($conn, $kwerOdsetki);
            echo"<meta http-equiv='refresh' content='0;url=rachunki_lista.php'></div>";
            
        }?>
            <div class='prawy'>
           <h2>Na tej stronie:</h2>
           <ul><h3>
           <li>Zmienisz status rachunku na zapłącony</li></h3>
   </ul>
           </div>
            <?php
    }
}}
mysqli_free_result($wynikTyp);
mysqli_free_result($wynSprRach);
mysqli_close($conn);
?>
</main>
<footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</body>
</html>
<script>
function dzis()
{
    document.getElementById('dat_zap').value='<?php echo $wiersz[2]; ?>';
}
function valid()
{
    let data_zap=document.getElementById('dat_zap').value;
    let term_zap=document.getElementById('termin').value;
    let dzis='<?php echo $wiersz[2]; ?>';
let RegData= new RegExp("^[0-9]{4}[-][0-9]{2}[-][0-9]{2}");
        wynikData=RegData.test(data_zap);
        
        if(wynikData==true)
        {   
            let rok=data_zap.substring(0, 4);
            let mies=data_zap.substring(5, 7);
            let dzien=data_zap.substring(8);
            let a_rok=dzis.substring(0, 4);
            let a_mies=dzis.substring(5, 7);
            let a_dzien=dzis.substring(8);
            var valDat=true;
            if(rok>1999 && rok<a_rok)
            {
                if(mies<=12 && mies>0 && dzien>0 && dzien<=31)
                {}
                else{
                    alert("1");
                    valDat=false;
                }
            }
            else if(rok==a_rok)
            {
                if(mies>0 && mies<a_mies && dzien>0 && dzien<32)
                {}
                else if(mies==a_mies)
                {
                    if(dzien>0 && dzien<=a_dzien)
                    {}
                    else{
                        alert("2");
                        valDat=false;
                    }
                }
                else{
                    alert("3");
                        valDat=false;
                }
            }
            else{
                echo("4");
                valDat=false;
            }
        }
        else{
            alert("5");
            valDat=false;
        }
        let validate=false;
        if(valDat)
        {
            document.getElementById('dat_zap').classList.remove('ERROR');
            document.getElementById('dat_zap').classList.add('OK');
            document.getElementById('tabError').classList.remove('pokaz');
            document.getElementById('tabError').classList.add('tabError');
            validate=true;
        }
        else{
            document.getElementById('dat_zap').classList.remove('OK');
            document.getElementById('dat_zap').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            document.getElementById('errors').innerHTML=("Data powinna być zapisana w formacie rok-miesiąc-dzień i nie powinna być późniejsza niż dzisiejsza!<br>");
        }
        if(validate)
        {
            let formZap=document.getElementById('formSprRach');
            let potw=confirm('Zmienić stan rachunku na zapłacony?');
            if(potw==1)
            {
                formZap.submit();
            }
        }
        }
var btn2=document.getElementById('btn2');
btn2.addEventListener('click', valid);
var btnDzisiaj=document.getElementById('zapDzis');
btnDzisiaj.addEventListener('click', dzis);
</script>