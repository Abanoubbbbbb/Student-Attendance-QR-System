<!DOCTYPE html>
<html>
<head>
    <title>مسح الحضور</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/minified/html5-qrcode.min.js"></script>

    <style>
        .scanner-container {
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }
        #reader {
            width: 100%;
            margin: 20px 0;
        }
        #result {
            margin-top: 20px;
            font-size: 18px;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="scanner-container">
            <h1>مسح كود الحضور</h1>
            <p>يرجى توجيه الكاميرا نحو QR الخاص بالطالب</p>

            <div id="reader"></div>
            <div id="result"></div>

            <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">عرض الطلاب</a>
        </div>
    </div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            fetch('{{ route("attendance.processScan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qr_code: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');

                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="success">
                            <h4>✅ تم تسجيل الحضور بنجاح</h4>
                            <p><strong>الطالب:</strong> ${data.student.name}</p>
                            <p><strong>الوقت:</strong> ${data.attendance.arrival_time}</p>
                            <a href="/attendance/confirmation/${data.student.id}" class="btn btn-success mt-2">
                                عرض تأكيد الحضور
                            </a>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="error">
                            <h4>❌ ${data.message}</h4>
                            ${data.student ? `<p><strong>الطالب:</strong> ${data.student.name}</p>` : ''}
                            ${data.attendance_time ? `<p><strong>تم التسجيل سابقاً في:</strong> ${data.attendance_time}</p>` : ''}
                        </div>
                    `;
                }

                html5QrcodeScanner.clear(); // إيقاف الكاميرا بعد أول مسح
            });
        }

        function onScanFailure(error) {
            // ممكن تتجاهل الأخطاء هنا
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: { width: 250, height: 250 } },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</body>
</html>
