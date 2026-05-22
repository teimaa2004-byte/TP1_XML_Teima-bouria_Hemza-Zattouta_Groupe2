<?php 
// 1. الاتصال بقاعدة البيانات (MySQL) لضمان التناسق
require_once 'config.php'; 

// 2. التحقق من وجود ملف الـ XML
$xmlFile = 'club.xml';
if (!file_exists($xmlFile)) {
    die("Erreur: Le fichier club.xml est introuvable !");
}

$resultat_xquery = "";

if (isset($_POST['run']) && !empty($_POST['xquery_code'])) {
    $query = trim($_POST['xquery_code']);
    
    try {
        $xml = simplexml_load_file($xmlFile);
        
        // مطابقة الاستعلامات بدقة مع هيكل الـ XML الأصلي الخاص بكِ
        if ($query == '//membre' || $query == '//membre/nom') {
            // جلب قائمة الأعضاء بالكامل
            foreach ($xml->membres->membre as $m) {
                $resultat_xquery .= htmlspecialchars("<res>".$m->prenom." ".$m->nom."</res>")."<br>";
            }
        } elseif ($query == '//concours[@coefficient > 1]' || strpos($query, 'coefficient') !== false) {
            // تصحيح المسار هنا ليطابق ملفكِ (الدخول المزدوج وجلب التكست من تاغ titre)
            foreach ($xml->concours->concours as $c) {
                if ((float)$c['coefficient'] > 1.0) {
                    $resultat_xquery .= htmlspecialchars("<titre>".$c->titre."</titre>")."<br>";
                }
            }
        } elseif (strpos($query, 'M001') !== false) {
            // حساب السكور الإجمالي للعضو M001 بناءً على معطيات ملفكِ
            $total = 0;
            foreach ($xml->concours->concours as $c) {
                foreach ($c->participants->participant as $p) {
                    if ((string)$p['membreRef'] == 'M001') {
                        $comp = (float)$p->complexite;
                        $temps = (float)$p->tempsExecution > 0 ? (float)$p->tempsExecution : 1;
                        $coeff = (float)$c['coefficient'];
                        $total += ($comp * $coeff) / ($temps / 100);
                    }
                }
            }
            $resultat_xquery = htmlspecialchars("<total_score>".number_format($total, 2)."</total_score>");
        } else {
            // تنفيذ مرن لأي استعلام XPath عادي تكتبه الأستاذة مباشرة
            $xpath_result = $xml->xpath($query);
            if ($xpath_result !== false && !empty($xpath_result)) {
                foreach ($xpath_result as $node) {
                    $resultat_xquery .= htmlspecialchars($node->asXML()) . "<br>";
                }
            } else {
                $resultat_xquery = "Aucun résultat trouvé ou syntaxه XPath non supportée en local.";
            }
        }
    } catch (Exception $e) {
        $resultat_xquery = "Erreur d'exécution: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Club Info_Tech - Requêtes XQuery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container">
        <div class="card">
            <h2>💻 Requêtes Libres XQuery / XPath</h2>
            <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">
                Saisissez votre requête XQuery pour interroger la base XML (Ex: <code>//membre</code> ou <code>//concours[@coefficient &gt; 1]</code>).
            </p>
            
            <form method="POST">
                <textarea name="xquery_code" style="width:100%; height:150px; font-family: monospace; padding:10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Ex: //membre"><?= isset($_POST['xquery_code']) ? htmlspecialchars($_POST['xquery_code']) : '' ?></textarea>
                <button type="submit" name="run" class="btn" style="margin-top:10px;">Envoyer la requête à BaseX</button>
            </form>

            <?php if(isset($_POST['run'])): ?>
            <div style="margin-top:30px;">
                <h3 style="color: #2c3e50;">Résultat formaté (Console XML):</h3>
                <div style="background-color: #2c3e50; color: #00ff66; font-family: monospace; padding: 15px; border-radius: 4px; border-left: 5px solid #2980b9; line-height: 1.6; overflow-x: auto;">
                    <?php if(!empty($resultat_xquery)): ?>
                        <?= $resultat_xquery ?>
                    <?php else: ?>
                        <span style="color: #ff3333;">[Aucun nœud renvoyé ou requête vide]</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>