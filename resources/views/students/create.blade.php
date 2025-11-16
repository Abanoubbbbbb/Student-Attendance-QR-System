@extends('layouts.app') {{-- استخدام القالب العام --}}

@section('title', 'إضافة طالب جديد') {{-- عنوان الصفحة في التاب --}}

@section('content') {{-- محتوى الصفحة --}}
    <h1 class="mb-4">إضافة طالب جديد</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">الكود الجامعي</label>
            <input type="text" name="student_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">اسم الطالب</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">المرحلة</label>
            <input type="text" name="stage" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الفصل</label>
            <input type="text" name="class" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">إضافة الطالب</button>
    </form>
@endsection
