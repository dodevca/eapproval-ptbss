<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

namespace App\Models;

use CodeIgniter\Model;
use App\Models\User_models;

class Mail_sender extends Model
{
    public function sendToApprover($to, $as, $subject, $data) {
        $userModel  = new \App\Models\User_models();
        $email      = \Config\Services::email();
        
        $from   = 'approval@devisigeneralservicebss.com';
        $name   = 'E-Approval | Banggai Sentral Sulawesi';
        
        $data['sender'] = 'approver';
        
        foreach($to as $emailTo){
            $data['approver']['email']      = urlencode(base64_encode($emailTo));
            $data['approver']['hierarchy']  = urlencode(base64_encode($as));

            $email->setFrom($from, $name);
            $email->setTo($emailTo);
            $email->setSubject($subject);
            $email->setMessage(view('mail', $data));
            
            if($data['file']['attachment'] != null || empty($data['file']['attachment'])) {
                $attachments = explode(', ', $data['file']['attachment']);
                foreach($attachments as $attachment) {
                    $email->attach($item);
                }
            }
            
            $email->send();
        }
    }
    public function sendToApplicant($to, $as, $subject, $data) {
        $userModel  = new \App\Models\User_models();
        $email      = \Config\Services::email();
        
        $from       = 'approval@devisigeneralservicebss.com';
        $name       = 'E-Approval | Banggai Sentral Sulawesi';
        
        $data['sender']                 = 'applicant';
        $data['approver']['email']      = urlencode(base64_encode($to));
        $data['approver']['hierarchy']  = urlencode(base64_encode($as));
        
        $email->setFrom($from, $name);
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage(view('mail', $data));
        
        $email->send();
    }
}