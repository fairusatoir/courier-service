<?php

namespace App\Http\Services;

use App\Helpers\LogFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MakeRequest
{

    public function __constuct()
    {
        //
    }

    /**
     * Init default header for request
     *
     * @return void
     */
    private static function initDefautlHeader($header)
    {
        return array_merge($header, [
            'Content-Type: application/json'
        ]);
    }

    /**
     * Create Http get request curl
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function _get($header, $url, Request $request, $idRequest)
    {
        // return $url;

        $method = 'GET';

        /** Request Factory */
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $url); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::initDefautlHeader($header)); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        // private $body = [ 
        //     'matter' => 'Documents', 
        //     'points' => [ 
        //         [ 
        //             'address' => 'JL. Jawa, Blok J1 No. 31, Komplek Nusaloka, Tangerang, Rw. Mekar Jaya, Serpong, Kota Tangerang Selatan, Banten 15310', 
        //         ], 
        //         [ 
        //             'address' => 'Jl. Raya Ragunan No.39, RT.1/RW.2, Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12540', 
        //         ], 
        //     ], 
        // ]; 

        /** Handshake Session */
        self::logFormat($idRequest,'START', $method." ".$url, $header);

        /** Result Validation */
        $result = curl_exec($curl); 
        if ($result === false) { 
            self::logFormat($idRequest,'ERROR', $method." ".$url);
            throw new Exception(curl_error($curl), curl_errno($curl)); 
        } 

        curl_close($curl);

        $response = json_decode($result);
        self::logFormat($idRequest,'END', $method." ".$url, [], $response);
        return $response; 
        
    }

    /**
     * Create Http get request curl
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function _post($header, $url, Request $request, $idRequest)
    {
        $method = 'POST';

        /** Request Factory */
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $url); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::initDefautlHeader($header)); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        // private $body = [ 
        //     'matter' => 'Documents', 
        //     'points' => [ 
        //         [ 
        //             'address' => 'JL. Jawa, Blok J1 No. 31, Komplek Nusaloka, Tangerang, Rw. Mekar Jaya, Serpong, Kota Tangerang Selatan, Banten 15310', 
        //         ], 
        //         [ 
        //             'address' => 'Jl. Raya Ragunan No.39, RT.1/RW.2, Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12540', 
        //         ], 
        //     ], 
        // ]; 

        $body = $request->all();
 
        $json = json_encode($body['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 

        /** Handshake Session */
        self::logFormat($idRequest,'START', $method." ".$url, $header, $body['data']);

        /** Result Validation */
        $result = curl_exec($curl); 
        if ($result === false) { 
            self::logFormat($idRequest,'ERROR', $method." ".$url);
            throw new Exception(curl_error($curl), curl_errno($curl)); 
        } 

        curl_close($curl);

        $response = json_decode($result);
        self::logFormat($idRequest,'END', $method." ".$url, [], $response);
        return $response; 
        
    }

    public static function logFormat($idRequest = null, $status = "", $url = null, $header = null, $data = null)
    {
        Log::info([
            'idRequest'=> $idRequest,
            'message'=> "[".$status."][".$url."]",
            'header'=> json_encode($header),
            'body'=> json_encode($data)
        ]);
    }

}