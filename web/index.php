<?php $xml = simplexml_load_file('club.xml'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="card">
            <h2>📖 Liste des Concours Disponibles</h2>
            <table>
                <thead>
                    <tr><th>Titre</th><th>Date</th><th>Catégorie</th><th>Coefficient</th></tr>
                </thead>
                <tbody>
                    <?php foreach($xml->concours->concours as $c): ?>
                    <tr>
                        <td><?= $c->titre ?></td>
                        <td><?= $c['date'] ?></td>
                        <td><span class="badge"><?= $c['categorieRef'] ?></span></td>
                        <td><?= $c['coefficient'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>