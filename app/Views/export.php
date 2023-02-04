<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php $nickname = isset(explode(" ", $accounts[0]['name'])[1]) ? explode(' ', $accounts[0]['name'])[0] : $accounts[0]['name']; ?>
        <title>Export Data | Dashboard</title>
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
                        <h1 class="h2 mt-4">Export Data</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item active">Export</li>
                        </ol>
                        <?php if ($as == 'Manager'): ?>
                            <h3 class="h5">Ekspor Data</h3>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                    <a href="<?= base_url('export/approved') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                        <i class="fa-solid fa-thumbs-up" width="16px"></i>
                                        <p class="mb-0">Ekspor Data Disetujui</p>
                                    </a>
                                    <a href="<?= base_url('export/approved') ?>" class="text-muted ms-auto">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                                <li class="d-flex align-items-center gap-2 rounded p-3 border border-1 mb-3">
                                    <a href="<?= base_url('export/item') ?>" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                        <i class="fa-solid fa-bars" width="16px"></i>
                                        <p class="mb-0">Ekspor Data Keperluan</p>
                                    </a>
                                    <a href="<?= base_url('export/item') ?>" class="text-muted ms-auto">
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