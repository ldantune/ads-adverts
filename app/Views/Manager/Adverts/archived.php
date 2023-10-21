<?= $this->extend('Manager/Layout/main'); ?>

<?php $this->section('title') ?>

<?php echo lang('Adverts.title_index'); ?>

<?= $this->endSection(); ?>


<?php $this->section('styles') ?>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.css" />


<?= $this->endSection(); ?>


<?= $this->section('content') ?>


<!-- Container Start -->
<div class="container-fluid">
    <!-- Row Start -->
    <div class="row">

        <div class="col-md-8">

            <div class="card shadow-lg">

                <div class="card-header">

                    <h5><?php echo lang('Adverts.title_index'); ?></h5>

                </div>

                <div class="card-body">

                    <a href="<?php echo route_to('adverts.manager'); ?>" class="btn btn-main-sm btn-outline-info mb-4"><?php echo lang('App.btn_back'); ?></a>

                    <table class="table table-borderless table-striped" id="dataTable">
                        <thead>
                            <tr>

                                <th scope="col" class="all"><?php echo lang('Adverts.label_title'); ?></th>
                                <th scope="col" class="all"><?php echo lang('Adverts.label_code'); ?></th>
                                <th scope="col" class="all text-center"><?php echo lang('App.btn_actions'); ?></th>
                            </tr>
                        </thead>

                    </table>

                </div>

            </div>

        </div>
    </div>
    <!-- Row End -->
</div>
<!-- Container End -->


<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php echo $this->include('Manager/Adverts/Scripts/_datatable_all_archived'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_recover_advert'); ?>
<?php echo $this->include('Manager/Adverts/Scripts/_delete_advert'); ?>


<script>
    function refreshCSRFToken(token) {

        $('[name="<?php echo csrf_token(); ?>"]').val(token);
        $('meta[name="<?php echo csrf_token(); ?>"]').attr('content', token);

    }
</script>

<?= $this->endSection() ?>