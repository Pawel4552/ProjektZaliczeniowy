<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <?php
    session_start();
    if(isset($_SESSION['uid']))
    //niszczenie danych sesji
    session_unset();
    session_destroy();
    echo "<meta http-equiv='refresh' content='1;url=glowna.php'>";
    mysqli_close($conn);
    ?>
</body>
</html>