<!DOCTYPE html>
<html>
<head>
    <title>بيانات الطالب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>بيانات الطالب</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">معلومات الطالب</h5>
                <p><strong>الكود:</strong> {{ $student->student_code }}</p>
                <p><strong>الاسم:</strong> {{ $student->name }}</p>
                <p><strong>المرحلة:</strong> {{ $student->stage }}</p>
                <p><strong>الفصل:</strong> {{ $student->class }}</p>
                <p><strong>رقم الهاتف:</strong> {{ $student->phone }}</p>
                <p><strong>كود الـ QR:</strong> {{ $student->qr_code }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">QR Code</h5>
                <img src="{{ asset('storage/qr_codes/' . $student->id . '.svg') }}" alt="QR Code" class="img-fluid" width="200" height="200">
                <p class="mt-2">يمكن للمدرس مسح هذا الكود لتسجيل الحضور</p>
            </div>
        </div>

        <a href="{{ route('students.create') }}" class="btn btn-secondary mt-3">إضافة طالب جديد</a>
    </div>
</body>
</html>
