<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSavedCard extends Model
{
    protected $table = 'user_saved_cards';
    protected $fillable = ['user_id', 'card_token', 'masked_card', 'card_type', 'expiry_date', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
