<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'region',
        'specialization',
        'image',
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
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'buyer_id');
    }

    public function rated(Product $product)
    {
        return $this->ratings->where('product_id', $product->id)->isNotEmpty();
    }

    public function productRatings(Product $product)
    {
        return $this->rated($product) ? $this->ratings->where('product_id', $product->id)->first() : NULL;
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'consultant_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    // public function rated(Product $product)
    // {
    //     return $this->ratings->where('product_id', $product->id)->isNotEmpty();
    // }

    public function consultation()
    {
        return $this->hasOne(Consultation::class, 'consultant_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // get all sent messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'sender_id')->latestOfMany();
    }
    public function lastChatMessage($withUserId)
    {
        return Message::where(function ($query) use ($withUserId) {
            $query->where('sender_id', $this->id)
                ->where('receiver_id', $withUserId);
        })
            ->orWhere(function ($query) use ($withUserId) {
                $query->where('sender_id', $withUserId)
                    ->where('receiver_id', $this->id);
            })
            ->latest()
            ->first();
    }
}
