<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GigOrder extends Model
{
    protected $table = 'gig_orders';
    protected $fillable = [
        'full_name',
        'email',
        'message',
        'additional_note',
        'selected_payment_gateway',
        'file',
        'gig_id',
        'selected_plan_index',
        'selected_plan_revisions',
        'selected_plan_delivery_days',
        'selected_plan_price',
        'selected_plan_title',
        'payment_track',
        'payment_status',
        'order_status',
        'transaction_id',
        'seen',
        'user_id',
    ];
}
