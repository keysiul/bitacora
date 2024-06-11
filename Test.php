<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Test</title>
</head>
<body>
    <?php require_once "BitacoraConnection.php";
    $connection = new BitacoraConnecion();
    echo("Database :". pg_dbname($connection->getBitacoraConnection()->getCon()));
    ?>
</body>
</html>