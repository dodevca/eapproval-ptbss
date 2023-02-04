<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="-1"/>
        <title>E-Signature Setting | Dashboard</title>
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
                        <h1 class="h2 mt-4">E-Signature Setting</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('setting') ?>" class="text-decoration-none">Setting</a></li>
                            <li class="breadcrumb-item active">E-Sign</li>
                        </ol>
                        <h2 class="h5">Signature anda</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <img src="<?= base_url('uploads/signatures/' . $accounts[0]['sign'] . '.png') ?>" class="img-fluid rounded mb-3" width="216px" height="216px" />
                                </div>
                                <div class="card card-raised">
                                    <div class="card-body">
                                        <h2 class="card-title h5">Buat Signature baru</h2>
                                        <div class="alert alert-success alert-dismissible fade d-none" id="success" role="alert">
                                            <p>Berhasil mengganti E-Signature anda.</p>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <div class="alert alert-danger alert-dismissible fade d-none" id="alert" role="alert">
                                            <p>Error! Pastikan anda sudah mengisi E-Signature pad.</p>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?= form_open(base_url('setting/setesign')); ?>
                                            <div class="mb-3 text-center pt-3">
                                                <canvas id="signaturePad" class="border border-warning rounded" width="288px" height="288px"></canvas>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                                                <button class="btn btn-outline-secondary" type="button" id="reset"><i class="fa-solid fa-trash me-2"></i>Reset</button>
                                                <button class="btn btn-secondary" type="button" id="undo"><i class="fa-solid fa-rotate-left me-2"></i>Undo</button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button class="btn btn-primary" type="button" id="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script src="<?= base_url('js/signaturepad.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/canvas.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
    </body>
</html>