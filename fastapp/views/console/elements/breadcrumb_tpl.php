<section class="content-header" style="padding: 15px 15px 10px 15px; position: relative;">
    <h1 style="margin: 0; font-size: 24px; font-weight: 500; color: #333; display: inline-block;">
        <i class="fa fa-th-large text-primary" style="margin-right: 5px;"></i>
        <?= isset($table_meta['config']['title']) ? $table_meta['config']['title'] : (isset($title) ? $title : ucwords(str_replace('_', ' ', $this->uri->segment(2) ? $this->uri->segment(2) : 'Dashboard'))) ?>
    </h1>
    <ul class="breadcrumb pull-right" style="background: transparent; margin: 0; padding: 7px 5px; font-size: 13px;">
        <li><a href="<?= console_url('dashboard') ?>" style="color: #333;"><i class="fa fa-dashboard"></i> Home</a></li>
        <? if (isset($site_breadcrumb) && is_array($site_breadcrumb)): ?>
            <? foreach ($site_breadcrumb as $node_name => $node_link): ?>
                <li><a href="<?= $node_link ?>" style="color: #333;"><?= $node_name ?></a></li>
            <? endforeach; ?>
        <? endif; ?>
        <li class="active" style="color: #777;"><?= ucwords(str_replace('_', ' ', $this->uri->segment(2) ? $this->uri->segment(2) : 'Dashboard')) ?></li>
        <li style="margin-left: 10px;">
            <button class="btn btn-default btn-xs" onclick="goBack();" title="Go Back"><i class="fa fa-arrow-left"></i> Back</button>
        </li>
    </ul>
    <div class="clearfix"></div>
</section>
<script>
    function goBack() {
        if (typeof $('ul.breadcrumb li:nth-last-child(3)').children('a').attr('href') != 'undefined')
            window.location.href = $('ul.breadcrumb li:nth-last-child(3)').children('a').attr('href');
        else
            window.history.back();
    }
</script>