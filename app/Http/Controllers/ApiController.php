<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\Contact;
use App\Models\Activity;
use App\Models\User;

class ApiController extends BaseController
{



    public function index(Request $request)
    {
        $limit = $request->get('record',30);

        if($limit==-1)
            $limit= Voter::count();

        $voters = Voter::paginate($limit);;

        if($voters->count()=='0')
            return Response()->json(array('status' => 'error','error_code' => 401,'message' => ('api.voters.empty'),'data' => ''));

        return Response()->json(array('status' => 'success','error_code' => '','message' => ('api.voters.success'),
            'data' => $voters->toArray()));

    }


    public function contacts($registrationId){
        if($registrationId==-1)
            $contacts = Contact::all();
        else
            $contacts = Contact::whereRegistrationid($registrationId)->get();

        if($contacts->count()=='0'){

            return Response()->json(array('status' => 'error','error_code' => 401,'message' => ('api.contacts.empty'),'data' => ''));

        }
        return Response()->json(array('status' => 'success','error_code' => '','message' => ('api.contacts.success'),'data' => $contacts));
    }

    public function syncVoters(Request $request)
    {
        try
        {
            $data = $request->getContent();

            $data = json_decode($data);
            $sync_stats = array('voters'=>0);
            if(array_key_exists('voters', $data)) {
                //key exists, do stuff
                $data_voters = $data->voters;

                foreach($data_voters as $data_voter)
                {
                    //Update Voter
                    $voter = Voter::find($data_voter->registrationId);
                    if($voter)
                        $voter->update((array) $data_voter);
                }
                $sync_stats['voters']= count($data_voters);
            }


            return Response()->json(array('status' => 'success','error_code' => '','message' => ('api.sync.success'),'data' => $sync_stats));
        } catch (Exception $ex) {

            return Response()->json(array('status' => 'error','error_code' => $ex->getCode(),'message' => $ex->getMessage(),'data' => ''));
        }

    }

    public function syncContacts(Request $request)
    {
        try
        {
            $data = $request->getContent();
return 'lsalnam;lmdsm;ldsm';
            $data = json_decode($data);
            $sync_stats = array('contacts'=>0);

            if(array_key_exists('contacts', $data)) {
                //key exists, do stuff
                $data_contacts = $data->contacts;

                foreach($data_contacts as $data_contact)
                {

                    switch ($data_contact->sync) {
                        case 1: //insert
                            Contact::create((array)$data_contact);
                            break;
                        case 2: //update
                            $contact = Contact::find($data_contact->id);
                            if($contact)
                                $contact->update((array)$data_contact);
                            break;
                        case 3: //delete
                            $contact = Contact::find($data_contact->id);
                            if($contact)
                                $contact->delete();
                            break;

                    }


                }
                $sync_stats['contacts']= count($data_contacts);
            }


            return Response()->json(array('status' => 'success','error_code' => '','message' => Lang::get('api.sync.success'),'data' => $sync_stats));
        } catch (Exception $ex) {

            return Response()->json(array('status' => 'error','error_code' => $ex->getCode(),'message' => $ex->getMessage(),'data' => ''));
        }

    }

    public function activities(Request $request)
    {
        $limit = $request->get('record',10);

        $activities = Activity::orderBy('id','desc')->limit($limit);

        if($activities->count()=='0')
            return Response()->json(array('status' => 'error','error_code' => 401,'message' => ('api.activities.empty'),'data' => ''));

        return Response()->json(array('status' => 'success','error_code' => '','message' => ('api.activities.success'),
            'data' => $activities->get()));

    }

    public function users(){

        $users = User::all();

        if($users->count()=='0')
            return Response()->json(array('status' => 'error','error_code' => 401,'message' => ('api.users.empty'),'data' => ''));

        return Response()->json(array('status' => 'success','error_code' => '','message' => ('api.users.success'),
            'data' => $users));
    }


} 