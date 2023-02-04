<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Download Recap By Item | Dashboard</title>
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
                            <h1 class="h4 mb-0">Rekap Keperluan</h1>
                            <p class="text-muted mb-0">PT. Banggai Sentral Sulawesi</p>
                        </div>
                    </div>
                    <h2 class="text-secondary fst-italic" id="docName"><?= ucwords($query['description'])?></h2>
                </div>
                <div class="card-body">
                    <div class="card-subject shadow-sm rounded p-3 mb-4">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <h3 class="h6 fw-bold mb-1">Keperluan</h3>
                                <h4><?= $query['description'] ?></h4>
                            </div>
                            <div class="col-6 mb-3 text-end">
                                <h3 class="h6 fw-bold mb-1">Kode Referensi</h3>
                                <h4><?= $query['refcode'] ?></h4>
                            </div>
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <td>Jenis Dokumen</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= ucwords($query['type']) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Kontrak</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $query['contractNumber'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $query['category'] ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <table>
                                    <tr>
                                        <td>Tahun Pengajuan</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= $query['year'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Periode Awal</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= date("d/m/Y", strtotime($query['beginningPeriod'])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Periode Akhir</td>
                                        <td class="px-2">:</td>
                                        <td><strong><?= date("d/m/Y", strtotime($query['endPeriod'])) ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h5 class="ms-2 mb-4 text-center">Rekap Keperluan</h5>
                    <table class="table table-bordered py-3" id="exportTable">
                        <thead>
                            <tr>
                                <th scope="col" >Tanggal</th>
                                <th scope="col" >Nomor Bukti</th>
                                <th scope="col" >Keterangan</th>
                                <th scope="col" >Jumlah</th>
                                <th scope="col" >Satuan</th>
                                <th scope="col" >Harga Satuan</th>
                                <th scope="col" >Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 0; $i < count($result); $i++) { ?>
                                <tr>
                                    <td class="text-end"><?= $result[$i]['date'] ?></td>
                                    <td ><?= $result[$i]['proofNumber'] ?></td>
                                    <td ><?= $result[$i]['moreDescription'] ?></td>
                                    <td class="text-center"><?= $result[$i]['amount'] ?></td>
                                    <td ><?= $result[$i]['unit'] ?></td>
                                    <td class="text-end">Rp<?= number_format($result[$i]['unitPrice'], 0, '', '.') ?></td>
                                    <td class="text-end">Rp<?= number_format($result[$i]['totalPrice'], 0, '', '.') ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="6" class="text-center ">Total</td>
                                <td class="text-end ">Rp<?= number_format($total, 0, '', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
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
                    filename    : 'E-Approval - Recap ' + document.getElementById('docName').innerHTML + '.pdf',
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