<?php

namespace App\Controllers;

class Downloads extends BaseController
{
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
            $data   = [];
            $email  = $session->get('email');
            
            $getHierarchy = $db->query("SELECT * FROM hierarchies WHERE email = '$email'");
            if (count($getHierarchy->getResult()) != 0 || !empty($getHierarchy->getRow()))
            {
                $data['as']         = $session->get('hierarchy');
                $data['breadcrumb'] = $submission;
                
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
                    $data['document']['total']                      = (int) $doc->total;
                    $data['document']['file']['submission']         = $doc->submission;
                    $data['document']['file']['attachment']         = explode(', ', $doc->attachment);
                    $data['document']['approval']['Admin']          = $doc->Admin;
                    $data['document']['approval']['Supervisor_I']  = $doc->Supervisor_I;
                    $data['document']['approval']['Supervisor_II']   = $doc->Supervisor_II;
                    $data['document']['approval']['Manager']        = $doc->Manager;
                    $data['document']['disapproval']                = $doc->disapproval;
                }
                else
                {
                   throw new \Exception('Not Found');
                }
                
                $db->close();
                
                // return $this->response->setJSON($data);
                return view('download', $data);
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
                return view('download_item', $data);
            }
            else
            {
                $db->close();
                
                return view('login'); 
            }
        }
    }
}