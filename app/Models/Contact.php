<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 18/10/2014
 * Time: 2:38 AM
 */

class Contact extends Model {

    protected $fillable = ['registrationId','contact_date','contact_type','contact_person','created_by','user_id'];

    public static $rules = [
        'contact_date' => 'required',
        'contact_type' => 'required',
        'contact_person' => 'required',
        'created_by' => 'required',
    ];

    public function voter()
    {
        return $this->belongsTo('App\Models\Voter','registrationId','registrationId');
    }

    public static function boot()
    {
        parent::boot();

        // Setup event bindings...
        Contact::created(function($contact){
            Activity::Add($contact,'Created');
        });

        Contact::updated(function($contact){
                Activity::Add($contact,'Updated');
        });

        Contact::deleted(function($contact){
            Activity::Add($contact,'Deleted');
        });


    }
}