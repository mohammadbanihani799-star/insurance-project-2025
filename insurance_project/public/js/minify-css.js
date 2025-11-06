const fs = require('fs');
const path = require('path');

// قراءة الملف
const inputFile = path.join(__dirname, 'public/style_files/frontend/css/bc.bundle.css');
const outputFile = path.join(__dirname, 'public/style_files/frontend/css/bc.bundle.min.css');

let css = fs.readFileSync(inputFile, 'utf8');

// تصغير بسيط: إزالة التعليقات والمسافات الزائدة
css = css
    .replace(/\/\*[\s\S]*?\*\//g, '') // إزالة التعليقات
    .replace(/\s+/g, ' ') // استبدال المسافات المتعددة بمسافة واحدة
    .replace(/\s*([{}:;,])\s*/g, '$1') // إزالة المسافات حول الرموز
    .replace(/;}/g, '}') // إزالة الفاصلة المنقوطة قبل }
    .trim();

// حفظ الملف المصغر
fs.writeFileSync(outputFile, css, 'utf8');

console.log(`✅ تم التصغير بنجاح!`);
console.log(`📦 الحجم الأصلي: ${(fs.statSync(inputFile).size / 1024).toFixed(2)} KB`);
console.log(`📦 الحجم المصغر: ${(fs.statSync(outputFile).size / 1024).toFixed(2)} KB`);
console.log(`💾 التوفير: ${(((fs.statSync(inputFile).size - fs.statSync(outputFile).size) / fs.statSync(inputFile).size) * 100).toFixed(1)}%`);
