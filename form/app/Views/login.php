<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Log In</title>
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
                                <h3 class="font-weight-light my-4">Log In</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <p class="mb-0"><?= session()->getFlashdata('error') ?></p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <?= form_open(base_url('/auth')); ?>
                                    <?= csrf_field(); ?>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@ptbss.com" required />
                                        <label for="email">Email address</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                        <button type="submit" class="btn btn-primary">Log in</button>
                                    </div>
                                </form>
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