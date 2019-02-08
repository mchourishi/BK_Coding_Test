#!/usr/bin/env php
<?php
/*
 * @Author: mukta.patel 
 * @Date: 2019-02-07  22:13:21 
 * @Description : A CLI script that asks for name,email and address and validates them. Execute from command line as php UserInfo.php""
 */

class UserInfo{
//This is the main function that runs when the file is executed.
public function run(){
    echo "Enter your First Name : ";
    //Get firstname from command line input
    $firstName = trim(fgets(STDIN));
    echo "Enter your Last Name : ";
    //Get lastname from command line input
    $lastName = trim(fgets(STDIN));
    
    $repeatEmailPrompt = false;
    $repeatAddressPrompt = false;    
    
    //Prompt to ask email address until a valid email address is entered.
    while(!$repeatEmailPrompt){
    echo "Enter your Email Address : ";
    $email = trim(fgets(STDIN));
    //Validate email address.
    $validEmail = $this->validateEmailAddress($email);
    if(!$validEmail){
        $repeatEmailPrompt = false;
        echo "Invalid email address, Please try again.\n";
    }else{
        //Email looks good.
        $repeatEmailPrompt = true;
    }
    }
    
    //Prompt to ask  address until a valid geocoding address is entered.
    while(!$repeatAddressPrompt){
        echo "Enter your address : ";
        $address = trim(fgets(STDIN));
        //Validate geocoding address with Google Maps API.
        $validAddress = $this->validateAddress($address);
        if(!$validAddress){
            $repeatAddressPrompt = false;
            echo "Invalid Address, Please try again.\n";
        }else{
            //Address looks good.
            $repeatAddressPrompt = true;           
        }
        } 

        //Everything looks good, greet the person!
        if($repeatEmailPrompt && $repeatAddressPrompt){
            fwrite(STDOUT, 'Welcome '.$firstName.' '.$lastName);    
        }
}    

public function validateEmailAddress($email)
{
    $validEmail = true;    
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    if (!preg_match($regex, $email)) {
     $validEmail = false;
    }           
    return $validEmail;
}

public function validateAddress($address){    
    $validAddress = true;
     // url encode the address
     $address = urlencode($address);
     //google api key
    $key = "AIzaSyBKxc3UEDJUCdxxaK1h0IaLkZvY0kNIwj4";     
     // google map geocode api url
     $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$key}";  
     echo "Please Wait...Validating your address.......\n";
     // get the json response
     $response_json = file_get_contents($url);      
     // decode the json
     $response = json_decode($response_json, true);
     // response status will be ok if able to geocode an address, which would mean a valid address
     if($response['status']!='OK'){
         $validAddress = false;
     }
     return $validAddress;
}
}


$userInfo = new UserInfo();
$userInfo->run();

