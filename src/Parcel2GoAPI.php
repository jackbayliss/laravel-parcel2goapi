<?php
namespace jackbayliss\Parcel2GoApi;
use jackbayliss\Parcel2GoApi\Exceptions\ApiException;

class Parcel2GoAPI
{
    protected $accesstoken;
    protected $tocountry; 
    protected $quotes; 
    protected $parcels; 

    public function __construct(){
        // Gets the token upon creating.
       $this->GetToken();
    }
    // Gets us a bearer token from the parcel2goapi, using the authentication in config.
    public function GetToken()
    {
        $url = "https://www.parcel2go.com/auth/connect/token";
        $data = array('client_id'=>  config('parcel2goapi.client_id'),
        'client_secret'=> config('parcel2goapi.client_secret'),
        'grant_type'=>'client_credentials',
        'scope'=>'public-api payment');

        $data = http_build_query($data);
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        
        
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $server_output = curl_exec ($ch);
        
        curl_close ($ch);
        
        // Get our access token.
     
        if(isset(json_decode($server_output)->access_token)){
            $accesstoken = json_decode($server_output)->access_token;
            $this->accesstoken = $accesstoken;
            return $this;
            }else{
                throw new ApiException("Error with client_secret or client_id ,please set them in config.");
    
            }

      
    }

    // Gets a quote from the API using the token supplied.
    public function GetQuote()
    {
        // Get the quote for the user
        $url = "https://www.parcel2go.com/api/quotes";
    
    
        $data = array('CollectionAddress'=> array('Country' => config('parcel2goapi.from_address'),), 'DeliveryAddress' => array("Country" => $this->tocountry), 'Parcels' => 
        [
            $this->parcels
        ] 
    );
        
        $data = json_encode($data);
        // dd($data2);
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: Bearer '. $this->accesstoken ;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        
        
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $server_output = curl_exec ($ch);
        
        curl_close ($ch);

       if(isset(json_decode($server_output)->Quotes)){
        $this->quotes = json_decode($server_output)->Quotes;
        return $this;

       }else{
           throw new ApiException("ERROR WITH PARCELS, OR COUNTRY CODE.");
       }
    }
    
    // Sets the country we are sending to.
    public function SetToCountry($tocountry){
        $this->tocountry = $tocountry;
        return $this;
    }
    public function SetParcels($parcels){
        $this->parcels =  $parcels;
        return $this;
    }
}


?>