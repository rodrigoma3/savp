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
            <b><?php echo __('Driver name: '); ?></b><?php echo $diary['Driver']['name']; ?><br>
            <b><?php echo __('Driver document: '); ?></b><?php echo $diary['Driver']['document']; ?>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b><?php echo __('Car model: '); ?></b><?php echo $diary['Car']['model']; ?><br>
            <b><?php echo __('Car plate: '); ?></b><?php echo $diary['Car']['car_plate']; ?>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b><?php echo __('Initial KM: '); ?></b><?php echo $diary['Diary']['initial_km']; ?><br>
            <b><?php echo __('Final KM: '); ?></b>__________________
        </div><!-- /.col -->
    </div><!-- /.row -->
    <br>
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
                <table class="table table-striped center">
                    <thead>
                        <tr>
                            <th class="center"><?php echo __('#'); ?></th>
                            <th class="center"><?php echo __('Name'); ?></th>
                            <th class="center"><?php echo __('Document'); ?></th>
                            <th class="center"><?php echo __('Companion of the'); ?></th>
                            <th class="center"><?php echo __('Establishment'); ?></th>
                            <th class="center"><?php echo __('Start Time'); ?></th>
                            <th class="center"><?php echo __('End Time'); ?></th>
                            <th class="center"><?php echo __('Bedridden'); ?></th>
                            <th class="center"><?php echo __('Absent'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($diary['Stop'] as $stop): ?>
                            <tr>
                                <td><?php echo $count; ?></td>
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
                                <?php if ((!isset($companions[$stop['patient_id']]) || empty($companions[$stop['patient_id']])) && $stop['bedridden']): ?>
                                    <td><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
                                <?php else: ?>
                                    <td><i class="fa fa-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
                                <?php endif; ?>
                                <td><i class="fa fa-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
                            </tr>
                            <?php $count++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
        <div class="col-xs-12 center">
            <!-- <small><?php //echo __('Visitor scheduling system of the Health Department of Bento Gonçalves'); ?></small> -->
            <small><?php echo __('report printed by %s', Configure::read('Parameter.System.system_name')); ?></small>
        </div><!-- /.col -->
    </div>

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
