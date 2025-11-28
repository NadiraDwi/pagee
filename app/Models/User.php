<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel
    protected $table = 'users';

    // Primary key tabel
    protected $primaryKey = 'id_user';

    // Auto increment primary key
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    public function getAuthIdentifierName(){
    return 'id_user';
    }


    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'nama',
        'username',   // ← TAMBAHKAN INI
        'email',
        'password',
        'foto',
        'bio',
        'role',
    ];


    // Kolom yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: user punya banyak post
    public function posts() {
        return $this->hasMany(Post::class, 'id_user', 'id_user');
    }

    // Cast password otomatis hash
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function collaborationsAsUser1()
    {
        return $this->hasMany(PostCollab::class, 'id_user1', 'id_user');
    }

    public function collaborationsAsUser2()
    {
        return $this->hasMany(PostCollab::class, 'id_user2', 'id_user');
    }

    // Semua kolaborasi user
    public function allCollaborations()
    {
        return $this->collaborationsAsUser1->merge($this->collaborationsAsUser2);
    }

}
