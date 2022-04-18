<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprawdzanie rachunków</title>
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
    width:100%;
    background-color:rgba(179, 255, 164, 0.788);
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
    {?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
            <a href='dane.php'><input type='button' class='navButon' value='Wszystkie konta'></a>
            <a href='oplaty.php'><input type='button' class='navButon' value='Opłaty'></a>
            <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki'></a>
            <a href='rejestracja.php'><input type='button' class='navButon' value='Zarejestruj nowego użytkownika'></a>
            </nav><main>
        <?php
    echo "<meta http-equiv='refresh' content='0;url=glowna.php'>";}
    else
    { 
        ?>
        <a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>
        <a href='dane.php'><input type='button' class='navButon' value='Moje konto'></a>
        <a href='liczniki.php'><input type='button' class='navButon' value='Wpisz liczniki' id='liczniki'></a>
        <a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki' id='rachunki'></a>
        <a href='cennik.php'><input type='button' class='navButon' value='Cennik opłat'></a>
        </nav><main>
            <?php
          echo "<div class='lewy'>Sprawdzanie rachunków, to może trochę potrwać</div>";
        $id_czlonka=$wierszTyp[1];
        $kwerTypOp="select typ, id_oplaty, koszt from oplaty where typ in('stała', 'za m^2')";
        $wynTypOp=mysqli_query($conn, $kwerTypOp);
        $kwerCzl="select date_format(data_zamieszkania, '%Y%m'), metraz, date_format(current_date(), '%Y%m') from czlonek where id_czlonka='$id_czlonka'";
        $wyCzl=mysqli_query($conn, $kwerCzl);
        $wieCzl=mysqli_fetch_array($wyCzl);
        $data_zam=$wieCzl[0];
        $metraz=$wieCzl[1];
        $data_dzis=$wieCzl[2];
        $ileRach=0;
        while($wierTypOp=mysqli_fetch_array($wynTypOp))
        {
            $typOp=$wierTypOp[0];
            $id_op=$wierTypOp[1];
            $kosztOp=$wierTypOp[2];
            if($typOp=="za m^2")
            {
                $kosztMsc=$kosztOp*$metraz;
            }
            if($typOp=="stała")
            {
                $kosztMsc=$kosztOp;
            }
            $kwerenda1="select count(id_rachunku) from rachunek where id_czlonka='$id_czlonka' and id_oplaty='$id_op'";
            $wynik1=mysqli_query($conn, $kwerenda1);
            $wiersz1=mysqli_fetch_array($wynik1);
            $kwerDaty="select date_format(current_date(), '%m'), date_add(current_date(), interval 14 day)";
            $wynDaty=mysqli_query($conn, $kwerDaty);
            $wieDaty=mysqli_fetch_array($wynDaty);
            switch ($wieDaty[0])
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
        $termin=$wieDaty[1];
            if($wiersz1[0]==0)
            {
                $kwIleMsc="select period_diff($data_dzis, $data_zam)";
                $wynIleMsc=mysqli_query($conn, $kwIleMsc);
                $wieIleMsc=mysqli_fetch_array($wynIleMsc);
                $ileMsc=$wieIleMsc[0];
                if($ileMsc>0)
                {
                    $wartość=$ileMsc*$kosztMsc;
                    $wartość=round($wartość, 2);
                    $zapRach="insert into rachunek values(null, '$miesiac', '$termin', '$wartość', 'N', null, 0.00, $id_czlonka, $id_op, null)";
                    mysqli_query($conn, $zapRach); 
                    $ileRach++;
                }
                
            }
            else
            {
                $kwerPopRach="select date_format(date_sub(termin_platnosci, interval 14 day), '%Y%m'), odsetki from rachunek where id_czlonka='$id_czlonka' and id_oplaty='$id_op' order by termin_platnosci desc limit 1";
                $wynPopRach=mysqli_query($conn, $kwerPopRach);
                $wiePopRach=mysqli_fetch_array($wynPopRach);
                $popRach=$wiePopRach[0];
                $kwIleMsc="select period_diff($data_dzis, $popRach)";
                $wynIleMsc=mysqli_query($conn, $kwIleMsc);
                $wieIleMsc=mysqli_fetch_array($wynIleMsc);
                $ileMsc=$wieIleMsc[0];
                if($ileMsc>0)
                {
                    $wartość=($ileMsc*$kosztMsc)+$odsetki;
                    $wartość=round($wartość, 2);
                    $zapRach="insert into rachunek values(null, '$miesiac', '$termin', '$wartość', 'N', null, 0.00, $id_czlonka, $id_op, null)";
                    mysqli_query($conn, $zapRach);
                    $ileRach++;
                } 
            }
        }
        if($ileRach>0)
        {
            echo "Pomyślnie dodano rachunki!<meta http-equiv='refresh' content='5;url=glowna.php'><br>";
        }
        else{
            echo "<meta http-equiv='refresh' content='5;url=glowna.php'><br>";
        }
       }}}
       mysqli_free_result($wynPopRach);
       mysqli_free_result($wynikTyp);
       mysqli_free_result($wynIleMsc);
       mysqli_free_result($wynik1);
       mysqli_free_result($wynDaty);
       mysqli_free_result($wynTypOp);
       mysqli_free_result($wyCzl);
       mysqli_close($conn);
    ?>
    </main>
    <footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
    </body>
    </html>