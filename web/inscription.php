<?php 
// 1. الاتصال بقاعدة البيانات (MySQL) لضمان التناسق
require_once 'config.php'; 

// 2. قراءة ملف الـ XML
$xmlFile = 'club.xml';
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
} else {
    die("Erreur: Le fichier club.xml est introuvable !");
}

if (isset($_POST['valider'])) {
    // تصحيح مسار البحث عن المسابقة المختارة لحفظ العضو الجديد داخلها
    if (isset($xml->concours->concours)) {
        foreach ($xml->concours->concours as $con) {
            if ((string)$con['id'] == $_POST['c_id']) {
                
                // إضافة عقدة <participant> جديدة مع الأتريبيوت membreRef
                $p = $con->participants->addChild('participant');
                $p->addAttribute('membreRef', $_POST['m_id']);
                
                // إضافة قيم الأداء داخل تاغات نصية (عناصر) لتطابق هيكل ملفكِ الأصلي 100%
                $p->addChild('complexite', $_POST['comp']);
                $p->addChild('tempsExecution', $_POST['time']);
                break;
            }
        }
        
        // حفظ التعديلات في ملف XML
        $xml->asXML($xmlFile);
        
        // التوجيه لصفحة النتائج لرؤية التحديث فوراً
        header("Location: resultats.php?id=".$_POST['c_id']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Club Info_Tech - Inscription Concours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container">
        <div class="card">
            <h2>✍️ Nouvelle Inscription au Concours</h2>
            <form method="POST">
                
                <label>Concours:</label>
                <select name="c_id" required>
                    <option value="">-- Sélectionnez un concours --</option>
                    <?php 
                    // تصحيح المسار المزدوج هنا لملء القائمة المنسدلة للمسابقات
                    if (isset($xml->concours->concours)) {
                        foreach($xml->concours->concours as $c) {
                            echo "<option value='".(string)$c['id']."'>".(string)$c->titre."</option>";
                        }
                    }
                    ?>
                </select>
                
                <label>Membre:</label>
                <select name="m_id" required>
                    <?php 
                    if (isset($xml->membres->membre)) {
                        foreach($xml->membres->membre as $m) {
                            echo "<option value='".(string)$m['id']."'>".(string)$m->prenom." ".(string)$m->nom."</option>";
                        }
                    }
                    ?>
                </select>
                
                <div style="display:flex; gap:15px;">
                    <div style="flex:1;">
                        <label>Complexité de l'algo (0-100):</label>
                        <input type="number" name="comp" min="0" max="100" required>
                    </div>
                    <div style="flex:1;">
                        <label>Temps exécution (ms):</label>
                        <input type="number" name="time" min="1" required>
                    </div>
                </div>
                
                <button type="submit" name="valider" class="btn" style="margin-top:15px;">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
</html>