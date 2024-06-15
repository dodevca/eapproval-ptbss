<?php

namespace App\Controllers;
use CodeIgniter\Files\File;

class Settings extends BaseController
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
            $data                   = [];
            $email                  = $session->get('email');
            $data['currentPage']    = 'Setting';
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as'] = $session->get('hierarchy');;
                
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
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('setting', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    // Email
    public function email()
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
                $data['as'] = $session->get('hierarchy');;
                
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

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('email', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function setemail()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        $newemail       = $request->getPost('email');
        $password       = md5($request->getPost('password'));
        $email          = $session->get('email');
        
        $rules = [
            'email'     => 'required|valid_email',
            'password'  => 'required',
        ];
        
        if(!$this->validate($rules))
        {
            session()->setFlashdata('error', 'Email tidak valid.');
            
            return redirect()->back()->withInput();
        }
        else
        {
            $getHierarchy = $db->query("SELECT name FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                foreach ($getHierarchy->getResult('array') as $key => $row)
                {
                    $name = $row['name'];
                }
                
                $query      = $db->query("SELECT password FROM accounts WHERE email = '$email'");
                $getQuery   = $query->getRow();
                
                if ((count($query->getResult()) != 0 || !empty($query->getRow())) && $getQuery->password == $password)
                {
                    $update     = $db->query("UPDATE accounts SET email = '$newemail' WHERE email = '$email' AND password = '$password'");
                    $update2    = $db->query("UPDATE hierarchies SET email = '$newemail' WHERE email = '$email' AND name = '$name'");
                    
                    session()->setFlashdata('success', 'Berhasil mengganti email.');
                    
                    return redirect()->back();
                }
                else
                {
                    session()->setFlashdata('error', 'Password salah.');
                    
                    return redirect()->back()->withInput();
                }
            }
        }
    }
    
    // E-Signature
    public function esign()
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
                $data['as'] = $session->get('hierarchy');;
                
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

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('esign', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function setesign()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        $email      = $session->get('email');
        $signUrl    = $request->getVar('sign');
        
        $getHierarchy = $db->query("SELECT name FROM hierarchies WHERE email = '$email'");
        if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
        {
            $data['as'] = $session->get('hierarchy');;
            
            foreach ($getHierarchy->getResult('array') as $key => $row)
            {
                $data['accounts'][$key]['name'] = $row['name'];
            }

            if($signUrl != null)
            {
                $signEncode = explode(",", $signUrl);
                $signImage  = base64_decode($signEncode[1]);
                $newName    = base64_encode($data['accounts'][0]['name']) . '.png';
                
                file_put_contents('uploads/signatures/' . $newName, $signImage);
            }
            
            $db->close();
        }
        else
        {
            $db->close();
            
            return view('login'); 
        }
        
        return $this->response->setJSON($request->getVar());
    }
    
    // Password
    public function password()
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
                $data['as'] = $session->get('hierarchy');;
                
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

                $db->close();
                
                // return $this->response->setJSON($data);
                return view('password', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function setpassword()
    {
        $db         = \Config\Database::connect();
        $request    = \Config\Services::request();
        $session    = session();
        
        $oldPassword    = md5($request->getPost('oldPassword'));
        $newPassword    = md5($request->getPost('newPassword'));
        $matchPassword  = md5($request->getPost('matchPassword'));
        $email          = $session->get('email');
        
        $rules = [
            'oldPassword'   => 'required',
            'newPassword'   => 'required|min_length[8]',
            'matchPassword' => 'required|matches[newPassword]',
        ];
        
        if(!$this->validate($rules))
        {
            session()->setFlashdata('error', 'Password baru tidak sama.');
            
            return redirect()->back()->withInput();
        }
        else
        {
            $query      = $db->query("SELECT password FROM accounts WHERE email = '$email'");
            $getQuery   = $query->getRow();
            
            if ((count($query->getResult()) != 0 || !empty($query->getRow())) && $getQuery->password == $oldPassword)
            {
                $update = $db->query("UPDATE accounts SET password = '$newPassword' WHERE email = '$email' AND password = '$oldPassword'");
                session()->setFlashdata('success', 'Berhasil mengganti password.');
                return redirect()->back();
            }
            else
            {
                session()->setFlashdata('error', 'Password lama tidak sesuai.');
                
                return redirect()->back()->withInput();
            }
        }
    }
    
    // Hierarchy
    public function hierarchies()
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
                $data['as'] = $session->get('hierarchy');;
                
                if ($data['as'] == 'Manager')
                {
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
                    
                    $data['hierarchies'] = [];
                    $query = $db->query("SELECT email, name, hierarchy FROM hierarchies");
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['hierarchies'][$key]['email']        = $row['email'];
                        $data['hierarchies'][$key]['name']         = $row['name'];
                        $data['hierarchies'][$key]['hierarchy']    = $row['hierarchy'];
                    }
                    
                    $db->close();
                    
                    // return $this->response->setJSON($data);
                    return view('hierarchy', $data);
                }
                else
                {
                    $db->close();
                    
                    return redirect()->to('/'); 
                }
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function sethierarchies()
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
            
            $data['as'] = $session->get('hierarchy');;
            
            if ($data['as'] == 'Manager')
            {
                $data['purpose'] = $request->getVar('purpose');
                
                switch ($data['purpose']) {
                    case 'add':
                        $data['message']    = 'Berhasil menambahkan hierarchy.';
                        $data['notMessage'] = 'Gagal menambahkan hierarchy. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'email'     => strtolower(trim($request->getVar('email'))),
                            'name'      => ucwords(strtolower(trim($request->getVar('name')))),
                            'hierarchy' => $request->getVar('hierarchy'),
                            'sign'      => base64_encode($request->getVar('name'))
                        ];
                        $data['query2']      = [
                            'email'     => strtolower(trim($request->getVar('email'))),
                            'password'  => md5('Login_BSS')
                        ];
                        $db->table('hierarchies')->replace($data['query']);
                        $db->table('accounts')->ignore(true)->insert($data['query2']);
                        break;
                    case 'delete':
                        $email      = trim(strtolower(base64_decode(urldecode($request->getVar('email')))));
                        $hierarchy  = base64_decode(urldecode($request->getVar('as')));
                        $data['message']    = 'Berhasil menghapus hierarchy.';
                        $data['notMessage'] = 'Gagal menambahkan hierarchy. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'email'     => $email,
                            'hierarchy' => $hierarchy
                        ];
                        $db->table('hierarchies')->delete($data['query']);
                        break;
                    default:
                        $data['action']     = null;
                        $data['message']    = 'Error';
                        $data['notMessage'] = 'Error';
                        break;
                }
                $db->close();

                session()->setFlashdata('success', $data['message']);
                return redirect()->back();
            }
            else
            {
                $db->close();
                
                return redirect()->to('/'); 
            }
        }
        
        // return $this->response->setJSON($data);
    }
    
    // Project Code
    public function projects()
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
                $data['as'] = $session->get('hierarchy');;
                
                if ($data['as'] == 'Manager')
                {
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
                    
                    $data['projects'] = [];
                    $query = $db->query("SELECT projectCode, contractNumber, customer FROM projects");
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['projects'][$key]['projectCode']      = $row['projectCode'];
                        $data['projects'][$key]['contractNumber']   = $row['contractNumber'];
                        $data['projects'][$key]['customer']         = $row['customer'];
                    }
                    
                    array_sort_by_multiple_keys($data['projects'], [
                        'projectCode' => SORT_ASC,
                    ]);
                    
                    $db->close();
                    
                    // return $this->response->setJSON($data);
                    return view('project', $data);
                }
                else
                {
                    $db->close();
                    
                    return redirect()->to('/'); 
                }
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function setprojects()
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
            
            $data['as'] = $session->get('hierarchy');;
            
            if ($data['as'] == 'Manager')
            {
                $data['purpose'] = $request->getVar('purpose');
                
                switch ($data['purpose']) {
                    case 'add':
                        $data['message']    = 'Berhasil menambahkan kode proyek.';
                        $data['notMessage'] = 'Gagal menambahkan kode proyek. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'projectCode'       => 'P' . trim($request->getVar('projectCode')),
                            'contractNumber'    => trim($request->getVar('contractNumber')),
                            'customer'          => trim(ucwords(strtolower($request->getVar('customer'))))
                        ];
                        $db->table('projects')->replace($data['query']);
                        break;
                    case 'delete':
                        $data['message']    = 'Berhasil menghapus kode proyek.';
                        $data['notMessage'] = 'Gagal menambahkan kode proyek. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'projectCode' => trim(base64_decode(urldecode($request->getVar('projectCode'))))
                        ];
                        $db->table('projects')->delete($data['query']);
                        break;
                    default:
                        $data['action']     = null;
                        $data['message']    = 'Error';
                        $data['notMessage'] = 'Error';
                        break;
                }
                $db->close();

                session()->setFlashdata('success', $data['message']);
                return redirect()->back();
            }
            else
            {
                $db->close();
                
                return redirect()->to('/'); 
            }
        }
        
        // return $this->response->setJSON($data);
    }
    
    // Category
    public function categories()
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
                $data['as'] = $session->get('hierarchy');;
                
                if ($data['as'] == 'Manager')
                {
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
                    
                    $data['categories'] = [];
                    $query = $db->query("SELECT category FROM categories");
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['categories'][$key]      = $row['category'];
                    }
                    
                    sort($data['categories']);
                    
                    $db->close();
                    
                    // return $this->response->setJSON($data);
                    return view('category', $data);
                }
                else
                {
                    $db->close();
                    
                    return redirect()->to('/'); 
                }
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
        
        // return $this->response->setJSON($data);
    }
    
    public function setcategories()
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
            
            $data['as'] = $session->get('hierarchy');;
            
            if ($data['as'] == 'Manager')
            {
                $data['purpose'] = $request->getVar('purpose');
                
                switch ($data['purpose']) {
                    case 'add':
                        $data['message']    = 'Berhasil menambahkan kategori.';
                        $data['notMessage'] = 'Gagal menambahkan kategori. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'category'       => ucwords(strtolower(trim($request->getVar('category'))))
                        ];
                        $db->table('categories')->replace($data['query']);
                        break;
                    case 'delete':
                        $data['message']    = 'Berhasil menghapus kategori.';
                        $data['notMessage'] = 'Gagal menambahkan kategori. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'category' => ucwords(strtolower(trim(base64_decode(urldecode($request->getVar('category'))))))
                        ];
                        $db->table('categories')->delete($data['query']);
                        break;
                    default:
                        $data['action']     = null;
                        $data['message']    = 'Error';
                        $data['notMessage'] = 'Error';
                        break;
                }
                $db->close();

                session()->setFlashdata('success', $data['message']);
                return redirect()->back();
            }
            else
            {
                $db->close();
                
                return redirect()->to('/'); 
            }
        }
        
        // return $this->response->setJSON($data);
    }

    public function refcode()
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
                $data['as'] = $session->get('hierarchy');;
                
                if ($data['as'] == 'Manager')
                {
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
                    
                    $data['refcode'] = [];
                    $query = $db->query("SELECT code, description FROM refcode");
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['refcode'][$key]['code']          = $row['code'];
                        $data['refcode'][$key]['description']   = $row['description'];
                    }
                    
                    array_sort_by_multiple_keys($data['refcode'], [
                        'description' => SORT_ASC,
                    ]);
                    
                    $db->close();
                    
                    // return $this->response->setJSON($data);
                    return view('refcode', $data);
                }
                else
                {
                    $db->close();
                    
                    return redirect()->to('/'); 
                }
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
        
        // return $this->response->setJSON($data);
    }
    
    public function setrefcode()
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
            
            $data['as'] = $session->get('hierarchy');;
            
            if ($data['as'] == 'Manager')
            {
                $data['purpose'] = $request->getVar('purpose');
                
                switch ($data['purpose']) {
                    case 'add':
                        $data['message']    = 'Berhasil menambahkan kode referensi.';
                        $data['notMessage'] = 'Gagal menambahkan kode referensi. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'code'          => trim($request->getVar('code')),
                            'description'   => ucwords(strtolower(trim($request->getVar('description'))))
                        ];
                        
                        $db->table('refcode')->replace($data['query']);
                        break;
                    case 'delete':
                        $data['message']    = 'Berhasil menghapus kode referensi.';
                        $data['notMessage'] = 'Gagal menambahkan kode referensi. Pastikan data yang dimasukkan benar.';
                        $data['query']      = [
                            'code'          => trim(base64_decode(urldecode($request->getVar('code')))),
                            'description'   => ucwords(strtolower(trim(base64_decode(urldecode($request->getVar('description'))))))
                        ];
                        $db->table('refcode')->delete($data['query']);
                        break;
                    default:
                        $data['action']     = null;
                        $data['message']    = 'Error';
                        $data['notMessage'] = 'Error';
                        break;
                }
                $db->close();

                session()->setFlashdata('success', $data['message']);
                return redirect()->back();
            }
            else
            {
                $db->close();
                
                return redirect()->to('/'); 
            }
        }
        
        // return $this->response->setJSON($data);
    }
}