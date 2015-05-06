<?php namespace App\Http\Middleware;
use Closure;
class AccessMiddleware {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $response)
    {
        $access_token = $request->header('access_token',$request->get('access_token'));
        if (!$access_token)
            return Response()->json(array('status' => 'error','error_code' => '','message' =>('authentication.error.token'),'data' => ''));

        if(!($access_token=='7a17e8c57ceae62bad7aaea61766d6e532630d15'))
            return  $response =  Response()->json(array('status' => 'error','error_code' => '','message' => ('authentication.error.invalid-token'),'data' => ''));


  }







}