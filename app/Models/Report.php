<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_no',
        'user_id',
        'report_type_id',
        'description',
        'location',
        'll',
        'lg',
        'file_path',
    ];
    protected $appends = ['file_url']; // This makes it show in toArray/toJson

    protected static function booted()
    {
        static::creating(function ($report) {
            $report->report_no = 'REP-' . strtoupper(Str::random(8));
        });
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path
            ? Storage::disk('public')->url($this->file_path)
            : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function type()
    {
        return $this->belongsTo(ReportType::class, 'report_type_id');
    }
}
