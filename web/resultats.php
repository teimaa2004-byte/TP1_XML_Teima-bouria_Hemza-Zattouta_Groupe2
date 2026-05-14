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
            <h2>🥇 Résultats des Concours</h2>
            <form method="GET" style="display:flex; gap:10px; margin-bottom:20px;">
                <select name="id" style="flex:2;">
                    <?php foreach($xml->concours->concours as $c) {
                        $selected = ($_GET['id'] == $c['id']) ? "selected" : "";
                        echo "<option value='{$c['id']}' $selected>{$c->titre}</option>";
                    } ?>
                </select>
                <button type="submit" class="btn-small">Afficher résultats</button>
            </form>

            <?php if(isset($_GET['id'])): ?>
                <table>
                    <thead>
                        <tr><th>Rang</th><th>Participant</th><th>Complexité</th><th>Temps (ms)</th><th>Score</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        foreach($xml->concours->concours as $c) {
                            if($c['id'] == $_GET['id']) {
                                foreach($c->participants->participant as $p) {
                                    $score = ((float)$p->complexite * (float)$c['coefficient']) / ((float)$p->tempsExecution / 100);
                                    echo "<tr>
                                            <td>".($rank==1?"1 🥇":$rank)."</td>
                                            <td>{$p['membreRef']}</td>
                                            <td>{$p->complexite}</td>
                                            <td>{$p->tempsExecution}</td>
                                            <td><strong>".number_format($score, 2)."</strong></td>
                                          </tr>";
                                    $rank++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>