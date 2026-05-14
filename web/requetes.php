<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><link rel="stylesheet" href="style.css"></head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="card">
            <h2>💻 Requêtes Libres XQuery</h2>
            <p style="font-size: 0.9rem; color: #666;">Saisissez votre requête XQuery pour interroger la base XML via BaseX REST API.</p>
            <form method="POST">
                <textarea name="xquery_code" style="width:100%; height:150px; font-family: monospace; padding:10px;" placeholder="Ex: //membre[nom='Benali']"></textarea>
                <button type="submit" name="run" class="btn-submit">Envoyer la requête à BaseX</button>
            </form>

            <?php if(isset($_POST['run'])): ?>
            <div style="margin-top:20px;">
                <h3>Résultat formaté:</h3>
                <div class="result-area">
                    <code>
                        <?php 
                        // محاكاة النتيجة المعروضة (Formaté en HTML) كما في ورقة الأستاذة
                        echo "Affichage du résultat pour: " . htmlspecialchars($_POST['xquery_code']); 
                        ?>
                    </code>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body></html>