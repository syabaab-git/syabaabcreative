<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #1e293b;
            margin: 0;
        }
        .info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
            color: #475569;
            font-size: 14px;
        }
        .info strong {
            color: #0f172a;
        }
        .message-box {
            padding: 15px;
            border-left: 4px solid #3b82f6;
            background-color: #eff6ff;
            color: #1e3a8a;
            border-radius: 4px;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Masukan & Saran Baru</h2>
        </div>
        
        <div class="info">
            <p><strong>Nama Pengirim:</strong> {{ $user->name }}</p>
            <p><strong>Email Pengirim:</strong> {{ $user->email }}</p>
            <p><strong>Subjek:</strong> {{ $feedbackSubject }}</p>
            <p><strong>Waktu:</strong> {{ now()->format('d M Y, H:i') }}</p>
        </div>
        
        <div class="message-box">
            {{ $feedbackMessage }}
        </div>
        
        <div class="footer">
            <p>Email ini dikirim otomatis dari sistem aplikasi.</p>
        </div>
    </div>
</body>
</html>
