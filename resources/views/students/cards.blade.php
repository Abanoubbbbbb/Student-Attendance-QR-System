<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            direction: rtl;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            width: 48%;
            height: 230px;
            border: 1px solid #007bff;
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .card-content {
            width: 60%;
        }

        .qr-code {
            width: 35%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-code svg {
            width: 100px;
            height: 100px;
        }

        h4 {
            margin: 0 0 5px;
            color: #007bff;
        }

        p {
            margin: 4px 0;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="cards-container">
        @foreach($students as $student)
            <div class="card">
                <div class="card-content">
                    <h4>مدرسة النجاح</h4>
                    <p><strong>الاسم:</strong> {{ $student->name }}</p>
                    <p><strong>الكود:</strong> {{ $student->student_code }}</p>
                    <p><strong>المرحلة:</strong> {{ $student->stage }}</p>
                    <p><strong>الصف:</strong> {{ $student->class }}</p>
                    <p><strong>الهاتف:</strong> {{ $student->phone ?? 'غير مسجل' }}</p>
                </div>
                <div class="qr-code">
                    {!! QrCode::format('svg')->size(100)->generate(route('attendance.autoScan', ['qr_code' => $student->qr_code])) !!}
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
