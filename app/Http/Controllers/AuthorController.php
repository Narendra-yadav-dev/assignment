<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
// use Client;
class AuthorController extends Controller
{
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
    public function authors(Request $request)
    {
      //   if(is_null(Session::get('token')))
      //   {
      //       return redirect('/');
      //   }
      //   $token = Session::get('token');
      // $response = Http::withHeaders([
      //      `Authorization: Bearer {$token}`
      //   ])->get('https://symfony-skeleton.q-tests.com/api/v2/authors');
      //   dd($response);
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/authors';
        $response = $this->commonFun($url, 'GET');
        $data = json_decode($response)->items;

        return view('authors',compact('data'));
    }
    public function authorDelete($id)
    {
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/authors/'.$id;
        $responses = $this->commonFun($url, 'GET');
        $data = json_decode($responses);
        if(!empty($data->books)){
            return redirect('authors')->with('error','Cannot delete');
        }
        $response = $this->commonFun($url, 'DELETE');
        if($response){
         return redirect('authors')->with('error','successfully!');
        }
        return redirect('authors')->with('success','successfully!');
    }
    public function authorView($id)
    {
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/authors/'.$id;
        $response = $this->commonFun($url, 'GET');
        $data = json_decode($response);
        // $data = $data[0];
        //dd($data);
        return view('authorsView',compact('data'));
    }
     public function authorAdd()
    {
        return view('author_add');
    }
    public function authorAddNew(Request $request)
    {
        if($request->all()){
            $formData = $request->all();
            $url = 'https://symfony-skeleton.q-tests.com/api/v2/authors';
             
            $response = $this->commonFun($url, 'POST', $formData);
            dd($response);
            return redirect('authors')->with('success','successfully!');
        } 
    }
}
