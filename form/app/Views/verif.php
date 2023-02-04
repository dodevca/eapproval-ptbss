<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Email Authentification</title>
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
                                <h3 class="font-weight-light my-4">Autentifikasi</h3>
                            </div>
                            <div class="card-body">
                                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <p class="mb-0"><?= session()->getFlashdata('error') ?></p>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <?= form_open(base_url('/auth/code')); ?>
                                    <?= csrf_field(); ?>
                                    <input type="email" class="form-control d-none" id="email" name="email" value="<?= $email ?>" required />
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="code" name="code" placeholder="Kode autentifikasi" required />
                                        <label for="code">Kode Autentifikasi</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <p class="mb-0">Belum menerima email?</p>
                                        <div>
                                            <span class="text-muted me-2" id="count"></span>
                                            <button type="button" class="btn btn-outline-primary" id="resend" disabled>Kirim ulang</button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?= $this->include('partials/footer'); ?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                const startTimer = (duration) => {
                    var timer = duration, minutes, seconds
                    setInterval(function () {
                        minutes = parseInt(timer / 60, 10)
                        seconds = parseInt(timer % 60, 10)
                
                        minutes = minutes < 10 ? "0" + minutes : minutes
                        seconds = seconds < 10 ? "0" + seconds : seconds
                
                        document.getElementById('count').textContent = minutes + ":" + seconds
                
                        if (--timer < 0) {
                            document.getElementById('count').textContent = ''
                            document.getElementById('resend').removeAttribute('disabled')
                        }
                    }, 1000)
                }
                
                startTimer(120)
                    
                const resend = document.getElementById('resend');   

                resend.addEventListener("click", function(e){
                    let xhr     = new XMLHttpRequest()
                    
                    xhr.open('GET', 'https://form.devisigeneralservicebss.com/auth/email?email=<?= $email ?>')
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function() {
                        if(xhr.readyState == 4 && xhr.status == 200) {
                            window.location.reload(true)
                        }
                    }
                    xhr.send()
                })
            })
        </script>
        <script src="<?= base_url('/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
    </body>
</html>