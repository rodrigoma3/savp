<section class="content invoice" style="color: #333;">

    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <h2 class="page-header">
                <?php echo Configure::read('Parameter.System.system_name'); ?>
            </h2>
            <b><?php echo __('Patient: '); ?></b><?php echo $stop['Patient']['name']; ?><br>
            <b><?php echo __('Document: '); ?></b><?php echo $stop['Patient']['document']; ?><br>
            <b><?php echo __('Companion Name: '); ?></b><?php echo (isset($stop['Companion']['name'])) ? $stop['Companion']['name'] : ''; ?><br>
            <b><?php echo __('Companion Document: '); ?></b><?php echo (isset($stop['Companion']['document'])) ? $stop['Companion']['document'] : ''; ?><br>
            <b><?php echo __('Destination: '); ?></b><?php echo $cities[$stop['Diary']['Destination']['city_id']]; ?><br>
            <b><?php echo __('Establishment: '); ?></b><?php echo $stop['Establishment']['name']; ?><br>
            <b><?php echo __('Date: '); ?></b><?php echo date('d/m/Y', strtotime($stop['Diary']['date'])); ?><br>
            <b><?php echo __('Time: '); ?></b><?php echo $stop['Diary']['Destination']['time']; ?><br>
            <b><?php echo __('Departure: '); ?></b><?php echo ($stop['Stop']['bedridden']) ? $stop['Patient']['address'].', '.$stop['Patient']['number'].' - '.$stop['Patient']['neighborhood'].' - '.$cities[$stop['Patient']['city_id']] : Configure::read('Parameter.System.starting_address'); ?><br>
            <b><?php echo __('Scheduler: '); ?></b><?php echo $this->Session->read('Auth.User.name').' - '.$this->Session->read('Auth.User.document'); ?><br>
            <b><?php echo __('Emission: '); ?></b><?php echo date('d/m/Y H:i'); ?>
        </div><!-- /.col -->
    </div><!-- /.row -->


    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> <?php echo __('Print'); ?></button>
        </div>
    </div>
</section>

<!-- /*<style type="text/css" media="print">
    @page { size: landscape; }
</style>*/ -->
<script type="text/javascript">
    window.print();
</script>
