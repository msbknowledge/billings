<?php if (isset($searchFields) && !empty($searchFields)) : ?>
<div class="box box-primary search_box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-filter"></i> Search &amp; Filter Criteria</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <form class="search-table-form form-horizontal" method="post" onsubmit="return false;">
            <div class="row">
                <?php foreach ($searchFields as $searchField) : 
                    $cleanLabel = ucwords(str_replace('_', ' ', str_replace(
                        array_keys(isset($this->page_config['replace_text']) ? $this->page_config['replace_text'] : array()), 
                        array_values(isset($this->page_config['replace_text']) ? $this->page_config['replace_text'] : array()), 
                        $searchField
                    )));
                ?>
                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 12px;">
                        <label class="control-label" style="text-align: left; margin-bottom: 4px; font-weight: 600; display: block;" for="search_<?= $searchField ?>"><?= $cleanLabel ?></label>

                        <?php
                        // Status Columns
                        if (isset($table_meta['config']['use_status_columns']) && is_array($table_meta['config']['use_status_columns'])) {
                            $arr_index = array_search($searchField, $table_meta['config']['use_status_columns']);
                            if ($arr_index !== FALSE) {
                        ?>
                                <select name="<?= $searchField ?>" id="search_<?= $searchField ?>" class="form-control">
                                    <option value="">-- All Status --</option>
                                    <option value="1">Active / On</option>
                                    <option value="0">Inactive / Off</option>
                                </select>
                    </div>
                        <?php
                                continue;
                            }
                        }

                        // Dropdown Columns
                        if (isset($table_meta['config']['use_dropdown_columns_options'])) {
                            $arr_index = array_key_exists($searchField, $table_meta['config']['use_dropdown_columns_options']);
                            if ($arr_index !== FALSE) {
                                $choosenValue = isset($default_search_value[$searchField]) ? $default_search_value[$searchField] : null;
                        ?>
                                <select name="<?= $searchField ?>" id="search_<?= $searchField ?>" class="form-control select2" style="width: 100%;">
                                    <option value="">-- All / Select <?= $cleanLabel ?> --</option>
                                    <?php
                                    $optionList = (isset($table_meta['config']['use_dropdown_columns_options'][$searchField]) ? $table_meta['config']['use_dropdown_columns_options'][$searchField] : $table_meta['config']['use_dropdown_columns_options']);
                                    if (is_array($optionList)) {
                                        foreach ($optionList as $optkey => $optvalue) :
                                    ?>
                                        <option <?php if ($optkey === $choosenValue) echo 'selected="selected"'; ?> value="<?= $optkey ?>"><?= $optvalue ?></option>
                                    <?php 
                                        endforeach; 
                                    }
                                    ?>
                                </select>
                    </div>
                        <?php
                                continue;
                            }
                        }

                        // Datepicker Columns
                        if (isset($table_meta['config']['datepicker_columns']) && is_array($table_meta['config']['datepicker_columns'])) {
                            $arr_index = array_search($searchField, $table_meta['config']['datepicker_columns']);
                            if ($arr_index !== FALSE) {
                        ?>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control datepicker" id="search_<?= $searchField ?>" name="<?= $searchField ?>" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                    </div>
                        <?php
                                continue;
                            }
                        }

                        // Datetimepicker Columns
                        if (isset($table_meta['config']['datetimepicker_columns']) && is_array($table_meta['config']['datetimepicker_columns'])) {
                            $arr_index = array_search($searchField, $table_meta['config']['datetimepicker_columns']);
                            if ($arr_index !== FALSE) {
                        ?>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control datetimepicker" id="search_<?= $searchField ?>" name="<?= $searchField ?>" placeholder="YYYY-MM-DD HH:mm" autocomplete="off">
                                </div>
                    </div>
                        <?php
                                continue;
                            }
                        }
                        ?>

                        <div class="input-group">
                            <input type="text" class="form-control" id="search_<?= $searchField ?>" name="<?= $searchField ?>" placeholder="Search <?= strtolower($cleanLabel) ?>...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="if(typeof initSearch === 'function') initSearch();"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right" style="margin-top: 10px;">
                    <button type="button" class="btn btn-sm btn-primary" onclick="if(typeof initSearch === 'function') initSearch();">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <button type="button" class="btn btn-sm btn-default" onclick="$('.search-table-form')[0].reset(); if($('.select2').length){ $('.select2').val('').trigger('change'); } if(typeof initSearch === 'function') initSearch();">
                        <i class="fa fa-refresh"></i> Reset Filters
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>