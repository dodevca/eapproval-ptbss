        <nav class="sb-topnav navbar navbar-expand navbar-light bg-white shadow">
             <a class="navbar-brand d-flex align-items-center ps-3" href="<?= base_url() ?>">
                <img src="<?= base_url('/images/logo-cropped.png') ?>" class="me-2" width="48px" height="48px" />
                <strong>DASHBOARD</strong>
            </a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-auto" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ms-auto ms-lg-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <div class="text-center py-3 border-bottom">
                            <i class="fa-solid fa-user text-secondary fa-2xl mb-2"></i>
                            <h6 class="mb-0"><?= $accounts[0]['name'] ?></h6>
                            <p class="text-muted mb-0"><?= $accounts[0]['email'] ?></p>
                        </div>
                        
                        <ul class="list-unstyled pt-2">
                            <li><a class="dropdown-item" href="<?= base_url('/setting/email') ?>"><i class="fa-solid fa-envelope me-2 text-muted" width="16px"></i>E-Mail</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('/setting/esign') ?>"><i class="fa-solid fa-signature me-2 text-muted" width="16px"></i>Signature</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('/setting/password') ?>"><i class="fa-solid fa-lock me-2 text-muted" width="16px"></i>Password</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('/logout') ?>"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>