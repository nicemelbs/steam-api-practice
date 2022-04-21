<?php

use app\core\Application;
use app\models\SteamUser;

require_once Application::$ROOT_DIR . '/steamauth/steamauth.php';

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? 'PHP Framework' ?></title>

    <?= Application::$app->favicon() ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>

                <?php if (!Application::isGuest()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/<?= $_SESSION['steamid'] ?>/games">My Games</a>
                    </li>

                <?php } ?>

            </ul>

            <div class="d-flex justify-content-end">

                <?php if (Application::isGuest()): ?>
                    <ul class="navbar-nav">
                        <li class="nav-item"><?php loginbutton('rectangle'); ?></li>
                    </ul>
                <?php else: ?>
                    <ul class="navbar-nav">
                        <?php
                        $user = SteamUser::findBySteamId($_SESSION['steamid']);
                        if ($user): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/profile"><?= $user->personaname ?> </a>
                            </li>
                            <li class="nav-item">
                                <img src="<?= $user->avatar ?> " class="rounded-circle" width="30" height="30"
                                     alt="<?= $user->personaname ?>">
                            </li>
                        <?php endif; ?>
                        <li class="nav-item"><?php logoutbutton(); ?></li>
                    </ul>
                <?php endif ?>
            </div>

        </div>
    </div>
</nav>

<?php if (Application::$app->session->hasFlash('success')) { ?>

    <div class="container">
        <div class="alert alert-success">
            <?= Application::$app->session->getFlash('success') ?>
        </div>
    </div>
<?php } ?>

<div class="container">{{ content }}</div>

<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">&copy; 2021 Company, Inc</p>

        <a href="/"
           class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"/>
            </svg>
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
        </ul>
    </footer>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>


</body>
</html>
