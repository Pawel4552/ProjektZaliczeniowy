<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejstracja</title>
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
    $db=mysqli_select_db($conn, 'wspoldzielnia');
$kwerenda="select distinct blok from tablica";
$wynik=mysqli_query($conn, $kwerenda);

$dzis="select current_date()";
$data=mysqli_query($conn, $dzis);
$dzien=mysqli_fetch_array($data);
?>

    <form action="rejestruj.php" method="POST" id="rej_form">
    <fieldset>
    <legend><h3>Rejestracja</h3></legend>
    Imię: <input type="text" name="imie" id="imie" placeholder="Imię"><br>
    Nazwisko: <input type="text" name="nazwisko" id="nazwisko" placeholder="Nazwisko"><br>
    Numer mieszkania: <input type="text" name="lokal" id="lokal" placeholder="Nr mieszkania"><br>
    Blok: 
    <?php 
    echo "<select name='blok' id='blok'><option selected value='none'>Wybierz blok</option>";
    while($wiersz=mysqli_fetch_array($wynik))
    {
        echo "<option value='".$wiersz['blok'] ."'>".$wiersz['blok'] ."</option>";
    }
    echo '</select>';
    ?><br>
    Metraż: <input type='text' name='metraz' id="metraz" placeholder="000.00"><br>
    Data zamieszkania: <input type="text" name="Dat_zam" id="Dat_zam" placeholder="rrrr-mm-dd"><br>
    <input type='hidden' id="dzis" name="dzis" value='<?php echo $dzien[0];?>'>
    <input type="hidden" name="login" id="login">
    <input type="button" value="Zarejestruj" id="btn1">
    </fieldset>
    </form>
<div id="tabError" class="tabError">
        <p id="errors"></p>
</div></div>
<div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Zarejestrować nowego mieszkańca współdzielni</li><br>
           <li>Z podanych danych zostanie wygenerowany login w postaci:<BR>3 pierwsze litery imienia i nazwiska, nr lokalu, oznaczenie bloku</li><br></h3>
   </ul>
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
        echo "<h1>Tylko administracja ma możliwośc rejestarcji nowych członków współdzielni</h1></div>";
        ?>
<div class='prawy'>
           <h2>Zawartość nie jest przeznaczona dla ciebie, zmień stronę!</h2>
           </div>
<?php
    }
}}
mysqli_free_result($wynik);
mysqli_free_result($wynikTyp);    
mysqli_free_result($data);
    mysqli_close($conn);
    ?>
    </main>
    <footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
    </body>
    </html>
<script>
function valid()
    {
        let errorMsg=[];
        let validate=true;
        let imie=document.getElementById('imie').value;
        let nazwisko=document.getElementById('nazwisko').value;
        let lokal=document.getElementById('lokal').value;
        let blok=document.getElementById('blok').value;
        let metraz=document.getElementById('metraz').value;
        let data_zam=document.getElementById('Dat_zam').value;
        let dzis=document.getElementById('dzis').value;
        
        let RegImie= new RegExp("^[A-ZŁŚĆŹŻŃĄĘ]{1}[a-złśźńćżąę]{1,29}$");
        let wynikImie=RegImie.test(imie);
        if(wynikImie)
        {
            document.getElementById('imie').classList.remove('ERROR');
            document.getElementById('imie').classList.add('OK');
        }
        else{
            document.getElementById('imie').classList.remove('OK');
            document.getElementById('imie').classList.add('ERROR');
            validate=false;
            errorMsg.push("Imię powinno zaczynać się z WIELKIEJ litery!<br>");
        }
        let RegNazw= new RegExp("^[A-ZŁŚĆŹŻŃĄĘ]{1}[a-złśźńćżąę]{1,25}[-]?[A-Z]?[a-złśźńćżąę]{1,22}?$");
        let wynikNazw=RegNazw.test(nazwisko);
        if(wynikNazw)
        {
            document.getElementById('nazwisko').classList.remove('ERROR');
            document.getElementById('nazwisko').classList.add('OK');
        }
        else{
            document.getElementById('nazwisko').classList.remove('OK');
            document.getElementById('nazwisko').classList.add('ERROR');
            validate=false;
            errorMsg.push("Nazwisko powinno zaczynać się z WIELKIEJ litery!<br>");
        }
        parseInt(lokal)
        if(!isNaN(lokal) && lokal!=0)
        {
            document.getElementById('lokal').classList.remove('ERROR');
            document.getElementById('lokal').classList.add('OK');
        }
        else{
            document.getElementById('lokal').classList.remove('OK');
            document.getElementById('lokal').classList.add('ERROR');
            validate=false;
            errorMsg.push("Numer mieszkania powinien byc liczbą całkowitą większą od 0!<br>");
        }
        if(blok!='none')
        {
            document.getElementById('blok').classList.remove('ERROR');
            document.getElementById('blok').classList.add('OK');
        }
        else{
            document.getElementById('blok').classList.remove('OK');
            document.getElementById('blok').classList.add('ERROR');
            validate=false;
            errorMsg.push("Należy wybrać oznaczenie bloku!<br>");
        }
        metraz=metraz.replace(',', '.');
        metraz=parseFloat(metraz).toFixed(2); 
        document.getElementById('metraz').value=metraz;
        let RegMet= new RegExp("^[0-9]{1,3}[.][0-9]{1,2}$");
        wynikMet=RegMet.test(metraz);
        if(wynikMet)
        {
            document.getElementById('metraz').classList.remove('ERROR');
            document.getElementById('metraz').classList.add('OK');
        }
        else{
            document.getElementById('metraz').classList.remove('OK');
            document.getElementById('metraz').classList.add('ERROR');
            validate=false;
            errorMsg.push("Metraż mieszkania powinien być liczbą!<br>");
        }
        let RegData= new RegExp("^[0-9]{4}[-][0-9]{2}[-][0-9]{2}");
        wynikData=RegData.test(data_zam);
        
        if(wynikData==true)
        {   
            let rok=data_zam.substring(0, 4);
            let mies=data_zam.substring(5, 7);
            let dzien=data_zam.substring(8);
            let a_rok=dzis.substring(0, 4);
            let a_mies=dzis.substring(5, 7);
            let a_dzien=dzis.substring(8);
            let valDat=true;
            if(rok>1999 && rok<a_rok)
            {
                if(mies<=12 && mies>0 && dzien>0 && dzien<=31)
                {}
                else{
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
                        valDat=false;
                    }
                }
                else{
                        valDat=false;
                }
            }
            else{
                valDat=false;
            }
        }
        else{
            valDat=false;
        }
        if(valDat)
        {
            document.getElementById('Dat_zam').classList.remove('ERROR');
            document.getElementById('Dat_zam').classList.add('OK');
        }
        else{
            document.getElementById('Dat_zam').classList.remove('OK');
            document.getElementById('Dat_zam').classList.add('ERROR');
            validate=false;
            errorMsg.push("Data powinna być zapisana w formacie rok-miesiąc-dzień i nie powinna być późniejsza niż dzisiejsza!<br>");
        }
        
        if(validate)
        {
           let rej_form=document.getElementById('rej_form');
            document.getElementById('login').value=imie.substring(0, 3)+nazwisko.substring(0, 3)+lokal+blok;
            rej_form.submit();
        }
        else{
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            document.getElementById('rej_form').classList.add('przesun_form');
            let tab;
            let errors=document.getElementById('errors');
            for(let i=0; i<errorMsg.length; i++)
        {
            tab+=(errorMsg[i]);
        }
        errors.innerHTML=tab;
        }
    }
    var btn1=document.getElementById('btn1');
    btn1.addEventListener('click', valid);
    </script>