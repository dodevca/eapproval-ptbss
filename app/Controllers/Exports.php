<?php

namespace App\Controllers;

class Exports extends BaseController
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
            $data['currentPage']    = 'Export Data';
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as'] = $session->get('hierarchy');
                
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
                return view('export', $data);
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
            $db->close();
            
            return view('login');
        }
        else
        {
            $data                   = [];
            $email                  = $session->get('email');
            $data['currentPage']    = null;
            
            $type   = ($request->getGet('type') == null) ? 'all' : $request->getGet('type');
            $month  = ($request->getGet('month') == null) ? 'unset' : $request->getGet('month');
            $year   = ($request->getGet('year') == null) ? 'unset' : $request->getGet('year');
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']     = $session->get('hierarchy');
                $data['type']   = $type;
                $data['month']  = $month;
                $data['year']   = $year;
                
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
                
                $data['document'] = [];
                
                switch ($type){
                    case 'payment':
                        $whereType = "AND type = 'permintaan pembayaran'";
                    break;
                    case 'income':
                        $whereType = "AND type = 'penerimaan pendapatan'";
                    break;
                    default:
                        $whereType = "";
                    break;
                }
                
                switch ($month){
                    case 'januari':
                        $whereMonth = "AND MONTH(approval_Manager) = 1";
                    break;
                    case 'februari':
                        $whereMonth = "AND MONTH(approval_Manager) = 2";
                    break;
                    case 'maret':
                        $whereMonth = "AND MONTH(approval_Manager) = 3";
                    break;
                    case 'april':
                        $whereMonth = "AND MONTH(approval_Manager) = 4";
                    break;
                    case 'mei':
                        $whereMonth = "AND MONTH(approval_Manager) = 5";
                    break;
                    case 'juni':
                        $whereMonth = "AND MONTH(approval_Manager) = 6";
                    break;
                    case 'juli':
                        $whereMonth = "AND MONTH(approval_Manager) = 7";
                    break;
                    case 'agustus':
                        $whereMonth = "AND MONTH(approval_Manager) = 8";
                    break;
                    case 'september':
                        $whereMonth = "AND MONTH(approval_Manager) = 9";
                    break;
                    case 'oktober':
                        $whereMonth = "AND MONTH(approval_Manager) = 10";
                    break;
                    case 'november':
                        $whereMonth = "AND MONTH(approval_Manager) = 11";
                    break;
                    case 'desember':
                        $whereMonth = "AND MONTH(approval_Manager) = 12";
                    break;
                    default:
                        $whereMonth = "";
                    break;
                }
                
                if ($year != 'unset'){
                    $whereYear = "AND YEAR(approval_Manager) = $year";
                }
                else
                {
                    $whereYear = "";
                }
                
                $query = $db->query("SELECT * FROM submissions WHERE Manager is NOT NULL $whereType $whereMonth $whereYear ORDER BY approval_Manager ASC");
                if (count($query->getResult()) != 0 || !empty($query->getRow()))
                {
                    foreach ($query->getResult('array') as $key => $row)
                    {
                        $data['document'][$key]['type']                               = ucwords($row['type']);
                        $data['document'][$key]['email']                              = $row['email'];
                        $data['document'][$key]['date']                               = date('d/m/Y', strtotime($row['date']));
                        $data['document'][$key]['proofNumber']                        = $row['proofNumber'];
                        $data['document'][$key]['projectCode']                        = $row['projectCode'];
                        $data['document'][$key]['contractNumber']                     = $row['contractNumber'];
                        $data['document'][$key]['customerName']                       = ucwords(strtolower($row['customer']));
                        $data['document'][$key]['recipientName']                      = ucwords(strtolower($row['recipient']));
                        $data['document'][$key]['category']                           = ucwords(strtolower($row['category']));
                        $data['document'][$key]['items']                              = json_decode($row['items'], true);
                        $data['document'][$key]['total']                              = $row['total'];
                        $data['document'][$key]['attachment']                         = explode(', ', $row['attachment']);
                        $data['document'][$key]['approval']['admin']['name']          = ucwords(strtolower($row['Admin']));
                        $data['document'][$key]['approval']['supervisor_I']['name']   = ucwords(strtolower($row['Supervisor_I']));
                        $data['document'][$key]['approval']['supervisor_II']['name']  = ucwords(strtolower($row['Supervisor_II']));
                        $data['document'][$key]['approval']['manager'] ['name']       = ucwords(strtolower($row['Manager']));
                        $data['document'][$key]['approval']['admin']['date']          = date('d/m/Y', strtotime($row['approval_Admin']));
                        $data['document'][$key]['approval']['supervisor_I']['date']   = date('d/m/Y', strtotime($row['approval_Supervisor_I']));
                        $data['document'][$key]['approval']['supervisor_II']['date']  = date('d/m/Y', strtotime($row['approval_Supervisor_II']));
                        $data['document'][$key]['approval']['manager'] ['date']       = date('d/m/Y', strtotime($row['approval_Manager']));
                    }
                    $data['results'] = count($data['document']);
                }
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('export_approved', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
    
    public function item()
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
            
            $description        = $request->getPost('description');
            $refcode            = $request->getPost('unitRef');
            $type               = $request->getPost('type');
            $contractNumber     = $request->getPost('contractNumber');
            $category           = $request->getPost('category');
            $year               = $request->getPost('year');
            $beginningPeriod    = $request->getPost('beginningPeriod');
            $endPeriod          = $request->getPost('endPeriod');
            
            $whereType              = $type == 'All' ? '' : "AND type = '$type'";
            $whereContractNumber    = $contractNumber == 'All' ? '' : "AND contractNumber = '$contractNumber'";
            $whereCategory          = $category == 'All' ? '' : "AND category = '$category'";
            $whereYear              = $year == 'All' ? '' : "AND YEAR(date) = $year";
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']     = $session->get('hierarchy');
                $data['result'] = [];
                $data['query']  = [
                    'type'              => '',
                    'contractNumber'    => '',
                    'category'          => '',
                    'description'       => '',
                    'refcode'           => '',
                    'year'              => '',
                    'beginningPeriod'   => '',
                    'endPeriod'         => ''
                ];
                
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
                
                $getContract = $db->query("SELECT contractNumber FROM submissions GROUP BY contractNumber");
                if (count($getContract->getResult()) != 0 || !empty($getContract->getRow()))
                {
                    foreach ($getContract->getResult('array') as $key => $row)
                    {
                        $data['form']['contractNumber'][$key] = $row['contractNumber'];
                    }
                }
                
                $getCategory = $db->query("SELECT category FROM categories");
                if (count($getCategory->getResult()) != 0 || !empty($getCategory->getRow()))
                {
                    foreach ($getCategory->getResult('array') as $key => $row)
                    {
                        $data['form']['category'][$key] = $row['category'];
                    }
                }
                
                $getDescription = $db->query("SELECT description FROM refcode GROUP BY description");
                if (count($getDescription->getResult()) != 0 || !empty($getDescription->getRow()))
                {
                    foreach ($getDescription->getResult('array') as $key => $row)
                    {
                        $data['form']['description'][$key] = $row['description'];
                    }
                }
                
                if($request->getPost())
                {
                    $data['query']['description']       = $description;
                    $data['query']['refcode']           = $refcode;
                    $data['query']['type']              = $type;
                    $data['query']['contractNumber']    = $contractNumber;
                    $data['query']['category']          = $category;
                    $data['query']['year']              = $year;
                    $data['query']['beginningPeriod']   = $beginningPeriod;
                    $data['query']['endPeriod']         = $endPeriod;
                    
                    $query = $db->query("SELECT date, proofNumber, items FROM submissions WHERE items is NOT NULL $whereType $whereContractNumber $whereCategory $whereYear");
                    if (count($query->getResult()) != 0 || !empty($query->getRow()))
                    {
                        $data['total'] = 0;
                        
                        for($i = 0; $i < count($query->getResult('array')); $i++)
                        {
                            $row                    = $query->getResult('array')[$i];
                            $items                  = json_decode($row['items'], true);
                            $result['date']         = date('d/m/Y', strtotime($row['date']));
                            $result['proofNumber']  = $row['proofNumber'];
                            
                            for($j = 0; $j < count($items); $j++)
                            {
                                if($items[$j]['description'] == $description && $items[$j]['unitRef'] == $refcode && strtotime($items[$j]['beginningPeriod']) >= strtotime($data['query']['beginningPeriod']) && strtotime($items[$j]['endPeriod']) <= strtotime($data['query']['endPeriod']))
                                {
                                    $result['moreDescription']  = $items[$j]['moreDescription'];
                                    $result['amount']           = $items[$j]['amount'];
                                    $result['unit']             = $items[$j]['unit'];
                                    $result['unitPrice']        = $items[$j]['unitPrice'];
                                    $result['totalPrice']       = $items[$j]['totalPrice'];
                                    
                                    $data['total'] += $result['totalPrice'];
                                    
                                    array_push($data['result'], $result);
                                }
                            }
                        }
                    }
                }
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('export_item', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
}