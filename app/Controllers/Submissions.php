<?php

namespace App\Controllers;

class Submissions extends BaseController
{
    public function index()
    {
        return view('submission');
    }
    
    public function pending()
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
            $data['currentPage']    = 'Pending';
            
            $page   = ($request->getGet('page') == null) ? 1 : $request->getGet('page');
            $sort   = ($request->getGet('sort') == null) ? 'DESC' : $request->getGet('sort');
            $limit  = 21;
            $offset = ($page * $limit) - 21;
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['page']       = $page;
                $data['prev']       = (int)$page - 1;
                $data['next']       = (int)$page + 1;
                $data['prev']       = (int)$page - 1;
                $data['next']       = (int)$page + 1;
                $data['sort']       = $sort;
                $data['breadcrumb'] = 'Pending';
                $data['message']    = 'Menunggu persetujuan anda';
                $data['notMessage'] = 'Tidak ada permintaan persetujuan.';
                
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
                
                switch ($data['as']) {
                    case 'Admin':
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_I';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_I':
                        $prevHierarchy      = 'Admin';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_II';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_II':
                        $prevHierarchy      = 'Supervisor_I';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Manager';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval is NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Manager':
                        $prevHierarchy      = 'Supervisor_II';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NULL AND disapproval is NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    default:
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        break;
                }
                
                $data['submissions'] = [];
                if (count($query->getResult()) != 0 || !empty($query->getRow()))
                {
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['submissions'][$key]['type']          = $row['type'];
                        $data['submissions'][$key]['proofNumber']   = $row['proofNumber'];
                        $data['submissions'][$key]['submission']    = $row['submission'];
                        $data['submissions'][$key]['projectCode']   = $row['projectCode'];
                        $data['submissions'][$key]['date']          = $row['dateSubmitted'];
                    }
                }
                
                $data['length'] = count($data['submissions']) < 21 ? count($data['submissions']) : count($data['submissions']) - 1;

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('submission', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function returned()
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
            $data['currentPage']    = 'Returned';
            
            $page   = ($request->getGet('page') == null) ? 1 : $request->getGet('page');
            $sort   = ($request->getGet('sort') == null) ? 'DESC' : $request->getGet('sort');
            $limit  = 21;
            $offset = ($page * $limit) - 21;
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['page']       = $page;
                $data['prev']       = (int)$page - 1;
                $data['next']       = (int)$page + 1;
                $data['sort']       = $sort;
                $data['breadcrumb'] = 'Returned';
                $data['message']    = 'Meminta Peninjauan Ulang';
                $data['notMessage'] = 'Tidak ada permintaan peninjauan ulang.';
                
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
                
                switch ($data['as']) {
                    case 'Admin':
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_I';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_I':
                        $prevHierarchy      = 'Admin';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_II';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_II':
                        $prevHierarchy      = 'Supervisor_I';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Manager';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND $nextHierarchy is NULL AND disapproval is NOT NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Manager':
                        $prevHierarchy      = 'Supervisor_II';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $prevHierarchy is NOT NULL AND $currentHierarchy is NOT NULL AND disapproval is NOT NULL ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    default:
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        break;
                }
                
                $data['submissions'] = [];
                if (count($query->getResult()) != 0 || !empty($query->getRow()))
                {
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['submissions'][$key]['type']          = $row['type'];
                        $data['submissions'][$key]['proofNumber']   = $row['proofNumber'];
                        $data['submissions'][$key]['submission']    = $row['submission'];
                        $data['submissions'][$key]['projectCode']   = $row['projectCode'];
                        $data['submissions'][$key]['date']          = $row['dateSubmitted'];
                    }
                }
                
                $data['length'] = count($data['submissions']) < 21 ? count($data['submissions']) : count($data['submissions']) - 1;

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('submission', $data);
            }
            else
            {
                $db->close();
        
                return view('login'); 
            }
        }
    }
    
    public function approved()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        if(!$session->has('logged_in'))
        {
            return view('login');
        }
        else
        {
            $data                   = [];
            $email                  = $session->get('email');
            $data['currentPage']    = 'Approved';
            
            $page   = ($request->getGet('page') == null) ? 1 : $request->getGet('page');
            $sort   = ($request->getGet('sort') == null) ? 'DESC' : $request->getGet('sort');
            $limit  = 21;
            $offset = ($page * $limit) - 21;
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['page']       = $page;
                $data['prev']       = (int)$page - 1;
                $data['next']       = (int)$page + 1;
                $data['sort']       = $sort;
                $data['breadcrumb'] = 'Approved';
                $data['message']    = 'Permintaan Yang Disetujui';
                $data['notMessage'] = 'Belum ada permintaan yang disetujui.';
                
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
                        $nextHierarchy      = 'Supervisor_I';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND Admin = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_I':
                        $prevHierarchy      = 'Admin';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_II';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND Supervisor_I = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_II':
                        $prevHierarchy      = 'Supervisor_I';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Manager';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND Supervisor_II = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Manager':
                        $prevHierarchy      = 'Supervisor_II';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NOT NULL AND Manager = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    default:
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        break;
                }
                
                $data['submissions'] = [];
                if (count($query->getResult()) != 0 || !empty($query->getRow()))
                {
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['submissions'][$key]['type']          = $row['type'];
                        $data['submissions'][$key]['proofNumber']   = $row['proofNumber'];
                        $data['submissions'][$key]['submission']    = $row['submission'];
                        $data['submissions'][$key]['projectCode']   = $row['projectCode'];
                        $data['submissions'][$key]['date']          = $row['dateSubmitted'];
                    }
                }
                
                $data['length'] = count($data['submissions']) < 21 ? count($data['submissions']) : count($data['submissions']) - 1;

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('submission', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function disapproved()
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
            $data['currentPage']    = 'Disapproved';
            
            $page   = ($request->getGet('page') == null) ? 1 : $request->getGet('page');
            $sort   = ($request->getGet('sort') == null) ? 'DESC' : $request->getGet('sort');
            $limit  = 21;
            $offset = ($page * $limit) - 21;
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['page']       = $page;
                $data['prev']       = (int)$page - 1;
                $data['next']       = (int)$page + 1;
                $data['sort']       = $sort;
                $data['breadcrumb'] = 'Disapproved';
                $data['message']    = 'Permintaan Yang Ditolak';
                $data['notMessage'] = 'Tidak ada permintaan yang ditolak.';
                
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
                        $nextHierarchy      = 'Supervisor_I';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_I':
                        $prevHierarchy      = 'Admin';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Supervisor_II';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Supervisor_II':
                        $prevHierarchy      = 'Supervisor_I';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = 'Manager';
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NULL AND $nextHierarchy is NULL AND disapproval = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    case 'Manager':
                        $prevHierarchy      = 'Supervisor_II';
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        
                        $query              = $db->query("SELECT type, proofNumber, submission, dateSubmitted, projectCode FROM submissions WHERE $currentHierarchy is NULL AND disapproval = '$name' ORDER BY dateSubmitted $sort LIMIT $limit OFFSET $offset");
                        break;
                    default:
                        $prevHierarchy      = null;
                        $currentHierarchy   = $data['as'];
                        $nextHierarchy      = null;
                        break;
                }
                
                $data['submissions'] = [];
                if (count($query->getResult()) != 0 || !empty($query->getRow()))
                {
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['submissions'][$key]['type']          = $row['type'];
                        $data['submissions'][$key]['proofNumber']   = $row['proofNumber'];
                        $data['submissions'][$key]['submission']    = $row['submission'];
                        $data['submissions'][$key]['projectCode']   = $row['projectCode'];
                        $data['submissions'][$key]['date']          = $row['dateSubmitted'];
                    }
                }

                $data['length'] = count($data['submissions']) < 21 ? count($data['submissions']) : count($data['submissions']) - 1;
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('submission', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
}