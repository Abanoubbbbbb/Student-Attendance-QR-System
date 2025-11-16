<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تأكيد الحضور</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .confirmation-card {
            max-width: 500px;
            margin: 60px auto;
            border: 3px solid #28a745;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .student-info p {
            margin: 5px 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-card">
            <div class="success-icon">✅</div>
            <h2 class="text-success">تم تسجيل الحضور بنجاح</h2>

            <div class="student-info mt-4">
                <p><strong>اسم الطالب:</strong> {{ $student->name }}</p>
                <p><strong>الكود:</strong> {{ $student->student_code }}</p>
                <p><strong>الفصل:</strong> {{ $student->class }}</p>
                <p><strong>تاريخ اليوم:</strong> {{ $attendance->attendance_date }}</p>
                <p><strong>وقت الحضور:</strong> {{ $attendance->arrival_time }}</p>
            </div>

            <div class="mt-4 d-grid gap-2">
                <a href="{{ route('attendance.scanPage') }}" class="btn btn-primary">📷 مسح طالب آخر</a>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">👥 عرض كل الطلاب</a>
            </div>
        </div>
    </div>
</body>
</html>
