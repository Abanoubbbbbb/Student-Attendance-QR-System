<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // صفحة مسح الـ QR يدوي بالكاميرا
    public function scanPage()
    {
        return view('attendance.scan');
    }

    // معالجة مسح الكود يدويًا (POST من الكاميرا)
    public function processScan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required'
        ]);

        $qrCode = $request->input('qr_code');
        $student = Student::where('qr_code', $qrCode)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'الطالب غير مسجل في النظام'
            ]);
        }

        $today = now()->format('Y-m-d');

        $existingAttendance = Attendance::where('student_id', $student->id)
            ->where('attendance_date', $today)
            ->first();

        if ($existingAttendance) {
            if ($existingAttendance->status === 'absent') {
                $existingAttendance->update([
                    'arrival_time' => now(),
                    'status' => 'present',
                    'scan_method' => 'qr',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'تم تحديث حالة الطالب إلى حاضر',
                    'student' => $student,
                    'attendance' => $existingAttendance
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'تم تسجيل حضور هذا الطالب اليوم بالفعل',
                'student' => $student,
                'attendance_time' => $existingAttendance->arrival_time
            ]);
        }

        $attendance = Attendance::create([
            'student_id' => $student->id,
            'attendance_date' => $today,
            'arrival_time' => now(),
            'status' => 'present',
            'scan_method' => 'qr'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الحضور بنجاح',
            'student' => $student,
            'attendance' => $attendance
        ]);
    }

    // مسح تلقائي من خلال رابط QR Code
    public function autoScan(Request $request)
    {
        $qrCode = $request->get('qr_code');

        if (!$qrCode) {
            return redirect()->route('attendance.scanPage')->with('error', 'لم يتم العثور على رمز QR.');
        }

        $student = Student::where('qr_code', $qrCode)->first();

        if (!$student) {
            return redirect()->route('attendance.scanPage')->with('error', 'الطالب غير مسجل في النظام.');
        }

        $today = now()->format('Y-m-d');

        $existingAttendance = Attendance::where('student_id', $student->id)
            ->where('attendance_date', $today)
            ->first();

        if ($existingAttendance) {
            if ($existingAttendance->status === 'absent') {
                $existingAttendance->update([
                    'arrival_time' => now(),
                    'status' => 'present',
                    'scan_method' => 'qr'
                ]);
            }

            return redirect()->route('attendance.confirmation', ['studentId' => $student->id])
                ->with('message', 'تم تسجيل حضور هذا الطالب اليوم بالفعل.');
        }

        Attendance::create([
            'student_id' => $student->id,
            'attendance_date' => $today,
            'arrival_time' => now(),
            'status' => 'present',
            'scan_method' => 'qr'
        ]);

        return redirect()->route('attendance.confirmation', ['studentId' => $student->id])
            ->with('message', 'تم تسجيل الحضور بنجاح.');
    }

    // صفحة تأكيد الحضور
    public function confirmation($studentId)
    {
        $student = Student::findOrFail($studentId);
        $today = now()->format('Y-m-d');

        $attendance = Attendance::where('student_id', $studentId)
            ->where('attendance_date', $today)
            ->first();

        return view('attendance.confirmation', compact('student', 'attendance'));
    }

    // صفحة عرض الحضور اليومي مع تسجيل الغياب التلقائي
    public function index()
    {
        $today = now()->format('Y-m-d');
        $students = Student::all();

        foreach ($students as $student) {
            $existingAttendance = Attendance::where('student_id', $student->id)
                ->where('attendance_date', $today)
                ->first();

            if (!$existingAttendance) {
                Attendance::create([
                    'student_id' => $student->id,
                    'attendance_date' => $today,
                    'arrival_time' => null,
                    'status' => 'absent',
                    'scan_method' => 'system',
                ]);
            }
        }

        $attendances = Attendance::with('student')
            ->where('attendance_date', $today)
            ->get();

        return view('attendance.index', compact('attendances'));
    }



    public function studentAttendanceDetails(Request $request, $studentId)
{
    $student = Student::findOrFail($studentId);

    // الحصول على تاريخ البداية والنهاية من الطلب (مع تحديد افتراضي إذا لم يُرسل)
    $from = $request->input('from') ?? now()->startOfMonth()->toDateString();
    $to = $request->input('to') ?? now()->endOfMonth()->toDateString();

    // جلب جميع السجلات خلال الفترة المطلوبة
    $attendances = Attendance::where('student_id', $studentId)
        ->whereBetween('attendance_date', [$from, $to])
        ->orderBy('attendance_date', 'desc')
        ->get();

    // تصفية الغياب فقط
    $absentDays = $attendances->where('status', 'absent');

    return view(' attendance.student-details', [
        'student' => $student,
        'attendances' => $attendances,
        'absentDays' => $absentDays,
        'from' => $from,
        'to' => $to,
    ]);
}

}
