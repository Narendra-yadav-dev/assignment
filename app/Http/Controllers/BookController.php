<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
// use Client;
class BookController extends Controller
{
    public function commonFun($url='', $method='', $data=[])
    {
       // dd(json_encode($data));
        if(is_null(Session::get('token')))
        {
            return redirect('/');
        }
        $token = Session::get('token');
        $curl = curl_init();
        if(!empty($data))
        {
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => $method,
              CURLOPT_POSTFIELDS =>json_encode($data),
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }
        else
        {
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
                'Authorization: Bearer '.$token
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }
        // dd($response);    
        return $response;
    }
    public function books(Request $request)
    {
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/books';
        $response = $this->commonFun($url, 'GET');
        $data = json_decode($response)->items;
        // dd($data);

        return view('books',compact('data'));
    }
    public function bookDelete($id)
    {
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/books/'.$id;
        $response = $this->commonFun($url, 'DELETE');
        // $data = json_decode($responses);
        if($response){
         return redirect('books')->with('error','successfully!');
        }
        return redirect('books')->with('success','successfully!');
    }
    public function bookAdd()
    {
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/authors';
        $response = $this->commonFun($url, 'GET');
        $data = json_decode($response)->items;
        $data  = $data;
        return view('book_add',compact('data'));
    }
    public function bookAddNew(Request $request)
    {
        if($request->all()){
            $formData = $request->all();
            $url = 'https://symfony-skeleton.q-tests.com/api/v2/books';
            $formData['author']=array('id'=>$formData['id']);
            $formData['number_of_pages']= (int)$formData['number_of_pages'];
            $formData['release_date']= "2023-03-15T21:13:39.429Z";
            unset($formData['id']);
            unset($formData['_token']); 
             
            $response = $this->commonFun($url, 'POST', $formData);
            //dd($response);
            return redirect('books')->with('success','successfully!');
        } 
    }
    public function bookView(Request $request ,$id)
    {
        $url = 'https://symfony-skeleton.q-tests.com/api/v2/books/'.$id;
        $response = $this->commonFun($url, 'GET');
        $data = json_decode($response);
        //dd($data);
        return view('bookView',compact('data'));
    }
}
