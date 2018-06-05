<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Genre Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Genre;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Genre</h2>";
        $objet = new Genre(1,"Libelle");
        var_dump($objet);
        ?>
    </body>
</html>
