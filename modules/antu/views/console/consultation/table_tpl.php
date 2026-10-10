<div class="content-wrapper-inner" style="padding: 15px;">
    <!-- Stat Summary Badges -->
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-teal" style="border-radius: 8px 0 0 8px;"><i class="fa fa-user-md"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Consultations</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['total']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-yellow" style="border-radius: 8px 0 0 8px;"><i class="fa fa-bell-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">New Requests</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['requested']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-blue" style="border-radius: 8px 0 0 8px;"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Scheduled</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['scheduled']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-green" style="border-radius: 8px 0 0 8px;"><i class="fa fa-check-circle-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Completed</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['completed']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card Box -->
    <div class="box box-primary" style="box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-radius: 8px;">
        <div class="box-header with-border" style="padding: 15px;">
            <h3 class="box-title" style="font-size: 18px; font-weight: 700;">
                <i class="fa fa-user-md text-primary" style="margin-right: 8px;"></i> Doctor Consultation Bookings
            </h3>
            <div class="box-tools pull-right" style="top: 10px;">
                <form method="get" action="<?= console_url('consultation') ?>" class="form-inline" style="display: inline-block;">
                    <div class="form-group" style="margin-right: 5px;">
                        <select name="status" class="form-control input-sm" onchange="this.form.submit()" style="border-radius: 4px;">
                            <option value="all" <?= ($status_filter == 'all' || empty($status_filter)) ? 'selected' : '' ?>>All Statuses</option>
                            <option value="Requested" <?= ($status_filter == 'Requested') ? 'selected' : '' ?>>Requested</option>
                            <option value="Scheduled" <?= ($status_filter == 'Scheduled') ? 'selected' : '' ?>>Scheduled</option>
                            <option value="Completed" <?= ($status_filter == 'Completed') ? 'selected' : '' ?>>Completed</option>
                            <option value="Cancelled" <?= ($status_filter == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <input type="text" name="search" class="form-control pull-right" placeholder="Search patient, doctor, dept..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
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
                            <th>Specialty / Department</th>
                            <th>Assigned Doctor</th>
                            <th>Preferred Date & Slot</th>
                            <th>Status</th>
                            <th>Booking Date</th>
                            <th style="text-align: right; padding-right: 15px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? if (!empty($consultations)): ?>
                            <? foreach ($consultations as $item): ?>
                                <?
                                $status = $item['status'] ?? 'Requested';
                                $badgeClass = 'label-warning';
                                if ($status === 'Scheduled') $badgeClass = 'label-primary';
                                elseif ($status === 'Completed') $badgeClass = 'label-success';
                                elseif ($status === 'Cancelled') $badgeClass = 'label-danger';
                                ?>
                                <tr style="font-size: 13px;">
                                    <td style="padding: 12px 15px; font-weight: 700; color: #0d9488;">
                                        MED-APT-<?= str_pad($item['id'], 4, '0', STR_PAD_LEFT) ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($item['patient_name']) ?></strong>
                                    </td>
                                    <td>
                                        <a href="tel:<?= htmlspecialchars($item['phone']) ?>" style="color: #334155;">
                                            <i class="fa fa-phone text-muted" style="margin-right: 4px;"></i><?= htmlspecialchars($item['phone']) ?>
                                        </a>
                                        <? if (!empty($item['email'])): ?>
                                            <div style="font-size: 11px; color: #94a3b8;"><?= htmlspecialchars($item['email']) ?></div>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 600;"><?= htmlspecialchars($item['department'] ?: 'General Medicine') ?></span>
                                    </td>
                                    <td>
                                        <? if (!empty($item['assigned_doctor_name'])): ?>
                                            <span style="font-weight: 600; color: #047857;"><i class="fa fa-stethoscope"></i> Dr. <?= htmlspecialchars($item['assigned_doctor_name']) ?></span>
                                        <? else: ?>
                                            <button class="btn btn-default btn-xs" onclick="openAssignModal(<?= $item['id'] ?>, <?= intval($item['doctor_id']) ?>)">
                                                <i class="fa fa-plus"></i> Assign Doctor
                                            </button>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #1e293b;"><i class="fa fa-calendar-o text-muted"></i> <?= date('d M Y', strtotime($item['preferred_date'])) ?></div>
                                        <div style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($item['preferred_time']) ?></div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs dropdown-toggle <?= str_replace('label-', 'btn-', $badgeClass) ?>" data-toggle="dropdown" style="font-size: 11px; font-weight: 600; border-radius: 12px; padding: 2px 10px;">
                                                <?= htmlspecialchars($status) ?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0);" onclick="updateConsultationStatus(<?= $item['id'] ?>, 'Requested')"><span class="label label-warning">Requested</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateConsultationStatus(<?= $item['id'] ?>, 'Scheduled')"><span class="label label-primary">Scheduled</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateConsultationStatus(<?= $item['id'] ?>, 'Completed')"><span class="label label-success">Completed</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:void(0);" onclick="updateConsultationStatus(<?= $item['id'] ?>, 'Cancelled')"><span class="label label-danger">Cancelled</span></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td style="color: #64748b; font-size: 12px;">
                                        <?= date('d M Y, h:i A', strtotime($item['created_at'])) ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 15px;">
                                        <button class="btn btn-default btn-xs" title="Assign / Reassign Doctor" onclick="openAssignModal(<?= $item['id'] ?>, <?= intval($item['doctor_id']) ?>)" style="margin-right: 3px;">
                                            <i class="fa fa-user-md text-primary"></i>
                                        </button>
                                        <a href="<?= console_url('consultation/delete/' . $item['id']) ?>" onclick="return confirm('Are you sure you want to delete this appointment?');" class="btn btn-default btn-xs" title="Delete Booking">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        <? else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa fa-user-md" style="font-size: 40px; margin-bottom: 12px; opacity: 0.4;"></i>
                                    <p style="font-size: 15px; margin: 0;">No consultation bookings found.</p>
                                </td>
                            </tr>
                        <? endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Assign Doctor Modal -->
<div class="modal fade" id="assignDoctorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <form method="post" action="<?= console_url('consultation/assign_doctor') ?>">
                <input type="hidden" name="id" id="assignConsultationId" value="">
                <div class="modal-header" style="background: #0d9488; color: #fff; border-radius: 8px 8px 0 0;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.9;">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-user-md"></i> Assign Specialist Doctor</h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group">
                        <label>Select Doctor from Staff Directory:</label>
                        <select name="doctor_id" id="assignDoctorSelect" class="form-control" required>
                            <option value="">-- Choose Doctor --</option>
                            <? foreach ($doctors as $doc): ?>
                                <option value="<?= $doc['doctor_ID'] ?>">Dr. <?= htmlspecialchars($doc['doctor_name']) ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                    <p class="text-muted" style="font-size: 12px;">Assigning a doctor will automatically update the appointment status to <strong>Scheduled</strong>.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="background: #0d9488; border-color: #0d9488;"><i class="fa fa-check"></i> Save & Confirm Slot</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAssignModal(id, currentDoctorId) {
    document.getElementById('assignConsultationId').value = id;
    if (currentDoctorId > 0) {
        document.getElementById('assignDoctorSelect').value = currentDoctorId;
    } else {
        document.getElementById('assignDoctorSelect').value = '';
    }
    $('#assignDoctorModal').modal('show');
}

function updateConsultationStatus(id, status) {
    $.post('<?= console_url("consultation/update_status") ?>', {id: id, status: status}, function(res) {
        window.location.reload();
    });
}
</script>
