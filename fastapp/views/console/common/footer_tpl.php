<? if ($current_user_session) { ?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Main Footer (Smart School Style) -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>&copy; <?= date('Y') ?> <a href="<?= base_url() ?>"><?= isset($site_settings['site_setting_title']) ? $site_settings['site_setting_title'] : 'MsbBillings' ?></a>.</strong> All rights reserved.
        </footer>
    </div><!-- /.wrapper -->
<? } else { ?>
    </div><!-- /#content -->
<? } ?>

<!-- Standard Application Modals (Bootstrap 3 / AdminLTE) -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Settings</h4>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subscription_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Subscription</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Form</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formAddEditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Record</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Details</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================
     Backend JavaScript Libraries (from assets/backend)
     ================================================== -->
<script src="<?= base_url(); ?>assets/backend/dist/js/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/datepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url(); ?>assets/backend/dist/js/jquery-ui.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/toast-alert/toastr.js"></script>
<script src="<?= base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/plugins/select2/select2.full.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/dist/js/app.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/dist/js/nprogress.js"></script>
<script src="<?= base_url(); ?>assets/backend/dist/js/dropify.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/dist/js/bootstrap-select.min.js"></script>
<script src="<?= base_url(); ?>js/jquery.cookie.js"></script>

<!-- FastApp Console Application Scripts -->
<script src="<?= base_url(); ?>assets/backend/custom/fastapp.js"></script>

<script type="text/javascript">
    $(function () {
        if ($.fn.selectpicker) {
            $('.languageselectpicker').selectpicker();
        }
    });

    function set_languages(lang_id) {
        if (typeof toastr !== 'undefined') {
            toastr.success("Language preference updated.");
        }
    }

    function markc(id) {
        if (typeof toastr !== 'undefined') {
            toastr.info("Task marked complete.");
        }
    }
</script>

<!-- Multi Branch Switch Modal -->
<div class="modal fade" id="multiBranchSwitchModal" tabindex="-1" role="dialog" aria-labelledby="multiBranchSwitchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="multiBranchSwitchModalLabel"><i class="fa fa-exchange"></i> Switch Branch</h4>
            </div>
            <div class="modal-body">
                <ul class="list-group" style="margin-bottom:0;">
                    <li class="list-group-item active"><i class="fa fa-check-circle"></i> <strong>Main Branch</strong> (Current)</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<? execute_hook('footer'); ?>
</body>
</html>
