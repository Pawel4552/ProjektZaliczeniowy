<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja danych</title>
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
    $kwerendaBlok="select distinct blok from tablica";
$wynikBlok=mysqli_query($conn, $kwerendaBlok);

$dzis="select current_date()";
$data=mysqli_query($conn, $dzis);
$dzien=mysqli_fetch_array($data);
$dzis=$dzien[0];
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
            $kwerenda="select * from czlonek where id_czlonka='$id'";
        $wynik=mysqli_query($conn, $kwerenda);
        $wiersz=mysqli_fetch_array($wynik);
        $imie=$wiersz['1'];
        $nazwisko=$wiersz['2'];
        $lokal=$wiersz['3'];
        $blok=$wiersz['4'];
        $metraz=$wiersz['5'];
        $data_zam=$wiersz['6'];
        $data_wyp=$wiersz['7']; 
        $id=$wiersz['0'];
        echo "<form action='edit.php' method='POST' id='edit_form' name='edit'>
        <fieldset>
        <legend>Zmień dane</legend>
        ID: <input type='text' name='id' value='$id' readonly><br>
        Imię: <input type='text' name='imie' value='$imie' id='imie'><br>
        Nazwisko: <input type='text' name='nazwisko' value='$nazwisko' id='nazwisko'><br>
        Nr mieszkania: <input type='text' name='lokal' value='$lokal' id='lokal'><br>
        Blok: <select name='blok' id='blok'><option selected value='$blok'>Wybierz blok</option>";
        while($wierszBlok=mysqli_fetch_array($wynikBlok))
        {
            echo "<option value='".$wierszBlok['blok'] ."'>".$wierszBlok['blok'] ."</option>";
        }
        echo "</select><br>
        Metraż: <input type='text' name='metraz' value='$metraz' id='metraz'><br>
        Data zamieszkania: <input type='text' name='data_zam' value='$data_zam' id='Dat_zam'><br>
        Data wyprowadzki: <input type='text' name='data_wyp' value='$data_wyp' id='Dat_wyp'><br>
        <input type='button' name='edit' value='Zmień dane' id='btn_edit'><br>
        <input type='hidden' id='dzis' name='dzis' value='$dzis'>
        </fieldset></form>
        <div id='tabError' class='tabError'>
        <p id='errors'></p>
</div></div>";
?>
<div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Sprawdzić dane użytkownika</li><br>
           <li>Zmienić dane użytkownika i zapisać je</li><br></h3>
   </ul>
           </div>
<?php
       }
       else if(isset($_POST['id']))
       {
           $id=$_POST['id'];
           $imie=$_POST['imie'];
           $nazwisko=$_POST['nazwisko'];
           $lokal=$_POST['lokal'];
           $blok=$_POST['blok'];
           $metraz=$_POST['metraz'];
           $data_zam=$_POST['data_zam'];
           $data_wyp=$_POST['data_wyp'];
           $kwerendaEd="update czlonek set imie='$imie', nazwisko='$nazwisko', nr_lokalu=$lokal, blok=$blok, metraz=$metraz, data_zamieszkania=$data_zam, data_wyprowadzki=$data_wyp where id_czlonka='$id'";
           mysqli_query($conn, $kwerendaEd);
           echo "<p>Zmodyfikowano pomyślnie dane dla użytkownika o id= $id</p>";
           echo "<meta http-equiv='refresh' content='5;url=dane.php'>";
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
        if(isset($_GET['id']))  
       {
            $id=$_GET['id'];
            $kwerenda="select * from czlonek where id_czlonka='$id'";
        $wynik=mysqli_query($conn, $kwerenda);
        $wiersz=mysqli_fetch_array($wynik);
        $imie=$wiersz['1'];
        $nazwisko=$wiersz['2'];
        $lokal=$wiersz['3'];
        $blok=$wiersz['4'];
        $metraz=$wiersz['5'];
        $data_zam=$wiersz['6'];
        $data_wyp=$wiersz['7']; 
        $id=$wiersz['0'];
        echo "<form action='edit.php' method='POST' id='edit_form' name='edit'>
        <fieldset>
        <legend><h3>Zmień dane</h3></legend>
        ID: <input type='text' name='id' value='$id' readonly><br>
        Imię: <input type='text' name='imie' value='$imie' id='imie'><br>
        Nazwisko: <input type='text' name='nazwisko' value='$nazwisko' id='nazwisko'><br>
        Nr mieszkania: <input type='text' name='lokal' value='$lokal' id='lokal'><br>
        Blok: <select name='blok' id='blok'><option selected value='$blok'>$blok</option>";
        while($wierszBlok=mysqli_fetch_array($wynikBlok))
        {
            echo "<option value='".$wierszBlok['blok'] ."'>".$wierszBlok['blok'] ."</option>";
        }
        echo "</select><br>
        Metraż: <input type='text' name='metraz' value='$metraz' id='metraz'><br>
        Data zamieszkania: <input type='text' name='data_zam' value='$data_zam' id='Dat_zam'><br>
        Data wyprowadzki: <input type='text' name='data_wyp' value='$data_wyp' id='Dat_wyp'><br>
        <a href='zmiana_hasla.php?id=$id'><input type='button' name='zm_haslo' value='Zmień hasło' id='btn_zmHasl'></a>
        <input type='button' name='edit' value='Zmień dane' id='btn_edit'><br>
        <input type='hidden' id='dzis' name='dzis' value='$dzis'>
        </fieldset></form>
        <div id='tabError' class='tabError'>
        <p id='errors'></p>
</div></div>";
?>
<div class='prawy'>
           <h2>Tutaj możesz:</h2>
           <ul><h3>
           <li>Sprawdzić swoje dane</li><br>
           <li>Zmienić swoje dane</li><br>
           <li>Zmienić swoje hasło</li></h3>
   </ul>
           </div>
<?php

       }
       else if(isset($_POST['id']))
       {
           $id=$_POST['id'];
           $imie=$_POST['imie'];
           $nazwisko=$_POST['nazwisko'];
           $lokal=$_POST['lokal'];
           $blok=$_POST['blok'];
           $metraz=$_POST['metraz'];
           $data_zam=$_POST['data_zam'];
           $data_wyp=$_POST['data_wyp'];
           $kwerendaEd="update czlonek set imie='$imie', nazwisko='$nazwisko', nr_lokalu=$lokal, blok=$blok, metraz=$metraz, data_zamieszkania=$data_zam, data_wyprowadzki=$data_wyp where id_czlonka='$id'";
           mysqli_query($conn, $kwerendaEd);
           echo "<p>Zmodyfikowano pomyślnie dane dla użytkownika o id= $id</p>";
           echo "<meta http-equiv='refresh' content='5;url=dane.php'>";
       }
    }
}
}mysqli_free_result($wynik);
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
        let data_wyp=document.getElementById('Dat_wyp').value;
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
            
            dzis=dzis.trim();
            let a_rok=dzis.substring(0, 4);
            let a_mies=dzis.substring(5, 7);
            let a_dzien=dzis.substring(8);
            var valDat=true;
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
        if(data_wyp!='')
        {
            wynikData=RegData.test(data_wyp);
        if(wynikData==true)
        {  
            let rok2=data_wyp.substring(0, 4);
        let mies2=data_wyp.substring(5, 7);
        let dzien2=data_wyp.substring(8);
        var valDat=true;
        if(rok2>1999 && rok2<a_rok)
            {
                if(mies2<=12 && mies2>0 && dzien2>0 && dzien2<=31)
                {}
                else{
                    valDat=false;
                }
            }
            else if(rok2==a_rok)
            {
                if(mies2>0 && mies2<a_mies && dzien2>0 && dzien2<32)
                {}
                else if(mies2==a_mies)
                {
                    if(dzien2>0 && dzien2<=a_dzien)
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
            document.getElementById('Dat_wyp').classList.remove('ERROR');
            document.getElementById('Dat_wyp').classList.add('OK');
        }
        else{
            document.getElementById('Dat_wyp').classList.remove('OK');
            document.getElementById('Dat_wyp').classList.add('ERROR');
            validate=false;
            errorMsg.push("Data powinna być zapisana w formacie rok-miesiąc-dzień i nie powinna być późniejsza niż dzisiejsza!<br>");
        }
        }
        else{
            document.getElementById('Dat_wyp').classList.remove('ERROR');
            document.getElementById('Dat_wyp').classList.add('OK');
        }
        
        if(validate)
        {
           let rej_form=document.getElementById('edit_form');
            rej_form.submit();
        }
        else{
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            document.getElementById('edit_form').classList.add('przesun_form');
            let tab;
            let errors=document.getElementById('errors');
            for(let i=0; i<errorMsg.length; i++)
        {
            tab+=(errorMsg[i]);
        }
        errors.innerHTML=tab;
        }
    }
    var btn1=document.getElementById('btn_edit');
    btn1.addEventListener('click', valid);
</script>