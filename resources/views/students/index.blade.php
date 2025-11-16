@extends('layouts.app')

@section('title', 'كارنيهات الطلاب')

@section('content')

<style>
    .id-card {
        width: 350px;
        border: 2px solid #007bff;
        border-radius: 15px;
        padding: 20px;
        margin: 15px;
        display: inline-block;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background: white;
    }
    .id-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }
    .qr-code {
        text-align: center;
        margin: 20px 0;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    .student-info {
        margin-bottom: 8px;
        padding: 5px 0;
        border-bottom: 1px solid #eee;
    }
    .student-info:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: bold;
        color: #333;
    }
    .info-value {
        color: #666;
    }
    .container {
        text-align: center;
    }
</style>

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">نظام الحضور - كارنيهات الطلاب</span>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        @foreach($students as $student)
        <div class="col-auto mb-4">
            <div class="id-card">
                <div class="id-header">
                    <h4 class="mb-0">كارنية الطالب</h4>
                    <small>مدرسة النجاح</small>
                </div>

                <div class="student-info">
                    <span class="info-label">الكود:</span>
                    <span class="info-value">{{ $student->student_code }}</span>
                </div>
                <div class="student-info">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $student->name }}</span>
                </div>
                <div class="student-info">
                    <span class="info-label">المرحلة:</span>
                    <span class="info-value">{{ $student->stage }}</span>
                </div>
                <div class="student-info">
                    <span class="info-label">الفصل:</span>
                    <span class="info-value">{{ $student->class }}</span>
                </div>
                <div class="student-info">
                    <span class="info-label">التليفون:</span>
                    <span class="info-value">{{ $student->phone ?? 'غير مسجل' }}</span>
                </div>

                <div class="qr-code">
                    <img src="{{ asset('storage/qr_codes/' . $student->id . '.svg') }}"
                         alt="QR Code"
                         width="200"
                         height="200"
                         style="border: 1px solid #ddd; border-radius: 5px;">
                    <p class="text-muted mt-2 mb-0" style="font-size: 12px;">
                        مسح الكود لتسجيل الحضور
                    </p>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('students.show', $student->id) }}"
                       class="btn btn-sm btn-outline-primary me-2">عرض التفاصيل</a>
                    <a href="{{ route('attendance.scanPage') }}"
                       class="btn btn-sm btn-success">مسح الحضور</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($students->count() == 0)
    <div class="alert alert-info text-center">
        <h4>لا يوجد طلاب مسجلين</h4>
        <p>ابدأ بإضافة الطلاب الجدد</p>
        <a href="{{ route('students.create') }}" class="btn btn-primary">إضافة طالب جديد</a>
    </div>
    @endif

    <div class="text-center mt-4 mb-5">
        <a href="{{ route('students.create') }}" class="btn btn-success btn-lg me-3">
            ➕ إضافة طالب جديد
        </a>
        <a href="{{ route('attendance.scanPage') }}" class="btn btn-primary btn-lg">
            📱 مسح الحضور
        </a>
    </div>
</div>

@endsection
