<?php
require_once 'core/db.php';
require_once 'core/functions.php';
require_once('ripcord/ripcord.php');
require_once 'core/odoo_functions.php';

/* $uid =odoo_authenticate($odoo_url_auth,$odoo_db, $odoo_username, $odoo_password);
    print("<p>Your current user id is '${uid}'</p>");
    $models = odoo_logging_in($odoo_url_exec);
$rs=$models->execute_kw($odoo_db, $uid, $odoo_password,
    'sale.order.line', 'fields_get',
    array(), array('attributes' => array('string', 'help', 'type','required')));

var_dump($rs);exit(); */



$requests=get_all_requests_from_db($db);
//var_dump($requests);exit();

if(count($requests)>0){
    $uid =odoo_authenticate($odoo_url_auth,$odoo_db, $odoo_username, $odoo_password);
    print("<p>Your current user id is '${uid}'</p>");
    $models = odoo_logging_in($odoo_url_exec);

    foreach($requests as $req){
        $request_id=$req['id'];
        print("<p>Request ".$request_id."</p>");
        $quotation_number='REQUEST-'.$request_id;
        print("<p>Quotation number :".$quotation_number."</p>");
        $request_items=get_request_items_from_db($request_id,$db);
        print("<p>Total items :".count($request_items)."</p>");
        
        /* Search if quotation number exist in odoo */
        $results_odoo_search_quotation=odoo_search_read_quotation($models,$odoo_db, $uid, $odoo_password,$quotation_number);
        

        if(count($results_odoo_search_quotation)==0){
            print("<p>Quotation number '$quotation_number' not sync to odoo </p>");
            
            //Create quotation in odoo
            $odoo_quotation_id=odoo_create_quotation($models,$odoo_db, $uid, $odoo_password,$req,$request_items);
            exit();
            /* //update
            if($odoo_invoice_id>0){
                $rsUpdate=update_invoice_odoo_id($invoice_id,$odoo_invoice_id,$db);
            } */
    
        }else{
            $found_odoo_id=$results_odoo_search_quotation[0]['id'];
            print("<p>Request number '$invoice_number' already synced to odoo . id founded = $found_odoo_id</p>");
            $odoo_quotation_id=odoo_update_quotation($models,$odoo_db, $uid, $odoo_password,$data_request,$request_items,$found_odoo_id); 
            exit();
        }        
    }
}

exit();



/* $request_id=10;
if($request_id>0){
    $request_items=get_request_items_from_db($request_id,$db);
    //var_dump($request_items);
} */

//$quotations=odoo_get_all_quotations($models,$odoo_db, $uid, $odoo_password);
//var_dump($quotations);exit();







function odoo_search_read_quotation($models,$odoo_db, $uid, $odoo_password,$quotation_number){
    print("<p>Start search : ".$quotation_number."</p>");
    $results=$models->execute_kw($odoo_db, $uid, $odoo_password,
        'sale.order', 'search_read',
        array(array(array('name', '=', $quotation_number))),
        array('fields'=>array('id', 'name'), 'limit'=>1));
    print("<p>End search : ".$quotation_number."</p>");
    return $results;
}
function odoo_update_quotation($models,$odoo_db, $uid, $odoo_password,$data_request,$request_items,$found_odoo_id){
    print("********start update quotation: $found_odoo_id");
    $odoo_quotation_id =$models->execute_kw($odoo_db, $uid, $odoo_password, 'sale.order', 'write',
    array(array($found_odoo_id), array('state'=>"draft")));

    print("********Updated invoice: $odoo_quotation_id");
    print("********end update invoice: $found_odoo_id");
    return $odoo_quotation_id;
}
function odoo_create_quotation($models,$odoo_db, $uid, $odoo_password,$data_request,$request_items){
    //create partner
    //$partner_id=odoo_create_partner($models,$odoo_db, $uid, $odoo_password,$data_request);
    //print("<p>Partner patient created with id '{$partner_id}'</p>");
    //print("<p>Partner doctor created with id '{$partner_doctor_id}'</p>");
    $partner_id=1;
    $odoo_quotation_id = $models->execute_kw($odoo_db, $uid, $odoo_password,
        'sale.order', 'create',
        array(array(
            'name'=>'REQUEST-'.$data_request['id'],
            'state'=>'draft',
            'date_order'=>$data_request['created_at'],
            'partner_id'=>$partner_id,            
            'company_id' => 1,//company drtooth
        )
    ));
    if(is_int($odoo_quotation_id)){
        print("<p>Quotation created with id '{$odoo_quotation_id}'</p>");
        // Create quotation line(s)
        odoo_create_quotation_lines($odoo_quotation_id,$models,$odoo_db, $uid, $odoo_password,$request_items);
    }
    else{
        print("<p>Error: ");
        print("</p>");
    }
    return $odoo_quotation_id;
}
function odoo_create_quotation_lines($odoo_quotation_id,$models,$odoo_db, $uid, $odoo_password,$request_items){
    print("<p>---- START CREATION LINES  </p>");
    print("<p>---- TOTAL LINES :".count($request_items)." </p>");

    if(count($request_items)>0){
        foreach($request_items as $row){
            //var_dump($row);exit();
            $quotation_line_id = $models->execute_kw($odoo_db, $uid, $odoo_password,
            'sale.order.line',
            'create',
                array(
                    array(
                        'order_id'=>$odoo_quotation_id,
                        'name'=>$row['product_name'],
                        'price_unit'=>$row['rate'],
                        //'product_uom'=>$row['odoo_id'],
                        //'product_uom_qty'=>$row['quantity'],         
                        'product_uom_qty'=>$row['quantity'],         
                    )
                ),
                //['context'=>['check_move_validity'=>False]]
            );


            if(is_int($quotation_line_id)){
                print("<p>Invoice line created with id '{$quotation_line_id}'</p>");
            }
            else{
                print("<p>Error: ");
                print($quotation_line_id['faultString']);
                print("</p>");
            }
            exit();
        }
    }
    print("<p>----END CREATION LINES </p>");
}