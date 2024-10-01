<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Calendrier;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'start_date', 
        'end_date', 
        'description', 
        'calendrier_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calendrier()
    {
        return $this->belongsTo(Calendrier::class);
    }
}
