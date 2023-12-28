<?php

// This encryption function for system validation, user validation, password validation, etc 
// Read the full document of chiper method: https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
// Read the full document of openssl encrypt/decyrpt: https://www.php.net/manual/en/function.openssl-encrypt.php

class PrivEncryption{
    //Secret Initialization Vector (change this)
    private String $privSecretIV = "iv-key-secret";
    
    //Secret key (change this)
    private String $privSecretKey = "priv-key";

    //Encryption method (chiper method)
    private String $privEncryptionMethod = "AES-256-CFB";

    protected function privEncryption($string){
        //Sanitize the string
        $sanitizedString = $this->sanitize($string);
        
        //Return encryption method
        $encryptionMethod = $this->privEncryptionMethod;

        //Return secret Initialization Vector
        $secretIV = $this->privSecretIV;
        
        ////Return secret key
        $secretKey = $this->privSecretKey;

        //Hash the secret key
        $hashKey = hash('sha256', $secretKey);

        //Initialization Vector - Return part of a secret iv - Encrypt method AES-256-CFB must be 16 bytes
        $iv = substr(hash('sha256', $secretIV), 0, 16);

        //Encrypt with Openssl
        $encryptSSL = openssl_encrypt($sanitizedString, $encryptionMethod, $hashKey, 0, $iv);
        
        //Decode the encrypted string with Base64
        $finalEncrypt = base64_encode($encryptSSL);
        
        //Return the result of encrypted string
        echo $finalEncrypt;
    }

    protected function privDecryption($string, $secretKey){
        //Get master secret key and hash with sha256
        $secretKeyMaster = hash('sha256', $this->privSecretKey);

        //Sanitize the string
        $sanitizedString = $this->sanitize($string);

        //Sanitize secret key from user input
        $sanitizedSecretKey = $this->sanitize($secretKey);

        //Get secret Initialization Vector
        $secretIV = $this->privSecretIV;
        
        //Get encryption method
        $encryptionMethod = $this->privEncryptionMethod;

        //Decode base64 string
        $decodedString = base64_decode($sanitizedString);

        //Hash the secret key from user
        $hashKey = hash('sha256', $sanitizedSecretKey);

        //Initialization Vector - Return part of a secret iv - Encrypt method AES-256-CFB must be 16 bytes
        $iv = substr(hash('sha256', $secretIV), 0, 16);

        //Decrypt with Openssl
        $finalDecrypt = openssl_decrypt($decodedString, $encryptionMethod, $hashKey, 0, $iv);
        
        //Return the decrypted string
        if ($hashKey == $secretKeyMaster) {
            echo $finalDecrypt;
        } else {
            echo "Invalid Secret Key!";
        }
    }

    private function sanitize($value){
        //Prevent special characters
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

class Encryption extends PrivEncryption{
    //Return the encryption function from class PrivEncryption
    public function encryption($string){
        return $this->privEncryption($string);
    }

    //Return the decryption function form class PrivEncryption
    public function decryption($string, $secretKey){
        return $this->privDecryption($string, $secretKey);
    }
}