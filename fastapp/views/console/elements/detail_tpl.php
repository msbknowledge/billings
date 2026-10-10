<table class="table table-bordered table-striped table-hover detail-view-table" style="margin-bottom: 0;">
    <thead>
        <tr style="background: #f4f6f9;">
            <th style="width: 32%;">Field Name</th>           
            <th>Details / Value</th> 
        </tr>
    </thead>   
    <tbody>
        <?php if (isset($table_meta['data']) && is_array($table_meta['data'])): ?>
            <?php foreach ($table_meta['data'] as $t_key => $table_td): ?>
                <tr>    
                    <td style="font-weight: 600; color: #555; vertical-align: middle;">
                        <?= ucfirst(str_replace('_', ' ', $t_key)) ?>
                    </td>                    
                    <?php
                    // Status Columns
                    if (isset($table_meta['config']['use_status_columns']) && is_array($table_meta['config']['use_status_columns'])) {
                        if (in_array($t_key, $table_meta['config']['use_status_columns']) === TRUE) {
                    ?> 
                            <td style="vertical-align: middle;">                                                                                          
                                <?php if (intval($table_td) === 1): ?>
                                    <span class="label label-success"><i class="fa fa-check"></i> Enabled / Active</span>
                                <?php else: ?>
                                    <span class="label label-danger"><i class="fa fa-times"></i> Disabled / Inactive</span>
                                <?php endif; ?>
                            </td>
                    <?php
                            continue;
                        }
                    }

                    // Dropdown Options
                    if (isset($table_meta['config']['use_dropdown_columns_options']) && is_array($table_meta['config']['use_dropdown_columns_options'])) {
                        if (array_key_exists($t_key, $table_meta['config']['use_dropdown_columns_options']) === TRUE) {
                    ?> 
                            <td style="vertical-align: middle;">    
                                <?php 
                                if (isset($table_meta['config']['use_dropdown_columns_options']['multi'][$t_key])) {
                                    $decoded = json_decode($table_td, TRUE);
                                    if (is_array($decoded)) {
                                        $labels = array();
                                        foreach ($decoded as $m_value) {
                                            if (isset($table_meta['config']['use_dropdown_columns_options'][$t_key][$m_value])) {
                                                $labels[] = '<span class="badge bg-aqua">' . htmlspecialchars($table_meta['config']['use_dropdown_columns_options'][$t_key][$m_value]) . '</span>';
                                            }
                                        }
                                        echo implode(' ', $labels);
                                    } else {
                                        echo 'N/A';
                                    }
                                } else {
                                    echo isset($table_meta['config']['use_dropdown_columns_options'][$t_key][$table_td]) 
                                        ? htmlspecialchars($table_meta['config']['use_dropdown_columns_options'][$t_key][$table_td]) 
                                        : 'N/A';
                                }
                                ?>
                            </td>
                    <?php
                            continue;
                        }
                    }
                    
                    // Image Columns
                    if (isset($table_meta['config']['use_image_columns']) && is_array($table_meta['config']['use_image_columns'])) {
                        $arr_index = array_search($t_key, $table_meta['config']['use_image_columns']);
                        if ($arr_index !== FALSE) {
                            $img_src = $table_td ? ($table_meta['config']['use_image_columns_path'][0] ? $table_meta['config']['use_image_columns_path'][0] : '' ) . $table_td : cdn_url() . 'uploads/noImage.jpg';
                    ?> 
                            <td style="vertical-align: middle;"> 
                                <a href="<?= $img_src ?>" target="_blank" title="View Full Image">
                                    <img class="img-thumbnail" style="max-height: 120px; max-width: 200px; box-shadow: 0 1px 3px rgba(0,0,0,0.12);" src="<?= $img_src ?>" alt="<?= htmlspecialchars($table_td) ?>"/>
                                </a>
                            </td>
                    <?php
                            continue;
                        }
                    }
                    ?>
                    <td style="vertical-align: middle; word-break: break-word;">
                        <?= (is_scalar($table_td) && strlen($table_td) > 0) ? htmlspecialchars_decode($table_td) : '<span class="text-muted"><em>None</em></span>' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
