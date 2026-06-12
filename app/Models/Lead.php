<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'status',
        'source',
        'notes',
        'followed_up_at',
    ];

    protected $hidden = ['user_id'];

    public const NEW = 'new';
    public const CONTACTED = 'contacted';
    public const CONVERTED = 'converted';
    public const LOST = 'lost';

    public function creator(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function scopeCreator($query){
        return $query->where('user_id',auth()->user()->id);
    }
}
