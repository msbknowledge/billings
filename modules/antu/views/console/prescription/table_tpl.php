<div class="content-wrapper-inner" style="padding: 15px;">
    <!-- Stat Summary Badges -->
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-purple" style="border-radius: 8px 0 0 8px;"><i class="fa fa-file-text-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Prescriptions</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['total']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-yellow" style="border-radius: 8px 0 0 8px;"><i class="fa fa-hourglass-half"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending Review</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['pending']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-blue" style="border-radius: 8px 0 0 8px;"><i class="fa fa-check-square-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Verified & Active</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['verified']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-green" style="border-radius: 8px 0 0 8px;"><i class="fa fa-medkit"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Dispensed</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['dispensed']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card Box -->
    <div class="box box-primary" style="box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-radius: 8px;">
        <div class="box-header with-border" style="padding: 15px;">
            <h3 class="box-title" style="font-size: 18px; font-weight: 700;">
                <i class="fa fa-file-text-o text-primary" style="margin-right: 8px;"></i> Uploaded Customer Prescriptions
            </h3>
            <div class="box-tools pull-right" style="top: 10px;">
                <form method="get" action="<?= console_url('prescription') ?>" class="form-inline" style="display: inline-block;">
                    <div class="form-group" style="margin-right: 5px;">
                        <select name="status" class="form-control input-sm" onchange="this.form.submit()" style="border-radius: 4px;">
                            <option value="all" <?= ($status_filter == 'all' || empty($status_filter)) ? 'selected' : '' ?>>All Statuses</option>
                            <option value="Pending Pharmacist Review" <?= ($status_filter == 'Pending Pharmacist Review') ? 'selected' : '' ?>>Pending Review</option>
                            <option value="Verified & Processed" <?= ($status_filter == 'Verified & Processed') ? 'selected' : '' ?>>Verified & Processed</option>
                            <option value="Medicine Dispensed" <?= ($status_filter == 'Medicine Dispensed') ? 'selected' : '' ?>>Medicine Dispensed</option>
                            <option value="Rejected" <?= ($status_filter == 'Rejected') ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <input type="text" name="search" class="form-control pull-right" placeholder="Search patient name, phone..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-hover table-striped" style="vertical-align: middle; margin-bottom: 0;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-size: 13px;">
                            <th style="padding: 12px 15px;">Token / ID</th>
                            <th>Patient Name</th>
                            <th>Contact Phone</th>
                            <th>Address & Notes</th>
                            <th>Prescription Document</th>
                            <th>Review Status</th>
                            <th>Upload Date</th>
                            <th style="text-align: right; padding-right: 15px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? if (!empty($prescriptions)): ?>
                            <? foreach ($prescriptions as $rx): ?>
                                <?
                                $status = $rx['status'] ?? 'Pending Pharmacist Review';
                                $badgeClass = 'label-warning';
                                if ($status === 'Verified & Processed') $badgeClass = 'label-info';
                                elseif ($status === 'Medicine Dispensed') $badgeClass = 'label-success';
                                elseif ($status === 'Rejected') $badgeClass = 'label-danger';

                                $fileUrl = base_url('uploads/prescriptions/' . $rx['prescription_file']);
                                $isPdf = strtolower(pathinfo($rx['prescription_file'], PATHINFO_EXTENSION)) === 'pdf';
                                ?>
                                <tr style="font-size: 13px;">
                                    <td style="padding: 12px 15px; font-weight: 700; color: #7c3aed;">
                                        RX-<?= date('Y', strtotime($rx['created_at'])) ?>-<?= str_pad($rx['id'], 5, '0', STR_PAD_LEFT) ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($rx['patient_name']) ?></strong>
                                    </td>
                                    <td>
                                        <a href="tel:<?= htmlspecialchars($rx['phone']) ?>" style="color: #334155;">
                                            <i class="fa fa-phone text-muted" style="margin-right: 4px;"></i><?= htmlspecialchars($rx['phone']) ?>
                                        </a>
                                        <? if (!empty($rx['email'])): ?>
                                            <div style="font-size: 11px; color: #94a3b8;"><?= htmlspecialchars($rx['email']) ?></div>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($rx['address'] ?: 'No address specified') ?></div>
                                        <? if (!empty($rx['notes'])): ?>
                                            <div style="font-size: 12px; color: #64748b; font-style: italic;">"<?= htmlspecialchars($rx['notes']) ?>"</div>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <? if (!empty($rx['prescription_file'])): ?>
                                            <? if ($isPdf): ?>
                                                <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-default btn-xs" style="color: #b91c1c; font-weight: 600;">
                                                    <i class="fa fa-file-pdf-o"></i> View PDF File
                                                </a>
                                            <? else: ?>
                                                <a href="javascript:void(0);" onclick="previewRxImage('<?= $fileUrl ?>', '<?= htmlspecialchars($rx['patient_name'], ENT_QUOTES, 'UTF-8') ?>')" style="display: inline-block;">
                                                    <img src="<?= $fileUrl ?>" alt="RX" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                                </a>
                                            <? endif; ?>
                                        <? else: ?>
                                            <span class="text-muted">No file</span>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs dropdown-toggle <?= str_replace('label-', 'btn-', $badgeClass) ?>" data-toggle="dropdown" style="font-size: 11px; font-weight: 600; border-radius: 12px; padding: 2px 10px;">
                                                <?= htmlspecialchars($status) ?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0);" onclick="updateRxStatus(<?= $rx['id'] ?>, 'Pending Pharmacist Review')"><span class="label label-warning">Pending Review</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateRxStatus(<?= $rx['id'] ?>, 'Verified & Processed')"><span class="label label-info">Verified & Processed</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateRxStatus(<?= $rx['id'] ?>, 'Medicine Dispensed')"><span class="label label-success">Medicine Dispensed</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:void(0);" onclick="updateRxStatus(<?= $rx['id'] ?>, 'Rejected')"><span class="label label-danger">Rejected</span></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td style="color: #64748b; font-size: 12px;">
                                        <?= date('d M Y, h:i A', strtotime($rx['created_at'])) ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 15px;">
                                        <? if (!empty($rx['prescription_file'])): ?>
                                            <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-default btn-xs" title="Open Full Prescription File" style="margin-right: 3px;">
                                                <i class="fa fa-external-link text-primary"></i>
                                            </a>
                                        <? endif; ?>
                                        <a href="<?= console_url('prescription/delete/' . $rx['id']) ?>" onclick="return confirm('Are you sure you want to delete this prescription?');" class="btn btn-default btn-xs" title="Delete Record">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        <? else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa fa-file-text-o" style="font-size: 40px; margin-bottom: 12px; opacity: 0.4;"></i>
                                    <p style="font-size: 15px; margin: 0;">No prescription uploads found.</p>
                                </td>
                            </tr>
                        <? endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Prescription Preview Modal -->
<div class="modal fade" id="rxPreviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #7c3aed; color: #fff; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.9;">&times;</button>
                <h4 class="modal-title" id="rxModalTitle"><i class="fa fa-image"></i> Prescription Document Preview</h4>
            </div>
            <div class="modal-body" style="text-align: center; padding: 20px; background: #0f172a;">
                <img id="rxModalImage" src="" alt="Prescription Preview" style="max-width: 100%; max-height: 75vh; border-radius: 4px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
            </div>
            <div class="modal-footer">
                <a id="rxModalDownloadBtn" href="" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Open / Download Full Resolution</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function previewRxImage(url, patientName) {
    document.getElementById('rxModalImage').src = url;
    document.getElementById('rxModalDownloadBtn').href = url;
    document.getElementById('rxModalTitle').innerHTML = '<i class="fa fa-image"></i> Prescription: ' + patientName;
    $('#rxPreviewModal').modal('show');
}

function updateRxStatus(id, status) {
    $.post('<?= console_url("prescription/update_status") ?>', {id: id, status: status}, function(res) {
        window.location.reload();
    });
}
</script>
