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
            <h3 class="box-title"><i class="fa fa-truck text-primary"></i> <?= !empty($table_meta['config']['title']) ? $table_meta['config']['title'] : 'Purchase' ?></h3>
            <div class="box-tools pull-right">
                <?php if (is_array($config['allowed_action']) && in_array('add_detail', $config['allowed_action']) !== FALSE): ?>
                    <a href="<?= console_url('purchase/add_detail'); ?>" class="btn btn-primary btn-sm" id="btn_add_purchase">
                        <i class="fa fa-plus"></i> Add Purchase
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

                    <div class="table-responsive scrollgard" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                                <tr style="background: #f4f6f9;">
                                    <?php if ($config['enable_ordering']): ?>
                                        <th style="width: 40px; text-align: center;">Order</th>
                                    <?php endif; ?>
                                    <?php $th_key = 0; ?>
                                    <?php if ($config['tablePrimaryKey']): ?>
                                        <?php if (is_array($config['allowed_action']) && in_array('delete', $config['allowed_action']) !== FALSE): ?>
                                            <th style="width: 40px; text-align: center;">Choose</th>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php foreach ($table_headers as $table_th): ?>
                                        <?php
                                        if ($table_allowed_header < ++$th_key) {
                                            break;
                                        } else {
                                            if (is_array($config['list_columns']) && in_array($table_th, $config['list_columns']) === FALSE) {
                                                continue;
                                            }
                                        }
                                        ?>
                                        <th class="sortable_th" data-rel="<?= $table_th ?>" style="cursor: pointer; white-space: nowrap;">
                                            <?= ucwords(str_replace('_', ' ', (str_replace(array_keys($this->page_config['replace_text']), array_values($this->page_config['replace_text']), $table_th)))) ?>
                                            <i data-rel="<?= $table_th ?>" class="fa fa-sort pull-right text-muted shorter" style="cursor: pointer; margin-top: 3px;" title="Click to Sort"></i>
                                        </th>
                                    <?php endforeach; ?>
                                    <th style="text-align: center; min-width: 140px;">Action</th> 
                                </tr>
                            </thead> 
                            <?php if ($config['enable_ordering']): ?>
                                <tbody class="orderable">
                            <?php else: ?>
                                <tbody>
                            <?php endif; ?>
                                <?php foreach ($table_meta['data'] as $table_tr): ?>
                                    <?php if ($config['tablePrimaryKey']): ?>    
                                        <tr id="row_<?= $table_tr[$config['tablePrimaryKey']] ?>">
                                    <?php else: ?>
                                        <tr>
                                    <?php endif; ?>
                                        <?php if ($config['enable_ordering']): ?>
                                            <td class="text-center" style="cursor: move;"><i class="fa fa-arrows text-muted"></i></td>    
                                        <?php endif; ?>
                                        <?php $td_key = 0; ?>
                                        <?php if ($config['tablePrimaryKey']): ?>
                                            <?php if (is_array($config['allowed_action']) && in_array('delete', $config['allowed_action']) !== FALSE): ?>
                                                <td class="text-center">
                                                    <input class="selectedItem" type="checkbox" value="<?= base64_encode($table_tr['purchase_entry_number']); ?>" name="selectedItem[]">
                                                </td> 
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php foreach ($table_tr as $t_key => $table_td): ?>
                                            <?php
                                            if ($table_allowed_header < ++$td_key) {
                                                break;
                                            } else {
                                                if (is_array($config['list_columns']) && in_array($t_key, $config['list_columns']) === FALSE) {
                                                    continue;
                                                }

                                                if (is_array($config['use_status_columns']) && in_array($t_key, $config['use_status_columns']) === TRUE) {
                                                    ?> 
                                                    <td class="text-center">                                                                                          
                                                        <?php switch (intval($table_td)) {
                                                            case 1:
                                                                echo '<span class="label label-success">Active</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="label label-danger">Inactive</span>';
                                                        } ?>
                                                    </td>
                                                    <?php
                                                    continue;
                                                }

                                                if (is_array($config['use_dropdown_columns_options']) && array_key_exists($t_key, $config['use_dropdown_columns_options']) === TRUE) {
                                                    ?> 
                                                    <td>                                                                                          
                                                        <?php
                                                        if (isset($config['use_dropdown_columns_options']['multi'][$t_key])) {
                                                            $decoded = json_decode($table_td, TRUE);
                                                            if (is_array($decoded)) {
                                                                $labels = array();
                                                                foreach ($decoded as $m_value) {
                                                                    if (isset($config['use_dropdown_columns_options'][$t_key][$m_value])) {
                                                                        $labels[] = '<span class="badge bg-aqua">' . htmlspecialchars($config['use_dropdown_columns_options'][$t_key][$m_value]) . '</span>';
                                                                    }
                                                                }
                                                                echo implode(' ', $labels);
                                                            }
                                                        } else {
                                                            echo isset($config['use_dropdown_columns_options'][$t_key][$table_td]) ? htmlspecialchars($config['use_dropdown_columns_options'][$t_key][$table_td]) : 'N/A';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    continue;
                                                }

                                                if (is_array($config['use_image_columns']) && in_array($t_key, $config['use_image_columns']) !== FALSE) {
                                                    $img_src = $table_td ? ($config['use_image_columns_path'][0] ? $config['use_image_columns_path'][0] : '') . $table_td : cdn_url() . 'uploads/noImage.jpg';
                                                    ?> 
                                                    <td class="text-center"> 
                                                        <a href="<?= $img_src ?>" target="_blank">
                                                            <img class="img-thumbnail" style="max-height: 40px;" src="<?= $img_src ?>" alt="<?= htmlspecialchars($table_td) ?>"/>
                                                        </a>
                                                    </td>
                                                    <?php
                                                    continue;
                                                }
                                            }
                                            ?>
                                            <td>
                                                <?php if (is_array($config['allowed_action']) && in_array('quick_edit', $config['allowed_action']) !== FALSE): ?>
                                                    <span style="cursor: pointer; width: 100%; display: block; min-height: 24px;" relId="<?= $table_tr[$config['tablePrimaryKey']]; ?>" relfield="<?= $t_key ?>" onclick="quickEdit(this)" id="<?= $t_key . '-' . $table_tr[$config['tablePrimaryKey']] ?>" title="Click To Quick Edit">
                                                        <?= strip_tags($table_td) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <?= strip_tags($table_td); ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                                                   
                                        <td class="text-center" style="white-space: nowrap;">
                                            <?php if (is_array($config['allowed_action']) && in_array('view_detail', $config['allowed_action']) !== FALSE): ?>
                                                <a class="btn btn-default btn-xs" title="View Details" data-toggle="tooltip" target="_blank" href="<?= console_url('purchase/view_detail/' . base64_encode($table_tr['purchase_entry_number'])); ?>">
                                                    <i class="fa fa-eye text-primary"></i>  
                                                </a>
                                            <?php endif; ?>
                                            <?php if (is_array($config['allowed_action']) && in_array('edit_detail', $config['allowed_action']) !== FALSE): ?>
                                                <a class="btn btn-default btn-xs" title="Edit Purchase" data-toggle="tooltip" target="_blank" href="<?= console_url('purchase/edit_detail/' . base64_encode($table_tr['purchase_entry_number'])); ?>">
                                                    <i class="fa fa-pencil text-warning"></i>  
                                                </a>
                                            <?php endif; ?>
                                            <?php if (is_array($config['allowed_action']) && in_array('delete', $config['allowed_action']) !== FALSE): ?>
                                                <a class="btn btn-default btn-xs" title="Delete Purchase" data-toggle="tooltip" href="javascript:void(0);" onclick="popupDeleteSingle('<?= base64_encode($table_tr['purchase_entry_number']) ?>')">
                                                    <i class="fa fa-trash text-danger"></i> 
                                                </a>
                                            <?php endif; ?>
                                            <?php if (is_array($config['allowed_action']) && in_array('purchase_return', $config['allowed_action']) !== FALSE): ?>
                                                <a class="btn btn-default btn-xs" title="Purchase Return" data-toggle="tooltip" href="<?= console_url('purchase/purchase_return/' . base64_encode($table_tr['purchase_entry_number'])); ?>">
                                                    <i class="fa fa-reply text-info"></i> 
                                                </a>
                                            <?php endif; ?>
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
                    <i class="fa fa-info-circle"></i> No purchase records found.
                    <?php if (is_array($config['allowed_action']) && in_array('add_detail', $config['allowed_action']) !== FALSE): ?>
                        Click <a href="<?= console_url('purchase/add_detail'); ?>" class="btn btn-primary btn-xs" style="margin-left: 5px;"><i class="fa fa-plus"></i> Add Purchase</a> to create a new entry.
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        var section = 'purchases_model';

        /***************** View Detail *****************/
        generateDetailedView = function (targetItem) {
            currentPostRequest = $.post(page_url + 'view_detail', { entry: targetItem }, function (respData) {
                if (respData != '') {
                    $('.index-wrapper').html(respData);
                    if ($('.br_det').length == 0) {
                        $('.breadcrumb').append('<li class="br_det"><a href="javascript:void(0);">Details</a></li>');
                    }
                    if (typeof postDetailLoad === 'function') postDetailLoad();
                }
            }, 'html');
        };

        /***************** Edit Detail *****************/
        generateEditView = function (targetItem) {
            currentPostRequest = $.post(page_url + 'edit_detail', { 'load_edit_entry': targetItem }, function (respData) {
                if (respData != '') {
                    $('.index-wrapper').html(respData);
                    if ($('.br_edt').length == 0) {
                        $('.breadcrumb').append('<li class="br_edt"><a href="javascript:void(0);">Edit Detail</a></li>');
                    }
                    if (typeof $('.form-actions button.btn-primary').attr('onclick') == 'undefined') {
                        $('.form-actions button.btn-primary').attr('onclick', "saveOperation('edit')");
                    }
                    if (typeof initDatePickers === 'function') initDatePickers();
                    if (typeof $.fn.select2 !== 'undefined') $('.select2').select2();
                }
            }, 'html');
        };

        /***************** Add Detail *****************/
        generateAddView = function (targetItem) {
            currentPostRequest = $.post(page_url + 'add_detail', { 'load_add_entry': 'yes' }, function (respData) {
                if (respData != '') {
                    $('.index-wrapper').html(respData);
                    if ($('.br_add').length == 0) {
                        $('.breadcrumb').append('<li class="br_add"><a href="javascript:void(0);">Add Detail</a></li>');
                    }
                    if (typeof $('.form-actions button.btn-primary').attr('onclick') == 'undefined') {
                        $('.form-actions button.btn-primary').attr('onclick', "saveOperation('add')");
                    }
                    if (typeof initDatePickers === 'function') initDatePickers();
                    if (typeof $.fn.select2 !== 'undefined') $('.select2').select2();
                }
            }, 'html');
        };

        /***************** Save Operation *****************/
        var saveOperation = function (method) {
            if (typeof validate_form === 'function' && !validate_form($('#addEditForm'), {
                beforeValidation: function (targetObject) {
                    $(targetObject).closest('.form-group, .control-group').removeClass('has-error error');
                    $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html('');
                },
                onValidationError: function (targetObject, validationType) {
                    $(targetObject).closest('.form-group, .control-group').addClass('has-error error');
                    var msg = (validationType === 'required') ? 'This field is required.' : 'Please enter valid data.';
                    $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html(msg);
                }
            })) {
                return false;
            }

            var postUrl = (method == 'add') ? page_url + 'add_detail' : page_url + 'edit_detail';
            currentPostRequest = $.post(postUrl, $('#addEditForm').serialize(), function (respData) {
                if (respData && respData.status === 'success') {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(respData.message || 'Saved successfully!');
                    } else {
                        alert(respData.message || 'Saved successfully!');
                    }
                    setTimeout(function () {
                        if (typeof goBack === 'function') goBack();
                    }, 1000);
                } else {
                    var err = (respData && respData.message) ? respData.message : 'Error saving record.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(err);
                    } else {
                        alert(err);
                    }
                }
            }, 'json');
        };

        /***************** Reorder Table *****************/
        var reorderTable = function () {
            if (typeof $.fn.sortable !== 'undefined') {
                $(".orderable").sortable({
                    update: function (event, ui) {
                        var orderElements = [];
                        $(".orderable").children().each(function () {
                            orderElements.push($(this).attr('id').substring(4));
                        });
                        currentPostRequest = $.post(page_url + 'order_table', { orderElements: orderElements }, function (responce) {}, 'json');
                    }
                });
            }
        };

        /***************** Quick Edit *****************/
        var quickEdit = function (targetItem) {
            $(targetItem).hide();
            $(targetItem).parent().append('<input type="text" class="form-control input-sm" value="' + $.trim($(targetItem).html()) + '">');
            var targetElement = $(targetItem).parent().find('input');
            targetElement.focus();
            $(targetElement).blur(function () {
                $(targetItem).html($(targetElement).val());
                currentPostRequest = $.post(page_url + 'quick_edit', {
                    targetItem: $(targetItem).attr('relfield') + '-' + $(targetItem).attr('relId'),
                    targetValue: $(targetElement).val()
                }, function (respData) {
                    $(targetElement).remove();
                    $(targetItem).show();
                }, 'json');
            });
        };

        $(document).ready(function() {
            if (typeof setSorting === 'function') setSorting();
            if (typeof initDatePickers === 'function') initDatePickers();
        });
    </script>
</div>