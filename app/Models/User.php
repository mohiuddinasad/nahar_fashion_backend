<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Frontend\Wishlist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'position',
        'username',
        'user_image',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime', // ✅ moved here
        ];
    }

    // ✅ Check if user can see the admin panel
    public function canAccessBackend(): bool
    {
        return $this->hasAnyRole(['super_admin', 'admin', 'manager']);
    }

    // ✅ Check if user has wholesale access
    public function hasWholesaleAccess(): bool
    {
        return $this->hasRole('wholesale_buyer')
            || $this->hasPermissionTo('wholesale.access');
    }

    // ✅ Give a customer wholesale access
    public function grantWholesaleAccess(): void
    {
        $this->givePermissionTo('wholesale.access');
    }

    // ✅ Remove wholesale access from a customer
    public function revokeWholesaleAccess(): void
    {
        $this->revokePermissionTo('wholesale.access');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
