<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
// use Client;
class UserController extends Controller
{
    //

    public function login(Request $request)
    {
        $response = Http::post('https://symfony-skeleton.q-tests.com/api/v2/token', [
          "email"=> $request->email,
          "password"=> $request->password,
            ]);
        $jsonData = $response->json();
        // dd($jsonData);
        if(@$jsonData['status'] == 401)
        {
            dd('invalid');
        }
        Session::put('token',$jsonData['token_key']);
        Session::put('userdata',$jsonData);
        Session::get('token');


        return redirect('index');
    }
    public function index()
    {
        // dd(Session::get('token'));
        if(is_null(Session::get('token')))
        {
            return redirect('/');
        }
        return view('index');
    }
    public function commonFun($url='', $method='', $data=[])
    {
        if(is_null(Session::get('token')))
        {
            return redirect('/');
        }
        $token = Session::get('token');
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $method,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token.''
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl); 
        return $response;
    }
    public function logout()
    {
        // Session::put('token','');
        Session::forget('token');
        return redirect('/');
    }
}
