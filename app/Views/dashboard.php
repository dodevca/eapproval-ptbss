<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= $accounts[0]['name'] ?> | Dashboard</title>
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
                        <h1 class="h2 mt-4">Hallo, <?= $nickname ?></h1>
                        <div class="row py-4">
                            <div class="col-md-3">
                                <a href="<?= base_url('pending') ?>" class="d-flex align-items-center justify-content-between w-100 bg-white shadow-sm border-start border-3 border-warning rounded p-3 mb-3 mb-md-0 text-decoration-none">
                                    <div>
                                        <h2 class="h4 text-dark"><?= $pending ?></h2>
                                        <p class="mb-0 text-dark">Pending</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-warning" style="width:3rem;height:3rem">
                                        <i class="fa-solid fa-clock text-light"></i>
                                    </div>
                                </a>
                            </div>
                            <?php if ($as != 'Manager'): ?>
                                <div class="col-md-3">
                                    <a href="<?= base_url('returned') ?>" class="d-flex align-items-center justify-content-between w-100 bg-white shadow-sm border-start border-3 border-info rounded p-3 mb-3 mb-md-0 text-decoration-none">
                                        <div>
                                            <h2 class="h4 text-dark"><?= $returned ?></h2>
                                            <p class="mb-0 text-dark">Returned</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-info" style="width:3rem;height:3rem">
                                            <i class="fa-solid fa-rotate-left text-light"></i>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-3">
                                <a href="<?= base_url('approved') ?>" class="d-flex align-items-center justify-content-between w-100 bg-white shadow-sm border-start border-3 border-success rounded p-3 mb-3 mb-md-0 text-decoration-none">
                                    <div>
                                        <h2 class="h4 text-dark"><?= $approved ?></h2>
                                        <p class="mb-0 text-dark">Approved</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-success" style="width:3rem;height:3rem">
                                        <i class="fa-solid fa-check text-light"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url('disapproved') ?>" class="d-flex align-items-center justify-content-between w-100 bg-white shadow-sm border-start border-3 border-danger rounded p-3 mb-3 mb-md-0 text-decoration-none">
                                    <div>
                                        <h2 class="h4 text-dark"><?= $disapproved ?></h2>
                                        <p class="mb-0 text-dark">Disapproved</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger" style="width:3rem;height:3rem">
                                        <i class="fa-solid fa-xmark text-light"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="h5">Menunggu Persetujuan Anda</h2>
                                    <?php if (count($needApproval) > 0 || !empty($needApproval)): ?>
                                        <a href="<?= base_url('pending') ?>" class="btn btn-outline-secondary">Semua</a>
                                    <?php endif; ?>
                                </div>
                                <ul class="list-unstyled py-3">
                                    <?php if (count($needApproval) > 0 || !empty($needApproval)): ?>
                                        <?php for ($i = 0; $i < count($needApproval); $i++) { ?>
                                            <li class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-3 rounded p-3 border border-1 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-file-circle-exclamation text-warning fa-2xl"></i>
                                                    <div class="ms-3 me-auto">
                                                        <a href="<?= base_url('view/' . $needApproval[$i]['submission']) ?>" class="text-decoration-none"><h3 class="h5 mb-0 fw-bold"><?= $needApproval[$i]['proofNumber'] ?></h3></a>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <p class="mb-0"><small><b><?= $needApproval[$i]['projectCode'] ?></b></small></p>
                                                            <div class="vr mx-2"></div>
                                                            <p class="text-muted mb-0"><small><i><?= date('d-m-Y H:i', strtotime($needApproval[$i]['date'])) ?></i></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end ms-auto">
                                                    <a href="<?= base_url('view/' . $needApproval[$i]['submission']) ?>" class="btn btn-link text-decoration-none text-dark"><i class="fa-solid fa-eye text-primary fa-lg me-2"></i>Lihat</a>
                                                    <a href="<?= base_url('download/' . $needApproval[$i]['submission']) ?>" class="btn btn-link text-decoration-none text-dark"><i class="fa-solid fa-download text-primary fa-lg me-2"></i>Unduh</a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php else: ?>
                                        <li>
                                            <div class="alert alert-warning" role="alert">
                                                Tidak ada permintaan aprroval.
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="h5"><?= $as == 'Manager' ? 'Telah Disetujui' : 'Meminta Peninjauan Ulang' ?></h2>
                                    <?php if (count($needRecheck) > 0 || !empty($needRecheck)): ?>
                                        <a href="<?= $as == 'Manager' ? base_url('approved') : base_url('returned') ?>" class="btn btn-outline-secondary">Semua</a>
                                    <?php endif; ?>
                                </div>
                                <ul class="list-unstyled py-3">
                                    <?php if (count($needRecheck) > 0 || !empty($needRecheck)): ?>
                                        <?php for ($i = 0; $i < count($needRecheck); $i++) { ?>
                                            <li class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-3 rounded p-3 border border-1 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid <?= $as == 'Manager' ? 'fa-file-circle-check text-success' : 'fa-file-pen text-info' ?> fa-2xl"></i>
                                                    <div class="ms-3 me-auto">
                                                        <a href="<?= base_url('view/' . $needRecheck[$i]['submission']) ?>" class="text-decoration-none"><h3 class="h5 mb-0 fw-bold"><?= $needRecheck[$i]['proofNumber'] ?></h3></a>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <p class="mb-0"><small><b><?= $needRecheck[$i]['projectCode'] ?></b></small></p>
                                                            <div class="vr mx-2"></div>
                                                            <p class="text-muted mb-0"><small><i><?= date('d-m-Y H:i', strtotime($needRecheck[$i]['date'])) ?></i></small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end ms-auto">
                                                    <a href="<?= base_url('view/' . $needRecheck[$i]['submission']) ?>" class="btn btn-link text-decoration-none text-dark"><i class="fa-solid fa-eye text-primary fa-lg me-2"></i>Lihat</a>
                                                    <a href="<?= base_url('download/' . $needRecheck[$i]['submission']) ?>" class="btn btn-link text-decoration-none text-dark"><i class="fa-solid fa-download text-primary fa-lg me-2"></i>Unduh</a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <?php else: ?>
                                        <li>
                                            <div class="alert alert-warning" role="alert">
                                                <?= $as == 'Manager' ? 'Belum ada permintaan yang disetujui.' : 'Tidak ada permintaan peninjauan ulang.' ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
    </body>
</html>
