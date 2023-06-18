<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

/* application boostrap */
$app = (require_once __DIR__ . '/../src/conf/bootstrap.php');

$app->setBasePath('/Archi/giftbox/gift.appli/public/index.php');

/* routes loading */
(require_once __DIR__ . '/../src/conf/routes.php')($app);

$app->run();
