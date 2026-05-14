<?php 
$xml = simplexml_load_file('club.xml');
if (isset($_POST['valider'])) {
    foreach ($xml->concours->concours as $con) {
        if ($con['id'] == $_POST['c_id']) {
            $p = $con->participants->addChild('participant');
            $p->addAttribute('membreRef', $_POST['m_id']);
            $p->addChild('complexite', $_POST['comp']);
            $p->addChild('tempsExecution', $_POST['time']);
        }
    }
    $xml->asXML('club.xml');
    header("Location: resultats.php?id=".$_POST['c_id']);
}
?>
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
            <h2>✍️ Nouvelle Inscription</h2>
            <form method="POST">
                <label>Concours:</label>
                <select name="c_id"><?php foreach($xml->concours->concours as $c) echo "<option value='{$c['id']}'>{$c->titre}</option>"; ?></select>
                
                <label>Membre:</label>
                <select name="m_id"><?php foreach($xml->membres->membre as $m) echo "<option value='{$m['id']}'>{$m->prenom} {$m->nom}</option>"; ?></select>
                
                <div style="display:flex; gap:15px;">
                    <div style="flex:1;"><label>Complexité de l'algo (0-100):</label><input type="number" name="comp"></div>
                    <div style="flex:1;"><label>Temps exécution (ms):</label><input type="number" name="time"></div>
                </div>
                
                <button type="submit" name="valider" class="btn-submit">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
</html>