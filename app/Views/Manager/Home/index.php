<?= $this->extend('Manager/Layout/main'); ?>

<?php $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection(); ?>


<?php $this->section('styles') ?>


<?= $this->endSection(); ?>


<?= $this->section('content') ?>

<!-- Envio para o template principal o conteúdo dessa view -->

<div class="container-fluid">
    <h1><?php echo $title ?? ''; ?></h1>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<!-- Envio para o template principal os arquivos scripts dessa view -->

<?= $this->endSection() ?>