<?php 
// 1. الاتصال بقاعدة البيانات (MySQL) لجلب أسماء الأعضاء الحقيقية
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
    <title>Club Info_Tech - Résultats</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container">
        <div class="card">
            <h2>🥇 Résultats des Concours</h2>
            
            <form method="GET" style="display:flex; gap:10px; margin-bottom:20px;">
                <select name="id" style="flex:2;">
                    <option value="">-- Sélectionnez un concours --</option>
                    <?php 
                    if (isset($xml->concours->concours)) {
                        foreach($xml->concours->concours as $c) {
                            $selected = (isset($_GET['id']) && $_GET['id'] == (string)$c['id']) ? "selected" : "";
                            echo "<option value='".(string)$c['id']."' $selected>".(string)$c->titre."</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn">Afficher résultats</button>
            </form>

            <?php if(isset($_GET['id']) && !empty($_GET['id'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Participant</th>
                            <th>Complexité</th>
                            <th>Temps (ms)</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        
                        // تصحيح مسار البحث عن المسابقة المختارة
                        foreach($xml->concours->concours as $c) {
                            if((string)$c['id'] == $_GET['id']) {
                                
                                // التكرار على المشاركين داخل المسابقة المختارة
                                foreach($c->participants->participant as $p) {
                                    
                                    // جلب الاسم واللقب الحقيقي للمشارك من قاعدة بيانات MySQL
                                    $mRef = (string)$p['membreRef'];
                                    $fullName = "ID: " . $mRef; 
                                    
                                    $stmt = $conn->prepare("SELECT nom, prenom FROM membres WHERE id = :id");
                                    $stmt->execute(['id' => $mRef]);
                                    $userDb = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($userDb) {
                                        $fullName = $userDb['prenom'] . " " . $userDb['nom'];
                                    }

                                    // جلب القيم من داخل التاغات التابعة للمشارك بحسب ملفكِ الأصلي
                                    $comp = (float)$p->complexite;
                                    $temps = (float)$p->tempsExecution > 0 ? (float)$p->tempsExecution : 1;
                                    $coeff = (float)$c['coefficient'];

                                    // معادلة حساب السكور الخاصة بكِ
                                    $score = ($comp * $coeff) / ($temps / 100);
                                    
                                    echo "<tr>
                                            <td><strong>".($rank == 1 ? "1 🥇" : $rank)."</strong></td>
                                            <td>{$fullName}</td>
                                            <td>{$comp}</td>
                                            <td>{$temps} ms</td>
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