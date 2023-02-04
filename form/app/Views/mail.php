<html style="box-sizing:border-box;" >
    <head style="box-sizing:border-box;" >
        <meta charset="UTF-8" style="box-sizing:border-box;" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" style="box-sizing:border-box;" />
        <title style="box-sizing:border-box;" ><?= ucwords($type)?> - <?= $document['proofNumber'] ?></title>
    </head>
    <body class="bg-light" style="box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:'Open Sans', sans-serif;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);" >
        <?php if ($message != 'Disapproved.'): ?>
            <?php if ($sender == 'approver'): ?>
                <p>Hallo, <?= base64_decode(urldecode($approver['email'])) ?>.</p>
                <p>Anda diharapkan melakukan pengecekan dan respon terkait <?= ucwords($type) ?> di bawah ini :</p>
            <?php else: ?>
                <?php if($message == 'Approved.'): ?>
                    <p>Hallo, <?= $email?>.</p>
                    <p><?= ucwords($type) ?> anda sudah disetujui oleh :</p>
                    <p><?= ucwords(str_replace('_', '', $approved['hierarchy'])) ?> : <?= $approved['name'] ?></p>
                    <p>Tanggal : <?= date('d-m-Y', strtotime($approval['date'])) ?></p>
                    <p>Jam : <?= date('H:i', strtotime($approval['date'])) ?></p>
                    <?php if ($nextApprover != null): ?>
                        <p>Selanjutnya <?= ucwords($type) ?> anda akan dilanjutkan kepada <strong><?= $nextApprover?></strong> untuk dilakukan pengecekan terhadap <?= ucwords($type) ?> anda.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Hallo, <?= $email?>.</p>
                    <p><?= ucwords($type) ?> anda berhasil diajukan.</p>
                    <p>Berikut adalah bukti <?= ucwords($type) ?> anda :</p>
                <?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if ($sender == 'approver'): ?>
                <p>Hallo, <?= base64_decode(urldecode($approver['email'])) ?>.</p>
                <p><?= ucwords($type) ?> ini dikembalikan oleh :</p>
                <p><?= str_replace('_', '', $disapproved['hierarchy']) ?> : <?= $disapproved['name'] ?></p>
                <p>Anda diharapkan melakukan pengecekan kembali.</p>
                <?php if (!empty($notes) && $notes != null): ?>
                    <p>Berikut beberapa yang perlu diperbaiki :</p>
                    <p><?= $notes ?></p>
                <?php endif; ?>
            <?php else: ?>
                <p>Hallo, <?= $email?>.</p>
                <p><?= ucwords($type) ?> anda ditolak oleh <?= $disapproved['name'] . ' (' . str_replace('_', '', $disapproved['hierarchy']) . ')' ?></p>
                <?php if ($approval['Admin'] == null): ?>
                    <p>Silahkan ajukan kembali <?= ucwords($type) ?> anda dan masukkan data yang valid.</p>
                    <?php if (!empty($notes) && $notes != null): ?>
                        <p>Berikut beberapa yang perlu diperbaiki :</p>
                        <p><?= $notes ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Sedang dilakukan pengecekan kembali pada <?= ucwords($type) ?> anda.</p>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        <div id="softcopyWrapper" class="container-fluid" style="box-sizing:border-box;background-color:#fff;margin-top:1rem;" >
            <div id="softcopy" class="card shadow mx-auto" style="box-sizing:border-box;position:relative;height:auto;word-wrap:break-word;background-color:#fff;margin-right:auto!important;margin-left:auto!important;min-width:680px;width:100%;padding-top:1.5rem;padding-bottom:1.5rem;padding-right:1.5rem;padding-left:1.5rem;border-style:none;box-shadow:rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;" >
                <div class="card-header d-flex align-items-center justify-content-between gap-3" style="box-sizing:border-box;padding-top:0.5rem;padding-bottom:0.5rem;padding-right:1rem;padding-left:1rem;margin-bottom:0;color:#212529;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:rgba(0, 0, 0, 0.175);display:flex!important;align-items:center!important;gap:1rem!important;border-style:none;background-color:#fff;" >
                    <div class="d-flex align-items-center gap-3" style="box-sizing:border-box;display:flex!important;align-items:center!important;gap:1rem!important;" >
                        <img src="<?= base_url('/images/logo-cropped.png') ?>" width="52px" height="52px" style="box-sizing:border-box;vertical-align:middle;" />
                        <h1 class="h4 mb-0" style="box-sizing:border-box;margin-top:0;font-weight:500;line-height:1.2;font-size:1.5rem;margin-bottom:0!important;margin-left:0.5rem;margin-top:11px;" ><?= ucwords($type)?></h1>
                    </div>
                    <h2 class="text-secondary fst-italic" style="box-sizing:border-box;margin-top:0;margin-bottom:0.5rem;font-weight:500;line-height:1.2;font-size:2rem;font-style:italic!important;color:rgba(0, 150, 192, 1)!important;margin-left:auto" ><?= $document['proofNumber'] ?></h2>
                </div>
                <div class="card-body" style="box-sizing:border-box;flex:1 1 auto;padding-top:1rem;padding-bottom:1rem;padding-right:1rem;padding-left:1rem;color:#212529;" >
                    <div class="card-subject shadow-sm rounded p-3 mb-4" style="box-sizing:border-box;margin-bottom:1.5rem!important;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;border-radius:0.375rem!important;color:#fff;background-color:#001c46;" >
                        <div class="row" style="box-sizing:border-box;display:flex;flex-wrap:wrap;margin-top:calc(-1 * 0);margin-right:calc(-0.5 * 1.5rem);margin-left:calc(-0.5 * 1.5rem);" >
                            <div class="col-6 mb-3" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:50%;margin-bottom:1rem!important;" >
                                <h3 class="h6 fw-bold mb-1" style="box-sizing:border-box;margin-top:0;line-height:1.2;font-size:1rem;margin-bottom:0.25rem!important;font-weight:700!important;color:#fff" >Nomor Bukti</h3>
                                <h4 style="box-sizing:border-box;margin-top:0;margin-bottom:0.5rem;font-weight:500;line-height:1.2;font-size:1.5rem;color:#fff" ><?= $document['proofNumber'] ?></h4>
                            </div>
                            <div class="col-6 mb-3 text-end" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:50%;margin-bottom:1rem!important;text-align:right!important;" >
                                <h3 class="h6 fw-bold mb-1" style="box-sizing:border-box;margin-top:0;line-height:1.2;font-size:1rem;margin-bottom:0.25rem!important;font-weight:700!important;color:#fff" >Tanggal Pengajuan</h3>
                                <h4 style="box-sizing:border-box;margin-top:0;margin-bottom:0.5rem;font-weight:500;line-height:1.2;font-size:1.5rem;color:#fff" ><?= $document['date'] ?></h4>
                            </div>
                        </div>
                        <div class="row" style="box-sizing:border-box;display:flex;flex-wrap:wrap;margin-top:calc(-1 * 0);margin-right:calc(-0.5 * 1.5rem);margin-left:calc(-0.5 * 1.5rem);" >
                            <div class="col-6" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:50%;" >
                                <table style="box-sizing:border-box;caption-side:bottom;border-collapse:collapse;color:#fff" >
                                    <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >Referensi</td>
                                        <td class="px-2" style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;padding-right:0.5rem!important;padding-left:0.5rem!important;" >:</td>
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" ><strong style="box-sizing:border-box;font-weight:bolder;" ><?= $document['projectCode'] ?></strong></td>
                                    </tr>
                                    <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >Kontrak</td>
                                        <td class="px-2" style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;padding-right:0.5rem!important;padding-left:0.5rem!important;" >:</td>
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" ><strong style="box-sizing:border-box;font-weight:bolder;" ><?= $document['contractNumber'] ?></strong></td>
                                    </tr>
                                    <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >Kategori</td>
                                        <td class="px-2" style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;padding-right:0.5rem!important;padding-left:0.5rem!important;" >:</td>
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" ><strong style="box-sizing:border-box;font-weight:bolder;" ><?= $document['category'] ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:50%;" >
                                <table style="box-sizing:border-box;caption-side:bottom;border-collapse:collapse;color:#fff" >
                                    <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >Pelanggan</td>
                                        <td class="px-2" style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;padding-right:0.5rem!important;padding-left:0.5rem!important;" >:</td>
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" ><strong style="box-sizing:border-box;font-weight:bolder;" ><?= $document['customerName'] ?></strong></td>
                                    </tr>
                                    <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" >
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" ><?= $type == 'permintaan pembayaran' ? 'Penerima' : 'Asal Setoran' ?></td>
                                        <td class="px-2" style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;padding-right:0.5rem!important;padding-left:0.5rem!important;" >:</td>
                                        <td style="box-sizing:border-box;border-color:inherit;border-style:solid;border-width:0;" ><strong style="box-sizing:border-box;font-weight:bolder;" ><?= $document['recipientName'] ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h5 class="ms-2 mb-4 text-center" style="box-sizing:border-box;margin-top:0;font-weight:500;line-height:1.2;font-size:1.25rem;margin-bottom:1.5rem!important;margin-left:0.5rem!important;text-align:center!important;" >Rincian Keperluan</h5>
                    <table class="table table-bordered" style="box-sizing:border-box;caption-side:bottom;border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;vertical-align:top;border-color:#dee2e6;" >
                        <thead style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;vertical-align:bottom;" >
                            <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" >
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >No.</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Keperluan</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Kode Ref.</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Keterangan</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Periode</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Jumlah</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Satuan</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Harga Satuan</th>
                                <th scope="col" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" >Harga Total</th>
                            </tr>
                        </thead>
                        <tbody style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;vertical-align:inherit;" >
                            <?php for ($i = 0; $i < count($items);$i++) { ?>
                                <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" >
                                    <th scope="row" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" ><?= $i + 1 ?></th>
                                    <td style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" ><?= $items[$i]['description'] ?></td>
                                    <td style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" ><?= $items[$i]['unitRef'] ?></td>
                                    <td style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" ><?= $items[$i]['moreDescription'] ?></td>
                                    <td style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" ><?= date('d/m/Y', strtotime($items[$i]['beginningPeriod'])) ?> - <?= date('d/m/Y', strtotime($items[$i]['endPeriod'])) ?></td>
                                    <td class="amount" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:center;" ><?= $items[$i]['amount'] ?></td>
                                    <td class="unit" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" ><?= $items[$i]['unit'] ?></td>
                                    <td class="price" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;position:relative;text-align:right;" align="right" ><?= $items[$i]['unitPrice'] < 0 ? '- Rp' . number_format(abs($items[$i]['unitPrice']), 0, '', '.') : 'Rp' . number_format($items[$i]['unitPrice'], 0, '', '.') ?></td>
                                    <td class="price" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;position:relative;text-align:right;" align="right" ><?= $items[$i]['totalPrice'] < 0 ? '- Rp' . number_format(abs($items[$i]['totalPrice']), 0, '', '.') : 'Rp' . number_format($items[$i]['totalPrice'], 0, '', '.') ?></td>
                                </tr>
                            <?php } ?>
                            <tr style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;" >
                                <th scope="row" colspan="8" class="text-end" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;text-align:right!important;" >Jumlah Harga</th>
                                <td class="price" style="box-sizing:border-box;border-color:inherit;border-style:solid;padding:0.5rem;position:relative;text-align:right;" align="right" ><?= $total < 0 ? '- Rp' . number_format(abs($total), 0, '', '.') : 'Rp' . number_format($total, 0, '', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer" style="box-sizing:border-box;padding-top:0.5rem;padding-bottom:0.5rem;padding-right:1rem;padding-left:1rem;color:#212529;border-top-width:1px;border-top-style:solid;border-top-color:rgba(0, 0, 0, 0.175);border-style:none;background-color:#fff;" >
                    <div id="approval" class="row align-items-center approval" style="box-sizing:border-box;display:flex;flex-wrap:wrap;margin-top:calc(-1 * 0);margin-right:calc(-0.5 * 1.5rem);margin-left:calc(-0.5 * 1.5rem);align-items:center!important;" >
                        <div id="approved" class="col-1 text-center approved" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:20%;text-align:center!important;" >
                            <?php if ($approval['Manager'] != null): ?>
                                <img src="<?= base_url('/images/approved.png') ?>" style="width: 100%;height: auto;max-height: 100px;" />
                            <?php endif; ?>
                        </div>
                        <div class="col-3" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:20%;" >
                            <div id="manager" class="d-flex flex-column align-items-center" style="box-sizing:border-box;text-align:center;border-bottom:1px solid #dee2e6;" >
                                <h5 class="hierarchy" style="box-sizing:border-box;margin-top:0;line-height:1.2;font-size:1rem;font-weight:700;margin-bottom:0;" >Manager</h5>
                                <div class="signature" style="box-sizing:border-box;width:72px;height:72px;margin-left:auto;margin-right:auto;" >
                                    <?= $approval['Manager'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Manager']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name" style="box-sizing:border-box;margin-top:0;margin-bottom:0;position:relative;width:100%;text-align:center;min-height:1.5rem" ><?= $approval['Manager'] != null ? $approval['Manager'] : '' ?></p>
                            </div>
                        </div>
                        <div class="col-3" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:20%;" >
                            <div id="supervisor-i" class="d-flex flex-column align-items-center" style="box-sizing:border-box;text-align:center;border-bottom:1px solid #dee2e6;" >
                                <h5 class="hierarchy" style="box-sizing:border-box;margin-top:0;line-height:1.2;font-size:1rem;font-weight:700;margin-bottom:0;" >Supervisor II</h5>
                                <div class="signature" style="box-sizing:border-box;width:72px;height:72px;margin-left:auto;margin-right:auto;" >
                                    <?= $approval['Supervisor_II'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Supervisor_II']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name" style="box-sizing:border-box;margin-top:0;margin-bottom:0;position:relative;width:100%;text-align:center;min-height:1.5rem" ><?= $approval['Supervisor_II'] != null ? $approval['Supervisor_II'] : '' ?></p>
                            </div>
                        </div>
                        <div class="col-3" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:20%;" >
                            <div id="supervisor-ii" class="d-flex flex-column align-items-center" style="box-sizing:border-box;text-align:center;border-bottom:1px solid #dee2e6;" >
                                <h5 class="hierarchy" style="box-sizing:border-box;margin-top:0;line-height:1.2;font-size:1rem;font-weight:700;margin-bottom:0;" >Supervisor I</h5>
                                <div class="signature" style="box-sizing:border-box;width:72px;height:72px;margin-left:auto;margin-right:auto;" >
                                    <?= $approval['Supervisor_I'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Supervisor_I']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name" style="box-sizing:border-box;margin-top:0;margin-bottom:0;position:relative;width:100%;text-align:center;min-height:1.5rem" ><?= $approval['Supervisor_I'] != null ? $approval['Supervisor_I'] : '' ?></p>
                            </div>
                        </div>
                        <div class="col-3" style="box-sizing:border-box;flex-shrink:0;max-width:100%;padding-right:calc(1.5rem * 0.5);padding-left:calc(1.5rem * 0.5);margin-top:0;flex:0 0 auto;width:20%;" >
                            <div id="admin" class="d-flex flex-column align-items-center" style="box-sizing:border-box;text-align:center;border-bottom:1px solid #dee2e6;" >
                                <h5 class="hierarchy" style="box-sizing:border-box;margin-top:0;line-height:1.2;font-size:1rem;font-weight:700;margin-bottom:0;" >Admin</h5>
                                <div class="signature" style="box-sizing:border-box;width:72px;height:72px;margin-left:auto;margin-right:auto;" >
                                    <?= $approval['Admin'] != null ? '<img src="https://devisigeneralservicebss.com/uploads/signatures/' . base64_encode($approval['Admin']) . '.png' . '" width="72px" height="72px"/>' : '' ?>
                                </div>
                                <p class="name" style="box-sizing:border-box;margin-top:0;margin-bottom:0;position:relative;width:100%;text-align:center;min-height:1.5rem" ><?= $approval['Admin'] != null ? $approval['Admin'] : '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($sender == 'applicant'): ?>
            <div style="box-sizing:border-box;text-align:center;padding:0 1rem;margin-top:1rem;">
                <a href="<?= base_url('/view?applicant=' . urlencode(base64_encode($email)) . '&doc=' . $file['submission']) ?>" target="_blank" style="box-sizing:border-box;display: inline-block;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #fff;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;user-select: none;border: 1px solid #001c46;border-radius: 0.375rem;background-color: #001c46;margin-left:auto;margin-right:auto">
                   Unduh bukti
                </a>
            </div>
        <?php endif; ?>
        <?php if ($sender == 'approver' && $disapproval == null): ?>
            <div>
                <div style="box-sizing:border-box;margin-top:2rem;background:#fff;border:1px solid rgba(0, 150, 192, 1)!important;padding:1rem;width:100%;text-align:center;border-radius:0.375rem!important;">
                    <h3 style="margin-top:0;margin-bottom:1rem;">Respon Anda</h3>
                    <a href="<?= base_url('/submit/approve?approver=' . $approver['email'] . '&as=' . $approver['hierarchy'] . '&doc=' . $file['submission']) ?>" target="_blank" style="box-sizing:border-box;display: inline-block;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #fff;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;user-select: none;border: 1px solid #198754;border-radius: 0.375rem;background-color: #198754;margin-right:0.5rem">
                       Terima
                    </a>
                    <a href="<?= base_url('/submit/disapprove?approver=' . $approver['email'] . '&as=' . $approver['hierarchy'] . '&doc=' . $file['submission']) ?>" target="_blank"  style="box-sizing:border-box;display: inline-block;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #fff;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;user-select: none;border: 1px solid #dc3545;border-radius: 0.375rem;background-color: #dc3545;margin-left:0.5rem">
                        Tolak
                    </a>
                </div>
            </div>
        <?php elseif($sender == 'approver' && $disapproval != null): ?>
            <div>
                <div style="box-sizing:border-box;margin-top:2rem;background:#fff;border:1px solid rgba(0, 150, 192, 1)!important;padding:1rem;width:100%;text-align:center;border-radius:0.375rem!important;">
                    <h3 style="margin-top:0;margin-bottom:1rem;">Respon Anda</h3>
                    <a href="https://devisigeneralservicebss/edit/<?= $file['submission'] ?>" target="_blank" style="box-sizing:border-box;display: inline-block;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #fff;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;user-select: none;border: 1px solid #198754;border-radius: 0.375rem;background-color: #198754;margin-right:0.5rem">
                       Edit
                    </a>
                    <a href="<?= base_url('/submit/approve?approver=' . $approver['email'] . '&as=' . $approver['hierarchy'] . '&doc=' . $file['submission']) ?>" target="_blank"  style="box-sizing:border-box;display: inline-block;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #198754;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;user-select: none;border: 1px solid #198754;border-radius: 0.375rem;background-color: #fff;margin-left:0.5rem;margin-rigth:0.5rem;">
                        Ajukan Ulang
                    </a>
                    <a href="<?= base_url('/submit/disapprove?approver=' . $approver['email'] . '&as=' . $approver['hierarchy'] . '&doc=' . $file['submission']) ?>" target="_blank"  style="box-sizing:border-box;display: inline-block;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #fff;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;user-select: none;border: 1px solid #dc3545;border-radius: 0.375rem;background-color: #dc3545;margin-left:0.5rem">
                        Turunkan
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </body>
</html>