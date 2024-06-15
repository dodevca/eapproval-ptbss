<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= ucwords($document['type'])?> <?= $breadcrumb ?> | Dashboard</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
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
                        <h1 class="h2 mt-4"><?= $document['proofNumber'] ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item">View</li>
                            <li class="breadcrumb-item active"><?= $breadcrumb ?></li>
                        </ol>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h2 class="h5"><?= ucwords($document['type']) ?> yang diajukan oleh : <?= $document['email'] ?></h2>
                        </div>
                        <div class="position-relative py-3 mx-auto mb-4" style="max-width:1220px">
                            <div class="row">
                                <div class="col-3">
                                    <p class="mx-2 text-center">Admin</p>
                                </div>
                                <div class="col-3">
                                    <p class="mx-2 text-center">Supervisor I</p>
                                </div>
                                <div class="col-3">
                                    <p class="mx-2 text-center">Supervisor II</p>
                                </div>
                                <div class="col-3">
                                    <p class="mx-2 text-center">Manager</p>
                                </div>
                            </div>
                            <?php
                            if($document['approval']['Admin'] == null && $document['approval']['Supervisor_I'] == null && $document['approval']['Supervisor_II'] == null && $document['approval']['Manager'] == null)
                            {
                                $progressLenght = '11';
                            }
                            else if($document['approval']['Admin'] != null && $document['approval']['Supervisor_I'] == null && $document['approval']['Supervisor_II'] == null && $document['approval']['Manager'] == null)
                            {
                                $progressLenght = '37';
                            }
                            else if($document['approval']['Admin'] != null && $document['approval']['Supervisor_I'] != null && $document['approval']['Supervisor_II'] == null && $document['approval']['Manager'] == null)
                            {
                                $progressLenght = '63';
                            }
                            else if($document['approval']['Admin'] != null && $document['approval']['Supervisor_I'] != null && $document['approval']['Supervisor_II'] != null && $document['approval']['Manager'] == null)
                            {
                                $progressLenght = '88';
                            }
                            else if($document['approval']['Admin'] != null && $document['approval']['Supervisor_I'] != null && $document['approval']['Supervisor_II'] != null && $document['approval']['Manager'] != null)
                            {
                                $progressLenght = '100';
                            }
                            else
                            {
                                $progressLength = '0';
                            }
                            ?>
                            <div class="position-absolute row" style="top:50%;left:0;right:0;bottom:auto;transform:translateY(-50%)">
                                <div class="col-3">
                                    <div class="
                                    <?php
                                    if ($document['approval']['Admin'] == null && $document['approval']['Supervisor_I'] == null && $document['disapproval'] == null)
                                    {
                                        echo 'bg-warning';
                                    }
                                    else if($document['approval']['Admin'] != null && $document['approval']['Supervisor_I'] == null && $document['disapproval'] != null)
                                    {
                                       echo 'bg-info'; 
                                    }
                                    else if($document['approval']['Admin'] == null && $document['approval']['Supervisor_I'] == null && $document['disapproval'] != null)
                                    {
                                        echo 'bg-danger';
                                    }
                                    else if($document['approval']['Admin'] != null)
                                    {
                                        echo 'bg-success';
                                    }
                                    else
                                    {
                                        echo 'bg-light';
                                    }
                                    ?>
                                    mx-auto rounded-circle" style="height:24px;width:24px;"></div>
                                </div>
                                <div class="col-3">
                                    <div class="
                                    <?php
                                    if ($document['approval']['Supervisor_I'] == null && $document['approval']['Admin'] != null && $document['approval']['Supervisor_II'] == null && $document['disapproval'] == null)
                                    {
                                        echo 'bg-warning';
                                    }
                                    else if($document['approval']['Supervisor_I'] != null && $document['approval']['Supervisor_II'] == null && $document['disapproval'] != null)
                                    {
                                       echo 'bg-info'; 
                                    }
                                    else if($document['approval']['Supervisor_I'] == null && $document['approval']['Admin'] != null && $document['approval']['Supervisor_II'] == null && $document['disapproval'] != null)
                                    {
                                        echo 'bg-danger';
                                    }
                                    else if($document['approval']['Supervisor_I'] != null)
                                    {
                                        echo 'bg-success';
                                    }
                                    else
                                    {
                                        echo 'bg-light';
                                    }
                                    ?>
                                    mx-auto rounded-circle" style="height:24px;width:24px;"></div>
                                </div>
                                <div class="col-3">
                                    <div class="
                                    <?php
                                    if ($document['approval']['Supervisor_II'] == null && $document['approval']['Supervisor_I'] != null && $document['approval']['Manager'] == null && $document['disapproval'] == null)
                                    {
                                        echo 'bg-warning';
                                    }
                                    else if($document['approval']['Supervisor_II'] != null && $document['approval']['Manager'] == null && $document['disapproval'] != null)
                                    {
                                       echo 'bg-info'; 
                                    }
                                    else if($document['approval']['Supervisor_II'] == null && $document['approval']['Supervisor_I'] != null && $document['approval']['Manager'] == null && $document['disapproval'] != null)
                                    {
                                        echo 'bg-danger';
                                    }
                                    else if($document['approval']['Supervisor_II'] != null)
                                    {
                                        echo 'bg-success';
                                    }
                                    else
                                    {
                                        echo 'bg-light';
                                    }
                                    ?>
                                    mx-auto rounded-circle" style="height:24px;width:24px;"></div>
                                </div>
                                <div class="col-3">
                                    <div class="
                                    <?php
                                    if ($document['approval']['Manager'] == null && $document['approval']['Supervisor_II'] != null && $document['disapproval'] == null)
                                    {
                                        echo 'bg-warning';
                                    }
                                    else if($document['approval']['Manager'] == null && $document['approval']['Supervisor_II'] != null && $document['disapproval'] != null)
                                    {
                                        echo 'bg-danger';
                                    }
                                    else if($document['approval']['Manager'] != null)
                                    {
                                        echo 'bg-success';
                                    }
                                    else
                                    {
                                        echo 'bg-light';
                                    }
                                    ?>
                                    mx-auto rounded-circle" style="height:24px;width:24px;"></div>
                                </div>
                            </div>
                            <div class="progress bg-white shadow-sm" style="height: 8px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $progressLenght ?>%" aria-valuenow="<?= $progressLenght ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <p class="mb-0 mt-3 mx-2 text-center">
                                        <?php
                                        if ($document['approval']['Admin'] == null && $document['approval']['Supervisor_I'] == null && $document['disapproval'] == null)
                                        {
                                            echo 'On Progress';
                                        }
                                        else if($document['approval']['Admin'] != null && $document['approval']['Supervisor_I'] == null && $document['disapproval'] != null)
                                        {
                                           echo 'On Returned'; 
                                        }
                                        else if($document['approval']['Admin'] == null && $document['approval']['Supervisor_I'] == null && $document['disapproval'] != null)
                                        {
                                            echo 'Disapproved';
                                        }
                                        else if($document['approval']['Admin'] != null)
                                        {
                                            echo 'Approved';
                                        }
                                        else
                                        {
                                            echo 'Not Received';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p class="mb-0 mt-3 mx-2 text-center">
                                        <?php
                                        if ($document['approval']['Supervisor_I'] == null && $document['approval']['Admin'] != null && $document['approval']['Supervisor_II'] == null && $document['disapproval'] == null)
                                        {
                                            echo 'On Progress';
                                        }
                                        else if($document['approval']['Supervisor_I'] != null && $document['approval']['Supervisor_II'] == null && $document['disapproval'] != null)
                                        {
                                           echo 'On Returned'; 
                                        }
                                        else if($document['approval']['Supervisor_I'] == null && $document['approval']['Admin'] != null && $document['approval']['Supervisor_II'] == null && $document['disapproval'] != null)
                                        {
                                            echo 'Disapproved';
                                        }
                                        else if($document['approval']['Supervisor_I'] != null)
                                        {
                                            echo 'Approved';
                                        }
                                        else
                                        {
                                            echo 'Not Received';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p class="mb-0 mt-3 mx-2 text-center">
                                        <?php
                                        if ($document['approval']['Supervisor_II'] == null && $document['approval']['Supervisor_I'] != null && $document['approval']['Manager'] == null && $document['disapproval'] == null)
                                        {
                                            echo 'On Progress';
                                        }
                                        else if($document['approval']['Supervisor_II'] != null && $document['approval']['Manager'] == null && $document['disapproval'] != null)
                                        {
                                           echo 'On Returned'; 
                                        }
                                        else if($document['approval']['Supervisor_II'] == null && $document['approval']['Supervisor_I'] != null && $document['approval']['Manager'] == null && $document['disapproval'] != null)
                                        {
                                            echo 'Disapproved';
                                        }
                                        else if($document['approval']['Supervisor_II'] != null)
                                        {
                                            echo 'Approved';
                                        }
                                        else
                                        {
                                            echo 'Not Received';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="col-3">
                                    <p class="mb-0 mt-3 mx-2 text-center">
                                        <?php
                                        if ($document['approval']['Manager'] == null && $document['approval']['Supervisor_II'] != null && $document['disapproval'] == null)
                                        {
                                            echo 'On Progress';
                                        }
                                        else if($document['approval']['Manager'] == null && $document['approval']['Supervisor_II'] != null && $document['disapproval'] != null)
                                        {
                                            echo 'Disapproved';
                                        }
                                        else if($document['approval']['Manager'] != null)
                                        {
                                            echo 'Approved';
                                        }
                                        else
                                        {
                                            echo 'Not Received';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mb-3 mx-auto" style="max-width:1220px">
                            <button type="button" class="btn btn-outline-secondary" id="downloadPdf"><i class="fa-solid fa-download me-2"></i>Unduh</button>
                        </div>
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
                                                <img src="<?= base_url('images/approved.png') ?>" style="width: 100%;height: auto;max-height: 100px;" />
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-2">
                                            <div id="manager" class="d-flex flex-column align-items-center justify-content-between">
                                                <h5 class="hierarchy">Manager</h5>
                                                <div class="signature">
                                                    <?= $document['approval']['Manager'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Manager']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                                </div>
                                                <p class="name"><?= $document['approval']['Manager'] != null ? $document['approval']['Manager'] : '' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div id="supervisor-i" class="d-flex flex-column align-items-center justify-content-between">
                                                <h5 class="hierarchy">Supervisor II</h5>
                                                <div class="signature">
                                                    <?= $document['approval']['Supervisor_II'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Supervisor_II']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                                </div>
                                                <p class="name"><?= $document['approval']['Supervisor_II'] != null ? $document['approval']['Supervisor_II'] : '' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div id="supervisor-ii" class="d-flex flex-column align-items-center justify-content-between">
                                                <h5 class="hierarchy">Supervisor I</h5>
                                                <div class="signature">
                                                    <?= $document['approval']['Supervisor_I'] != null ? '<img src="' . base_url('uploads/signatures/' . base64_encode($document['approval']['Supervisor_I']) . '.png') . '" width="72px" height="72px"/>' : '' ?>
                                                </div>
                                                <p class="name"><?= $document['approval']['Supervisor_I'] != null ? $document['approval']['Supervisor_I'] : '' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div id="admin" class="d-flex flex-column align-items-center justify-content-between">
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
                            <?php if ($document['file']['attachment'] != null || !empty($document['file']['attachment'])): ?>
                                <?php foreach($document['file']['attachment'] as $key => $attacment) { ?>
                                    <a href="https://form.devisigeneralservicebss.com/attachments/<?= $attacment ?>" target="_blank" class="btn btn-secondary" ><i class="fa-solid fa-paperclip me-2"></i>Lampiran <?= $key + 1 ?></a>
                                <?php } ?>
                            <?php endif; ?>
                        </div>
                        <?php if(($document['approval'][$as] == null && $document['disapproval'] == null) || ($document['approval'][$as] != null && $document['disapproval'] != null && $document['approval'][$approval['nextHierarchy']] == null)): ?>
                            <?php if($document['approval'][$as] != null && $document['disapproval'] != null && $document['notes'] != null): ?>
                                <div class="text-center rounded border border-1 p-3 mt-4 mx-auto" style="max-width:1220px">
                                    <h2 class="h5">Catatan</h2>
                                    <p class="text-start"><?= nl2br($document['notes']) ?></p>
                                </div>
                            <? endif; ?>
                            <div class="text-center rounded border border-1 p-3 mt-4 mx-auto" style="max-width:1220px">
                                <h2 class="h5">Respon Anda</h2>
                                <div class="d-flex align-items-center justify-content-center mx-auto mt-4 gap-2">
                                    <?php if($document['approval'][$as] == null && $document['disapproval'] == null): ?>
                                        <a href="https://form.devisigeneralservicebss.com/submit/approve?approver=<?= urlencode(base64_encode($accounts[0]['email'])) ?>&as=<?= urlencode(base64_encode($as)) ?>&doc=<?= $document['file']['submission'] ?>" target="_blank" class="btn btn-success" ><i class="fa-solid fa-check me-2"></i>Terima</a>
                                        <button type="button" class="btn btn-danger" onClick="inputNotes()"><i class="fa-solid fa-xmark me-2"></i>Tolak</button>
                                        <?php if($as == 'Supervisor_I' || $as == 'Supervisor_II'): ?>
                                            <a href="<?= base_url('edit/' . $document['file']['submission']) ?>" class="btn btn-outline-success" ><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="<?= base_url('edit/' . $document['file']['submission']) ?>" class="btn btn-success" ><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                        <a href="https://form.devisigeneralservicebss.com/submit/approve?approver=<?= urlencode(base64_encode($accounts[0]['email'])) ?>&as=<?= urlencode(base64_encode($as)) ?>&doc=<?= $document['file']['submission'] ?>" target="_blank" class="btn btn-outline-success" ><i class="fa-solid fa-file me-2"></i>Ajukan Kembali</a>
                                        <button type="button" class="btn btn-danger" onClick="inputNotes()"><i class="fa-solid fa-xmark me-2"></i>Turunkan</button>
                                    <?php endif; ?>
                                </div>
                                <div class="text-start mt-4 d-none" id="notesForm">
                                        <p>Berikan catatan kepada <?= $approval['prevHierarchy'] == null || $approval['prevHierarchy'] == '' ? 'Pemohon' : str_replace('_', ' ', $approval['prevHierarchy']) ?> terlebih dahulu!</p>
                                    <?= form_open('https://form.devisigeneralservicebss.com/submit/disapprove', ['target' => '_blank']); ?>
                                        <input type="text" class="d-none" name="approver" value="<?= urlencode(base64_encode($accounts[0]['email'])) ?>" />
                                        <input type="text" class="d-none" name="as" value="<?= urlencode(base64_encode($as)) ?>" required />
                                        <input type="text" class="d-none" name="doc" value="<?= $document['file']['submission'] ?>" required />
                                        <div class="mb-3">
                                            <textarea class="form-control" id="notes" name="notes" rows="4" required ></textarea>
                                        </div>
                                        <button class="btn btn-outline-danger" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        <? endif; ?>
                        <?php if($document['approval']['Manager'] == null && $document['approval'][$as] != null && $document['approval'][$approval['nextHierarchy']] == null && $document['disapproval'] == null): ?>
                            <div class="text-center rounded border border-1 p-3 mt-4 mx-auto" style="max-width:1220px">
                                <h2 class="h5">Edit Dokumen</h2>
                                <div class="d-flex align-items-center justify-content-center mx-auto">
                                    <a href="<?= base_url('edit/' . $document['file']['submission']) ?>" class="btn btn-outline-success" ><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script type="text/javascript">
            function inputNotes(){
                document.getElementById('notesForm').classList.remove('d-none');
                document.getElementById('notesForm').classList.add('d-block');
            }
        </script>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="<?= base_url('js/pdf.js') ?>" type="text/javascript"></script>
    </body>
</html>