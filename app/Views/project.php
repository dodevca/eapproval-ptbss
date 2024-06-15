<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Setting Projects | Dashboard</title>
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
                        <h1 class="h2 mt-4">Setting Projects</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('setting') ?>" class="text-decoration-none">Setting</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                        <?php if (!empty(session()->getFlashdata('error'))): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p class="mb-0"><?= session()->getFlashdata('error') ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty(session()->getFlashdata('success'))): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0"><?= session()->getFlashdata('success') ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-lg-6 mb-4 order-2 order-lg-1">
                                <h2 class="h5">Daftar Kode Proyek</h2>
                                <?php if (count($projects) > 0 || !empty(count($projects))): ?>
                                    <ul class="list-unstyled">
                                        <?php for($i = 0; $i < count($projects); $i++) { ?>
                                            <li class="d-flex align-items-center justify-content-between border rounded border-1 p-2 mb-2">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3" class="h4"><i class="fa-solid fa-file-powerpoint text-muted me-2"></i><?= $projects[$i]['projectCode'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nomor Kontrak</td>
                                                            <td class="px-2">:</td>
                                                            <td><?= $projects[$i]['contractNumber'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Pelanggan</td>
                                                            <td class="px-2">:</td>
                                                            <td><?= $projects[$i]['customer'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <a href="<?= base_url('setting/setprojects?purpose=delete&projectCode=' . urlencode(base64_encode($projects[$i]['projectCode']))) ?>" class="btn btn-link text-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php else: ?>
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="alert alert-warning" role="alert">
                                                Belum ada kode proyek
                                            </div>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-6 mb-4 order-1 order-lg-2">
                                <div class="position-sticky" style="top:72px">
                                    <h3 class="card-title h5">Tambah Kode Proyek</h3>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <?= form_open(base_url('setting/setprojects')); ?>
                                                <input type="purpose" class="form-control d-none" id="purpose" name="purpose" value="add" required />
                                                <div class="mb-3">
                                                    <label for="projectCode" class="form-label">Referensi / Kode Proyek</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="projectCodeText">P</span>
                                                        <input type="text" class="form-control" id="projectCode" name="projectCode" placeholder="000" aria-validate="false" aria-describedby="projectCodeText" required />
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="contractNumber" class="form-label">Nomor Kontrak</label>
                                                    <input type="text" class="form-control" id="contractNumber" name="contractNumber" placeholder=".../.../..." aria-validate="false" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="customer" class="form-label">Nama Pelanggan</label>
                                                    <input type="name" class="form-control" id="customer" name="customer" placeholder="Masukkan nama pelanggan" aria-validate="false" required />
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-plus me-2"></i>Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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