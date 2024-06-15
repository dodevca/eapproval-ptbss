<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Download <?= $breadcrumb ?> | Dashboard</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>"/>
        <script src="https://kit.fontawesome.com/ff94f270b6.js" crossorigin="anonymous"></script>
        <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet" />
    </head>
    <body class="bg-white pt-4">
        <div id="softcopyWrapper" class="container-fluid">
            <div id="softcopy" class="card shadow mx-auto">
                <div class="card-header d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= base_url('images/logo-cropped.png') ?>" width="52px" height="52px" />
                        <div>
                            <h1 class="h4 mb-0"><?= ucwords($document['type'])?></h1>
                            <p class="text-muted mb-0">PT. Banggai Sentral Sulawesi</p>
                        </div>
                    </div>
                    <h2 class="text-secondary fst-italic" id="docName"><?= $document['proofNumber'] ?></h2>
                </div>
                <div class="card-body">
                    <div class="card-subject shadow-sm rounded p-3 mb-4">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <h3 class="h6 fw-bold mb-1">Nomor Bukti</h3>
                                <h4><?= $document['proofNumber'] ?></h4>
                            </div>
                            <div class="col-6 mb-3 text-end">
                                <h3 class="h6 fw-bold mb-1">Tanggal Pengajuan</h3>
                                <h4><?= $document['date'] ?></h4>
                            </div>
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <td>Referensi</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $document['projectCode'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Kontrak</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $document['contractNumber'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $document['category'] ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <td>Pelanggan</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $document['customerName'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><?= $document['type'] == 'permintaan pembayaran' ? 'Penerima' : 'Asal Setoran' ?></td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $document['recipientName'] ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h5 class="ms-2 mb-4 text-center">Rincian Keperluan</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Keperluan</th>
                                <th scope="col">Kode Ref.</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Periode</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < count($document['items']);$i++) { ?>
                                <tr>
                                    <th scope="row"><?= $i + 1 ?></th>
                                    <td><?= $document['items'][$i]['description'] ?></td>
                                    <td><?= $document['items'][$i]['unitRef'] ?></td>
                                    <td><?= $document['items'][$i]['moreDescription'] == null || empty($document['items'][$i]['moreDescription']) ? '-' : $document['items'][$i]['moreDescription'] ?></td>
                                    <td><?= $document['items'][$i]['beginningPeriod'] == null || empty($document['items'][$i]['beginningPeriod']) ? '-' : date('d/m/Y', strtotime($document['items'][$i]['beginningPeriod'])) . ' - ' . date('d/m/Y', strtotime($document['items'][$i]['endPeriod'])) ?></td>
                                    <td class="amount"><?= $document['items'][$i]['amount'] ?></td>
                                    <td class="unit"><?= $document['items'][$i]['unit'] ?></td>
                                    <td class="price text-end"><?= $document['items'][$i]['unitPrice'] < 0 ? '- Rp' . number_format(abs($document['items'][$i]['unitPrice']), 0, '', '.') : 'Rp' . number_format($document['items'][$i]['unitPrice'], 0, '', '.') ?></td>
                                    <td class="price text-end"><?= $document['items'][$i]['totalPrice'] < 0 ? '- Rp' . number_format(abs($document['items'][$i]['totalPrice']), 0, '', '.') : 'Rp' . number_format($document['items'][$i]['totalPrice'], 0, '', '.') ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th scope="row" colspan="8" class="text-end">Jumlah Harga</th>
                                <td class="price text-end"><?= $document['total'] < 0 ? '- Rp' . number_format(abs($document['total']), 0, '', '.') : 'Rp' . number_format($document['total'], 0, '', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div id="approval" class="row align-items-start approval">
                        <div id="approved" class="col-4 text-center approved">
                            <?php if ($document['approval']['Manager'] != null): ?>
                                <img src="<?= base_url('/images/approved.png') ?>" style="width: 100%;height: auto;max-height: 100px;" />
                            <?php endif; ?>
                        </div>
                        <div class="col-2">
                            <div id="manager" class="d-flex flex-column align-items-center">
                                <h5 class="hierarchy">Manager</h5>
                                <div class="signature">
                                    <?= $document['approval']['Manager'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Manager']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name"><?= $document['approval']['Manager'] != null ? $document['approval']['Manager'] : '' ?></p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div id="supervisor-i" class="d-flex flex-column align-items-center">
                                <h5 class="hierarchy">Supervisor II</h5>
                                <div class="signature">
                                    <?= $document['approval']['Supervisor_II'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Supervisor_II']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name"><?= $document['approval']['Supervisor_II'] != null ? $document['approval']['Supervisor_II'] : '' ?></p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div id="supervisor-ii" class="d-flex flex-column align-items-center">
                                <h5 class="hierarchy">Supervisor I</h5>
                                <div class="signature">
                                    <?= $document['approval']['Supervisor_I'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Supervisor_I']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name"><?= $document['approval']['Supervisor_I'] != null ? $document['approval']['Supervisor_I'] : '' ?></p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div id="admin" class="d-flex flex-column align-items-center">
                                <h5 class="hierarchy">Admin</h5>
                                <div class="signature">
                                    <?= $document['approval']['Admin'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Admin']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name"><?= $document['approval']['Admin'] != null ? $document['approval']['Admin'] : '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mx-auto pt-4 gap-2">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-secondary" ><i class="fa-solid fa-chevron-left me-2"></i>Kembali</a>
        </div>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function(){
                const element = document.getElementById('softcopy')
                const opt = {
                    margin      : 0,
                    filename    : 'E-Approval - ' + document.getElementById('docName').innerHTML + '.pdf',
                    image       : { type: 'png', quality: 1 },
                    html2canvas : { scale: 2 },
                    jsPDF       : { unit: 'in', format: 'B3', orientation: 'portrait' }
                }
                html2pdf().set(opt).from(element).save()
            })
        </script>
        <script src="<?= base_url('js/scripts.js') ?>"></script>
    </body>
</html>