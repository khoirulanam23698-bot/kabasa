<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'profile_photo_path', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{

public function bookings()
{
    return $this->hasMany(Booking::class);
}
public function profilePhotoUrl(): string
{
    // Pakai foto yang diunggah, tapi hanya kalau file-nya benar-benar ada
    if ($this->profile_photo_path
        && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->profile_photo_path)) {
        return asset('storage/' . $this->profile_photo_path);
    }

    // Kalau tidak ada: lingkaran ungu dengan huruf inisial nama
    $initial = strtoupper(mb_substr($this->name ?: '?', 0, 1));
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96"><rect width="96" height="96" fill="#7c3aed"/><text x="50%" y="50%" dy=".35em" text-anchor="middle" font-family="Arial" font-size="44" font-weight="700" fill="#fff">' . e($initial) . '</text></svg>';

    return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
}


public function isAdmin(): bool
{
    return $this->role === 'admin';
}

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function isPetugas(): bool
{
    return $this->role === 'petugas';
}

public function isOwner(): bool
{
    return $this->role === 'owner';
}

public function vehicles()
{
    return $this->hasMany(Vehicle::class);
}

}
