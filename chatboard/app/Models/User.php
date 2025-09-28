<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- 1. เพิ่มบรรทัดนี้

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // ... โค้ดอื่นๆ ที่มีอยู่แล้ว ...

    /**
     * Get all of the posts for the User.
     * 2. เพิ่มฟังก์ชันนี้เข้าไปทั้งหมด
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}