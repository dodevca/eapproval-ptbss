<?php
namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Models\User_models;
use App\Models\Mail_sender;

class Home extends BaseController
{
    protected $helpers = ['form'];
    
    public function index()
    {
        $session = session();
        
        if(!$session->has('authenticated'))
        {
            return view('login');
        }
        else
        {
            return view('home');
        }
    }
    
    public function authEmail()
    {
        $userModels = new \App\Models\User_models();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        $data   = [];
        $email  = $request->getPost('email') == null ? $session->get('email') : $request->getPost('email');
        
        if($userModels->validEmail($email))
        {
            $data['email'] = $email;
            
            $query = $db->query("SELECT email FROM applicants WHERE email = '$email'LIMIT 1");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                $data['message'] = 'Dupiclate';
                
                return view('verif', $data);
            }
            else
            {
                $data['message']    = 'Success';
                $code               = $userModels->randomCode(11);
                $data['code']       = $code;
                $data['expired']    = date('d/m/Y H:i', strtotime('+3 days'));
                
                $db->table('applicants')->insert([
                    'email' => $data['email'],
                    'code'  => $data['code'],
                ]);
                
                $userModel  = new \App\Models\User_models();
                $email      = \Config\Services::email();
                
                $from       = 'approval@devisigeneralservicebss.com';
                $name       = 'Autentikasi Email | Banggai Sentral Sulawesi';
                
                $email->setFrom($from, $name);
                $email->setTo($data['email']);
                $email->setSubject('Jangan Bagikan Kode Ini!');
                $email->setMessage(view('mail_auth', $data));
                
                $email->send();
                
                $sessionData = [
                    'email' => $email,
                ];
                $session->set($sessionData);
                
                return view('verif', $data); 
            }
        }
        else
        {
            session()->setFlashdata('error', 'Format email salah! Pastikan email menggunakan domain ptbss.com');
            
            return redirect()->back()->withInput();
        }
        
        // return $this->response->setJSON($data);
    }
    
    public function reauthEmail()
    {
        $userModels = new \App\Models\User_models();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        
        $data   = [];
        $email  = $request->getGet('email');
        
        if($userModels->validEmail($email))
        {
            $data['email'] = $email;
            
            $query = $db->query("SELECT email, code FROM applicants WHERE email = '$email'LIMIT 1");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                $userModel = new \App\Models\User_models();
                
                $row                = $query->getRow();
                $code               = $row->code;
                $data['code']       = $code;
                $data['expired']    = date('d/m/Y H:i', strtotime('+3 days'));
                
                $email = \Config\Services::email();
                
                $from  = 'approval@devisigeneralservicebss.com';
                $name  = 'Autentikasi Email | Banggai Sentral Sulawesi';
                
                $email->setFrom($from, $name);
                $email->setTo($data['email']);
                $email->setSubject('Jangan Bagikan Kode Ini!');
                $email->setMessage(view('mail_auth', $data));
                
                $email->send();
                
                return $this->response->setJSON($data);
            }
            else
            {
                $data['message']    = 'Not found';
                session()->setFlashdata('error', 'Email tidak ada!');
                
                return $this->response->setJSON($data);
            }
        }
        else
        {
            $data['message']    = 'Wrong email';
            session()->setFlashdata('error', 'Format email salah!');
            
            return $this->response->setJSON($data);
        }
    }
    
    public function authCode()
    {
        $userModels = new \App\Models\User_models();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        $email  = $request->getPost('email');
        $code   = $request->getPost('code');
        
        $data['email'] = $email;
        
        $query = $db->query("SELECT email, code FROM applicants WHERE email = '$email'LIMIT 1");
        if (count($query->getResult()) != 0 || !empty($query->getRow()))
        {
            $row        = $query->getRow();
            $rowCode    = $row->code;
            
            if($rowCode == $code)
            {
                $sessionData = [
                    'email'         => $email,
                    'authenticated' => $email,
                ];
                $session->set($sessionData);
                
                return redirect()->to('/');
            }
            else
            {
                session()->setFlashdata('error', 'Kode autentikasi salah!');
                
                return view('verif', $data); 
            }
        }
        else
        {
            session()->setFlashdata('error', 'Email tidak ditemukan!');
            
            return view('verif', $data); 
        }
    }
    
    public function changeEmail()
    {
        $session = session();
        
        if(!$session->has('authenticated'))
        {
            return view('login');
        }
        else
        {
            $session    = session();
           
            $session->remove(['authenticated']);
           
            return redirect()->to('/');
        }
    }
    
    public function payment()
    {
        $session = session();
        
        if(!$session->has('authenticated'))
        {
            return view('login');
        }
        else
        {
            $db                     = \Config\Database::connect();
            $session                = session();
            $data['authenticated']  = $session->get('authenticated');
            $data['categories']     = [];
            $data['description']    = [];
                
            $getCategory = $db->query("SELECT category FROM categories");
            if (count($getCategory->getResult()) != 0 || !empty($getCategory->getRow()))
            {
                foreach ($getCategory->getResult('array') as $key => $row)
                {
                    $data['categories'][$key] = $row['category'];
                }
            }
            
            $getDescription = $db->query("SELECT description FROM refcode GROUP BY description");
            if (count($getDescription->getResult()) != 0 || !empty($getDescription->getRow()))
            {
                foreach ($getDescription->getResult('array') as $key => $row)
                {
                    $data['description'][$key] = $row['description'];
                }
            }
            
            sort($data['categories']);
            sort($data['description']);
            
            // return $this->response->setJSON($data);
            return view('form_payment', $data);
        }
    }
    
    public function income()
    {
        $session = session();
        
        if(!$session->has('authenticated'))
        {
            return view('login');
        }
        else
        {
            $db                     = \Config\Database::connect();
            $session                = session();
            $data['authenticated']  = $session->get('authenticated');
            $data['categories']     = [];
            $data['description']    = [];
            
            $getCategory = $db->query("SELECT category FROM categories");
            if (count($getCategory->getResult()) != 0 || !empty($getCategory->getRow()))
            {
                foreach ($getCategory->getResult('array') as $key => $row)
                {
                    $data['categories'][$key] = $row['category'];
                }
            }
            
            $getDescription = $db->query("SELECT description FROM refcode GROUP BY description");
            if (count($getDescription->getResult()) != 0 || !empty($getDescription->getRow()))
            {
                foreach ($getDescription->getResult('array') as $key => $row)
                {
                    $data['description'][$key] = $row['description'];
                }
            }
            
            sort($data['categories']);
            sort($data['description']);
            
            // return $this->response->setJSON($data);
            return view('form_income', $data);
        }
    }
    
    public function view()
    {
        $sendEmail  = new \App\Models\Mail_sender();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $data       = [];
     
        $applicant  = base64_decode(urldecode($request->getGet('applicant')));
        $document   = $request->getGet('doc');
            
        $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$document' AND email = '$applicant'");
        if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
        {
            $data['message'] = 'Document was submited.';
            $doc = $getDoc->getRow();
            
            $data['type']                       = $doc->type;
            $data['email']                      = $doc->email;
            $data['document']['date']           = $doc->date;
            $data['document']['proofNumber']    = $doc->proofNumber;
            $data['document']['projectCode']    = $doc->projectCode;
            $data['document']['contractNumber'] = $doc->contractNumber;
            $data['document']['customerName']   = $doc->customer;
            $data['document']['recipientName']  = $doc->recipient;
            $data['document']['category']       = $doc->category;
            $data['items']                      = json_decode($doc->items, true);
            $data['total']                      = $doc->total;
            $data['file']['submission']         = $doc->submission;
            $data['file']['attachment']         = $doc->attachment;
            $data['approval']['Admin']          = $doc->Admin;
            $data['approval']['Supervisor_I']   = $doc->Supervisor_I;
            $data['approval']['Supervisor_II']  = $doc->Supervisor_II;
            $data['approval']['Manager']        = $doc->Manager;
        }
        else
        {
           throw new \Exception('Not Found');
        }
        
        $db->close();
            
        // return $this->response->setJSON($data);
        return view('form_output', $data);
    }
    
    public function submit()
    {
        $session = session();
        
        if(!$session->has('authenticated'))
        {
            return view('login');
        }
        else
        {
            $userModels = new \App\Models\User_models();
            $sendEmail  = new \App\Models\Mail_sender();
            $db         = \Config\Database::connect();
            $request    = \Config\Services::request();
            $data       = [];
            
            helper('date');
            
            $rules = [
                'type'          => 'required',
                'email'         => 'required|valid_email',
                'date'          => 'required',
                'proofNumber'   => 'required',
                'projectCode'   => 'required',
                'contractNumber'=> 'required',
                'customerName'  => 'required',
                'recipientName' => 'required',
                'category'      => 'required',
            ];
            
            $data['type']                       = trim($request->getPost('type'));
            $data['email']                      = trim($request->getPost('email'));
            $data['document']['date']           = date('d-m-Y', strtotime($request->getPost('date')));
            $data['document']['proofNumber']    = trim($request->getPost('proofNumber'));
            $data['document']['projectCode']    = 'P' . trim($request->getPost('projectCode'));
            $data['document']['contractNumber'] = trim($request->getPost('contractNumber'));
            $data['document']['customerName']   = $userModels->titlefy($request->getPost('customerName'));
            $data['document']['recipientName']  = $userModels->titlefy($request->getPost('recipientName'));
            $data['document']['category']       = ($request->getPost('category') == 'other') ? $userModels->titlefy($request->getPost('otherCategory')) : $userModels->titlefy($request->getPost('category'));
            $data['file']['submission']         = $userModels->slugify($data['document']['proofNumber']);
            $data['file']['attachments']        = null;
            $data['total']                      = (int) preg_replace("/\./", "", $request->getPost('total'));
            
            for ($i = 0; $i <  count($request->getPost('description')); $i++) {
                $data['items'][$i]['description']       = $userModels->titlefy($request->getPost('description')[$i]);
                $data['items'][$i]['unitRef']           = $request->getPost('unitRef')[$i] == null ? '-' : trim($request->getPost('unitRef')[$i]);
                $data['items'][$i]['amount']            = (float) $request->getPost('amount')[$i];
                $data['items'][$i]['unit']              = ucwords(trim($request->getPost('unit')[$i]));
                $data['items'][$i]['unitPrice']         = (int) preg_replace("/\./", "", $request->getPost('unitPrice')[$i]);
                $data['items'][$i]['totalPrice']        = (int) preg_replace("/\./", "", $request->getPost('totalPrice')[$i]);
                $data['items'][$i]['moreDescription']   = $request->getPost('moreDescription')[$i] == '' || $request->getPost('moreDescription')[$i] == null ? '-' : ucwords(trim($request->getPost('moreDescription')[$i]));
                $data['items'][$i]['beginningPeriod']   = date('Y-m-d', strtotime($request->getPost('beginningPeriod')[$i]));
                $data['items'][$i]['endPeriod']         = date('Y-m-d', strtotime($request->getPost('endPeriod')[$i]));
            }
            
            $data['approval']['Admin']          = null;
            $data['approval']['Supervisor_I']   = null;
            $data['approval']['Supervisor_II']  = null;
            $data['approval']['Manager']        = null;
            $data['disapproval']                = null;
    
            $file = $request->getFiles();
            
            if(!$this->validate($rules))
            {
                $db->close();
                session()->setFlashdata('error', $this->validator->listErrors());
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            else
            {
                if($file)
                {
                    $extArr     = ['png','jpeg','jpg','pdf','xls','xlsx','tmp'];
                    $attachment = [];
                    
                    foreach ($file['attachment'] as $key => $img)
                    {
                        if (in_array($img->guessExtension(), $extArr))
                        {
                            $newName = $img->getRandomName();
                            $img->move('../public/attachments/', $newName);
                            
                            $attachment[$key] = $newName;
                        }
                    }
                    $data['file']['attachments'] = implode(', ', $attachment);
                }
                
                $proofNumber = $data['document']['proofNumber'];
                
                $query  = $db->query("SELECT email FROM submissions WHERE proofNumber = '$proofNumber'");
                if (count($query->getResult()) == 0 || empty($query->getRow()))
                {
                    $data['message'] = 'Document was submited.';
                    $db->table('submissions')->insert([
                        'type'          => $data['type'],
                        'date'          => date('Y-m-d', strtotime($data['document']['date'])),
                        'proofNumber'   => $data['document']['proofNumber'],
                        'projectCode'   => $data['document']['projectCode'],
                        'contractNumber'=> $data['document']['contractNumber'],
                        'customer'      => $data['document']['customerName'],
                        'recipient'     => $data['document']['recipientName'],
                        'category'      => $data['document']['category'],
                        'items'         => json_encode($data['items']),
                        'total'         => $data['total'],
                        'attachment'    => $data['file']['attachments'],
                        'submission'    => $data['file']['submission'],
                        'email'         => $data['email'],
                    ]);
                    
                    $reciever = $db->query("SELECT email FROM hierarchies WHERE hierarchy = 'Admin'");
                    foreach ($reciever->getResult('array') as $row) {
                        $to[] = $row['email'];
                    }
                    
                    $sendEmail->sendToApprover($to, 'Admin', 'Menunggu Persetujuan Anda - ' . $data['document']['proofNumber'], $data);
                    $sendEmail->sendToApplicant($data['email'], 'Applicant', 'Pengajuan ' . ucwords($data['type']) . ' - ' . $data['document']['proofNumber'], $data);
                    
                    $db->close();
                    
                    // return $this->response->setJSON($data);
                    return redirect()->to('/view?applicant=' . urlencode(base64_encode($data['email'])) . '&doc=' . $data['file']['submission']); 
                }
                else
                {
                    $db->close();
                    
                    $data['message'] = 'Document is already exist.';
                    return view('form_output', $data);
                    // return $this->response->setJSON($data);
                }
            }
        }
    }
    
    public function approve()
    {
        $userModels = new \App\Models\User_models();
        $sendEmail  = new \App\Models\Mail_sender();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $data       = [];
     
        $approver   = base64_decode(urldecode($request->getGet('approver')));
        $hierarchy  = str_replace(' ', '_', base64_decode(urldecode($request->getGet('as'))));
        $document   = $request->getGet('doc');
        
        $getApp = $db->query("SELECT name, sign FROM hierarchies WHERE email = '$approver' AND hierarchy = '$hierarchy'");
        if (count($getApp->getResult()) != 0 || !empty($getApp->getRow()))
        {
            $app = $getApp->getRow();
            
            switch ($hierarchy) {
                case 'Admin':
                    $nextApprover = 'Supervisor_I';
                    break;
                case 'Supervisor_I':
                    $nextApprover = 'Supervisor_II';
                    break;
                case 'Supervisor_II':
                    $nextApprover = 'Manager';
                    break;
                case 'Manager':
                    $nextApprover = null;
                    break;
                default:
                    $nextApprover = null;
                    break;
            }
            
            $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$document'");
            if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
            {
                $doc = $getDoc->getRow();
                
                $data['type']                       = $doc->type;
                $data['email']                      = $doc->email;
                $data['document']['date']           = $doc->date;
                $data['document']['proofNumber']    = $doc->proofNumber;
                $data['document']['projectCode']    = $doc->projectCode;
                $data['document']['contractNumber'] = $doc->contractNumber;
                $data['document']['customerName']   = $doc->customer;
                $data['document']['recipientName']  = $doc->recipient;
                $data['document']['category']       = $doc->category;
                $data['items']                      = json_decode($doc->items, true);
                $data['total']                      = $doc->total;
                $data['file']['submission']         = $doc->submission;
                $data['file']['attachment']         = $doc->attachment;
                $data['approver']['name']           = $app->name;
                $data['approver']['sign']           = $app->sign;
                $data['approval']['Admin']          = $doc->Admin;
                $data['approval']['Supervisor_I']   = $doc->Supervisor_I;
                $data['approval']['Supervisor_II']  = $doc->Supervisor_II;
                $data['approval']['Manager']        = $doc->Manager;
                $data['approval']['date']           = date("Y-m-d H:i:s");
                $data['disapproval']                = $doc->disapproval;
                $data['nextApprover']               = $nextApprover;
                    
                if($data['approval'][$hierarchy] == null && $data['disapproval'] == null)
                {
                    $data['message']                    = "Approved.";
                    $data['approval'][$hierarchy]       = $app->name;
                    $data['approved']['name']           = $app->name;
                    $data['approved']['hierarchy']      = $hierarchy;
                    
                    $dateapproval = 'approval_' . $hierarchy;
                    
                    $db->query("UPDATE submissions SET $hierarchy = '$app->name', $dateapproval = NOW() WHERE submission = '$document' AND $hierarchy is NULL");
                    
                    if($nextApprover != null)
                    {
                        $sendEmail->sendToApplicant($data['email'], 'Applicant', $data['document']['proofNumber'] . ' - ' . ucwords($data['type']) . ' Anda Disetujui Oleh ' . str_replace('_', ' ', $hierarchy), $data);
                        
                        $reciever = $db->query("SELECT email FROM hierarchies WHERE hierarchy = '$nextApprover'");
                        foreach ($reciever->getResult('array') as $row) {
                            $to[] = $row['email'];
                        }
                        $sendEmail->sendToApprover($to, str_replace('_', ' ', $nextApprover), 'Menunggu Persetujuan Anda - ' . $data['document']['proofNumber'], $data);
                    }
                    else
                    {
                        $sendEmail->sendToApplicant($data['email'], 'Applicant', $data['document']['proofNumber'] . ' - ' . ucwords($data['type']) . ' Anda Telah Sepenuhnya Disetujui', $data);
                    }
                }
                elseif ($data['approval'][$hierarchy] != null && $data['disapproval'] != null)
                {
                    $data['message']                = "Re-Approved.";
                    $data['disapproval']            = null;
                    
                    $db->query("UPDATE submissions SET disapproval = NULL, notes = NULL WHERE submission = '$document' AND $hierarchy is NOT NULL AND disapproval is NOT NULL");
                    
                    $reciever = $db->query("SELECT email FROM hierarchies WHERE hierarchy = '$nextApprover'");
                    foreach ($reciever->getResult('array') as $row) {
                        $to[] = $row['email'];
                    }
            
                    if($nextApprover != null)
                    {
                        $sendEmail->sendToApprover($to, str_replace('_', ' ', $nextApprover), 'Menunggu Persetujuan Anda - ' . $data['document']['proofNumber'], $data);
                    }
                }
                else
                {
                    $data['message'] = "Already approved.";
                }
            }
            else
            {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
        else
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $db->close();
            
        // return $this->response->setJSON([$approver, $hierarchy]);
        return view('approval', $data);
    }
    
    public function disapprove()
    {
        $userModels = new \App\Models\User_models();
        $sendEmail  = new \App\Models\Mail_sender();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $data       = [];
     
        $approver   = base64_decode(urldecode($request->getVar('approver')));
        $hierarchy  = str_replace(' ', '_', base64_decode(urldecode($request->getVar('as'))));
        $document   = $request->getVar('doc');
        $notes      = $request->getVar('notes');
        
        $getApp = $db->query("SELECT name, sign FROM hierarchies WHERE email = '$approver' AND hierarchy = '$hierarchy'");
        if (count($getApp->getResult()) != 0 || !empty($getApp->getRow()))
        {
            $app = $getApp->getRow();
            
            switch ($hierarchy) {
                case 'Admin':
                    $prevApprover = null;
                    $nextApprover = 'Supervisor_I';
                    break;
                case 'Supervisor_I':
                    $prevApprover = 'Admin';
                    $nextApprover = 'Supervisor_II';
                    break;
                case 'Supervisor_II':
                    $prevApprover = 'Supervisor_I';
                    $nextApprover = 'Manager';
                    break;
                case 'Manager':
                    $prevApprover = 'Supervisor_II';
                    $nextApprover = null;
                    break;
                default:
                    $prevApprover = null;
                    $nextApprover = null;
                    break;
            }
            
            $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$document'");
            if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
            {
                $doc = $getDoc->getRow();
                
                $data['type']                       = $doc->type;
                $data['email']                      = $doc->email;
                $data['document']['date']           = $doc->date;
                $data['document']['proofNumber']    = $doc->proofNumber;
                $data['document']['projectCode']    = $doc->projectCode;
                $data['document']['contractNumber'] = $doc->contractNumber;
                $data['document']['customerName']   = $doc->customer;
                $data['document']['recipientName']  = $doc->recipient;
                $data['document']['category']       = $doc->category;
                $data['items']                      = json_decode($doc->items, true);
                $data['total']                      = $doc->total;
                $data['file']['submission']         = $doc->submission;
                $data['file']['attachment']         = $doc->attachment;
                $data['approver']['name']           = $app->name;
                $data['approver']['sign']           = $app->sign;
                $data['approval']['Admin']          = $doc->Admin;
                $data['approval']['Supervisor_I']   = $doc->Supervisor_I;
                $data['approval']['Supervisor_II']  = $doc->Supervisor_II;
                $data['approval']['Manager']        = $doc->Manager;
                $data['disapproval']                = $doc->disapproval;
                $data['notes']                      = $doc->notes;
                $data['prevApprover']               = $prevApprover;
                $data['nextApprover']               = $nextApprover;
                
                if (($data['approval'][$hierarchy] == null && $data['disapproval'] == null) || ($data['approval'][$hierarchy] != null && $data['approval'][$nextApprover] == null && $data['disapproval'] !=  null))
                {
                    $data['disapproval']                = $app->name;
                    $data['disapproved']['name']        = $app->name;
                    $data['disapproved']['hierarchy']   = $hierarchy;
                    $data['message']                    = "Disapproved.";
                    if ($notes != null || !empty($notes))
                    {
                        if($data['notes'] == null)
                        {
                            $note = 'Catatan ' . str_replace('_', ' ', $hierarchy) . ' :\n' . $notes;
                            $data['notes'] = $note;
                        }
                        else
                        {
                            $note = $data['notes'] . '\n\nCatatan ' . str_replace('_', ' ', $hierarchy) . ' :\n' . $notes;
                            $data['notes'] = $note;
                        }
                        $db->query("UPDATE submissions SET $hierarchy = NULL, disapproval = '$app->name', notes = '$note' WHERE submission = '$document'");
                    }
                    else
                    {
                        $db->query("UPDATE submissions SET $hierarchy = NULL, disapproval = '$app->name' WHERE submission = '$document'");
                    }
                    
                    $sendEmail->sendToApplicant($data['email'], 'Applicant', $data['document']['proofNumber'] . ' - ' . ucwords($data['type']) . ' Anda Ditolak Oleh ' . str_replace('_', ' ', $hierarchy), $data);
                    if($prevApprover != null)
                    {
                        $reciever = $db->query("SELECT name, email FROM hierarchies WHERE hierarchy = '$prevApprover'");
                        foreach ($reciever->getResult('array') as $row) {
                            $to[] = $row['email'];
                        }
                        $sendEmail->sendToApprover($to, str_replace('_', ' ', $prevApprover), ucwords($data['type']) . ' Dikembalikan Dari ' . str_replace('_', ' ', $hierarchy) . ' - ' . $data['document']['proofNumber'], $data);
                    } else {
                         $db->query("DELETE FROM submissions WHERE submission = '$document' AND email = '$doc->email'");
                    }
                }
                else
                {
                    $data['disapproval']                = $app->name;
                    $data['disapproved']['name']        = $app->name;;
                    $data['disapproved']['hierarchy']   = $hierarchy;
                    $data['message'] = "Can't disapprove now.";
                }
            }
            else
            {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
        else
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $db->close();
            
        // return $this->response->setJSON($data);
        return view('disapproval', $data);
    }
    
    public function submitnotes()
    {
        $userModels = new \App\Models\User_models();
        $sendEmail  = new \App\Models\Mail_sender();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        
        $data       = [];
        $document   = $request->getPost('doc');
        $notes      = $request->getPost('notes');
        $hierarchy  = $request->getPost('as');
        
        $data['newnotes'] = $notes;
        
        $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$document'");
        if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
        {
            switch ($hierarchy) {
                case 'Admin':
                    $prevApprover = null;
                    $nextApprover = 'Supervisor_I';
                    break;
                case 'Supervisor_I':
                    $prevApprover = 'Admin';
                    $nextApprover = 'Supervisor_II';
                    break;
                case 'Supervisor_II':
                    $prevApprover = 'Supervisor_I';
                    $nextApprover = 'Manager';
                    break;
                case 'Manager':
                    $prevApprover = 'Supervisor_II';
                    $nextApprover = null;
                    break;
                default:
                    $prevApprover = null;
                    $nextApprover = null;
                    break;
            }
            
            $doc = $getDoc->getRow();
            
            $data['type']                       = $doc->type;
            $data['email']                      = $doc->email;
            $data['document']['date']           = $doc->date;
            $data['document']['proofNumber']    = $doc->proofNumber;
            $data['document']['projectCode']    = $doc->projectCode;
            $data['document']['contractNumber'] = $doc->contractNumber;
            $data['document']['customerName']   = $doc->customer;
            $data['document']['recipientName']  = $doc->recipient;
            $data['document']['category']       = $doc->category;
            $data['items']                      = json_decode($doc->items, true);
            $data['total']                      = $doc->total;
            $data['file']['submission']         = $doc->submission;
            $data['file']['attachment']         = $doc->attachment;
            $data['approval']['Admin']          = $doc->Admin;
            $data['approval']['Supervisor_I']  = $doc->Supervisor_I;
            $data['approval']['Supervisor_II']   = $doc->Supervisor_II;
            $data['approval']['Manager']        = $doc->Manager;
            $data['disapproval']                = $doc->disapproval;
            $data['notes']                      = $doc->notes;
            $data['approver']['name']           = $data['disapproval'];
            $data['approver']['sign']           = null;
            $data['prevApprover']               = $prevApprover;
            $data['nextApprover']               = $nextApprover;
            
            if (($data['approval'][$hierarchy] == null && $data['disapproval'] != null) || ($data['approval'][$hierarchy] != null && $data['approval'][$nextApprover] == null && $data['disapproval'] !=  null))
            {
                if($data['notes'] == null)
                {
                    $note = 'Catatan ' . str_replace('_', '', $hierarchy) . ' :\n' . $notes;
                }
                else
                {
                    $note = $data['notes'] . '\n\nCatatan ' . str_replace('_', '', $hierarchy) . ' :\n' . $notes; 
                }
                
                $data['disapproval']                = $data['disapproval'];
                $data['disapproved']['name']        = $data['disapproval'];
                $data['disapproved']['hierarchy']   = $hierarchy;
                $data['message']                    = "Notes submitted.";
                
                $name = $data['disapproval'];
                session()->setFlashdata('success', $data['message']);
                
                $db->query("UPDATE submissions SET $hierarchy = NULL, notes = '$note' WHERE submission = '$document' AND $hierarchy is NULL AND disapproval is NOT NULL");
            }
            else
            {
                $data['message'] = "Can't disapprove now.";
                session()->setFlashdata('error', $data['message']);
                return redirect()->back();
            }
        }
        else
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $db->close();
        
        // return $this->response->setJSON($data);
        return view('disapproval', $data);
    }
    
    public function projects()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        
        $project = $request->getGet('p');
        if ($project != null)
        {
            $query = $db->query("SELECT * FROM projects WHERE projectCode = '$project' LIMIT 1");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                $results = $query->getRow();
                
                $data['projectCode']    = $results->projectCode;
                $data['contractNumber'] = $results->contractNumber;
                $data['customer']       = $results->customer;
            }
            else
            {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
        else
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $db->close();
        
        return $this->response->setJSON($data);
    }
    
    public function query()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        
        $q = $request->getGet('q');
        
        $data['description'] = [];
        if ($q != null)
        {
            $query = $db->query("SELECT description FROM refcode WHERE description LIKE '%$q%' GROUP BY description LIMIT 5");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                foreach ($query->getResult('array') as $key => $row) {
                    $data['description'][$key] = $row['description'];
                }
                
                sort($data['description']);
            }
            else
            {
                return $this->response->setJSON($data);
            }
        }
        else
        {
            return $this->response->setJSON($data);
        }
        
        $db->close();
        
        return $this->response->setJSON($data);
    }
    
    
    
    public function refcode()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        
        $desc = $request->getGet('d');
        
        $data['code'] = [];
        if ($desc != null)
        {
            $query = $db->query("SELECT code FROM refcode WHERE description = '$desc'");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                foreach ($query->getResult('array') as $key => $row) {
                    $data['code'][$key] = $row['code'];
                }
                
                sort($data['code']);
            }
            else
            {
               return $this->response->setJSON($data);
            }
        }
        else
        {
            return $this->response->setJSON($data);
        }
        
        $db->close();
        
        return $this->response->setJSON($data);
    }
}