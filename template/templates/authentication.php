<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $_ENV['SOFTWARE_TITLE'] ?> | <?= $this->e($title) ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= $this->asset('/asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->asset('/asset/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->asset('/asset/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition <?= $type ?>-page">

<?=$this->section('content')?>

<script src="<?= $this->asset('/asset/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= $this->asset('/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= $this->asset('/asset/js/adminlte.min.js') ?>"></script>
</body>
</html>
