<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php $nickname = isset(explode(" ", $accounts[0]['name'])[1]) ? explode(' ', $accounts[0]['name'])[0] : $accounts[0]['name']; ?>
        <title><?= $nickname . "'s " . $breadcrumb ?> Submissions | Dashboard</title>
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
                        <h1 class="h2 mt-4"><?= $breadcrumb ?> Submission</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item active"><?= $breadcrumb ?></li>
                        </ol>
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="h5"><?= $message ?></h2>
                            <?php if (count($submissions) > 0 || !empty($submissions)): ?>
                                <div class="ms-3">
                                    <div class="dropdown">
                                        <a class="btn btn-outline-secondary dropdown-toggle" href="javascript:;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-sort me-2"></i>
                                            <?php
                                            if ($sort == 'DESC') {
                                                echo 'Terbaru';
                                            } elseif ($sort == 'ASC') {
                                                echo 'Terlama';
                                            } else {
                                                echo 'Terbaru';
                                            }
                                            ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url(strtolower($breadcrumb) . '?sort=DESC&page=1') ?>">Terbaru</a></li>
                                            <li><a class="dropdown-item" href="<?= base_url(strtolower($breadcrumb) . '?sort=ASC&page=1') ?>">Terlama</a></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <ul class="list-unstyled py-3">
                            <?php if (count($submissions) > 0 || !empty($submissions)): ?>
                                <?php for ($i = 0; $i < $length; $i++) { ?>
                                    <li class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-3 rounded p-3 border border-1 mb-3">
                                        <div class="d-flex align-items-center">
                                            <?php if ($breadcrumb == 'Pending'): ?>
                                                <i class="fa-solid fa-file-circle-exclamation text-warning fa-2xl"></i>
                                            <?php elseif ($breadcrumb == 'Returned'): ?>
                                                <i class="fa-solid fa-file-pen text-info fa-2xl"></i>
                                            <?php elseif ($breadcrumb == 'Approved'): ?>
                                                <i class="fa-solid fa-file-circle-check text-success fa-2xl"></i>
                                            <?php elseif ($breadcrumb == 'Disapproved'): ?>
                                                <i class="fa-solid fa-file-circle-xmark text-danger fa-2xl"></i>
                                            <?php else: ?>
                                                <i class="fa-solid fa-file fa-2xl"></i>
                                            <?php endif; ?>
                                            <div class="ms-3 me-auto">
                                                <a href="<?= base_url('view/' . $submissions[$i]['submission']) ?>" class="text-decoration-none"><h3 class="h5 mb-0 fw-bold"><?= $submissions[$i]['proofNumber'] ?></h3></a>
                                                <div class="d-flex align-items-center mt-1">
                                                    <p class="mb-0"><small><b><?= $submissions[$i]['projectCode'] ?></b></small></p>
                                                    <div class="vr mx-2"></div>
                                                    <p class="mb-0"><?= ucwords($submissions[$i]['type'])?></p>
                                                </div>
                                                <p class="text-muted mb-0"><small><i><?= date('d-m-Y H:i', strtotime($submissions[$i]['date'])) ?></i></small></p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end ms-auto">
                                            <a href="<?= base_url('view/' . $submissions[$i]['submission']) ?>" class="btn btn-link text-decoration-none text-dark"><i class="fa-solid fa-eye text-primary fa-lg me-2"></i>Lihat</a>
                                            <a href="<?= base_url('download/' . $submissions[$i]['submission']) ?>" class="btn btn-link text-decoration-none text-dark"><i class="fa-solid fa-download text-primary fa-lg me-2"></i>Unduh</a>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php else: ?>
                                <li>
                                    <div class="alert alert-warning" role="alert">
                                        <?= $notMessage ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php if (count($submissions) > 0 || !empty($submissions)): ?>
                            <nav aria-label="pagingation">
                                <ul class="pagination justify-content-center gap-3">
                                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= current_url() . '?sort=' . $sort . '&page=' . $prev ?>" aria-label="Previous">
                                            <span aria-hidden="true"><i class="fa-solid fa-angles-left"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item <?= count($submissions) < 21 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= current_url() . '?sort=' . $sort . '&page=' . $next ?>" aria-label="Next">
                                            <span aria-hidden="true"><i class="fa-solid fa-angles-right"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
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