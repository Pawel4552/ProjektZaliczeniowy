<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cennik</title>
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
echo "Nie nawi??zano po????czenia";
}
else{
    mysqli_select_db($conn, 'wspoldzielnia');
session_start();
if(isset($_SESSION['id']))
{
    $login=$_SESSION['id'];
    echo "<header><div class='hedLew'><h1>Wsp????dzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><div class='logOn hedPraw'><p>Jeste?? zalogowany jako: $login
    <a href='logout.php'><input type='button' value='wyloguj' id='btn1' class='log'></a></p>
    </div></header><nav>";
    $kwerenda="select typ_konta from konto where login='$login'";
    $wynikTyp=mysqli_query($conn, $kwerenda);
    $wiersz=mysqli_fetch_array($wynikTyp);
    if($wiersz[0]=='A')
    {
        echo"<a href='glowna.php'><input type='button' class='navButon' value='Strona g??owna'></a>";
        echo"<a href='dane.php'><input type='button' class='navButon' value='Wszystkie konta'></a>";
        echo"<a href='oplaty.php'><input type='button' class='navButon' value='Op??aty'>'</a>";
        echo"<a href='rachunki_lista.php'><<input type='button' class='navButon' value='Sprawd?? rachunki'>'</a>";
        echo"<a href='rejestracja.php'><input type='button' class='navButon' value='Zarejestruj nowego u??ytkownika'></a>";
        
        echo "</nav><main>";
    }
    else
    {
        echo"<a href='glowna.php'><input type='button' class='navButon' value='Strona g??owna'></a>";
        echo"<a href='dane.php'><input type='button' class='navButon' value='Moje konto'></a>";
        echo"<a href='liczniki.php'><input type='button' class='navButon' value='Wpisz liczniki' id='liczniki'></a>";
        echo"<a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawd?? rachunki' id='rachunki'></a>";
        echo"<a href='cennik.php'><input type='button' class='navButon' value='Cennik op??at'></a>";
        echo "</nav><main>";
    }
    mysqli_free_result($wynikTyp);
}
else{
    echo "<header><div class='hedLew'><h1>Wsp????dzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><div class='hedPraw'><p class='logOn'>Nie jeste?? zalogowany
    <a href='logowanie.php'><input type='button' value='zaloguj' id='btn1'></a></div></header></p></div><main>";
}

}


?>
<div class='lewy'>
    <ul>
    <?php
        $kwerenda2="select id_oplaty, rodzaj, typ, koszt from oplaty";
       $wynik=mysqli_query($conn, $kwerenda2);
       while($wiersz2=mysqli_fetch_array($wynik))
       {
           echo '<h3><li>' .$wiersz2[1] .' (op??ata ' .$wiersz2[2] .') ' .$wiersz2[3] .' z??</li></h3><br>';
       }
       mysqli_free_result($wynik);
       mysqli_free_result($wynikTyp);
       mysqli_close($conn);
       ?>
       </ul>
</div>
<div class='prawy'>
    <h3>Tutaj mo??esz:</h3><br>
    <ul><h3>
        <li>Sprawdzi?? cennik op??at</li></h3>
</ul>
</div>
</main>
<footer>Kontakt z administracj??, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</body>
</html>
