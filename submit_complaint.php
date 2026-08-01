<?php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. التقاط وتطهير البيانات القادمة من هاتف المراجع لمنع التلاعب النصي
    $clinic = strip_tags(trim($_POST['clinic']));
    $staff = strip_tags(trim($_POST['staff_name']));
    $complaint_text = strip_tags(trim($_POST['complaint_text']));

    if (empty($clinic) || empty($complaint_text)) {
        die("🚨 خطأ: يرجى ملء كافة الحقول المطلوبة بسلام!");
    }

    // إذا لم يتم تحديد اسم الموظف نجعله عاماً للقسم
    if (empty($staff)) {
        $staff = "القسم ككل";
    }

    // 2. صياغة السطر التراكمي المفرز بفواصل صارمة لسهولة تفكيكه بالـ VBA لاحقاً
    // الهيكل: اسم العيادة ||| اسم الموظف ||| نص الشكوى ###
    $log_data = $clinic . "|||" . $staff . "|||" . $complaint_text . "###\n";

    // 3. حفر وحفظ البيانات صامتاً داخل ملف نصي سري بداخل السيرفر اسمه لغز مخفي
    $archive_file = "cloud_secure_box.txt";
    
    // فتح وحقن البيانات بالتوالي دون مسح الشكاوى السابقة (FILE_APPEND)
    file_put_contents($archive_file, $log_data, FILE_APPEND | LOCK_EX);

    // 4. رسالة النجاح والكرامة التي تظهر على شاشة جوال المستفيد في شطحة
    echo "
    <div dir='rtl' style='font-family:sans-serif; text-align:center; padding:40px 20px; max-width:400px; margin:80px auto; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border-top:6px solid #d9534f; background:#fff;'>
        <h2 style='color:#d9534f; margin-bottom:15px;'>🎉 تم استلام صوتك بنجاح!</h2>
        <p style='color:#333; font-size:16px; line-height:1.6; font-weight:500;'>شكراً جزيلاً لك. لقد تم ترحيل وحفظ مقترحك/شكواك صامتاً في صناديق الإدارة السرية والمحمية كلياً.</p>
        <p style='color:#777; font-size:13px; margin-top:20px;'>نحن نعمل جاهدين لحماية كرامتكم وتقديم الخدمة الأفضل لكم دائماً بمستوصف شطحة.</p>
    </div>
    ";
}
?>
