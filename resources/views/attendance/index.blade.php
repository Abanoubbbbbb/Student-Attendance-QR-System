@extends('layouts.app')

@section('title', 'قائمة الحضور اليومية')

@section('content')
    <h2 class="mb-4 text-center">📋 قائمة الحضور ليوم {{ date('Y-m-d') }}</h2>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>اسم الطالب</th>
                <th>الكود</th>
                <th>الفصل</th>
                <th>المرحله</th>
                <th>الحالة</th>
                <th>وقت الحضور</th>
                <th>تفاصيل</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ $attendance->student->student_code }}</td>
                    <td>{{ $attendance->student->class }}</td>
                    <td>{{ $attendance->student->stage }}</td>
                    <td>
                        @if ($attendance->status === 'present')
                            <span class="badge bg-success">حاضر</span>
                        @else
                            <span class="badge bg-danger">غائب</span>
                        @endif
                    </td>
                    <td>
                        {{ $attendance->arrival_time
                            ? \Carbon\Carbon::parse($attendance->attendance_date . ' ' . $attendance->arrival_time)
                                ->locale('ar')
                                ->translatedFormat('Y-m-d H:i')
                            : '—'
                        }}
                    </td>
                    <td>
                <a href="{{ route('attendance.student-details', $attendance->student->id) }}" class="btn btn-sm btn-info">
                    عرض التفاصيل
                </a>
            </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{ route('attendance.scanPage') }}" class="btn btn-primary">العودة لصفحة المسح</a>
    </div>
@endsection
