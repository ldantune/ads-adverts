<?= $this->extend('Manager\Layout\main') ?>

<?= $this->section('title') ?>
    <?php echo $title ?? '' ?>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Hello World!</h1>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<?= $this->endSection() ?>