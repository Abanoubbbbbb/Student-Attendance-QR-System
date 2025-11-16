<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

// ========================
// طـــلاب
// ========================
Route::get('/students', [StudentsController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentsController::class, 'create'])->name('students.create');
Route::post('/students', [StudentsController::class, 'store'])->name('students.store');

// ⚠️ ترتيب مهم جداً: خلي الثابت قبل المتغير
Route::get('/students/cards', [StudentsController::class, 'cards'])->name('students.cards');
Route::get('/students/cards/pdf', [StudentsController::class, 'cardsPdf'])->name('students.cards.pdf');
Route::get('/students/{id}/qrcode', [StudentsController::class, 'showQrCode'])->name('students.qrcode');
Route::get('/students/{id}', [StudentsController::class, 'show'])->name('students.show');
Route::get('/students/cards', [StudentsController::class, 'cards'])->name('students.cards');

// ========================
// حـضــور
// ========================
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index'); // صفحة الحضور اليومية

Route::get('/attendance/scan', [AttendanceController::class, 'scanPage'])->name('attendance.scanPage');
Route::post('/attendance/scan', [AttendanceController::class, 'processScan'])->name('attendance.processScan');
Route::get('/attendance/auto-scan', [AttendanceController::class, 'autoScan'])->name('attendance.autoScan');
Route::get('/attendance/confirmation/{studentId}', [AttendanceController::class, 'confirmation'])->name('attendance.confirmation');
Route::get('/attendance/student/{studentId}/details', [AttendanceController::class, 'studentAttendanceDetails'])->name('attendance.student-details');

?>
