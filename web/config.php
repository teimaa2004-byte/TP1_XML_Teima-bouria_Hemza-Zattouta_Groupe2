<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "club_db";

try {
    // الاتصال باستخدام مكتبة PDO لضمان الحماية والكفاءة
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات في XAMPP: " . $e->getMessage());
}
?>