<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $helpers = ['form'];
    
    public function index()
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
            $data   = [];
            $email  = $session->get('email');
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['currentPage']    = 'Dashboard';
                $data['as']             = $session->get('hierarchy');
                
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
                
                $name = $data['accounts'][0]['name'];
                
                switch ($data['as']) {
                    case 'Admin':
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_II';
                        
                        $pending            = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL");
                        $returned           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL");
                        $approved           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NOT NULL AND Admin = '$name'");
                        $disapproved        = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval = '$name'");
                        
                        $needApproval       = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL LIMIT 20");
                        $needRecheck        = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL LIMIT 20");
                        break;
                    case 'Supervisor_I':
                        $prevHierarchy      = 'Admin';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_II';
                        
                        $pending            = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL");
                        $returned           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL");
                        $approved           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NOT NULL AND Supervisor_I = '$name'");
                        $disapproved        = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval = '$name'");
                        
                        $needApproval       = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL LIMIT 20");
                        $needRecheck        = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL LIMIT 20");
                        break;
                    case 'Supervisor_II':
                        $prevHierarchy      = 'Supervisor_I';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Manager';
                        
                        $pending            = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL");
                        $returned           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL");
                        $approved           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NOT NULL AND Supervisor_II = '$name'");
                        $disapproved        = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval = '$name'");
                        
                        $needApproval       = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL LIMIT 20");
                        $needRecheck        = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL LIMIT 20");
                        break;
                    case 'Manager':
                        $prevHierarchy      = 'Supervisor_II';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        
                        $pending            = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND disapproval is NULL");
                        $returned           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND disapproval is NOT NULL");
                        $approved           = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NOT NULL AND Manager = '$name'");
                        $disapproved        = $db->query("SELECT COUNT(id) as total FROM submissions WHERE $currentHierarchy is NULL AND disapproval = '$name'");
                        
                        $needApproval       = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND disapproval is NULL LIMIT 20");
                        $needRecheck        = $db->query("SELECT email, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND Manager = '$name' LIMIT 20");
                        break;
                    default:
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        break;
                }
                
                $getPending             = $pending->getRow();
                $data['pending']        = $getPending->total;
                
                $getReturned            = $returned->getRow();
                $data['returned']       = $getReturned->total;
                
                $getApproved            = $approved->getRow();
                $data['approved']       = $getApproved->total;
                
                $getDisapproved         = $disapproved->getRow();
                $data['disapproved']    = $getDisapproved->total;
                
                $data['needApproval'] = [];
                if (count($needApproval->getResult()) != 0 || !empty($needApproval->getRow()))
                {
                    foreach ($needApproval->getResult('array') as $key => $row)
                    {
                        $data['needApproval'][$key]['email']        = $row['email'];
                        $data['needApproval'][$key]['proofNumber']  = $row['proofNumber'];
                        $data['needApproval'][$key]['submission']   = $row['submission'];
                        $data['needApproval'][$key]['projectCode']  = $row['projectCode'];
                        $data['needApproval'][$key]['date']         = $row['dateSubmitted'];
                    }
                }
                
                $data['needRecheck'] = [];
                if (count($needRecheck->getResult()) != 0 || !empty($needRecheck->getRow()))
                {
                    foreach ($needRecheck->getResult('array') as $key => $row)
                    {
                        $data['needRecheck'][$key]['email']         = $row['email'];
                        $data['needRecheck'][$key]['proofNumber']   = $row['proofNumber'];
                        $data['needRecheck'][$key]['submission']    = $row['submission'];
                        $data['needRecheck'][$key]['projectCode']   = $row['projectCode'];
                        $data['needRecheck'][$key]['date']          = $row['dateSubmitted'];
                    }
                }

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('dashboard', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function auth()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        $rules = [
            'email'         => 'required|valid_email',
            'password'      => 'required'
        ];
        
        $email      = $request->getPost('email');
        $password   = md5($request->getPost('password'));
        
        $data['email']      = $email;
        $data['realPass']   = $request->getPost('password');  
        $data['password']   = $password;
        
        if(!$this->validate($rules))
        {
            $db->close();
            
            session()->setFlashdata('error', 'Format email salah!');
            
            return redirect()->back()->withInput();
        }
        else
        {
            $query = $db->query("SELECT email FROM accounts WHERE email = '$email' AND password = '$password'");
            if (count($query->getResult()) != 0 || !empty($query->getRow()))
            {
                $data['isset']      = 'isIsset';
                $data['accounts']   = [];
                
                $getHierarchy = $db->query("SELECT hierarchy FROM hierarchies WHERE email = '$email'");
                if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
                {
                    foreach ($getHierarchy->getResult('array') as $key => $row) {
                        $data['accounts'][$key]['hierarchy']    = $row['hierarchy'];
                    }
                    
                    array_sort_by_multiple_keys($data['accounts'], [
                        'hierarchy' => SORT_ASC,
                    ]);
                    
                    $sessionData = [
                        'email'     => $request->getPost('email'),
                        'hierarchy' => $data['accounts'][0]['hierarchy'],
                        'logged_in' => true,
                    ];
                    
                    $session->set($sessionData);
                }
                
                $db->close();

                return redirect()->to('/');
            }
            else
            {
                $db->close();
                
                session()->setFlashdata('error', 'Email atau password salah! Periksa kembali email dan password anda.');
                
                return redirect()->back()->withInput();
            }
        }
        
        // return $this->response->setJSON($data);
    }
    
    public function setHierarchy()
    {
        $request    = \Config\Services::request();
        $session    = session();
        
        if(!$session->has('logged_in'))
        {
            return view('login');
        }
        else
        {
            $hierarchy =  base64_decode(urldecode($request->getGet('as')));
            
            $session->set('hierarchy', $hierarchy);
            
            return redirect()->to('/');
        }
    }
    
    public function logout()
    {
        $session    = session();
        
        if(!$session->has('logged_in'))
        {
            return view('login');
        }
        else
        {
            $sessionData = ['email', 'logged_in'];
            $session->remove($sessionData);
        
            return redirect()->to('/');
        }
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
