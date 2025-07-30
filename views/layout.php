<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sama Shahr' ?></title>
    <meta name="description" content="<?= $description ?? 'Sama Shahr - Professional Web Development Services' ?>">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="/node_modules/swiper/swiper-bundle.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/media.css">
    
    <!-- Custom Font -->
    <link rel="stylesheet" href="/font/DERMOSO/OpenType-TT/DERMOSO.ttf">
</head>
<body>
    <!-- Header -->
    <header class="position-relative">
        <div class="header w-100">
            <div class="header__top">
                <div class="header__top-menu">
                    <ul class="header__top-item">
                        <a href="/"><li>home</li></a>
                        <a href="/projects"><li>project</li></a>
                        <a href="/about"><li>about us</li></a>
                        <a href="/contact"><li>contact</li></a>
                        <a href="/">
                            <li id="pick">
                                <img class="w-100" src="/pic/logo.png" alt="Sama Shahr Logo">
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php if (isset($flashMessage) && $flashMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flashMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__left">Copyright © <?= date('Y') ?> WebiMax</div>
        <div class="footer__right">
            <img class="footer__right-img" src="/pic/random1.png" alt="">
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="/node_modules/swiper/swiper-bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="/main.js"></script>
    
    <!-- Additional Scripts -->
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html> 