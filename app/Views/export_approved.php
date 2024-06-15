<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php $nickname = isset(explode(" ", $accounts[0]['name'])[1]) ? explode(' ', $accounts[0]['name'])[0] : $accounts[0]['name']; ?>
        <title>Export Approved Submissions | Dashboard</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>"/>
        <script src="https://kit.fontawesome.com/ff94f270b6.js" crossorigin="anonymous"></script>
        <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed">
        <?php
        if ($type == 'payment')
        {
            $fileType = ' (Permintaan Pembayaran)';
        }
        elseif ($type == 'income')
        {
            $fileType = ' (Penerimaan Pendapatan)';
        }
        else
        {
            $fileType = '';
        }
        $fileMonth  = $month == 'unset' ? '' : ucwords($month) . ' ';
        $fileYear   = $year == 'unset' ? '' : $year;
        $fileDate   = $year == 'unset' && $month == 'unset' ? '' : ' - ' . $fileMonth . $fileYear;
         
        $fileName = 'E-Approval Recap' . $fileType . $fileDate;
        ?>
        <?= $this->include('partials/nav'); ?>
        <div id="layoutSidenav">
            <?= $this->include('partials/sidenav'); ?>
            <div id="layoutSidenav_content">
                <main class="bg-light">
                    <div class="container-fluid px-4">
                        <h1 class="h2 mt-4">Export Approved Submissions</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item active"><a href="<?= base_url('export') ?>" class="text-decoration-none">Export</a></li>
                            <li class="breadcrumb-item active">Approved</li>
                        </ol>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-start flex-wrap gap-2 me-3">
                                <div class="dropdown">
                                    <a class="btn btn-outline-secondary dropdown-toggle" href="javascript:;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-file me-2"></i>
                                        <?php
                                        if ($type == 'payment') {
                                            echo 'Pembayaran';
                                        } elseif ($type == 'income') {
                                            echo 'Pendapatan';
                                        } else {
                                            echo 'Semua';
                                        }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=payment&month=' . $month . '&year=' . $year) ?>">Permintaan Pembayaran</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=income&month=' . $month . '&year=' . $year) ?>">Penerimaan Pendapatan</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=all&month=' . $month . '&year=' . $year) ?>">Semua</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <a class="btn btn-outline-secondary dropdown-toggle" href="javascript:;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-calendar-week me-2"></i>
                                        <?php
                                        if ($month != null && $month != 'unset') {
                                            echo 'Bulan (' . ucwords($month) . ')';
                                        } else {
                                            echo 'Bulan (Semua)';
                                        }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=januari&year=' . $year) ?>">Januari</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=februari&year=' . $year) ?>">Februari</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=maret&year=' . $year) ?>">Maret</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=april&year=' . $year) ?>">April</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=mei&year=' . $year) ?>">Mei</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=juni&year=' . $year) ?>">Juni</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=juli&year=' . $year) ?>">Juli</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=agustus&year=' . $year) ?>">Agustus</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=september&year=' . $year) ?>">September</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=oktober&year=' . $year) ?>">Oktober</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=november&year=' . $year) ?>">November</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=desember&year=' . $year) ?>">Desember</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=unset&year=' . $year) ?>">Semua</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <a class="btn btn-outline-secondary dropdown-toggle" href="javascript:;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-calendar me-2"></i>
                                        <?php
                                        if ($year != null && $year != 'unset') {
                                            echo 'Tahun (' . ucwords($year) . ')';
                                        } else {
                                            echo 'Tahun (Semua)';
                                        }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php $years = array_combine(range(date("Y"), 2022), range(date("Y"), 2022));
                                        foreach ($years as $y) { ?>
                                            <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=' . $month . '&year=' . $y) ?>"><?= $y ?></a></li>
                                        <?php } ?>
                                        <li><a class="dropdown-item" href="<?= base_url('export/approved?type=' . $type . '&month=' . $month . '&year=unset') ?>">Semua</a></li>
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="exportBtn"><i class="fa-solid fa-file-export me-2"></i>Export</button>
                        </div>
                        <div class="tableWrap overflow-auto mt-4">
                            <table class="table table-bordered py-3" id="exportTable">
                                <thead>
                                    <tr>
                                        <th colspan="24" class="align-middle"><?= $fileName ?></th>
                                    </tr>
                                    <tr>
                                        <th rowspan="3" class="align-middle text-nowrap">No.</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Jenis</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Tanggal</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Nomor Bukti</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Kode Proyek</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Nomor Kontrak</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Pelanggan</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Penerima/Asal Setoran</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Kategori</th>
                                        <th colspan="8" class="align-middle text-nowrap">Rincian</th>
                                        <th rowspan="3" class="align-middle text-nowrap">Total</th>
                                        <th colspan="8" class="align-middle text-nowrap">Persetujuan</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="align-middle text-nowrap">Keperluan</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Kode Ref.</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Keterangan</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Periode</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Jumlah</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Satuan</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Harga Satuan</th>
                                        <th rowspan="2" class="align-middle text-nowrap">Harga Total</th>
                                        <th colspan="2" class="align-middle text-nowrap">Admin</th>
                                        <th colspan="2" class="align-middle text-nowrap">Supervisor I</th>
                                        <th colspan="2" class="align-middle text-nowrap">Supervisor II</th>
                                        <th colspan="2" class="align-middle text-nowrap">Manager</th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-nowrap">Nama</th>
                                        <th class="align-middle text-nowrap">Tanggal</th>
                                        <th class="align-middle text-nowrap">Nama</th>
                                        <th class="align-middle text-nowrap">Tanggal</th>
                                        <th class="align-middle text-nowrap">Nama</th>
                                        <th class="align-middle text-nowrap">Tanggal</th>
                                        <th class="align-middle text-nowrap">Nama</th>
                                        <th class="align-middle text-nowrap">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($document); $i ++){
                                        $itemsTotal = count($document[$i]['items']); ?>
                                        <?php for ($j = 0; $j < $itemsTotal; $j++){ ?>
                                            <?php if ($j == 0): ?>
                                                <tr>
                                                    <th scope="row" class="align-middle" rowspan="<?= $itemsTotal ?>"><?= $i + 1 ?></th>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['type'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['proofNumber'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['projectCode'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['contractNumber'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['customerName'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['recipientName'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['category'] ?></td>
                                                    <td class="text-nowrap"><?= ucwords(strtolower($document[$i]['items'][$j]['description'])) ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['unitRef'] ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['moreDescription'] == null || empty($document[$i]['items'][$j]['moreDescription']) ? '-' : $document[$i]['items'][$j]['moreDescription'] ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['beginningPeriod'] == null || empty($document[$i]['items'][$j]['beginningPeriod']) ? '-' : date('d/m/Y', strtotime($document[$i]['items'][$j]['beginningPeriod'])) . ' - ' . date('d/m/Y', strtotime($document[$i]['items'][$j]['endPeriod'])) ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['amount'] ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['unit'] ?></td>
                                                    <td class="text-nowrap">Rp<?= number_format($document[$i]['items'][$j]['unitPrice'], 0, '', ',') ?></td>
                                                    <td class="text-nowrap">Rp<?= number_format($document[$i]['items'][$j]['totalPrice'], 0, '', ',') ?></td>
                                                    <td class="text-nowrap align-middle">Rp<?= number_format($document[$i]['total'], 0, '', ',') ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['admin']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['admin']['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_I']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_I']['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_II']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_II']['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['manager']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['manager']['date'] ?></td>
                                                </tr>
                                            <?php elseif ($j > 0): ?>
                                                <tr>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['type'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['proofNumber'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['projectCode'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['contractNumber'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['customerName'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['recipientName'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['category'] ?></td>
                                                    <td class="text-nowrap"><?= ucwords(strtolower($document[$i]['items'][$j]['description'])) ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['unitRef'] ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['moreDescription'] == null || empty($document[$i]['items'][$j]['moreDescription']) ? '-' : $document[$i]['items'][$j]['moreDescription'] ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['beginningPeriod'] == null || empty($document[$i]['items'][$j]['beginningPeriod']) ? '-' : date('d/m/Y', strtotime($document[$i]['items'][$j]['beginningPeriod'])) . ' - ' . date('d/m/Y', strtotime($document[$i]['items'][$j]['endPeriod'])) ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['amount'] ?></td>
                                                    <td class="text-nowrap"><?= $document[$i]['items'][$j]['unit'] ?></td>
                                                    <td class="text-nowrap">Rp<?= number_format($document[$i]['items'][$j]['unitPrice'], 0, '', ',') ?></td>
                                                    <td class="text-nowrap">Rp<?= number_format($document[$i]['items'][$j]['totalPrice'], 0, '', ',') ?></td>
                                                    <td class="text-nowrap align-middle">Rp<?= number_format($document[$i]['total'], 0, '', ',') ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['admin']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['admin']['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_I']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_I']['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_II']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['supervisor_II']['date'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['manager']['name'] ?></td>
                                                    <td class="text-nowrap align-middle"><?= $document[$i]['approval']['manager']['date'] ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php }
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script type="text/javascript">
            const exportBtn = document.getElementById('exportBtn')
            exportBtn.addEventListener('click', (e) => {
                e.preventDefault()
                
                const data = document.getElementById('exportTable')

                const file = XLSX.utils.table_to_book(data, {sheet: "sheet1"})
        
                XLSX.write(file, { bookType: 'xlsx', bookSST: true, type: 'base64' })
        
                XLSX.writeFile(file, '<?= $fileName ?>.' + 'xlsx')
            })
        </script>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
    </body>
</html>