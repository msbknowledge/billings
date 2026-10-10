<div class="row">
    <div class="col-md-4 col-sm-5 col-xs-12">
        <div class="box box-primary">
            <div class="box-body box-profile text-center" style="padding: 25px 15px;">
                <img class="profile-user-img img-responsive img-circle" style="width: 110px; height: 110px; margin: 0 auto; object-fit: cover; border: 3px solid #3c8dbc; box-shadow: 0 2px 6px rgba(0,0,0,0.15);" 
                     src="<?= (!empty($table_meta['data']['user_image']) ? (!empty($table_meta['config']['use_image_columns_path'][0]) ? $table_meta['config']['use_image_columns_path'][0] : '' ) . $table_meta['data']['user_image'] : cdn_url() . 'uploads/noImage.jpg'); ?>" 
                     alt="<?= html_escape($table_meta['data']['user_firstname']) ?>">
                
                <h3 class="profile-username" style="margin-top: 15px; margin-bottom: 5px; font-weight: 600;">
                    <?= htmlspecialchars_decode($table_meta['data']['user_firstname'] . ' ' . $table_meta['data']['user_lastname']) ?>
                </h3>
                
                <p class="text-muted" style="margin-bottom: 15px;">
                    <i class="fa fa-envelope-o"></i> <?= htmlspecialchars_decode($table_meta['data']['user_email']) ?>
                </p>

                <button class="btn btn-primary btn-block" onclick="editProfile()">
                    <i class="fa fa-pencil"></i> <b>Edit Profile Details</b>
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-7 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> Profile Information</h3>
            </div>
            <div class="box-body" style="padding: 0;">
                <table class="table table-striped table-bordered detail-view-table" style="margin-bottom: 0;">
                    <tbody>
                        <tr>    
                            <th style="width: 30%; background: #f9fbfd;"><i class="fa fa-id-card-o text-muted"></i> Full Name</th>                    
                            <td><?= htmlspecialchars_decode($table_meta['data']['user_firstname'] . ' ' . $table_meta['data']['user_lastname']) ?></td>
                        </tr>
                        <tr>    
                            <th style="background: #f9fbfd;"><i class="fa fa-envelope text-muted"></i> E-mail Address</th>                    
                            <td><?= htmlspecialchars_decode($table_meta['data']['user_email']) ?></td>
                        </tr>
                        <tr>    
                            <th style="background: #f9fbfd;"><i class="fa fa-map-marker text-muted"></i> Address</th>                    
                            <td><?= !empty($table_meta['data']['user_address']) ? htmlspecialchars_decode($table_meta['data']['user_address']) : '<span class="text-muted"><em>Not specified</em></span>' ?></td>
                        </tr>
                        <tr>    
                            <th style="background: #f9fbfd;"><i class="fa fa-info-circle text-muted"></i> Bio / Description</th>                    
                            <td><?= !empty($table_meta['data']['user_description']) ? htmlspecialchars_decode($table_meta['data']['user_description']) : '<span class="text-muted"><em>None</em></span>' ?></td>
                        </tr>
                    </tbody>
                </table>                          
            </div>
            <div class="box-footer text-right">
                <button class="btn btn-info" onclick="editProfile()">
                    <i class="fa fa-edit"></i> Edit Profile
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    /* Save profile operation */
    var saveOperation = function(method) {
        if (typeof validate_form === 'function' && !validate_form($('#addEditForm'), {
            beforeValidation: function(targetObject) {
                $(targetObject).closest('.form-group, .control-group').removeClass('has-error error');
                $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html('');
            },
            onValidationError: function(targetObject, validationType) {
                $(targetObject).closest('.form-group, .control-group').addClass('has-error error');
                var msg = (validationType === 'required') ? 'This field is required.' : 'Please enter valid data.';
                $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html(msg);
            }
        })) {
            return false;
        }

        currentPostRequest = $.post(page_url + 'edit_profile', $('#addEditForm').serialize(), function(respData) {
            if (respData && respData.status === 'success') {
                if (typeof toastr !== 'undefined') {
                    toastr.success(respData.message || 'Profile updated successfully!');
                } else {
                    alert(respData.message || 'Profile updated successfully!');
                }
                setTimeout(function() {
                    if (typeof goBack === 'function') goBack();
                }, 1000);
            } else {
                var err = (respData && respData.message) ? respData.message : 'Error updating profile.';
                if (typeof toastr !== 'undefined') {
                    toastr.error(err);
                } else {
                    alert(err);
                }
            }
        }, 'json');
    };

    /* Edit single profile */
    editProfile = function(targetItem) {
        currentPostRequest = $.post(page_url + 'edit_profile', {
            'load_edit_entry': ''
        }, function(respData) {
            if (respData) {
                $('.index-wrapper').html(respData);
                $('.breadcrumb').append('<li><a href="javascript:void(0);">Edit Profile</a></li>');
                var $btn = $('.box-footer button.btn-primary, .form-actions button.btn-primary');
                if ($btn.length && typeof $btn.attr('onclick') === 'undefined') {
                    $btn.attr('onclick', "saveOperation('edit')");
                }
                if (typeof initDatePickers === 'function') {
                    initDatePickers();
                }
                if (typeof $.fn.select2 !== 'undefined') {
                    $('.select2').select2();
                }
            }
        }, 'html');
    };
</script>