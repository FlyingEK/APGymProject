<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
    protected $fillable = [
        'comment',
        'created_by',
        'issue_id'
    ];
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id', 'issue_id');
    }
}
