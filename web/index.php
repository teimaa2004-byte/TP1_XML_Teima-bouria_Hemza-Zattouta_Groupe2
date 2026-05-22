<?php 
// 1. الاتصال بقاعدة البيانات (MySQL)
require_once 'config.php'; 

// 2. قراءة ملف الـ XML
$xmlFile = 'club.xml';
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile); 
} else {
    die("Erreur: Le fichier club.xml est introuvable !");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Club Info_Tech - Concours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container">
        <div class="card">
            <h2>📖 Liste des Concours Disponibles</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Catégorie</th>
                        <th>Coefficient</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // الدخول إلى الوسم التجميعي ثم تكرار المسابقات الفردية بدقة
                    if (isset($xml->concours->concours)) {
                        foreach($xml->concours->concours as $c) {
                            echo "<tr>";
                            echo "<td>" . (string)$c->titre . "</td>";
                            echo "<td>" . (string)$c['date'] . "</td>";
                            echo "<td><span class='badge'>" . (string)$c['categorieRef'] . "</span></td>";
                            echo "<td>" . (string)$c['coefficient'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>Aucun concours trouvé. Vérifiez le fichier XML.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>