<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Realisateur Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Realisateur;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Realisateur</h2>";
        $objet = new Realisateur(1,"BAUDRY","Quentin");
        var_dump($objet);
        ?>
    </body>
</html>
