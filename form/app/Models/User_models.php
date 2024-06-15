<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

namespace App\Models;

use CodeIgniter\Model;

class User_models extends Model
{
    public function slugify($string)
    {
        helper('text');
        helper('url');
    
        $string = str_replace(' ', '-', $string);
        $string = str_replace("'", '-', $string);
        $string = str_replace('.', '-', $string);
        $string = str_replace("/", '-', $string);
    
        return $string;
    }
    public function titlefy($string)
    {
        $string = strtolower($string);
        $string = ucwords($string);
        
        return trim($string);
    }
    
    public function randomCode($length) {
        $chary = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $return_str = "";
        
        for ($i = 0; $i < $length; $i++)
        {
            $return_str .= $chary[rand(0, count($chary)-1)];
        }
        return $return_str;
    }
    
    function validEmail($email)
    {
        // $allowedDomains = array('ptbss.com', 'gmail.com');
        $allowedDomains = array('ptbss.com');
        list($user, $domain) = explode('@', $email);
        
        if (checkdnsrr($domain, 'MX') && in_array($domain, $allowedDomains))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}