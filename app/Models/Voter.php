<?php namespace App\Models;

/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 15/10/2014
 * Time: 8:19 PM
 */
use Illuminate\Database\Eloquent\Model;
//use App\Contact;
class Voter extends Model  {

    //public static $unguarded = true;
    protected $guarded = array('sync');
    protected $primaryKey = 'registrationId';

    public function toArray()
    {
        $array = parent::toArray();
        $array['details'] = $this->details;
       // $array['contacts'] = $this->contacts;
        return $array;
    }

    public function getContactsAttribute()
    {
        return '<a href="/voters/'.$this->registrationId.'/contacts" class="btn btn-info btn-small">Contacts</a>';
    }


    public function getDetailsAttribute()
    {
        return '<a href="/voters/'.$this->registrationId.'" class="btn btn-info btn-small">Detail</a>';
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact','registrationId','registrationId');
    }
} 