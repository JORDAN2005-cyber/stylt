<?php $fl=flashes(); ?>
<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#16244a"><title><?= e(APP_NAME) ?></title><link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css"></head><body>
<div class="site-shell">
<header class="topbar"><a class="brand" href="<?= APP_URL ?>/index.php"><span class="brand-mark">S</span><span>Stylt</span></a><nav class="desktop-nav"><a href="<?= APP_URL ?>/index.php?page=search">Explorer</a><a href="<?= APP_URL ?>/index.php?page=register-professional">Devenir coiffeur</a></nav><button class="mode-pill" type="button">Mode client <span>⌄</span></button></header>
<?php foreach($fl as $f): ?><div class="toast <?= e($f['type']) ?>"><?= e($f['message']) ?></div><?php endforeach; ?>
<main class="page-wrap"><?php include $view; ?></main>
<nav class="bottom-nav"><a class="active" href="<?= APP_URL ?>/index.php"><span>⌂</span><small>Accueil</small></a><a href="<?= APP_URL ?>/index.php?page=search"><span>⌕</span><small>Explorer</small></a><a href="<?= APP_URL ?>/index.php?page=register-professional"><span>＋</span><small>Pro</small></a><a href="<?= APP_URL ?>/index.php?page=search"><span>♙</span><small>Profil</small></a></nav>
</div><script src="<?= APP_URL ?>/assets/js/app.js"></script></body></html>
