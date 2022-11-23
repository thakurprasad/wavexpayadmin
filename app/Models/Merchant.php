<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'merchants';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_name', 'access_salt',  'contact_name', 'contact_phone', 'status', 'is_partner', 'reward_value', 'merchant_payment_method', 'created_at', 'updated_at', 'wavexpay_api_key_id'
    ];

    public function MerchantApiKeys()
    {
        return $this->hasOne(MerchantKey::class);
    }

    public function MerchantUsers()
    {
        return $this->hasOne(MerchantUser::class);
    }

    public function MerchantAddresses()
    {
        return $this->hasMany(MerchantAddress::class);
    }

    public function Payments()
    {
        return $this->hasMany(Payment::class)->with(['payment_details']);
    }

    public function PaymentLinks()
    {
        return $this->hasMany(PaymentLink::class);
    }

    public function Invoices()
    {
        return $this->hasMany(Invoice::class)->with(['invoice_items']);
    }


    public function Items(){
        return $this->hasMany(Item::class);   
    }

}
