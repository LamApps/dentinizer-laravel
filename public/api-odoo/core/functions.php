<?php
function get_all_requests_from_db($db){
    $sql="SELECT r.*,u.name,u.username,u.email FROM `sp_requests` r JOIN users u ON r.`user_id` = u.id";   
    $sth = $db->query($sql);
    $datas = $sth->fetchAll();
    return $datas;
}

function get_request_items_from_db($request_id,$db){
    $sql="SELECT i.*,p.odoo_id FROM `sp_request_items` i 
    JOIN sp_products p ON i.`product_id` = p.id 
    WHERE `request_id` = $request_id";   
    $sth = $db->query($sql);
    $datas = $sth->fetchAll();
    return $datas;
}

function update_invoice_odoo_id($invoice_id,$odoo_invoice_id,$db){
    $sql="UPDATE `inv_invoices` SET `odoo_id` = :odoo_invoice_id WHERE `inv_invoices`.`id` = :invoice_id";
    $data = [
        'odoo_invoice_id' => $odoo_invoice_id,
        'invoice_id' => $invoice_id,
    ];
    $stmt= $db->prepare($sql);
    $stmt->execute($data);
}
function get_invoices_from_db($invoice_id,$db){
    if($invoice_id>0){
        $sql="SELECT i.*,p.ar_name patient_ar_name,p.name patient_name,p.address patient_address,p.phone patient_phone,p.email patient_email,u.name doctor_name FROM `inv_invoices` i 
        JOIN patients p ON i.`patient_id` = p.id 
        JOIN users u ON i.`doctor_id` = u.id 
        WHERE i.`id` = $invoice_id";
    }else{
        $sql="SELECT i.*,p.ar_name patient_ar_name,p.name patient_name,p.address patient_address,p.phone patient_phone,p.email patient_email,u.name doctor_name FROM `inv_invoices` i 
        JOIN patients p ON i.`patient_id` = p.id 
        JOIN users u ON i.`doctor_id` = u.id";
    }   
    $sth = $db->query($sql);
    $datas = $sth->fetchAll();
    return $datas;
}
function get_amounts_invoice($invoice_id,$db){
    $total =$subtotal = $total_paid=$total_refund=0;
    $discount_amount=0;
    if($invoice_id>0){
        $datas_invoice=get_invoice_from_db($invoice_id,$db);
        if(isset($datas_invoice)){
            $invoice =$datas_invoice;
            //$subtotal = Procedureserviceitem::where ('invoice_id',$invoice_id)->sum('total');
            //SELECT SUM(`total`) as subtotal FROM `pr_procedure_service_items` WHERE `invoice_id` = 13
            $q = $db->query("SELECT SUM(`total`) as subtotal FROM `pr_procedure_service_items` WHERE `invoice_id` = $invoice_id");
            $rs = $q->fetch();
            //var_dump($rs);
            $subtotal =(isset($rs['subtotal']))?$rs['subtotal']:0;
            //subtotal

            //Réduction : //'percentage', 'fixed_amount'
            //'before_tax', 'after_tax'
            $tax_amount = 0;
            $amout_to_discount=$subtotal;
            if($invoice['discount_type']=='after_tax'){
                if($invoice['tax_percentage']>0){
                    $tax_amount=calculateTaxAmount($subtotal,$invoice['tax_percentage']);
                }
                $amout_to_discount=$subtotal+$tax_amount;
                $discount_amount=calculateDiscount($amout_to_discount,$invoice->discount_amount_type,$invoice->discount_amount);
            }elseif($invoice['discount_type']=='before_tax'){
                $amout_to_discount=$subtotal;
                $discount_amount=calculateDiscount($amout_to_discount,$invoice->discount_amount_type,$invoice->discount_amount);
                if($invoice['tax_percentage']>0){
                $tax_amount=calculateTaxAmount($subtotal-$discount_amount,$invoice['tax_percentage']);
                }
            }else{
                if($invoice['tax_percentage']>0){
                $tax_amount=calculateTaxAmount($subtotal,$invoice['tax_percentage']);
                }
            }
            $total = $subtotal-$discount_amount+$tax_amount;
        }
        $query_ip="SELECT SUM(`amount`) as total_paid FROM `inv_invoice_payments` WHERE `invoice_id` = $invoice_id";
        $query_ir="SELECT SUM(`amount`) as total_refund FROM `inv_invoice_refunds` WHERE `invoice_id` = $invoice_id";
        $rs_invoice_payments=fetch_result($query_ip,$db);
        $total_paid =(isset($rs['total_paid']))?$rs['total_paid']:0;
        $rs_invoice_refunds=fetch_result($query_ir,$db);
        $total_refund =(isset($rs['total_refund']))?$rs['total_refund']:0;
    }
    return array(
        'total'=>$total,
        'subtotal'=>$subtotal,
        'discount_amount'=>$discount_amount,
        'tax_amount'=>$tax_amount,
        'total_paid'=>$total_paid,
        'total_refund'=>$total_refund,
    );
}
function fetch_result($query,$db){
    $q = $db->query($query);
    $rs = $q->fetch();
    return $rs;
}
function calculateTaxAmount($amount,$tax_percentage){
    $tax_amount = 0;
    if($tax_percentage>0){
      $tax_amount =($amount*$tax_percentage)/100;
    }
    return $tax_amount;
}
function calculateDiscount($amout_to_discount,$discount_amount_type,$invoice_discount_amount){
    $discount_amount=0;
    if($discount_amount_type=='percentage'){
      $discount_amount=($amout_to_discount*$invoice_discount_amount)/100;
    }elseif($discount_amount_type=='fixed_amount'){
      $discount_amount=$invoice_discount_amount;
    }
    return $discount_amount;
}
function get_invoice_items($invoice_id,$db){
    $rs_items=[];
    /* SELECT i.*, s.code,s.service_name
    FROM pr_procedure_service_items i
    INNER JOIN services s
    ON i.`service_id` = s.id
    WHERE `invoice_id` = 13 */
    $sql="SELECT i.*, s.code,s.service_name FROM pr_procedure_service_items i JOIN services s ON i.`service_id` = s.id WHERE `invoice_id` = $invoice_id";
    $stm = $db->query($sql);
    // fetch all rows into array, by default PDO::FETCH_BOTH is used
    $rs_items = $stm->fetchAll();
    //var_dump($rs_items);
    return $rs_items;
}

function insert_product($data,$db){
    $req = $db->prepare('INSERT INTO sp_products(`id`, `name`, `description`, `price`, `is_active`, `odoo_id`, `category`,`deleted_at`, `created_at`, `updated_at`) 
    VALUES(:id, :name, :description, :price, :is_active,:odoo_id,:category,:deleted_at, NOW(), NOW())');
    $req->execute(array(
        'id' => $data['id'],
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
        'is_active' => $data['is_active'],
        'odoo_id' => $data['odoo_id'],
        'category' => $data['category'],
        'deleted_at' => NUll,
	));
}
function update_product($data,$db){
    $req = $db->prepare('UPDATE `sp_products` SET `name` = :name, `description` = :description, `price` = :price, `is_active` = :is_active, `odoo_id` = :odoo_id, `category` = :category,`updated_at` = NOW() WHERE `id` = :id');
    $req->execute(array(
        'id' => $data['id'],
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
        'is_active' => $data['is_active'],
        'odoo_id' => $data['odoo_id'],
        'category' => $data['category'],
	));
}
function find_product_by_odoo($odoo_id,$db){
    $id=0;
    $q = $db->query("SELECT `id` FROM `sp_products` WHERE `odoo_id` = $odoo_id");
    $rs = $q->fetchAll(PDO::FETCH_COLUMN, 0);
    //var_dump($rs);
    if(count($rs)>0 && $rs[0]){
        $id=$rs[0];
    }
    return $id;
}
//INSERT INTO `sp_products` (`id`, `name`, `description`, `price`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'test', 'sqsxqx', '123', '1', NULL, '2021-07-17 19:13:12', '2021-07-22 19:13:12');
//UPDATE `sp_products` SET `name` = 'product 12', `description` = 'testZZZ', `price` = '16.50', `is_active` = '0', `odoo_id` = '20', `deleted_at` = NULL, `created_at` = '2021-05-17 09:35:26', `updated_at` = '2021-05-25 09:35:26' WHERE `sp_products`.`id` = 1;
//SELECT `id` FROM `sp_products` WHERE `odoo_id` = 20;