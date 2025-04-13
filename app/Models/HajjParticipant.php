<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class HajjParticipant extends Model
{
    use HasFactory, HasUuids;
    
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        // Participant Picture
        'picture',

        // Participant Code
        'hajj_database_id',
        'file_no',
        'registration_no',
        'no',
        'group_code',
        'status',
        'registration_date',
        'registration_time',
        'package',
        'package_code',
        'room_type',

        // Participant Details
        'name',
        'title',
        'ic_no',
        'passport_no',
        'age',
        'gender',
        'race',
        'religion',
        'phone',
        'email',
        'marriage_status',
        'status',
        'job',
        'job_sector',

        // Participant Address
        'address_1',
        'address_2',
        'address_3',
        'postcode',
        'district',
        'state',

        // Waris (Next of Kin)
        'waris',

        // Passport & Hajj Details
        'hajj_registration_no',
        'th_account_no',
        'month_hajj_registration',
        'year_hajj_registration',

        // Survey & Wakil (Representative)
        'representative',
        'media_survey',

        //Clothing Size
        'shirt_size',
        'kurta_size',
        'kopiah_size',

        // Remarks
        'remarks_1',
        'remarks_2',
        'remarks_3',

        //Family Members
        'family_member',

        //Bayaran
        'package_price',
        'discount',
        'price_after_discount',
        'wang_naik_haji',
        'upgrade_khemah_khas',
        'upgrade',
        'total',
        'payment_made',
        'total_payment',
        'payment_left',
        'payment_remarks',
    ];

    protected $casts = [
        'waris'=> 'json',
        'family_member' => 'json',
        'payment_made'=> 'json',
    ];
    
    /*protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            // Get the last participant number for the current hajj_database_id
            $lastParticipant = self::where('hajj_database_id', $model->hajj_database_id)
                ->orderBy('no', 'desc')
                ->first();
    
            // Set the new participant number
            $model->no = $lastParticipant ? $lastParticipant->no + 1 : 1;
        });
    }*/

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            // Get the associated HajjDatabase
            $hajjDatabase = HajjDatabase::find($model->hajj_database_id);
    
            if ($hajjDatabase) {
                // Get the last participant number for the current hajj_database_id
                $lastParticipant = self::where('hajj_database_id', $model->hajj_database_id)
                    ->orderBy('no', 'desc')
                    ->first();
    
                // Set the new participant number
                $model->no = $lastParticipant ? $lastParticipant->no + 1 : 1;
    
                // Generate the registration_no based on the code and the new participant number
                $model->registration_no = $hajjDatabase->code . '_' . str_pad($model->no, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function hajjDatabase(): BelongsTo
    {
        return $this->belongsTo(HajjDatabase::class);
    }
}
