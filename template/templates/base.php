<html>
<head>
    <title><?= \App\Software::TITLE ?> :: <?=$this->e($title)?></title>
    <link rel="stylesheet" href="<?=$this->asset('/css/styles.css')?>" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="<?= $this->asset('css/styles.css') ?>" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <body>
    <?=$this->section('content')?>
    </body>
</html>
