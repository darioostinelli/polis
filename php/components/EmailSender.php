<?php
namespace php\components;

class EmailSender
{

    private  $address;
    public function __construct($address)
    {
        ini_set("SMTP", "aspmx.l.google.com");
        ini_set("sendmail_from", "daostinelli@gmail.com");
        $this->address = $address;
        
    }
    public function sendFamilyTagEmail($object, $accessKey){
        
        $header = "From: polis@gmail.com"."\r\n";
        $header .= "Content-type:text/html;charset=UTF-8";
        $message = "Benvenuto su Polis! Il tuo codice famiglia e': ".$accessKey;
        $url = 'http://polis.inno-school.org/polis/src/templates/FamilyTagEmailTemplate.php?key='.$accessKey;             
        $message = file_get_contents($url);        
        mail($this->address, $object, $message, $header);
    }
}

