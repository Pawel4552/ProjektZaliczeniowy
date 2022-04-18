<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zmiana hasła</title>
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
    {
       
        echo"<a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>";
        echo"<a href='dane.php'><input type='button' class='navButon' value='Wszystkie konta'></a>";
        echo"<a href='oplaty.php'><input type='button' class='navButon' value='Opłaty'>'</a>";
        echo"<a href='rachunki_lista.php'><<input type='button' class='navButon' value='Sprawdź rachunki'>'</a>";
        echo"<a href='rejestracja.php'><input type='button' class='navButon' value='Zarejestruj nowego użytkownika'></a>";
        
        echo "</nav><main>Tutaj użytkownicy zmieniają swoje hasła";
    }
    else
    {
        echo"<a href='glowna.php'><input type='button' class='navButon' value='Strona głowna'></a>";
        echo"<a href='dane.php'><input type='button' class='navButon' value='Moje konto'></a>";
        echo"<a href='liczniki.php'><input type='button' class='navButon' value='Wpisz liczniki' id='liczniki'></a>";
        echo"<a href='rachunki_lista.php'><input type='button' class='navButon' value='Sprawdź rachunki' id='rachunki'></a>";
        echo"<a href='cennik.php'><input type='button' class='navButon' value='Cennik opłat'></a>";
        echo "</nav><main>";
    if(isset($_GET['id']))
        {
            echo "<div class='lewy'><form action='zmiana_h.php' method='POST' id='zm_hs_form'>
            <fieldset>
            <legend><h3>Zmiana hasła</h3></legend>
            <input type='text' name='log_zm_h' id='log_zm_h' value='$login' readonly class='log_zm_h'><br>
            Stare hasło: <input type='password' name='stare_haslo' placeholder='Podaj hasło'><br>
            Hasło: <input type='password' name='pass_zm_h' id='pass_zm_h' placeholder='Podaj hasło'><br>
            <div id='ukrDiv'>
            Potwierdź hasło: <input type='password' name='check_pass_zm' id='check_pass_zm' class='check_pass_zm' placeholder='Potwierdź hasło'><br>
            </div>
            <input type='button' id='btn3' value='Zmień hasło'>
            </fieldset>
            </form><div id='tabError' class='tabError'>
            <p id='errors'></p>
            </div></div>";
            ?>
                <div class='prawy'>
    <h3>Masz tutaj możliwosć:</h3><br>
    <ul><h3>
        <li>Zmienić swoje hasło</li></h3>
</ul>
<h3>Najpierw wpisz stare hasło, a potem podaj nowe.</h3>
</div>
            <?php
        }
    }
        }
        else{
            echo "<header><div class='hedLew'><h1>Współdzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><p class='logOn'>Nie jesteś zalogowany</div></header></p><main>";
         if(isset($_GET['login']))
    {

        $login=$_GET['login'];
        echo "<div class='lewy'><form action='zmiana_h.php' method='POST' id='zm_hs_form'>
        <fieldset>
        <legend><h3>Zmiana hasła</h3></legend>
        <input type='text' name='log_zm_h' id='log_zm_h' value='$login' readonly class='log_zm_h'><br>
        Hasło: <input type='password' name='pass_zm_h' id='pass_zm_h' placeholder='Podaj hasło'><br>
        <div id='ukrDiv'>
        Potwierdź hasło: <input type='password' name='check_pass_zm' id='check_pass_zm' class='check_pass_zm' placeholder='Potwierdź hasło'><br>
        </div>
        <input type='button' id='btn3' value='Zmień hasło'>
        </fieldset>
        </form><div id='tabError' class='tabError'>
        <p id='errors'></p>
        </div></div>";
        ?>
<div class='prawy'>
    <h3>Masz tutaj możliwosć:</h3><br>
    <ul><h3>
        <li>Ustawić swoje hasło</li></h3>
</ul>
<h3>Wpisz i potwierdź swoje hasło</h3>
</div>
        <?php
    }
    
} }
mysqli_free_result($wynikTyp);
mysqli_close($conn);
    ?>
    </main>
    <footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</body>
</html>
<script>
    var valid=false;
    document.getElementById('ukrDiv').classList.add('ukryj');
    function checkPass()
{
    let errors=document.getElementById('errors');
    let log=document.getElementById('log_zm_h').value;
    if(log!='admin')
    {
        
    let pass1=document.getElementById('pass_zm_h').value;
        let RegPass= new RegExp("^(?=.*[!@#$%^&*])(?=.*[0-9])(?=.*[a-złśźńćżąę])(?=.*[A-ZŁŚĆŹŻŃĄĘ])(?=.*[a-zA-ZłśźńćżąęŁŚĆŹŻŃĄĘ]).{8,32}$");
        let wynikPass=RegPass.test(pass1);
        if(wynikPass)
        {
            document.getElementById('pass_zm_h').classList.remove('ERROR');
            document.getElementById('pass_zm_h').classList.add('OK');
            document.getElementById('ukrDiv').classList.remove('ukryj');
            document.getElementById('ukrDiv').classList.add('.visib');
            errors.innerHTML=('');
        }
        else{
            document.getElementById('pass_zm_h').classList.remove('OK');
            document.getElementById('pass_zm_h').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            document.getElementById('ukrDiv').classList.remove('visib');
            document.getElementById('ukrDiv').classList.add('ukryj');
            let errors=document.getElementById('errors');
            errors.innerHTML=("Hasło nie spełnia wymagań!<br>Hasło musi mieć co najmniej 8 znakó w tym co najmniej:<br> 1 WIELKA litera, 1 mała litera, 1 cyfra, 1 znak [!@#$%^&*]");  
    }
    /*else{
        document.getElementById('pass_zm_h').classList.remove('ERROR');
            document.getElementById('pass_zm_h').classList.add('OK');
            document.getElementById('ukrDiv').classList.remove('ukryj');
            document.getElementById('ukrDiv').classList.add('.visib');
            errors.innerHTML=('');
    }*/
    
}}
function checkPass2()
{
    let pass1=document.getElementById('pass_zm_h').value;
    let pass2=document.getElementById('check_pass_zm').value;
    if(pass2==pass1)
    {
        document.getElementById('check_pass_zm').classList.remove('ERROR');
        document.getElementById('check_pass_zm').classList.add('OK');
        valid=true;
    }
    else
    {
        pass2=document.getElementById('check_pass_zm').value;
            document.getElementById('check_pass_zm').classList.remove('OK');
            document.getElementById('check_pass_zm').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            let errors=document.getElementById('errors');
            errors.innerHTML=("Hasła są różne, sprawdź poprawność!<br>");
    }
}
function sub()
{
    if(valid)
    {
        let zm_pass_form=document.getElementById('zm_hs_form');
        zm_pass_form.submit();
    }
}
var pass1=document.getElementById('pass_zm_h');
pass1.addEventListener('blur', checkPass);
var pass2=document.getElementById('check_pass_zm');
pass2.addEventListener('blur', checkPass2);
var btn3=document.getElementById('btn3');
btn3.addEventListener('click', sub);
</script>