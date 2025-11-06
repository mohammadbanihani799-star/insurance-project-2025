<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار تدفق التأمين</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            border-right: 4px solid #667eea;
        }
        .info-box h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #666;
            font-weight: 500;
        }
        .info-value {
            color: #333;
            font-weight: 600;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            box-shadow: 0 10px 20px rgba(108, 117, 125, 0.4);
        }
        .success {
            color: #28a745;
            background: #d4edda;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 اختبار تدفق التأمين</h1>
        <p class="subtitle">صفحة اختبار للتحقق من عملية حفظ البيانات</p>

        @if(session('success'))
            <div class="success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('danger') || session('warning'))
            <div class="error">
                ❌ {{ session('danger') ?? session('warning') }}
            </div>
        @endif

        <div class="info-box">
            <h3>📋 معلومات الجلسة الحالية</h3>
            @if(session('insuranceRequest'))
                <div class="info-item">
                    <span class="info-label">معرف الطلب:</span>
                    <span class="info-value">{{ session('insuranceRequest')['id'] ?? 'غير متوفر' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الهوية:</span>
                    <span class="info-value">{{ session('insuranceRequest')['identity_number'] ?? 'غير متوفر' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الجوال:</span>
                    <span class="info-value">{{ session('insuranceRequest')['mobile_number'] ?? 'غير متوفر' }}</span>
                </div>
            @else
                <p style="color: #dc3545;">⚠️ لا توجد بيانات في الجلسة - يرجى البدء من الصفحة الرئيسية</p>
            @endif
        </div>

        <form action="{{ route('test-create-session') }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            <button type="submit" class="btn">
                🔄 إنشاء جلسة جديدة للاختبار
            </button>
        </form>

        @if(session('insuranceRequest'))
            <a href="{{ route('insuranceStatements') }}" class="btn">
                ➡️ الانتقال إلى صفحة البيانات التفصيلية
            </a>
        @endif

        <a href="{{ route('welcome') }}" class="btn btn-secondary">
            🏠 العودة إلى الصفحة الرئيسية
        </a>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p style="margin-top: 10px; color: #666;">جاري المعالجة...</p>
        </div>
    </div>

    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                document.getElementById('loading').style.display = 'block';
            });
        });
    </script>
</body>
</html>
