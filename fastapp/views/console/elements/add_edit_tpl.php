<style>
    .ui-autocomplete-loading {
        background: white url('data:image/gif;base64,R0lGODlhEAAQAPMPALu7u5mZmTMzM93d3REREQAAAHd3d1VVVWZmZqqqqoiIiO7u7kRERCIiIgARAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFBwAPACwAAAAAEAAQAEAEcPDJtyg6dUrFetDTIopMoSyFcxxD1krD8AwCkASDIlPaUDQLR6G1Cy0SgqIkE1IQGMrFAKCcGWSBzwPAnAwarcKQ15MpTMJYd1ZyUDXSDGelBY0qIoBh/ZoYGgELCjoxCRRvIQcGD1kzgSAgAACQDxEAIfkEBQcADwAsAAAAAA8AEAAABF3wyfkMkotOJpscRKJJwtI4Q1MAoxQ0RFBw0xEvhGAVRZZJh4JgMAEQW7TWI4EwGFjKR+CAQECjn8DoN0kwDtvBT8FILAKJgfoo1iAGAPNVY9DGJXNMIHN/HJVqIxEAIfkEBQcADwAsAAAAABAADwAABFrwyfmColgiydpaQiY5x9Ith7hURdIl0wBIhpCAjKIIxaAUPQ0hFQsAC7MJALFSFi4SgC4wyHyuCYNWxH3AuhSEotkNGAALAPqqkigG8MWAjAnM4A8594vPUyIAIfkEBQcADwAsAAAAABAAEAAABF3wySkDvdKsddg+APYIWrcg2DIRQAcU6DJICjIsjBEETLEEBYLqYSDdJoCGiHgZwG4LQCCRECEIBAdoF5hdEIWwgBJqDs7DgcKyRHZl3uUwuhm2AbNNW+LV7yd+FxEAIfkEBQcACAAsAAAAABAADgAABEYQyYmMoVgeWQrP3NYhBCgZBdAFRUkdBIAUguVVo1ZsWFcEGB5GMBkEjiCBL2a5ZAi+m2SAURExwKqPiuCafBkvBSCcmiYRACH5BAUHAA4ALAAAAAAQABAAAARs0MnpAKDYrbSWMp0xZIvBKYrXjNmADOhAKBiQDF5gGcICNAyJTwFYTBaDQ0HAkgwSmAUj0OkMrkZM4HBgKK7YTKDRICAo2clAEIheKc9CISjEVTuEQrJASGcSBQcSUFEUDQUXJBgDBW0Zj34RACH5BAUHAA8ALAAAAAAQABAAAARf8Mn5xqBYgrVC4EEmBcOSfAEjSopJMglmcQlgBYjE5NJgZwjCAbO4YBAJjpIjSiAQh5ayyRAIDKvJIbnIagoFRFdkQDQKC0RBsCIUFAWsT7RwG410R8HiiK0WBwJjFBEAIfkEBQcADgAsAQABAA8ADwAABFrQybEWADXJLUHHAMJxIDAgnrOo2+AOibEMh1LN62gIxphzitRoCDAYNcNN6FBLShao4WzwHDQKvVGhoFAwGgtFgQHENhoB7nCwHRAIC0EyUcC8Zw1ha3NIRgAAIfkEBQcADwAsAAAAABAAEAAABGDwyfnWoljaNYYFV+Zx3hCEGEcuypBtMJBISpClAWLfWODymIFiCJwMDMiZBNAAYFqUAaNQ2E0YBIXGURAMCo1AAsFYBBoIScBJEwgSVcmP0li4FwcHz+FpCCQMPCFINxEAIfkEBQcADgAsAAABABAADwAABFzQyemWXYNqaSXY2vVtw3UNmROM4JQowKKlFOsgRI6ASQ8IhSADFAjAMIMAgSYJtByxyQIhcEoaBcSiwegpDgvAwSBJ0AIHBoCQqIAEi/TCIAABGhLG8MbcKBQgEQAh+QQFBwAPACwAAAEAEAAPAAAEXfDJSd+qeK5RB8fDRRWFspyotAAfQBbfNLCVUSSdKDV89gDAwcFBIBgywMRnkWBgcJUDKSZRIKAPQcGwYByAAYTEEJAAJIGbATEQ+B4ExmK9CDhBd8ThdHw/AmUYEQAh+QQFBwAPACwAAAEADwAPAAAEXvBJQIa8+ILSspdHkXxS9wxF4Q3L2aTBeC0sFjhAtuyLIjAMhYc2GBgaSKGuyNoBDp7czFAgeBIKwC6kWCAMxUSAFjtNCAAFGGF5tCQLAaJnWCTqHoREvQuQJAkyGBEAOw==')
        right center no-repeat;
    }

    /* Select2 Multi-Select Choices / Badges UI Fix */
    .select2-container--default .select2-selection--multiple {
        background-color: #ffffff !important;
        border: 1px solid #d2d6de !important;
        border-radius: 4px !important;
        min-height: 34px !important;
        padding: 2px 6px !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3c8dbc !important;
        outline: 0 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3c8dbc !important;
        border: 1px solid #367fa9 !important;
        border-radius: 3px !important;
        color: #ffffff !important;
        padding: 3px 8px 3px 6px !important;
        margin: 3px 5px 3px 0 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 18px !important;
        display: inline-block !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #ffffff !important;
        font-size: 14px !important;
        font-weight: bold !important;
        margin-right: 6px !important;
        margin-left: 0 !important;
        cursor: pointer !important;
        display: inline-block !important;
        opacity: 0.8 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
        color: #333333 !important;
        font-size: 13px !important;
        margin-top: 3px !important;
        padding: 0 4px !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3c8dbc !important;
        color: #ffffff !important;
    }
</style>
<?php
error_reporting(4);

/**
 * add_edit view helper functions modernized for Bootstrap 3 / AdminLTE
 */
if (!function_exists('field_label')) {
    function field_label($t_key = NULL, $table_meta = array()) {
        if (isset($table_meta['config']['replace_text'][$t_key])) {
            return $table_meta['config']['replace_text'][$t_key];
        }
        $ci =& get_instance();
        if (isset($ci->page_config['replace_text'][$t_key])) {
            return $ci->page_config['replace_text'][$t_key];
        }
        return ucwords(str_replace('_', ' ', $t_key));
    }
}

if (!function_exists('field_datepicker')) {
    function field_datepicker($t_key = NULL, $table_meta, $table_td) {
        if (isset($table_meta['config']['datepicker_columns']) && is_array($table_meta['config']['datepicker_columns'])) {
            $arr_index = array_search($t_key, $table_meta['config']['datepicker_columns']);
            if ($arr_index !== FALSE) {
                ?> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="<?= $t_key ?>"><?= field_label($t_key, $table_meta) ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="<?= $t_key ?>" id="<?= $t_key ?>" value="<?= html_escape($table_td) ?>" autocomplete="off">
                        </div>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <?php
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('field_date_time_picker')) {
    function field_date_time_picker($t_key = NULL, $table_meta, $table_td) {
        if (isset($table_meta['config']['datetimepicker_columns']) && is_array($table_meta['config']['datetimepicker_columns'])) {
            $arr_index = array_search($t_key, $table_meta['config']['datetimepicker_columns']);
            if ($arr_index !== FALSE) {
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="<?= $t_key ?>"><?= field_label($t_key, $table_meta) ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datetimepicker" name="<?= $t_key ?>" id="<?= $t_key ?>" value="<?= html_escape($table_td) ?>" autocomplete="off">
                        </div>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <?php
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('field_status')) {
    function field_status($t_key, $table_meta, $table_td) {
        if (isset($table_meta['config']['use_status_columns']) && is_array($table_meta['config']['use_status_columns'])) {
            if (in_array($t_key, $table_meta['config']['use_status_columns']) === TRUE) {
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="<?= $t_key ?>" style="display:block;"><?= ucfirst(str_replace('_', ' ', $t_key)) ?></label>
                        <label class="checkbox-inline" style="padding-top: 5px; font-weight: 500;">
                            <input name="<?= $t_key ?>" type="checkbox" class="minimal" <?= intval($table_td) ? 'checked="checked"' : '' ?> value="1">
                            <?= intval($table_td) ? '<span class="label label-success">Active / Enabled</span>' : '<span class="label label-default">Inactive / Disabled</span>' ?>
                        </label>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <?php
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('field_textarea')) {
    function field_textarea($t_key = NULL, $table_meta, $table_td) {
        if (isset($table_meta['config']['textarea_columns']) && is_array($table_meta['config']['textarea_columns'])) {
            $arr_index = array_search($t_key, $table_meta['config']['textarea_columns']);
            if ($arr_index !== FALSE) {
                ?>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="<?= $t_key ?>"><?= field_label($t_key, $table_meta) ?></label>
                        <textarea class="form-control" name="<?= $t_key ?>" id="textarea_<?= $t_key ?>" rows="4"><?= html_escape($table_td) ?></textarea>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <?php
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('is_primry_key')) {
    function is_primry_key($t_key = NULL, $table_meta) {
        if (isset($table_meta['config']['tablePrimaryKey']) && $table_meta['config']['tablePrimaryKey'] == $t_key)
            return TRUE;
        return FALSE;
    }
}

if (!function_exists('field_image')) {
    function field_image($t_key = NULL, $table_meta, $table_td) {
        if (isset($table_meta['config']['use_image_columns']) && is_array($table_meta['config']['use_image_columns'])) {
            $arr_index = array_search($t_key, $table_meta['config']['use_image_columns']);
            if ($arr_index !== FALSE) {
                $img_path = (!empty($table_meta['config']['use_image_columns_path'][0]) ? $table_meta['config']['use_image_columns_path'][0] : '');
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="<?= $t_key ?>"><?= field_label($t_key, $table_meta) ?></label>
                        <div style="margin-bottom: 6px;">
                            <img id="file_uploader_image<?= $t_key ?>" class="file_uploaded_img img-thumbnail" style="max-height: 120px;" src="<?= $table_td ? $img_path . $table_td : cdn_url() . 'uploads/noImage.jpg'; ?>" alt="<?= html_escape($table_td) ?>"/>
                        </div>
                        <input type="hidden" id="file_uploader_field<?= $t_key ?>" name="<?= $t_key ?>" value="<?= html_escape($table_td) ?>"/>
                        <input type="file" id="file_uploader<?= $t_key ?>" class="form-control" />
                        <span class="help-block text-danger"></span>
                    </div>

                    <script>
                        if (typeof $.fn.uploadify !== 'undefined') {
                            $('#file_uploader<?= $t_key ?>').uploadify({
                                'swf': '<?= cdn_url() ?>js/uploadify.swf',
                                'uploader': '<?= cdn_url() ?>uploader/',
                                'multi': <?= isset($table_meta['config']['multi_upload']) ? $table_meta['config']['multi_upload'] : 'false' ?>,
                                'onUploadSuccess': function (file, data, response) {
                                    $('#file_uploader_image<?= $t_key ?>').attr('src', '<?= $img_path ?>' + $.trim(data));
                                    $('#file_uploader_field<?= $t_key ?>').val($.trim(data));
                                }
                            });
                        }
                    </script>
                </div>
                <?php
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('field_dropdown')) {
    function field_dropdown($t_key = NULL, $table_meta, $table_td) {
        if (isset($table_meta['config']['use_dropdown_columns_options']) && is_array($table_meta['config']['use_dropdown_columns_options'])) {
            $arr_index = array_key_exists($t_key, $table_meta['config']['use_dropdown_columns_options']);
            if ($arr_index !== FALSE) {
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="<?= $t_key ?>"><?= field_label($t_key, $table_meta) ?></label>
                        <select class="form-control select2" style="width: 100%;" <?= (function_exists('is_readonly') && is_readonly($t_key, isset($table_meta['config']['readonly_columns']) ? $table_meta['config']['readonly_columns'] : array())) ? 'disabled="disabled"' : '' ?>
                            <?= isset($table_meta['config']['use_dropdown_columns_options']['multi'][$t_key]) ? " multiple=\"multiple\" name='" . $t_key . "[]' data-placeholder='Select " . field_label($t_key, $table_meta) . "'" : " name='$t_key'" ?> id="<?= $t_key ?>">
                            <?php if (!isset($table_meta['config']['use_dropdown_columns_options']['multi'][$t_key])): ?>
                            <option value="">-- Choose <?= field_label($t_key, $table_meta) ?> --</option>
                            <?php endif; ?>
                            <?php
                            $optionList = (isset($table_meta['config']['use_dropdown_columns_options'][$t_key]) ? $table_meta['config']['use_dropdown_columns_options'][$t_key] : $table_meta['config']['use_dropdown_columns_options']);
                            if (is_array($optionList)) {
                                foreach ($optionList as $optkey => $optvalue):
                                    $isSelected = false;
                                    if (isset($table_meta['config']['use_dropdown_columns_options']['multi'][$t_key])) {
                                        $decoded = is_array($table_td) ? $table_td : json_decode($table_td, TRUE);
                                        if (!is_array($decoded)) {
                                            $decoded = !empty($table_td) ? array_map('trim', explode(',', $table_td)) : array();
                                        }
                                        if (in_array((string)$optkey, array_map('strval', $decoded))) {
                                            $isSelected = true;
                                        }
                                    } else {
                                        if ((string)$optkey === (string)$table_td) {
                                            $isSelected = true;
                                        }
                                    }
                            ?>
                                    <option value="<?= $optkey ?>" <?= $isSelected ? 'selected="selected"' : '' ?>><?= $optvalue ?></option>
                            <?php 
                                endforeach; 
                            }
                            ?>
                        </select>
                        <span class="help-block text-danger"></span>
                    </div>
                </div>
                <?php
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('field_text')) {
    function field_text($t_key = NULL, $table_meta, $table_td) {
        $isReadOnly = (function_exists('is_readonly') && is_readonly($t_key, $table_meta)) || is_primry_key($t_key, $table_meta);
        ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label class="control-label" for="<?= $t_key ?>"><?= field_label($t_key, $table_meta) ?></label>
                <input type="text" class="form-control" <?= $isReadOnly ? 'readonly="readonly"' : '' ?> name="<?= $t_key ?>" id="<?= $t_key ?>" value="<?= html_escape($table_td) ?>" autocomplete="off">
                <span class="help-block text-danger"></span>
            </div>
        </div>
        <?php
    }
}
?>

<form id="addEditForm" method="post" action="save_details" onsubmit="return false">
    <div class="row">
        <?php if (isset($table_meta['data']) && is_array($table_meta['data'])): ?>
            <?php foreach ($table_meta['data'] as $t_key => $table_td): ?>
                <?php
                $field_value = is_array($table_td) ? '' : $table_td;

                if (field_status($t_key, $table_meta, $field_value))
                    continue;
                if (field_image($t_key, $table_meta, $field_value))
                    continue;
                if (field_dropdown($t_key, $table_meta, $field_value))
                    continue;
                if (field_textarea($t_key, $table_meta, $field_value))
                    continue;
                if (field_datepicker($t_key, $table_meta, $field_value))
                    continue;
                if (field_date_time_picker($t_key, $table_meta, $field_value))
                    continue;
                field_text($t_key, $table_meta, $field_value);
                ?>
            <?php endforeach; ?> 
        <?php endif; ?>
    </div>
    
    <div class="box-footer text-right" style="margin-top: 15px; border-top: 1px solid #f4f4f4; padding-top: 12px;">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="if(typeof goBack === 'function'){ goBack(); }"><i class="fa fa-times"></i> Cancel</button>
    </div>    
</form>

<script>
    if (typeof validationMeta === 'undefined') {
        var validationMeta = <?= isset($table_meta['config']['validation']) ? json_encode($table_meta['config']['validation']) : '{}' ?>;
    }
    
    $.each(validationMeta, function (key, value) {
        $('#addEditForm').find('[name="' + key + '"]').attr('from-validation', value);
    });

    $(document).ready(function() {
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').each(function() {
                var opts = { width: '100%' };
                if ($(this).attr('multiple')) {
                    opts.tags = true;
                }
                $(this).select2(opts);
            });
        }
        if (typeof initDatePickers === 'function') {
            initDatePickers();
        }
    });

    <?php if (isset($this) && isset($this->page_config['autocomplete'])): ?>
        var autoComplete = <?= json_encode($this->page_config['autocomplete']); ?>;
        $.each(autoComplete, function (targetField, value) {
            $.each(value, function (model, fieldToSearch) {
                $('[name="' + targetField + '"]').autocomplete({
                    source: page_url + "autocomplete/" + model + '/' + fieldToSearch,
                    minLength: 1
                });
            });
        });
    <?php endif; ?>

    $(function () {
        if ($('[name="payment_invoice"]').length && !$('[name="payment_invoice"]').val()) {
            $('[name="payment_invoice"]').val('<?= function_exists("generate_invoice_number") ? generate_invoice_number() : "INV" . time() ?>').prop('readonly', true);
        }
    });
</script>
