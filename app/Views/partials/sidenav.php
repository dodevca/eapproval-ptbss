            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark bg-primary" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav pb-4">
                            <div class="sb-sidenav-menu-heading">Pages</div>
                            <a class="nav-link <?= $currentPage == 'Dashboard' ? 'active' : '' ?>" href="<?= base_url() ?>">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house fa-lg"></i></div>
                                Dashboard
                            </a>
                            <?php if ($as == 'Manager'): ?>
                                <a class="nav-link <?= $currentPage == 'Export Data' ? 'active' : '' ?>" href="<?= base_url('/export') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-file-export fa-lg"></i></div>
                                    Export Data
                                </a>
                            <?php endif; ?>
                            <a class="nav-link <?= $currentPage == 'Setting' ? 'active' : '' ?>" href="<?= base_url('/setting') ?>">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-gear fa-lg"></i></div>
                                Setting
                            </a>
                            <div class="sb-sidenav-menu-heading">Submissions</div>
                            <a class="nav-link <?= $currentPage == 'Pending' ? 'active' : '' ?>" href="<?= base_url('/pending') ?>">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-clock fa-lg"></i></div>
                                Pending
                            </a>
                            <?php if ($as != 'Manager'): ?>
                                <a class="nav-link <?= $currentPage == 'Returned' ? 'active' : '' ?>" href="<?= base_url('/returned') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-rotate-left fa-lg"></i></i></div>
                                    Returned
                                </a>
                            <?php endif; ?>
                            <a class="nav-link <?= $currentPage == 'Approved' ? 'active' : '' ?>" href="<?= base_url('/approved') ?>">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-check fa-lg"></i></div>
                                Approved
                            </a>
                            <a class="nav-link <?= $currentPage == 'Disapproved' ? 'active' : '' ?>" href="<?= base_url('/disapproved') ?>">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-xmark fa-lg"></i></div>
                                Disapproved
                            </a>
                            <div class="sb-sidenav-menu-heading">Logged in as :</div>
                            <?php if (count($accounts) > 1): ?>
                                <a class="nav-link collapsed" href="javascript:;" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users fa-lg"></i></div>
                                    <?=  str_replace('_', ' ', $as) ?>
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <?php for($i = 0; $i < count($accounts); $i++) { ?>
                                            <a class="nav-link" href="/hierarchy?as=<?= urlencode(base64_encode($accounts[$i]['hierarchy'])) ?>"><?= str_replace('_', ' ', $accounts[$i]['hierarchy']) ?></a>
                                        <?php } ?>
                                    </nav>
                                </div>
                            <?php else: ?>
                                <a class="nav-link" href="javascript:;" disabled>
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user fa-lg"></i></div>
                                     <?= str_replace('_', ' ', $accounts[0]['hierarchy']) ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>