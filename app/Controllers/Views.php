<?php

namespace App\Controllers;
use App\Models\User_models;

class Views extends BaseController
{
    protected $helpers = ['form'];
    
    public function index($submission)
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        if(!$session->has('logged_in'))
        {
            $db->close();
            
            return view('login');
        }
        else
        {
            $data                   = [];
            $email                  = $session->get('email');
            $data['currentPage']    = null;
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['breadcrumb'] = $submission;
                
                switch ($data['as']) {
                    case 'Admin':
                        $data['approval']['prevHierarchy']      = null;
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = 'Supervisor_I';
                        break;
                    case 'Supervisor_I':
                        $data['approval']['prevHierarchy']      = 'Admin';
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = 'Supervisor_II';
                        break;
                    case 'Supervisor_II':
                        $data['approval']['prevHierarchy']      = 'Supervisor_I';
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = 'Manager';
                        break;
                    case 'Manager':
                        $data['approval']['prevHierarchy']      = 'Supervisor_II';
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = null;
                        break;
                    default:
                        $data['approval']['prevHierarchy']      = null;
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = null;
                        break;
                }
                
                foreach ($getHierarchy->getResult('array') as $key => $row)
                {
                    $data['accounts'][$key]['email']        = $row['email'];
                    $data['accounts'][$key]['name']         = $row['name'];
                    $data['accounts'][$key]['hierarchy']    = $row['hierarchy'];
                    $data['accounts'][$key]['sign']         = $row['sign'];
                }
                
                array_sort_by_multiple_keys($data['accounts'], [
                    'hierarchy' => SORT_ASC,
                ]);
                    
                $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$submission'");
                if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
                {
                    $doc = $getDoc->getRow();
                    
                    $data['document']['type']                       = $doc->type;
                    $data['document']['email']                      = $doc->email;
                    $data['document']['date']                       = $doc->date;
                    $data['document']['proofNumber']                = $doc->proofNumber;
                    $data['document']['projectCode']                = $doc->projectCode;
                    $data['document']['contractNumber']             = $doc->contractNumber;
                    $data['document']['customerName']               = $doc->customer;
                    $data['document']['recipientName']              = $doc->recipient;
                    $data['document']['category']                   = $doc->category;
                    $data['document']['items']                      = json_decode($doc->items, true);
                    $data['document']['total']                      = $doc->total;
                    $data['document']['file']['submission']         = $doc->submission;
                    $data['document']['file']['attachment']         = $doc->attachment != null ? explode(', ', $doc->attachment) : null;
                    $data['document']['approval']['Admin']          = $doc->Admin;
                    $data['document']['approval']['Supervisor_I']   = $doc->Supervisor_I;
                    $data['document']['approval']['Supervisor_II']  = $doc->Supervisor_II;
                    $data['document']['approval']['Manager']        = $doc->Manager;
                    $data['document']['disapproval']                = $doc->disapproval;
                    $data['document']['notes']                      = $doc->notes;
                }
                else
                {
                   throw new \Exception('Not Found');
                }
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('view', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function edit($submission)
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        if(!$session->has('logged_in'))
        {
            $db->close();
            
            return view('login');
        }
        else
        {
            $data                   = [];
            $email                  = $session->get('email');
            $data['currentPage']    = null;
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['breadcrumb'] = $submission;
                
                switch ($data['as']) {
                    case 'Admin':
                        $data['approval']['prevHierarchy']      = null;
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = 'Supervisor_I';
                        break;
                    case 'Supervisor_I':
                        $data['approval']['prevHierarchy']      = 'Admin';
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = 'Supervisor_II';
                        break;
                    case 'Supervisor_II':
                        $data['approval']['prevHierarchy']      = 'Supervisor_I';
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = 'Manager';
                        break;
                    case 'Manager':
                        $data['approval']['prevHierarchy']      = 'Supervisor_II';
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = null;
                        break;
                    default:
                        $data['approval']['prevHierarchy']      = null;
                        $data['approval']['currentHierarchy']   = $data['as'];
                        $data['approval']['nextHierarchy']      = null;
                        break;
                }
                
                foreach ($getHierarchy->getResult('array') as $key => $row)
                {
                    $data['accounts'][$key]['email']        = $row['email'];
                    $data['accounts'][$key]['name']         = $row['name'];
                    $data['accounts'][$key]['hierarchy']    = $row['hierarchy'];
                    $data['accounts'][$key]['sign']         = $row['sign'];
                }
                
                array_sort_by_multiple_keys($data['accounts'], [
                    'hierarchy' => SORT_ASC,
                ]);
                    
                $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$submission'");
                if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
                {
                    $doc = $getDoc->getRow();
                    
                    $data['document']['type']                       = $doc->type;
                    $data['document']['email']                      = $doc->email;
                    $data['document']['date']                       = $doc->date;
                    $data['document']['proofNumber']                = $doc->proofNumber;
                    $data['document']['projectCode']                = $doc->projectCode;
                    $data['document']['contractNumber']             = $doc->contractNumber;
                    $data['document']['customerName']               = $doc->customer;
                    $data['document']['recipientName']              = $doc->recipient;
                    $data['document']['category']                   = $doc->category;
                    $data['document']['items']                      = json_decode($doc->items, true);
                    $data['document']['total']                      = $doc->total;
                    $data['document']['file']['submission']         = $doc->submission;
                    $data['document']['file']['attachment']         = $doc->attachment != null ? explode(', ', $doc->attachment) : null;
                    $data['document']['approval']['Admin']          = $doc->Admin;
                    $data['document']['approval']['Supervisor_I']   = $doc->Supervisor_I;
                    $data['document']['approval']['Supervisor_II']  = $doc->Supervisor_II;
                    $data['document']['approval']['Manager']        = $doc->Manager;
                    $data['document']['disapproval']                = $doc->disapproval;
                }
                else
                {
                   throw new \Exception('Not Found');
                }
                
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
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('edit', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function removeAttach()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        if(!$session->has('logged_in'))
        {
            $db->close();
            
            return view('login');
        }
        else
        {
            $data               = [];
            $submission         = $request->getVar('submission');
            $data['submission'] = $submission;
            $data['removed']    = $request->getVar('attachment');
                    
            $getDoc = $db->query("SELECT * FROM submissions WHERE submission = '$submission'");
            if (count($getDoc->getResult()) != 0 || !empty($getDoc->getRow()))
            {
                $doc = $getDoc->getRow();
                
                $attachments = $doc->attachment != null ? explode(', ', $doc->attachment) : null;
                
                $arrEl = $data['removed'];
                unset($attachments[$arrEl]);
                var_dump($attachments);
                
                $data['attachment'] = implode(', ', array_values($attachments));
                
                $db->table('submissions')->update([
                    'attachment' => $data['attachment'],
                ], ['submission' => $submission]);
            }
            
            $db->close();
            
            return $this->response->setJSON($data);
        }
    }
    
    public function save()
    {
        $userModels = new \App\Models\User_models();
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $data       = [];
        
        helper('date');
        
        $rules = [
            'date'          => 'required',
            'proofNumber'   => 'required',
            'projectCode'   => 'required',
            'contractNumber'=> 'required',
            'customerName'  => 'required',
            'recipientName' => 'required',
            'category'      => 'required',
        ];
        
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
        
        $file = $request->getFiles();
        
        if(!$this->validate($rules))
        {
            $db->close();
            session()->setFlashdata('error', $this->validator->listErrors());
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        else
        {
            $proofNumber = $data['document']['proofNumber'];
            
            $query  = $db->query("SELECT email, attachment FROM submissions WHERE proofNumber = '$proofNumber'");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                $doc = $query->getRow();
                
                $attachments = $doc->attachment != null ? explode(', ', $doc->attachment) : [];
                
                if($file)
                {
                    $extArr = ['png','jpeg','jpg','pdf','xls','xlsx','tmp'];
                    
                    foreach ($file['attachment'] as $key => $img)
                    {
                        if (in_array($img->guessExtension(), $extArr))
                        {
                            $newName = $img->getRandomName();
                            $img->move('../form/public/attachments/', $newName);
                            
                            array_push($attachments, $newName);
                        }
                    }
                }
                
                $data['file']['attachment'] = $attachments;
                
                $db->table('submissions')->update([
                    'date'          => date('Y-m-d', strtotime($data['document']['date'])),
                    'proofNumber'   => $data['document']['proofNumber'],
                    'projectCode'   => $data['document']['projectCode'],
                    'contractNumber'=> $data['document']['contractNumber'],
                    'customer'      => $data['document']['customerName'],
                    'recipient'     => $data['document']['recipientName'],
                    'category'      => $data['document']['category'],
                    'items'         => json_encode($data['items']),
                    'total'         => $data['total'],
                    'submission'    => $data['file']['submission'],
                    'attachment'    => $data['file']['attachment'] == null || count($data['file']['attachment']) == 0 ? null : implode(', ', $data['file']['attachment'])
                ], ['proofNumber' => $proofNumber]);
                
                session()->setFlashdata('success', 'Berhasil update data.');
                return redirect()->to('view/' . $data['file']['submission']);
                
                // return $this->response->setJSON($data);
            }
            else
            {
                session()->setFlashdata('error', 'Gagal update data.');
                return redirect()->back();
            }
            
            $db->close();
        }
    }
}