<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Representation</title>
    </head>
    <body>
        <?php
        use modele\metier\Representation;
        use modele\metier\Lieu;
        use modele\metier\Groupe;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Representation</h2>";
        $unLieu = new Lieu('5', 'La Joliverie', '141 route de Clisson', '5000');
        $unGroupe = new Groupe('g061', 'Groupe folklorique des Émirats', null, null, '61', 'France', 'O');
        $objet = new Representation('5', $unLieu, $unGroupe, '2017-07-15', '18:15:00', '19:00:00');
        var_dump($objet);
        ?>
    </body>
</html>