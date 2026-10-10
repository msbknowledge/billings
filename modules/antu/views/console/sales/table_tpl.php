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
    $config['base_url'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/index/';

    $config = array_merge($config, $table_meta['config']);
    $this->pagination->initialize($config);
    if (!empty($table_meta['data']) && count($table_meta['data'])) {
        $table_headers = array_keys($table_meta['data'][0]);
    }
    $table_allowed_header = is_array($config['list_columns']) ? 1000 : 4;
    ?>
    <div class="box box-primary">	
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-shopping-cart text-primary"></i> <?= !empty($table_meta['config']['title']) ? $table_meta['config']['title'] : 'Sales' ?></h3>
            <div class="box-tools pull-right">
                <?php if (!is_array($config['allowed_action']) || in_array('add_detail', $config['allowed_action']) !== FALSE): ?>
                    <a href="<?= console_url('sale/add_detail'); ?>" class="btn btn-primary btn-sm" id="btn_add_sale">
                        <i class="fa fa-plus"></i> Add Sale
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="box-body" style="padding: 15px;">
            <?php if (!empty($table_meta['data']) && count($table_meta['data'])): ?>
                <form method="post" action="" class="choose_entry_form">
                    <?php if (is_array($config['allowed_action']) && in_array('delete', $config['allowed_action']) !== FALSE) { ?>
                        <div style="margin-bottom: 12px;">
                            <button type="button" class="btn btn-default btn-sm btn_select_all" style="margin-right: 5px;"><i class="fa fa-check-square-o"></i> Select All</button>
                            <button type="button" class="btn btn-default btn-sm btn_deselect_all" style="margin-right: 5px;"><i class="fa fa-square-o"></i> Clear Selected</button>
                            <button type="button" onclick="popupDeleteAll()" class="btn btn-danger btn-sm search_remove"><i class="fa fa-trash"></i> Delete Selected</button>
                        </div>
                    <?php } ?>


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
                                            <?php
                                            $th_display = $table_th;
                                            if (!empty($this->page_config['replace_text']) && is_array($this->page_config['replace_text'])) {
                                                $th_display = str_replace(array_keys($this->page_config['replace_text']), array_values($this->page_config['replace_text']), $table_th);
                                            }
                                            ?>
                                            <th><?= ucwords(str_replace('_', ' ', $th_display)) ?><i data-rel="<?= $table_th ?>" class="icon icon-black icon-triangle-ns shorter" style="cursor: pointer"></i></th>
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
                                                            <input  class="selectedItem" type="checkbox" value="<?= base64_encode($table_tr['sale_invoice']); ?>" name="selectedItem[]">
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
                                                                ?>                                                        </td> <?php
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
                                                    <?php if (is_array($config['allowed_action']) && in_array('quick_edit', $config['allowed_action']) !== FALSE) { ?>
                                                        <span style="cursor: pointer; width: 100%; display: block; min-height: 32px; border-radius: 4px; vertical-align: middle; background-color: wheat;" relId="<?= $table_tr[$config['tablePrimaryKey']]; ?>" relfield = "<?= $t_key ?>" onclick="quickEdit(this)" id="<?= $t_key . '-' . $table_tr[$config['tablePrimaryKey']] ?>" title="Click To Quick Edit">
                                                            <?= strip_tags($table_td) ?>
                                                        </span>
                                                    <?php } else { ?>
                                                        <?= strip_tags($table_td); ?>
                                                    <?php } ?>
                                                </td>

            <!--                                                        <td class="center"><?= strip_tags($table_td); ?></td>-->
                                            <?php endforeach; ?>

                                            <td class="center" style="white-space: nowrap;">
                                                <div class="btn-group btn-group-xs">
                                                    <?php if (is_array($config['allowed_action']) && in_array('view_detail', $config['allowed_action']) !== FALSE): ?>
                                                        <a class="btn btn-success" title="View" target="_blank" href="<?= console_url('sale/view_detail/' . base64_encode($table_tr['sale_invoice'])); ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (is_array($config['allowed_action']) && in_array('edit_detail', $config['allowed_action']) !== FALSE): ?>
                                                        <a class="btn btn-primary" title="Edit" target="_blank" href="<?= console_url('sale/edit_detail/' . base64_encode($table_tr['sale_invoice'])); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (is_array($config['allowed_action']) && in_array('sale_return', $config['allowed_action']) !== FALSE): ?>
                                                        <a class="btn btn-warning" title="Return" href="<?= console_url('sale/sale_return/' . base64_encode($table_tr['sale_invoice'])); ?>">
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (is_array($config['allowed_action']) && in_array('mail', $config['allowed_action']) !== FALSE): ?>
                                                        <a class="btn btn-info" title="Mail" href="javascript:void(0);" onclick="sentMail('<?= base64_encode($table_tr['sale_invoice']) ?>')">
                                                            <i class="fa fa-envelope"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a class="btn btn-default" title="Print" target="_blank" href="<?= console_url('sale/view_detail/' . base64_encode($table_tr['sale_invoice']) . '/print'); ?>">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                    <?php if (is_array($config['allowed_action']) && in_array('delete', $config['allowed_action']) !== FALSE): ?>
                                                        <a class="btn btn-danger" title="Delete" href="javascript:void(0);" onclick="popupDeleteSingle('<?= base64_encode($table_tr['sale_invoice']) ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>                          
                                </tbody>
                            </table>  
                        </div>
                    </form>    
                    <div class="box-footer clearfix">
                        <?= $this->pagination->create_links(); ?>
                    </div>  
                <?php else: ?>
                    <div class="alert alert-info" style="margin-bottom: 0;">
                        <i class="fa fa-info-circle"></i> No sales records found. Click <strong><a href="<?= console_url('sale/add_detail'); ?>" class="alert-link">Add Sale</a></strong> to create the first sale invoice.
                    </div>
                <?php endif; ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.table_view_wrapper -->

    <script>

        /**********************************************view operation***************************/
        /**
         *Preview single operations
         **/
        generateDetailedView = function (targetItem) {
            var viewSingleOperation = function (targetItem) {
                currentPostRequest = $.post(page_url + 'view_detail', {
                    entry: targetItem
                }, function (respData) {
                    if (respData != '') {

                        $('.index-wrapper').html(respData);
                        if ($('.br_det').length == 0)
                            $('.breadcrumb').append('<li class="br_det"><a href="javascript:void(0);">Details</a></li>');
                        postDetailLoad();
                    }
                }, 'html');
            }
            viewSingleOperation(targetItem);

        }

        /**********************************************view operation***************************/

        /**********************************************Edit operation***************************/
        /**
         *Edit single operations
         **/
        generateEditView = function (targetItem) {
            var loadEditForm = function (targetItem) {
                currentPostRequest = $.post(page_url + 'edit_detail', {
                    'load_edit_entry': targetItem
                }, function (respData) {
                    if (respData != '') {
                        $('.index-wrapper').html(respData);
                        if ($('.br_edt').length == 0)
                            $('.breadcrumb').append('<li class="br_edt"><a href="javascript:void(0);">Edit Detail</a></li>');
                        if (typeof $('.form-actions button.btn-primary').attr('onclick') == 'undefined') {
                            $('.form-actions button.btn-primary').attr('onclick', "saveOperation('edit')");
                        }
                        setTimeout(function () {
                            $('.iphone-toggle').iphoneStyle();
                            $('[data-rel="chosen"],[rel="chosen"]').chosen();
                            $('.datepicker').each(function () {

                                dateVal = $(this).val();
                                $(this).datepicker();
                                $(this).datepicker("option", "dateFormat", "yy-mm-dd");
                                $(this).datepicker("setDate", dateVal);
                            });

                            $('.datetimepicker').each(function () {
                                $(this).datetimepicker({format: 'Y-m-d H:i:s'});
                            });
                        }, 300);
                    }
                }, 'html');
            }

            loadEditForm(targetItem);
        }


        /**********************************************Edit operation***************************/

        /**********************************************add operation***************************/
        /**
         *Add single operations
         **/
        generateAddView = function (targetItem) {
            var loadAddForm = function () {
                currentPostRequest = $.post(page_url + 'add_detail', {
                    'load_add_entry': 'yes'
                }, function (respData) {
                    if (respData != '') {
                        $('.index-wrapper').html(respData);
                        if ($('.br_add').length == 0)
                            $('.breadcrumb').append('<li class="br_add"><a href="javascript:void(0);">Add Detail</a></li>');
                        if (typeof $('.form-actions button.btn-primary').attr('onclick') == 'undefined') {
                            $('.form-actions button.btn-primary').attr('onclick', "saveOperation('add')");
                        }
                        setTimeout(function () {
                            $('.iphone-toggle').iphoneStyle();
                            $('.chosen-select-deselect').chosen({
                                allow_single_deselect: true
                            });
                            $('[data-rel="chosen"],[rel="chosen"]').chosen();
                            $('.datepicker').each(function () {
                                dateVal = $(this).val();
                                $(this).datepicker();
                                $(this).datepicker("option", "dateFormat", "yy-mm-dd");
                                $(this).datepicker("setDate", dateVal);
                            });
                            $('.datetimepicker').each(function () {
                                $(this).datetimepicker({format: 'Y-m-d H:i:s'});
                            });
                        }, 300);
                    }
                }, 'html');
            }
            loadAddForm(targetItem);
        }

        /**********************************************Add operation***************************/



        /*save operation
         **/
        var saveOperation = function (method) {
            if (validate_form($('#addEditForm'),
                    {
                        beforeValidation: function (targetObject) {
                            $(targetObject).parent().parent('.control-group').removeClass('error');
                            $(targetObject).parent().parent('.control-group').find('.help-inline').html('');

                        },
                        onValidationError: function (targetObject, validationType) {
                            $(targetObject).parent().parent('.control-group').addClass('error');
                            switch (validationType) {
                                case 'required':
                                    $(targetObject).parent().parent('.control-group').find('.help-inline').html('This is Required!!');
                                    break;
                                default:
                                    $(targetObject).parent().parent('.control-group').find('.help-inline').html('Please Enter A valid Data');
                            }
                        },
                        captchaValidator: function (targetObject) {
                            return validate_captcha(targetObject);
                        },
                        duplicateValidator: function (targetObject) {
                            return duplicate_check(targetObject);
                        }

                    })) {
                var postUrl = '';
                if (method == 'add') {
                    postUrl = page_url + 'add_detail';
                }
                if (method == 'edit') {
                    postUrl = page_url + 'edit_detail';
                }
                currentPostRequest = $.post(postUrl, $('#addEditForm').serialize(), function (respData) {
                    if (respData.status = 'success') {

                        $('.modal-body p').html(respData.message);
                        $('#myModal').modal('show');
                        $('.modal-footer .btn-primary').removeClass('btn-danger btn-success').addClass('btn-success').attr('onclick', 'goBack();');

                        setTimeout(function () {
                            goBack();
                        }, 1000);
                        //
                    }
                }, 'json');
            }

        }

        /*****/


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


        var reorderTable = function () {

            $(".orderable").sortable({
                update: function (event, ui) {
                    var orderElements = [];
                    $(".orderable").children().each(function () {
                        orderElements.push($(this).attr('id').substring(4));
                    });

                    currentPostRequest = $.post(page_url + 'order_table', {
                        orderElements: orderElements
                    }, function (responce) {
                        console.log(responce);
                    }, 'json');
                }
            });
        }
        /**QUICK EDIT**/
        var quickEdit = function (targetItem) {
            $(targetItem).hide();
            $(targetItem).parent().append('<input type="text" value="' + $.trim($(targetItem).html()) + '">');
            var targetElement = $(targetItem).parent().find('input');
            $(targetElement).blur(function () {
                $(targetItem).html($(targetElement).val());
                currentPostRequest = $.post(page_url + 'quick_edit', {
                    targetItem: $(targetItem).attr('relfield')+'-'+$(targetItem).attr('relId'),
                    targetValue: $(targetElement).val(),
                }, function (respData) {
                   $(targetElement).remove();
                   $(targetItem).show();
                    console.log(respData);
                }, 'json');
            });
        }
        /**quickEdit***/
        /*sentMail*/
        	var sentMail = function(targetObject){
			currentPostRequest = $.post(page_url + 'mailInvoice', {invoice_id:targetObject}, function (responce) {		
				alert(responce.status);					
            },'json');
		}
		 /**sentMail***/
        
    </script>

</div>
