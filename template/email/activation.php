<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
    <body>
    Hey <?= $this->e($username) ?>, <br>

    Es fehlt nur noch ein Schritt zur Eröffnung deines Raumfahrtunternehmens. <br>
    Klicke auf folgenden Link, um die Registrierung abzuschließen: <br>

    <a href="<?= \App\Software::WEBPAGE_URI . '/account/activate?token=' . $this->e($token) ?>"><?= \App\Software::WEBPAGE_URI . '/account/activate?token=' . $this->e($token) ?></a>

    <br>

    <h5>
        Wir wünschen dir viel Spaß!
    </h5>
</body>
</html>