<?= $this->extend('Dashboard/Layout/main'); ?>

<?php $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection(); ?>


<?php $this->section('styles') ?>


<?= $this->endSection(); ?>


<?= $this->section('content') ?>

<!-- Envio para o template principal o conteúdo dessa view -->

<div class="container-fluid">
    <section class="dashboard section">
        <!-- Container Start -->
        <div class="container">
            <!-- Row Start -->
            <div class="row">
                <?php echo $this->include('Dashboard/Layout/_sidebar'); ?>
                
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
                    <!-- Recently Favorited -->
                    <div class="widget dashboard-container my-adslist">
                        <h3 class="widget-header"><?php echo lang('Adverts.title_index'); ?></h3>
                        
                    </div>
                </div>
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </section>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<!-- Envio para o template principal os arquivos scripts dessa view -->

<?= $this->endSection() ?>