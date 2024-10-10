<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Enterprise extends Model
{
    use HasFactory;
    protected $table = 'enterprises';
    protected $fillable = [
        'name',        
    ];


    public function rules(){
        return[
            'name'=> 'required|min:3',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo é obrigatório',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
