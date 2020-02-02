<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CrawlerHoroscope extends Model
{
//    protected $connection = 'mysql';
    protected $table = 'CrawlerHoroscopes';
    public $timestamps = false;
    protected $fillable = [
        'date',
        'name',
        'overall_score',
        'overall_description',
        'love_score',
        'love_description',
        'work_score',
        'work_description',
        'finance_score',
        'finance_description',
        'create_time'
    ];

    public function create($array)
    {
        return DB::table($this->table)->insert($array);
    }
}
