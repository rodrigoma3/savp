<section class="content invoice" style="color: #333;">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> <?php echo $diary['Destination']['City']['name'].' - '.$diary['Diary']['date'].' - '.$diary['Destination']['time']; ?>
                <small class="pull-right"><?php echo __('Emission: %s', date('d/m/Y')); ?></small>
            </h2>
        </div><!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <b><?php echo __('Car model: '); ?></b><?php echo $diary['Car']['model']; ?><br>
            <b><?php echo __('Car plate: '); ?></b><?php echo $diary['Car']['car_plate']; ?><br>
            <b><?php echo __('Driver name: '); ?></b><?php echo $diary['Driver']['name']; ?><br>
            <b><?php echo __('Driver document: '); ?></b><?php echo $diary['Driver']['document']; ?>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <?php if (empty($diary['Stop'])): ?>
                <p>
                    <?php echo __('No scheduled stops'); ?>
                </p>
            <?php else: ?>
                <?php $companions = Hash::combine($diary['Stop'], '{n}.companion_id', '{n}.Patient.name'); ?>
                <?php $diary['Stop'] = Hash::sort($diary['Stop'], '{n}.sequence', 'asc', 'numeric'); ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo __('Name'); ?></th>
                            <th><?php echo __('Document'); ?></th>
                            <th><?php echo __('Companion of the'); ?></th>
                            <th><?php echo __('Establishment'); ?></th>
                            <th><?php echo __('Start Time'); ?></th>
                            <th><?php echo __('End Time'); ?></th>
                            <th><?php echo __('Absent'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($diary['Stop'] as $stop): ?>
                            <tr>
                                <td><?php echo h($stop['Patient']['name']); ?></td>
                                <td><?php echo h($stop['Patient']['document']); ?></td>
                                <?php if (isset($companions[$stop['patient_id']]) && !empty($companions[$stop['patient_id']])): ?>
                                    <td><?php echo h($companions[$stop['patient_id']]); ?></td>
                                <?php else: ?>
                                    <td>&nbsp;</td>
                                <?php endif; ?>
                                <td><?php echo h($stop['Establishment']['name']); ?></td>
                                <td><?php echo h($stop['start_time']); ?></td>
                                <td><?php echo h($stop['end_time']); ?></td>
                                <td><i class="fa fa-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
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
