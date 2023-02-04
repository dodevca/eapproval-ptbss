<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= 'Permintaan '. ucwords($type) . ' - ' . $document['proofNumber'] ?></title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
        <link rel="stylesheet" href="<?= base_url('/css/app.css') ?>" >
        <script src="https://kit.fontawesome.com/ff94f270b6.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    </head>
    <body class="bg-light">
        <?= $this->include('partials/nav'); ?>
        <main>
            <div class="container-fluid bg-primary text-center py-4">
                <h1 class="h3 mb-0 text-center text-white"><?= ucwords($type) ?></h1>
            </div>
            <div class="container py-4">
                <?php if ($message != 'Document is already exist.'): ?>
                    <h2 class="h4 text-center"><?= ucwords($type) ?> anda telah dikirim!</h2>
                    <p class="text-center">Kemajuan persetujuan formulir akan dikirim ke <u><?= $email; ?></u>.</p>
                    <div class="alert alert-warning mb-4 mx-auto" role="alert" style="max-width:520px;">
                      Jika anda tidak menerima e-mail, diharapkan untuk membuka <strong>Spam E-mail</strong>! Kemudian klik <strong>Laporkan bukan spam</strong>!
                    </div>
                    <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between pt-3 px-lg-3 gap-3 mx-auto" style="max-width:1220px">
                        <h6 class="mb-0 order-2 order-lg-1">Preview :</h6>
                        <div class="d-flex align-items-center justify-content-center gap-2 order-1 order-lg-2">
                            <button type="button" class="btn btn-primary" id="downloadPdf"><i class="fa-solid fa-download me-2"></i>Unduh Bukti</button>
                        </div>
                    </div>
                <?php else: ?>
                    <h2 class="h4 text-center text-danger">Permintaan <?= ucwords($type) ?> dengan nomor bukti <?= $document['proofNumber'] ?> pernah diajukan!</h2>
                    <p class="text-center">Permintaan <?= $type ?> diajukan oleh <u><?= $email; ?></u>.</p>
                    <div class="alert alert-warning mb-4 mx-auto" role="alert" style="max-width:520px;">
                      Jika anda tidak menerima e-mail, diharapkan untuk membuka <strong>Spam E-mail</strong>! Kemudian klik <strong>Laporkan bukan spam</strong>!
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($message != 'Document is already exist.'): ?>
            <div id="softcopyWrapper" class="container-fluid">
                <div id="softcopy" class="card shadow mx-auto">
                    <div class="card-header d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= base_url('/images/logo-cropped.png') ?>" width="52px" height="52px" />
                            <div>
                                <h1 class="h4 mb-0">Permintaan <?= ucwords($type)?></h1>
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
                                            <td><?= $type == 'permintaan pembayaran' ? 'Penerima' : 'Asal Setoran' ?></td>
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
                                <?php for ($i = 0; $i < count($items);$i++) { ?>
                                    <tr>
                                        <th scope="row"><?= $i + 1 ?></th>
                                        <td><?= $items[$i]['description'] ?></td>
                                        <td><?= $items[$i]['unitRef'] ?></td>
                                        <td><?= $items[$i]['moreDescription'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($items[$i]['beginningPeriod'])) ?> - <?= date('d/m/Y', strtotime($items[$i]['endPeriod'])) ?></td>
                                        <td class="amount"><?= $items[$i]['amount'] ?></td>
                                        <td class="unit"><?= $items[$i]['unit'] ?></td>
                                        <td class="price text-end"><?= $items[$i]['unitPrice'] < 0 ? '- Rp' . number_format(abs($items[$i]['unitPrice']), 0, '', '.') : 'Rp' . number_format($items[$i]['unitPrice'], 0, '', '.') ?></td>
                                        <td class="price text-end"><?= $items[$i]['totalPrice'] < 0 ? '- Rp' . number_format(abs($items[$i]['totalPrice']), 0, '', '.') : 'Rp' . number_format($items[$i]['totalPrice'], 0, '', '.') ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th scope="row" colspan="8" class="text-end">Jumlah Harga</th>
                                    <td class="price text-end"><?= $total < 0 ? '- Rp' . number_format(abs($total), 0, '', '.') : 'Rp' . number_format($total, 0, '', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div id="approval" class="row align-items-start approval">
                            <div id="approved" class="col-4 text-center approved">
                            </div>
                            <div class="col-2">
                                <div id="manager" class="d-flex flex-column align-items-center">
                                    <h5 class="hierarchy">Manager</h5>
                                    <div class="signature">
                                        <?= $approval['Manager'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Manager']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                    </div>
                                    <p class="name"><?= $approval['Manager'] != null ? $approval['Manager'] : '' ?></p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div id="supervisor-i" class="d-flex flex-column align-items-center">
                                    <h5 class="hierarchy">Supervisor II</h5>
                                    <div class="signature">
                                        <?= $approval['Supervisor_II'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Supervisor_II']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                    </div>
                                    <p class="name"><?= $approval['Supervisor_II'] != null ? $approval['Supervisor_II'] : '' ?></p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div id="supervisor-ii" class="d-flex flex-column align-items-center">
                                    <h5 class="hierarchy">Supervisor I</h5>
                                    <div class="signature">
                                        <?= $approval['Supervisor_I'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Supervisor_I']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                    </div>
                                    <p class="name"><?= $approval['Supervisor_I'] != null ? $approval['Supervisor_I'] : '' ?></p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div id="admin" class="d-flex flex-column align-items-center">
                                    <h5 class="hierarchy">Admin</h5>
                                    <div class="signature">
                                        <?= $approval['Admin'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Admin']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                    </div>
                                    <p class="name"><?= $approval['Admin'] != null ? $approval['Admin'] : '' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="text-center mt-5">
                <a href="<?= base_url() ?>" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-left me-2"></i>Beranda</a>
            </div>
        </main>
        <?= $this->include('partials/footer'); ?>
        <script src="<?= base_url('/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="<?= base_url('/js/pdf.js') ?>" type="text/javascript"></script>
    </body>
</html>
