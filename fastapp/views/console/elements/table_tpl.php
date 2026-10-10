<div class="table_view_wrapper">
    <?php
    $config['num_links'] = 2;
    $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = '&laquo; First';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Last &raquo;';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = 'Next &rsaquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&lsaquo; Prev';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['base_url'] = base_url() .$this->uri->segment(1).'/'.$this->uri->segment(2).'/index/'; 
    $config = array_merge($config, $table_meta['config']);
    $this->pagination->initialize($config);
    if (!empty($table_meta['data']) && count($table_meta['data'])) {
        $table_headers = array_keys($table_meta['data'][0]);
    }
    $table_allowed_header = is_array($config['list_columns']) ? 1000 : 6;
    ?>
    <div class="box box-primary">	
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list text-primary"></i> <?= !empty($table_meta['config']['title']) ? $table_meta['config']['title'] : 'Records' ?></h3>
            <div class="box-tools pull-right">
                <?php if (is_array($config['allowed_action']) && in_array('add_detail', $config['allowed_action']) !== FALSE): ?>
                    <?php 
                    $curSeg = $this->uri->segment(2);
                    if (in_array($curSeg, array('purchase', 'sale', 'sales', 'stock'))) {
                        $addUrl = console_url($curSeg . '/add_detail');
                        $addClick = '';
                    } else {
                        $addUrl = 'javascript:void(0);';
                        $addClick = 'onclick="popupAddNew()"';
                    }
                    ?>
                    <a href="<?= $addUrl ?>" <?= $addClick ?> class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Add <?= !empty($table_meta['config']['title']) ? $table_meta['config']['title'] : 'New' ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="box-body" style="padding: 15px;">
            <?php if (!empty($table_meta['data']) && count($table_meta['data'])): ?>
                <form method="post" action="" class="choose_entry_form">
                    <?php if (is_array($config['allowed_action']) && in_array('delete', $config['allowed_action']) !== FALSE): ?>
                        <div style="margin-bottom: 12px;">
                            <button type="button" class="btn btn-default btn-sm btn_select_all" style="margin-right: 5px;"><i class="fa fa-check-square-o"></i> Select All</button>
                            <button type="button" class="btn btn-default btn-sm btn_deselect_all" style="margin-right: 5px;"><i class="fa fa-square-o"></i> Clear Selected</button>
                            <button type="button" onclick="popupDeleteAll()" class="btn btn-danger btn-sm search_remove"><i class="fa fa-trash"></i> Delete Selected</button>
                        </div>
                    <?php endif; ?>

                    <div class="scrollgard" style="overflow: auto">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <?php if ($config['enable_ordering']): ?>
                                            <th>Drag To Order</th>
                                        <?php endif; ?>
                                        <?php $th_key = 0; ?>
                                        <?php if ($config['tablePrimaryKey']): ?>
                                            <?php
                                            if (is_array($config['allowed_action'])) {
                                                if (in_array('delete', $config['allowed_action']) !== FALSE) {
                                                    ?>
                                                    <th>Choose</th>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        <?php endif; ?>
                                        <?php foreach ($table_headers as $table_th): ?>
                                            <?php
                                            if ($table_allowed_header < ++$th_key) {
                                                break;
                                            } else {
                                                if (is_array($config['list_columns'])) {
                                                    if (in_array($table_th, $config['list_columns']) === FALSE) {
                                                        continue;
                                                    }
                                                }
                                            }
                                            ?>
                                            <th class="sortable_th" data-rel="<?= $table_th ?>" style="cursor: pointer; white-space: nowrap;">
                                                <?= ucwords(str_replace('_', ' ', (str_replace(array_keys($this->page_config['replace_text']), array_values($this->page_config['replace_text']), $table_th)))) ?>
                                                <i data-rel="<?= $table_th ?>" class="fa fa-sort pull-right text-muted shorter" style="cursor: pointer; margin-top: 3px;" title="Click to Sort"></i>
                                            </th>
                                        <?php endforeach; ?>
                                        <th>Action</th> 
                                    </tr>
                                </thead> 
                                <?php if ($config['enable_ordering']): ?>
                                    <tbody class='orderable'>
                                    <?php else: ?>
                                    <tbody>
                                    <?php endif; ?>
                                    <?php foreach ($table_meta['data'] as $table_tr): ?>
                                        <?php if ($config['tablePrimaryKey']): ?>    
                                            <tr id='row_<?= $table_tr[$config['tablePrimaryKey']] ?>'>
                                            <?php else: ?>
                                            <tr>
                                            <?php endif; ?>
                                            <?php if ($config['enable_ordering']): ?>
                                                <td class="center"><span class="center icon32 icon icon-arrow-nesw"></span></td>    
                                            <?php endif; ?>
                                            <?php $td_key = 0; ?>
                                            <?php if ($config['tablePrimaryKey']): ?>
                                                <?php
                                                if (is_array($config['allowed_action'])) {
                                                    if (in_array('delete', $config['allowed_action']) !== FALSE) {
                                                        ?>
                                                        <td class="center">
                                                            <input  class="selectedItem" type="checkbox" value="<?= $table_tr[$config['tablePrimaryKey']] ?>" name="selectedItem[]">
                                                        </td> 
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            <?php endif; ?>
                                            <?php foreach ($table_tr as $t_key => $table_td): ?>

                                                <?php
                                                if ($table_allowed_header < ++$td_key) {
                                                    break;
                                                } else {
                                                    if (is_array($config['list_columns'])) {
                                                        if (in_array($t_key, $config['list_columns']) === FALSE) {
                                                            continue;
                                                        }
                                                    }

                                                    if (is_array($config['use_status_columns'])) {
                                                        if (in_array($t_key, $config['use_status_columns']) === TRUE) {
                                                            ?> 
                                                            <td class="center">                                                                                          
                                                                <?php
                                                                switch (intval($table_td)) {
                                                                    case 1 :
                                                                        echo '<span class="label label-success">On</span>';
                                                                        break;
                                                                    default :
                                                                        echo '<span class="label label-important">Off</span>';
                                                                }
                                                                ?>
                                                            </td> <?php
                                                            continue;
                                                        }
                                                    }
                                                    if (is_array($config['use_dropdown_columns_options'])) {
                                                        if (array_key_exists($t_key, $config['use_dropdown_columns_options']) === TRUE) {
                                                            ?> 
                                                            <td class="center">                                                                                          
                                                                <?php
                                                                if (isset($config['use_dropdown_columns_options']['multi'][$t_key])) {
                                                                    $table_td = json_decode($table_td, TRUE);
                                                                    foreach ($table_td as $m_key => $m_value) {
                                                                        if ($m_key > 0) {
                                                                            echo ',';
                                                                        }
                                                                        echo $config['use_dropdown_columns_options'][$t_key][$m_value];
                                                                    }
                                                                } else {
                                                                    echo isset($config['use_dropdown_columns_options'][$t_key][$table_td]) ? $config['use_dropdown_columns_options'][$t_key][$table_td] : 'N/A';
                                                                }
                                                                ?>                                                        
                                                            </td> 
                                                            <?php
                                                            continue;
                                                        }
                                                    }

                                                    if (is_array($config['use_image_columns'])) {
                                                        $arr_index = array_search($t_key, $config['use_image_columns']);
                                                        if ($arr_index !== FALSE) {
                                                            ?> 
                                                            <td class="center">                                                                                          
                                                                <img style="width:64px" src='<?= $table_td ? $table_meta['config']['use_image_columns_path'][0] . $table_td : cdn_url() . 'uploads/noImage.jpg' ?>' alt="<?= $table_td ?>" />
                                                            </td> <?php
                                                            continue;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <td class="center">
                                                    <?php
                                                    if (is_array($config['allowed_action'])) {
                                                        if (in_array('quick_edit', $config['allowed_action']) !== FALSE) {
                                                            ?>
                                                            <span style="cursor: pointer; width: 100%; display: block; min-height: 32px; border-radius: 4px; vertical-align: middle; background-color: wheat;" relId="<?= $table_tr[$config['tablePrimaryKey']]; ?>" relfield = "<?= $t_key ?>" onclick="quickEdit(this)" id="<?= $t_key . '-' . $table_tr[$config['tablePrimaryKey']] ?>" title="Click To Quick Edit"   style="cursor: pointer">
                                                                <?= strip_tags($table_td) ?>
                                                            </span>
                                                        <? } else { ?>
                                                            <?= strip_tags($table_td); ?>
                                                            <?
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                            <?php endforeach; ?>

                                            <td class="center">
                                                <?php
                                                if (is_array($config['allowed_action'])) {
                                                    if (in_array('view_detail', $config['allowed_action']) !== FALSE) {
                                                        ?>
                                                        <a class="btn btn-default btn-xs" title="View" data-rel="tooltip" href="#" onclick="popupViewSingle(<?= $table_tr[$config['tablePrimaryKey']] ?>)">
                                                            <i class="fa fa-eye text-primary"></i>  
                                                        </a>
                                                        <?php
                                                    }
                                                }
                                                if (is_array($config['allowed_action'])) {
                                                    if (in_array('edit_detail', $config['allowed_action']) !== FALSE) {
                                                        ?>
                                                        <a class="btn btn-default btn-xs" title="Edit" data-rel="tooltip" href="#" onclick="popupEditSingle(<?= $table_tr[$config['tablePrimaryKey']] ?>)">
                                                            <i class="fa fa-pencil text-warning"></i>  
                                                        </a>
                                                        <?php
                                                    }
                                                }
                                                if (is_array($config['allowed_action'])) {
                                                    if (in_array('delete', $config['allowed_action']) !== FALSE) {
                                                        ?>

                                                        <a class="btn btn-default btn-xs" title="Delete" data-rel="tooltip" href="#" onclick="popupDeleteSingle(<?= $table_tr[$config['tablePrimaryKey']] ?>)">
                                                            <i class="fa fa-trash text-danger"></i> 

                                                        </a>
                                                        <?php
                                                    }
                                                }
                                                
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>                          
                                </tbody>
                            </table>  
                        </div>
                    </form>    
                <div class="box-footer clearfix" style="border-top: 1px solid #f4f4f4; padding: 10px 0 0;">
                    <div class="pull-right pagination-wrapper">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                </div>  
            <?php else: ?>
                <div class="alert alert-info" style="margin: 10px 0;">
                    <i class="fa fa-info-circle"></i> No records found.
                </div>
            <?php endif; ?>
            </div>
        </div>
    <script>

// Set cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

// Get cookie
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
        /**
         *for pagination
         **/
<?php if ($config['is_ajax']): ?>
            var loadAjaxPagination = setInterval(function () {
                if (typeof ajaxPagination == 'function') {
                    initAjaxPagination();
                }

            }, 100);
            initAjaxPagination = function () {
                ajaxPagination();
                clearInterval(loadAjaxPagination);
            }
<?php endif; ?>
/*sentMail*/
        	var sentMail = function(targetObject){
			currentPostRequest = $.post(page_url + 'mailInvoice', {invoice_id:targetObject}, function (responce) {		
				alert(responce.status);					
            },'json');
		}
		 /**sentMail***/
    </script>

</div>
