<div class="content-wrapper-inner" style="padding: 15px;">
    <? if ($saved): ?>
        <div class="alert alert-success alert-dismissible" style="border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Configuration Saved!</h4>
            Frontend portal settings have been updated successfully and are now live on the homepage.
        </div>
    <? endif; ?>

    <div class="row">
        <!-- Main Form Column -->
        <div class="col-md-8">
            <div class="box box-primary" style="box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-radius: 8px;">
                <div class="box-header with-border" style="padding: 15px;">
                    <h3 class="box-title" style="font-size: 18px; font-weight: 700;">
                        <i class="fa fa-cogs text-primary" style="margin-right: 8px;"></i> Frontend Portal CMS & Contact Settings
                    </h3>
                </div>

                <form method="post" action="<?= console_url('frontend_settings') ?>" class="form-horizontal">
                    <div class="box-body" style="padding: 20px;">
                        
                        <!-- Section 1: Branding -->
                        <h4 style="font-size: 15px; font-weight: 700; color: #0284c7; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 20px;">
                            <i class="fa fa-globe"></i> 1. Website Branding & Titles
                        </h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Portal Title</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_site_title" class="form-control" value="<?= htmlspecialchars($settings['frontend_site_title']) ?>" required>
                                <span class="help-block" style="font-size: 12px;">Appears in browser tab and SEO title tags.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Announcement Bar</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_announcement" class="form-control" value="<?= htmlspecialchars($settings['frontend_announcement']) ?>">
                                <span class="help-block" style="font-size: 12px;">Appears in the top alert banner on the frontend homepage.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Express Delivery Tag</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_delivery_badge" class="form-control" value="<?= htmlspecialchars($settings['frontend_delivery_badge']) ?>">
                                <span class="help-block" style="font-size: 12px;">e.g., Express 2-Hour Doorstep Delivery</span>
                            </div>
                        </div>

                        <!-- Section 2: Contact & Emergency -->
                        <h4 style="font-size: 15px; font-weight: 700; color: #0284c7; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-top: 30px; margin-bottom: 20px;">
                            <i class="fa fa-phone"></i> 2. Helpline & Emergency Helplines
                        </h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pharmacy Helpline</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_helpline" class="form-control" value="<?= htmlspecialchars($settings['frontend_helpline']) ?>" required>
                                <span class="help-block" style="font-size: 12px;">Primary call button in header & footer (e.g. +91 98300 12345).</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Emergency Helpline</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_emergency" class="form-control" value="<?= htmlspecialchars($settings['frontend_emergency']) ?>">
                                <span class="help-block" style="font-size: 12px;">24x7 Ambulance & Hospital helpline (e.g. 108 / 1800-200-6334).</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">WhatsApp Number</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_whatsapp" class="form-control" value="<?= htmlspecialchars($settings['frontend_whatsapp']) ?>" required>
                                <span class="help-block" style="font-size: 12px;">For floating WhatsApp chat button (include country code without spaces, e.g. +919830012345).</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Support Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="frontend_email" class="form-control" value="<?= htmlspecialchars($settings['frontend_email']) ?>">
                            </div>
                        </div>

                        <!-- Section 3: Location & Operating Hours -->
                        <h4 style="font-size: 15px; font-weight: 700; color: #0284c7; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-top: 30px; margin-bottom: 20px;">
                            <i class="fa fa-map-marker"></i> 3. Physical Store Location & Timing
                        </h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Store Address</label>
                            <div class="col-sm-9">
                                <textarea name="frontend_address" rows="2" class="form-control"><?= htmlspecialchars($settings['frontend_address']) ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Open Hours</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_open_hours" class="form-control" value="<?= htmlspecialchars($settings['frontend_open_hours']) ?>">
                                <span class="help-block" style="font-size: 12px;">e.g., 24 / 7 or 8:00 AM - 11:00 PM</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Customer Counter</label>
                            <div class="col-sm-9">
                                <input type="text" name="frontend_stat_customers" class="form-control" value="<?= htmlspecialchars($settings['frontend_stat_customers']) ?>">
                                <span class="help-block" style="font-size: 12px;">Statistic shown in hero section (e.g. 25,000+).</span>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer" style="padding: 15px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 24px; font-weight: 600;">
                            <i class="fa fa-save" style="margin-right: 6px;"></i> Save & Publish Changes
                        </button>
                        <a href="<?= base_url() ?>" target="_blank" class="btn btn-default pull-right" style="padding: 8px 18px;">
                            <i class="fa fa-external-link"></i> View Live Homepage
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info & Quick Links -->
        <div class="col-md-4">
            <div class="box box-info" style="box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-radius: 8px;">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-size: 16px; font-weight: 700;"><i class="fa fa-info-circle text-info"></i> Portal Overview</h3>
                </div>
                <div class="box-body" style="font-size: 13px; line-height: 1.6; color: #475569;">
                    <p>This panel gives you complete control over your customer-facing digital pharmacy portal.</p>
                    <ul style="padding-left: 20px; margin-bottom: 15px;">
                        <li><strong>Instant Sync:</strong> Changes saved here immediately update the website without restarting Apache or clearing browser cache.</li>
                        <li><strong>Customer Orders:</strong> View and manage customer medicine requests in the <a href="<?= console_url('customer_order') ?>">Online Orders</a> tab.</li>
                        <li><strong>Uploaded Prescriptions:</strong> Review prescription files uploaded by customers in <a href="<?= console_url('prescription') ?>">Prescriptions</a>.</li>
                        <li><strong>Doctor Appointments:</strong> Manage consultation slots in <a href="<?= console_url('consultation') ?>">Doctor Bookings</a>.</li>
                    </ul>
                    <a href="<?= base_url() ?>" target="_blank" class="btn btn-block btn-info" style="font-weight: 600;">
                        <i class="fa fa-globe"></i> Open Customer Portal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
