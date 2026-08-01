<?php
$archive_file = "cloud_secure_box.txt";

// رادار الفحص صامتاً: إذا كان الملف فارغاً أو غير موجود نبلغ أكسس فوراً
if (!file_exists($archive_file) || filesize($archive_file) == 0) {
    echo "NO_DATA";
    exit;
}

// 1. قراءة وضخ كافة الشكاوى المتراكمة بأسماء الموظفين لكمبيوتر المدير
$content = file_get_contents($archive_file);
echo $content;

// 2. التطهير الفوري الحاسم: مسح وتصفير ملف السيرفر السحابي فوراً لحماية أسرار 
file_put_contents($archive_file, "");
?>
