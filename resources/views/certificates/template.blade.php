<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $certificate->certificate_number }}</title>
    <style>
        @page { margin: 0px; }
        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            color: #333333;
        }
        .container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            border: 20px solid #4f46e5;
            box-sizing: border-box;
            background-image: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
        }
        .content {
            padding: 60px;
            text-align: center;
        }
        .header {
            margin-bottom: 40px;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 20px;
            color: #4338ca;
            margin: 0;
        }
        .presented-to {
            font-size: 18px;
            color: #64748b;
            margin-bottom: 15px;
            margin-top: 40px;
        }
        .name {
            font-size: 56px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            border-bottom: 2px solid #cbd5e1;
            display: inline-block;
            padding-bottom: 10px;
        }
        .reason {
            font-size: 18px;
            color: #475569;
            margin-top: 30px;
            line-height: 1.6;
        }
        .course-name {
            font-size: 28px;
            font-weight: bold;
            color: #312e81;
            margin: 15px 0;
        }
        .footer {
            position: absolute;
            bottom: 60px;
            width: calc(100% - 120px);
            left: 60px;
        }
        .signature-box {
            float: right;
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 10px;
            height: 50px;
        }
        .signature-name {
            font-weight: bold;
            margin: 0;
            font-size: 16px;
        }
        .signature-title {
            color: #64748b;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .cert-info {
            float: left;
            text-align: left;
        }
        .info-label {
            color: #64748b;
            font-size: 12px;
            margin: 0;
        }
        .info-value {
            font-weight: bold;
            font-size: 14px;
            margin: 2px 0 10px 0;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            position: absolute;
            top: 40px;
            left: 40px;
        }
        .verify-text {
            font-size: 10px;
            color: #94a3b8;
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Syabaab Academy</div>
        
        <div class="content">
            <div class="header">
                <h1 class="title">Sertifikat Kelulusan</h1>
                <p class="subtitle">Award of Completion</p>
            </div>
            
            <p class="presented-to">Sertifikat ini diberikan kepada:</p>
            
            <h2 class="name">{{ $certificate->user->name }}</h2>
            
            <p class="reason">Telah berhasil menyelesaikan semua modul pembelajaran<br>dan lulus ujian akhir pada kursus:</p>
            
            <h3 class="course-name">{{ $certificate->course->title }}</h3>
            
            <div class="footer">
                <div class="cert-info">
                    <p class="info-label">Nomor Sertifikat</p>
                    <p class="info-value">{{ $certificate->certificate_number }}</p>
                    
                    <p class="info-label">Tanggal Diberikan</p>
                    <p class="info-value">{{ \Carbon\Carbon::parse($certificate->issued_at)->format('d F Y') }}</p>
                </div>
                
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <p class="signature-name">Instruktur Kursus</p>
                    <p class="signature-title">Syabaab Creative Academy</p>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        
        <div class="verify-text">
            Verifikasi sertifikat ini di: {{ route('certificates.verify', $certificate->certificate_number) }}
        </div>
    </div>
</body>
</html>
