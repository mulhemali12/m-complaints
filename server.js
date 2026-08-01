const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname));

const archiveFile = path.join(__dirname, 'cloud_secure_box.txt');

// 🔴 1. رادار استقبال الشكاوى المحدثة بالأسماء من الجوال
app.post('/submit_complaint', (req, res) => {
    const clinic = req.body.clinic || '';
    const staff = req.body.staff_name || 'القسم ككل';
    const complaintText = req.body.complaint_text || '';

    if (!clinic || !complaintText) {
        return res.status(400).send("🚨 خطأ: يرجى ملء كافة الحقول المطلوبة بسلام!");
    }

    // صياغة السطر التراكمي المفرز بفواصل صارمة لسهولة التفكيك بالـ VBA: عيادة ||| موظف ||| نص ###
    const logData = `${clinic}|||${staff}|||${complaintText}###\n`;

    fs.appendFileSync(archiveFile, logData, 'utf8');

    // رسالة النجاح والكرامة التي تظهر على شاشة جوال المستفيد في شطحة
    res.send(`
        <div dir='rtl' style='font-family:sans-serif; text-align:center; padding:40px 20px; max-width:400px; margin:80px auto; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border-top:6px solid #d9534f; background:#fff;'>
            <h2 style='color:#d9534f; margin-bottom:15px;'>🎉 تم استلام صوتك بنجاح!</h2>
            <p style='color:#333; font-size:16px; line-height:1.6; font-weight:500;'>شكراً جزيلاً لك. لقد تم حفظ مقترحك/شكواك.</p>
        </div>
    `);
});

// 🔴 2. رادار بوابة تصدير وتطهير الشكاوى السحابية لكمبيوتر المدير لأكسس
app.get('/export_complaints', (req, res) => {
    if (!fs.existsSync(archiveFile) || fs.statSync(archiveFile).size === 0) {
        return res.send("NO_DATA");
    }

    const content = fs.readFileSync(archiveFile, 'utf8');
    res.send(content);

    // التطهير الفوري الحاسم: تصفير ومسح ملف السيرفر صامتاً فوراً لحماية أسرار أهلنا
    fs.writeFileSync(archiveFile, '', 'utf8');
});

app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
