@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تفاصيل الحضور والغياب للطالب: {{ $student->name }}</h2>

    <form method="GET" action="{{ route('attendance.student-details', $student->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label>من تاريخ:</label>
                <input type="date" name="from" class="form-control" value="{{ $from }}">
            </div>
            <div class="col-md-4">
                <label>إلى تاريخ:</label>
                <input type="date" name="to" class="form-control" value="{{ $to }}">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">عرض</button>
            </div>
        </div>
    </form>

    <h4>عدد أيام الغياب: {{ $absentDays->count() }}</h4>

    @if($absentDays->count())
        <ul>
            @foreach($absentDays as $absence)
                <li>{{ $absence->attendance_date }}</li>
            @endforeach
        </ul>
    @else
        <p>لا يوجد غياب في الفترة المحددة.</p>
    @endif

    <hr>

    <h4>جميع السجلات:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>وقت الوصول</th>
                <th>طريقة المسح</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->attendance_date }}</td>
                <td>
                    @if($attendance->status === 'present')
                        <span class="text-success">حاضر</span>
                    @else
                        <span class="text-danger">غائب</span>
                    @endif
                </td>
                <td>{{ $attendance->arrival_time ?? '-' }}</td>
                <td>{{ $attendance->scan_method }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
