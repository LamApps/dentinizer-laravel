<?php
require_once 'core/db.php';
require_once 'core/functions.php';
require_once('ripcord/ripcord.php');

$uid =odoo_authenticate($odoo_url_auth,$odoo_db, $odoo_username, $odoo_password);
//print("<p>Your current user id is '${uid}'</p>");
//exit();
$models = odoo_logging_in($odoo_url_exec);


$results_odoo_search_products=odoo_search_read_products($models,$odoo_db, $uid, $odoo_password);
//var_dump($results_odoo_search_products);exit();


if(count($results_odoo_search_products)>0){
    foreach($results_odoo_search_products as $row){
        $product_id=find_product_by_odoo($row['id'],$db);
        //print('<p>odoo : '.$row['id'].' ---- '.$product_id.'</p>');
        $data=array(
            'id' => $product_id,
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['list_price'],
            'is_active' => 1,
            'odoo_id' => $row['id'],
            'category' => $row['categ_id'][1],
            'deleted_at' => NULL,
        );
        if($product_id==0){
            insert_product($data,$db);
        }else{
            update_product($data,$db);
        } 
    }
}



function odoo_search_read_products($models,$odoo_db, $uid, $odoo_password){
    $results=$models->execute_kw($odoo_db, $uid, $odoo_password,
        'product.template', 'search_read',
        array(),
        array('fields'=>array('id', 'name','list_price','standard_price','description','categ_id')));
    return $results;
}

function odoo_authenticate($odoo_url_auth,$odoo_db, $odoo_username, $odoo_password){
    $common = ripcord::client($odoo_url_auth);
    $uid = $common->authenticate($odoo_db, $odoo_username, $odoo_password, array());
    return $uid;
}
function odoo_logging_in($odoo_url_exec){
    $models = ripcord::client($odoo_url_exec);
    return $models;
}

echo json_encode(['success'=>true,'msg'=>'Products have been synchronized']);