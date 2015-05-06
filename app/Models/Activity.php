<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 22/10/2014
 * Time: 3:06 PM
 */
class Activity extends Model  {

    protected $fillable = [
        'action_type',
        'action_detail',
        'user_id'
    ];


    public function contact()
    {
        return $this->belongsTo('Contact');
    }

    public  static  function Add($contact,$type){
        Activity::create(array(
            'user_id'=>$contact->user_id,
            'action_type'=>$type,
            'action_detail'=>$contact->created_by.' has '.$type.' contact for '.$contact->voter->firstName,
        ));
    }
}