<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'student_code',
        'name',
        'stage',
        'phone',
        'class',
        'qr_code',
    ];

    protected static function boot()
    {
        parent::boot();

        // توليد كود فريد عند الإنشاء إذا مش موجود
        static::creating(function ($student) {
            if (empty($student->qr_code)) {
                $student->qr_code = 'STU_' . $student->student_code . '_' . time();
            }
        });

        // بعد حفظ الطالب، توليد وحفظ ملف SVG للـ QR
        static::created(function ($student) {
            $qrContent = url('/attendance/auto-scan?qr_code=' . $student->qr_code);

            $svg = QrCode::format('svg')->size(300)->generate($qrContent);

            // تخزين ملف SVG في storage/app/public/qr_codes/{id}.svg
            Storage::disk('public')->put("qr_codes/{$student->id}.svg", $svg);
        });
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
