<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileSekolah extends Model
{
    use SoftDeletes;

    protected $table = 'profil_sekolah';

    protected $primaryKey = 'id_profile_sekolah';

    protected $fillable = [
        'judul_profile_sekolah',
        'konten_profile_sekolah',
        'upload_photo_profile_sekolah',
    ];

    protected $dates = [
        'deleted_at',
    ];
}