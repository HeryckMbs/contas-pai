<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'url_report',
        'url_report_excel',
        'mes',
        'ano',
    ];
}
