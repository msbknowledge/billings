<?php
function medicine_reminder() {
    $CI = &get_instance();
    $count = $CI->db->query('SELECT sale_date,customer_address,customer_name,customer_contact FROM sales join customers on customer_ID = sale_customer')->result_array();
    return $count;
}
function medicine_count() {
    $CI = &get_instance();
    $count = $CI->db->query('SELECT DISTINCT count(medicine_name) as medicine_count FROM medicines')->result_array();
    return $count;
}
function no_unit(){
	 $CI = &get_instance();
    return count($CI->medicines_model->no_unit());

}
function medicine_error_expire_date() {
    $CI = &get_instance();
    $count = count($CI->db->query('select medicines.*, medicine_stocks.* from medicine_stocks join medicines on medicine_stock_medicine = medicine_id where medicine_expire_year = 0 and medicine_expire_month =0 order by medicine_expire_year asc,medicine_expire_month asc')->result_array());
    return $count;
}
function medicine_error_storage() {
    $CI = &get_instance();
    return count($CI->medicines_model->get_list(array('medicine_storage'=>'')));;
}
function duplicate(){
	 $CI = &get_instance();
    return count( $CI->medicines_model->duplicate());
}

function total_sale_today() {
    $CI = &get_instance();
    $count = $CI->db->query('SELECT SUM(sale_total) as sale FROM `sales` WHERE DATE_FORMAT(sale_date, "%Y-%m-%d") = CURRENT_DATE')->result_array();
    return $count;
}
function expiring() {
    $CI = &get_instance();
    //$count = count($CI->medicine_stocks_model->expire());
    return $count;
}
function expired() {
    $CI = &get_instance();
    //$count = count($CI->medicine_stocks_model->expire(true));
    //return $count;
}
function medicine_error_zeronegetive() {
    $CI = &get_instance();
    $count = count($CI->medicine_stocks_model->zeronegetive());
    //$count =0;
    return $count;
}
function shortage() {
    $CI = &get_instance();
    //$count = count($CI->medicine_stocks_model->shortage());
    //return $count;
}
function total_purchase_today() {
    $CI = &get_instance();
    $count = $CI->db->query('SELECT SUM(purchase_total) as purchase FROM `purchases` WHERE purchase_date=CURRENT_DATE')->result_array();
    return $count;
}

function generate_invoice_number() {
    $invoice_last_count = (int) get_option('invoice_last_count') + 1;
    $inovice_number = get_option('invoice_number');
    return str_ireplace(array('[{number}]', '[{year}]'), array(sprintf('%05d', $invoice_last_count), date('Y')), $inovice_number);
}
function generate_purchase_number() {
    $purchase_last_count = (int) get_option('purchase_last_count') + 1;
    return sprintf('%05d', $purchase_last_count);
}
function generate_expiry_number() {
    $expiry_last_count = (int) get_option('expiry_last_count') + 1;
    return sprintf('%05d', $expiry_last_count);
}
function increase_purchase_number() {
    set_option('purchase_last_count', 1 + (int) get_option('purchase_last_count'));
}
function increase_expiry_number() {
    set_option('expiry_last_count', 1 + (int) get_option('expiry_last_count'));
}
function increase_invoice_number() {
    set_option('invoice_last_count', 1 + (int) get_option('invoice_last_count'));
}

function medicine_overview() {
    ?>
   	
   	 <?php
                                    $medicine_reminder = medicine_reminder();
                                    foreach($medicine_reminder as $files){
                                        $date1 = date("Y-m-d",strtotime($files['sale_date']));
                                        $date2 = date("Y-m-d",strtotime('+1 day'));
                                        
                                        if($files['sale_date']==$date2){
                                       
                                         echo'<div class="dashalert alert alert-success alert-dismissible" role="alert">
<button type="button" class="alertclose close close_notice" data-dismiss="alert" aria-label="Close" data-noticeid="138"><span aria-hidden="true">×</span></button>
<a href=""> '.$files['sale_date'].'-'. $files['customer_name'].'-'. $files['customer_address'].'-'. $files['customer_contact'].'</a>
</div> </div>';
          
                                        }else{
                                            //echo 'ff';
                                        }
                                    }
                                    //pr($medicine_reminder);
                                    
                                    ?>

             <div class="">

            


 <div class="box span12">
      
    <div class="box span6">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-bell"></i>Overview</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-bordewhite table-striped">
                <thead>
                    <tr>
                        <th>Labels</th>
                        <th>Number Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="label">Effective Medicine Added In Store</span>
                        </td>
                        <td>
                            
                                <span class="label"> <?php
                                    $medicine_count = medicine_count();
                                    if (empty($medicine_count[0]['medicine_count'])) {
                                        echo 'N/A';
                                    } else {
                                        echo $medicine_count[0]['medicine_count'];
                                    }
                                    ?></span>
                        </td>

                    </tr>
					 <tr>
                        <td>
                            <span class="label label-info">msbbilling Medicine Database</span>
                        </td>
                        <td>
                                <span class="label label-info">4Lakh+</span>
                        </td>

                    </tr>

                    <tr>
                        <td>
                            <span  class="label label-success">Total Sale of the day</span>
                        </td>
                        <td>
                                <span class="label"> Rs: <?php
                                    $sale_count = total_sale_today();
                                    if (empty($sale_count[0]['sale'])) {
                                        echo 'N/A';
                                    } else {
                                        echo $sale_count[0]['sale'];
                                    }
                                    ?></span>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <span  class="label label-success">Total Purchase of the day</span>
                        </td>
                        <td>
                                <span class="label">Rs: <?php
                                    $purchase_count = total_purchase_today();
                                    if (empty($purchase_count[0]['purchase'])) {
                                        echo 'N/A';
                                    } else {
                                        echo $purchase_count[0]['purchase'];
                                    }
                                    ?></span>
                        </td>

                    </tr>
					<tr>
                        <td>
                            <span  class="label label-warning">Upcoming Expire</span>
                        </td>
                        <td>
                            <a href="/console/medicine_stock/expiring_view">
							<button class="btn btn-success">
                              Click To check upcoming Expire
                            </button>
							</a>
                        </td>

                    </tr>
					<tr>
                        <td>
                            <span  class="label label-important"> Expired</span>
                        </td>
                        <td>
						<?php $result = expired()?>
                            <a href="/console/medicine_stock/expired_view">
							<button class="btn btn-danger">
                                Click To check Expired
                               <?//=$result?>
                            </button>
							</a>
                        </td>

                    </tr>
					<tr>
                        <td>
                            <span  class="label label-warning">Shortage (Less than 3 unit)</span>
                        </td>
                        <td>
						<?php $result = shortage()?>
                            <a href="/console/medicine_stock/shortage_view">
							<button class="btn btn-success">
                                Click To check Shortage
                                <!-- <span class="label"><?//=$result?></span> -->
                            </button>
							</a>
                        </td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div><!--/span-->

    <?php
}

function medicine_stock_update($medicine_batch, $medicine_id, $medicine_strip_stock, $medicine_loose_stock = 0, $type = "+", $medicine_mrp = null, $medicine_expire_month = null, $medicine_expire_year = null) {
    if (empty($medicine_id)) {
        return false;
    }
    $medicine_batch = !empty($medicine_batch) ? trim($medicine_batch) : 'N/A';
    $strip_qty = intval($medicine_strip_stock);
    $loose_qty = intval($medicine_loose_stock);

    $CI = &get_instance();

    // Fetch unit for loose calculation
    $med = $CI->db->select('medicine_unit')->get_where('medicines', array('medicine_id' => $medicine_id))->row_array();
    $unit = (!empty($med['medicine_unit']) && intval($med['medicine_unit']) > 1) ? intval($med['medicine_unit']) : 1;

    // Check if batch already exists in medicine_stocks
    $existing = $CI->db->get_where('medicine_stocks', array(
        'medicine_stock_medicine' => $medicine_id,
        'medicine_stock_batch' => $medicine_batch
    ))->row_array();

    if (!empty($existing)) {
        $current_strip = intval($existing['medicine_strip_stock']);
        $current_loose = intval($existing['medicine_loose_stock']);

        if ($type === '-') {
            $new_strip = $current_strip - $strip_qty;
            $new_loose = $current_loose - $loose_qty;
        } else {
            $new_strip = $current_strip + $strip_qty;
            $new_loose = $current_loose + $loose_qty;
        }

        // Handle loose overflow / underflow with unit
        if ($unit > 1) {
            if ($new_loose < 0) {
                $borrow_strips = ceil(abs($new_loose) / $unit);
                $new_strip -= $borrow_strips;
                $new_loose += ($borrow_strips * $unit);
            } elseif ($new_loose >= $unit) {
                $add_strips = floor($new_loose / $unit);
                $new_strip += $add_strips;
                $new_loose -= ($add_strips * $unit);
            }
        }

        $update_data = array(
            'medicine_strip_stock' => $new_strip,
            'medicine_loose_stock' => $new_loose,
            'medicine_stock_date'  => date('Y-m-d H:i:s')
        );

        if ($medicine_mrp !== null && $medicine_mrp !== '') {
            $update_data['medicine_mrp'] = $medicine_mrp;
        }
        if ($medicine_expire_month !== null && $medicine_expire_month !== '') {
            $update_data['medicine_expire_month'] = $medicine_expire_month;
        }
        if ($medicine_expire_year !== null && $medicine_expire_year !== '') {
            $update_data['medicine_expire_year'] = $medicine_expire_year;
        }

        $CI->db->where('medicine_stock_ID', $existing['medicine_stock_ID']);
        return $CI->db->update('medicine_stocks', $update_data);
    } else {
        // Record does not exist: insert new
        if ($type === '-') {
            $new_strip = 0 - $strip_qty;
            $new_loose = 0 - $loose_qty;
        } else {
            $new_strip = $strip_qty;
            $new_loose = $loose_qty;
        }

        if ($unit > 1) {
            if ($new_loose < 0) {
                $borrow_strips = ceil(abs($new_loose) / $unit);
                $new_strip -= $borrow_strips;
                $new_loose += ($borrow_strips * $unit);
            } elseif ($new_loose >= $unit) {
                $add_strips = floor($new_loose / $unit);
                $new_strip += $add_strips;
                $new_loose -= ($add_strips * $unit);
            }
        }

        $insert_data = array(
            'medicine_stock_medicine' => $medicine_id,
            'medicine_stock_batch'    => $medicine_batch,
            'medicine_strip_stock'    => $new_strip,
            'medicine_loose_stock'    => $new_loose,
            'medicine_stock_loose'    => 0,
            'medicine_expire_month'   => !empty($medicine_expire_month) ? $medicine_expire_month : 0,
            'medicine_expire_year'    => !empty($medicine_expire_year) ? $medicine_expire_year : 0,
            'medicine_mrp'            => !empty($medicine_mrp) ? $medicine_mrp : 0,
            'medicine_stock_date'     => date('Y-m-d H:i:s')
        );

        return $CI->db->insert('medicine_stocks', $insert_data);
    }
}
function medicine_js(){
?>
<script>
localStorage.setItem("bla","bla")
function get_expired_medicine(){
alert("Down for maintainence");
}
//get_expired_medicine();
/*****************/
function get_unique_medicine(){
$.post("/console/medicine_stock/get_unique_medicine_id",function(){

})
}

</script>
<?}
function medicine_stock_overview(){
	?>

	 <div class="box span6">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-bell"></i>Entry Error Report</h2>
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <table class="table table-bordewhite table-striped">
                <thead>
                    <tr>
                        <th>Labels</th>
                        <th>Number Count</th>
                    </tr>
					  
					</thead>
                <tbody>
				<tr>
						<td>Storeage Not Assigned</td>
						<td><a href="/console/medicine/storage_unassigned"><button><?=medicine_error_storage()?></button></a></td>
					</tr>
					<tr>
						<td>Expiry date error</td>
						<td><a href="/console/medicine_stock/expired_view"><button><?=medicine_error_expire_date()?></button></a></td>
					</tr> 
                                        <tr>
						<td>Zero or Negative Stock error</td>
						<td><a href="/console/medicine_stock/zeronegetive"><button><?=medicine_error_zeronegetive()?></button></a></td>
					</tr> 

					<tr>
						<td>Duplicate Entry</td>
						<td><a href="/console/medicine/duplicate"><button><?=duplicate()?></button></a></td>
					</tr> 
					<tr>
						<td><span  class="label label-important">Unit not assigned</span></td>
						<td><a href="/console/medicine/no_unit"><button class="btn btn-danger"><?=no_unit()?></button></a></td>
					</tr>	
					<tr>
						<td>Error In Sale Entry</td>
						<td>Counting...</td>
					</tr>							
				</tbody>
            </table>
				</div>
		</div></div>	
		 </div>   
<?}
register_hook('medicine_overview', 'dashboard');
register_hook('medicine_stock_overview', 'dashboard');
register_hook('medicine_js', 'dashboard');

