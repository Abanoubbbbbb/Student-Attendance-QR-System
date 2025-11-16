<?php

namespace App\Http\Controllers;
use App\Models\Student;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class StudentsController extends Controller
{
    public function index()

    {        $students = Student::all();
        return view('students.index', compact('students'));
    }


    public function create()
    {
        return view('students.create');
    }



   public function store(Request $request)
{
    $request->validate([
        'student_code' => 'required|unique:students',
        'name' => 'required',
        'stage' => 'required',
        'class' => 'required',
    ]);

    // استخدم create بالمصفوفة فقط
    $student = Student::create([
        'student_code' => $request->student_code,
        'name' => $request->name,
        'stage' => $request->stage,
        'phone' => $request->phone,
        'class' => $request->class,
        // ملاحظة: مش محتاج نمرر qr_code، هيتولد تلقائي
    ]);

    return redirect()->route('students.show', $student->id)
        ->with('success', 'تم إضافة الطالب بنجاح وتوليد QR code له');
}


        public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

public function showQrCode($id)
{
    $student = Student::findOrFail($id);

    // الرابط يحتوي على QR code parameter
    $url = route('attendance.autoScan', ['qr_code' => $student->qr_code]);

    $qrCode = QrCode::size(300)->generate($url);

    return view('students.qrcode', compact('student', 'qrCode'));
}
public function cards(Request $request)
{
    $query = Student::query();

    if ($request->filled('stage')) {
        $query->where('stage', $request->input('stage'));
    }

    if ($request->filled('class')) {
        $query->where('class', $request->input('class'));
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->input('name') . '%');
    }

    // اجلب فقط البيانات المطلوبة
    $students = $query->orderBy('name')->paginate(12); // 12 فقط لكل صفحة

    return view('students.cards', compact('students'));
}

public function cardsPdf(Request $request)
{
    $query = Student::query();

    if ($request->filled('stage')) {
        $query->where('stage', $request->stage);
    }

    if ($request->filled('class')) {
        $query->where('class', $request->class);
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    $students = $query->orderBy('name')->get(); // بدون paginate لأننا هنعمل PDF كامل

    $pdf = Pdf::loadView('students.cards_pdf', compact('students'));

    return $pdf->download('بطاقات_الطلاب.pdf');
}
}
