<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Pengajuan Formulir</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
        <link rel="stylesheet" href="<?= base_url('/css/app.css') ?>" >
        <script src="https://kit.fontawesome.com/ff94f270b6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <main>
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="text-center my-4">
                            <img src="<?= base_url('images/logo-ptbss.png') ?>" class="img-fluid" style="width:100%;height:auto;" />
                        </div>
                        <div class="card shadow-lg border-0 rounded">
                            <div class="card-header text-center bg-white">
                                <h3 class="font-weight-light my-4">Pengajuan Formulir</h3>
                            </div>
                            <div class="card-body">
                                <h4 class="h6">Pilih jenis formulir :</h4>
                                <ul class="list-unstyled">
                                    <li class="border rounded d-flex justify-content-between align-items-center gap-3 p-3 mb-3">
                                        <a href="<?= base_url('payment') ?>" class="text-dark text-decoration-none">
                                            Permintaan Pembayaran
                                        </a>
                                        <a href="<?= base_url('payment') ?>" class="text-dark text-decoration-none">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <li class="border rounded d-flex justify-content-between align-items-center gap-3 p-3 mb-3">
                                        <a href="<?= base_url('income') ?>" class="text-dark text-decoration-none">
                                            Penerimaan Pendapatan
                                        </a>
                                        <a href="<?= base_url('income') ?>" class="text-dark text-decoration-none">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?= $this->include('partials/footer'); ?>
        <script src="<?= base_url('/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
    </body>
</html>