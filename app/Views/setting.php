<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php $nickname = isset(explode(" ", $accounts[0]['name'])[1]) ? explode(' ', $accounts[0]['name'])[0] : $accounts[0]['name']; ?>
        <title>Setting | Dashboard</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>"/>
        <script src="https://kit.fontawesome.com/ff94f270b6.js" crossorigin="anonymous"></script>
        <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed">
        <?= $this->include('partials/nav'); ?>
        <div id="layoutSidenav">
            <?= $this->include('partials/sidenav'); ?>
            <div id="layoutSidenav_content">
                <main class="bg-light">
                    <div class="container-fluid px-4">
                        <?php $nickname = isset(explode(' ', $accounts[0]['name'])[1]) ? explode(' ', $accounts[0]['name'])[0] : $accounts[0]['name']; ?>
                        <h1 class="h2 mt-4">Setting</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                        <div class="d-flex align-items-center gap-3 my-4">
                            <i class="fa-solid fa-circle-user text-secondary fa-4x"></i>
                            <div>
                                <h2 class="h5 mb-0"><?= $accounts[0]['name'] ?></h2>
                                <p class="text-muted mb-0"><?= $accounts[0]['email'] ?> (<?= str_replace('_', ' ', $as) ?>)</p>
                                <a href="<?= base_url('setting/email') ?>">Ganti email</a>
                            </div>
                        </div>
                        <h3 class="h5">Pengaturan Akun</h3>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                <a href="<?= base_url('setting/esign') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                    <i class="fa-solid fa-signature" width="16px"></i>
                                    <p class="mb-0">Ganti e-signature</p>
                                </a>
                                <a href="<?= base_url('setting/esign') ?>" class="text-muted ms-auto">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                <a href="<?= base_url('setting/password') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                    <i class="fa-solid fa-lock" width="16px"></i>
                                    <p class="mb-0">Ganti password</p>
                                </a>
                                <a href="<?= base_url('setting/password') ?>" class="text-muted ms-auto">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                        <?php if ($as == 'Manager'): ?>
                            <h3 class="h5">Pengaturan Sistem</h3>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                    <a href="<?= base_url('setting/hierarchies') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                        <i class="fa-solid fa-sitemap" width="16px"></i>
                                        <p class="mb-0">Edit hierarchy</p>
                                    </a>
                                    <a href="<?= base_url('setting/hierarchies') ?>" class="text-muted ms-auto">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                                <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                    <a href="<?= base_url('setting/projects') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                        <i class="fa-solid fa-file-powerpoint" width="16px"></i>
                                        <p class="mb-0">Edit kode proyek</p>
                                    </a>
                                    <a href="<?= base_url('setting/projects') ?>" class="text-muted ms-auto">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                                <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                    <a href="<?= base_url('setting/categories') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                        <i class="fa-solid fa-list" width="16px"></i>
                                        <p class="mb-0">Edit kategori formulir</p>
                                    </a>
                                    <a href="<?= base_url('setting/categories') ?>" class="text-muted ms-auto">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                                <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                    <a href="<?= base_url('setting/refcode') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                        <i class="fa-solid fa-code-compare" width="16px"></i>
                                        <p class="mb-0">Edit kode referensi</p>
                                    </a>
                                    <a href="<?= base_url('setting/refcode') ?>" class="text-muted ms-auto">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
    </body>
</html>