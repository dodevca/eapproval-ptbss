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
    
        return url_title(convert_accented_characters($string), true);
    }
    public function titlefy($string)
    {
        $string = strtolower($string);
        $string = ucwords($string);
        
        return trim($string);
    }
}