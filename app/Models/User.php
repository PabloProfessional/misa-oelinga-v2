<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function administrator(): bool
    {
        if (Administrator::where('email',$this->email)->first()) {
            return true;
        }
        return false;
    }

    public function user_activity(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserActivity::class)->orderBy('created_at','asc')->take(4);
    }

    public function activity(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserActivity::class);
    }


    public function getActivityCountByMonth(): array
    {
        $logins = $this->activity()
            ->select('created_at')
            ->where('activity_type_id', 1)
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('F'); // Grouping by full month name
            })
            ->map(function($row) {
                return count($row); // Counting the number of activities in each month
            });

        $months = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];

        foreach ($logins as $month => $count) {
            $months[$month] = $count;
        }

        return $months;
    }

    public function latestActivity(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserActivity::class)->latestOfMany();
    }
}
