<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Export By Item | Dashboard</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>"/>
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
                        <h1 class="h2 mt-4">Export By Item</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item active"><a href="<?= base_url('export') ?>" class="text-decoration-none">Export</a></li>
                            <li class="breadcrumb-item active">Item</li>
                        </ol>
                        <h3 class="h5">Ekspor Berdasarkan Keperluan</h3>
                        <?= form_open(base_url('export/item')); ?>
                            <div class="row" id="form-item">
                                <div class="col-12 mb-3">
                                    <label for="type" class="form-label">Jenis Dokumen</label>
                                    <select class="form-select" id="type" name="type" aria-label="Jenis Dokumen" required />
                                        <option value="All">Semua</option>
                                        <option value="permintaan pembayaran" <?= $query['type'] == 'permintaan pembayaran' ? 'selected' : '' ?>>Permintaan Pembayaran</option>
                                        <option value="penerimaan pendapatan" <?= $query['type'] == 'penerimaan pendapatan' ? 'selected' : '' ?>>Penerimaan Pendapatan</option>
                                    </select>
                                </div>
                                <div class="col-12 col-6 mb-3">
                                    <label for="contractNumber" class="form-label">Nomor Kontrak</label>
                                    <select class="form-select" id="contractNumber" name="contractNumber" aria-label="Nomor Kontrak" required />
                                        <?php if($form['contractNumber'] != null && !empty($form['contractNumber'])): ?>
                                            <option value="All">Semua</option>
                                            <?php for ($i = 0; $i < count($form['contractNumber']); $i++){ ?>
                                                <option value="<?= $form['contractNumber'][$i] ?>" <?= $query['contractNumber'] == $form['contractNumber'][$i] ? 'selected' : '' ?>><?= $form['contractNumber'][$i] ?></option>
                                            <?php } ?>
                                        <? endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 col-6 mb-3">
                                    <label for="category" class="form-label">Beban Unit / Kategori</label>
                                    <select class="form-select" id="category" name="category" aria-label="Beban unit / kategori" required />
                                        <option value="All">Semua</option>
                                        <?php for ($i = 0; $i < count($form['category']); $i++){ ?>
                                            <option value="<?= $form['category'][$i] ?>" <?= $query['category'] == $form['category'][$i] ? 'selected' : '' ?>><?= $form['category'][$i] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="description" class="form-label">Keperluan</label>
                                    <select class="form-select" id="description" name="description" aria-label="Keperluan" required />
                                        <?php for ($i = 0; $i < count($form['description']); $i++){ ?>
                                            <option value="<?= $form['description'][$i] ?>" <?= $query['description'] == $form['description'][$i] ? 'selected' : '' ?>><?= $form['description'][$i] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="unitRef" class="form-label">Kode Ref.</label>
                                    <input type="text" class="form-control unitRef" list="codeList"  id="unitRef" name="unitRef" placeholder="Kode referensi" autocomplete="off" <?= ($query['refcode'] == '' || $query['refcode'] == null) ? '' : 'value="' . $query['refcode'] . '"' ?> required />
                                    <datalist class="codeList" id="codeList">
                                    </datalist>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="year" class="form-label">Tahun</label>
                                    <select class="form-select" id="year" name="year" aria-label="Tahun" required />
                                        <option value="All">Semua</option>
                                        <?php $years = array_combine(range(date("Y"), 2022), range(date("Y"), 2022));
                                        foreach ($years as $y) { ?>
                                            <option value="<?= $y ?>" <?= $query['year'] == $y ? 'selected' : '' ?>><?= $y ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="beginningPeriod" class="form-label">Periode Awal</label>
                                    <input type="date" class="form-control" id="beginningPeriod" name="beginningPeriod" <?= ($query['beginningPeriod'] == '' || $query['beginningPeriod'] == null) ? '' : 'value="' . $query['beginningPeriod'] . '"' ?> aria-validate="false" required />
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="endPeriod" class="form-label">Periode Akhir</label>
                                    <input type="date" class="form-control" id="endPeriod" name="endPeriod" <?= ($query['endPeriod'] == '' || $query['endPeriod'] == null) ? '' : 'value="' . $query['endPeriod'] . '"' ?> aria-validate="false" required />
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-eye me-2"></i>Lihat</button>
                                </div>
                            </div>
                        </form>
                        <?php if($result == null && empty($result) && !empty($query['description'])): ?>
                            <div class="border-top mt-4 pt-4">
                                <div class="alert alert-warning" role="alert">
                                    Hasil tidak ditemukan.
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($result != null && !empty($result)): ?>
                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn btn-outline-primary me-2" id="submitBtn"><i class="fa-solid fa-download me-2"></i>Unduh</button>
                                    <button type="button" class="btn btn-outline-primary" id="exportBtn"><i class="fa-solid fa-file-export me-2"></i>Export</button>
                                </div>
                                <div class="tableWrap overflow-auto mt-4">
                                    <table class="table table-bordered py-3" id="exportTable">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">Tanggal</th>
                                                <th class="text-nowrap">Nomor Bukti</th>
                                                <th class="text-nowrap">Keterangan</th>
                                                <th class="text-nowrap">Jumlah</th>
                                                <th class="text-nowrap">Satuan</th>
                                                <th class="text-nowrap">Harga Satuan</th>
                                                <th class="text-nowrap">Harga Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for($i = 0; $i < count($result); $i++) { ?>
                                                <tr>
                                                    <td class="text-end text-nowrap"><?= $result[$i]['date'] ?></td>
                                                    <td class="text-nowrap"><?= $result[$i]['proofNumber'] ?></td>
                                                    <td class="text-nowrap"><?= $result[$i]['moreDescription'] ?></td>
                                                    <td class="text-center text-nowrap"><?= $result[$i]['amount'] ?></td>
                                                    <td class="text-nowrap"><?= $result[$i]['unit'] ?></td>
                                                    <td class="text-end text-nowrap">Rp<?= number_format($result[$i]['unitPrice'], 0, '', '.') ?></td>
                                                    <td class="text-end text-nowrap">Rp<?= number_format($result[$i]['totalPrice'], 0, '', '.') ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th colspan="6" class="text-center text-nowrap">Total</td>
                                                <td class="text-end text-nowrap">Rp<?= number_format($total, 0, '', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function(){
                const form          = document.getElementsByTagName('form')
                const action        = form[0].action
                const submitBtn     = document.getElementById('submitBtn')
                const description   = document.getElementById('description')
                const exportBtn     = document.getElementById('exportBtn')
                
                if(submitBtn && exportBtn) {
                    submitBtn.addEventListener('click', (e) => {
                        e.preventDefault()
                        
                        if(action == "https://devisigeneralservicebss.com/export/item") {
                            form[0].action = "https://devisigeneralservicebss.com/download/item"
                        }
                        
                        form[0].submit()
                    })
                    
                    exportBtn.addEventListener('click', (e) => {
                        e.preventDefault()
                        
                        const data = document.getElementById('exportTable')
        
                        const file = XLSX.utils.table_to_book(data, {sheet: "sheet1"})
                
                        XLSX.write(file, { bookType: 'xlsx', bookSST: true, type: 'base64' })
                
                        XLSX.writeFile(file, '<?= 'E-Approval Recap - Keperluan (' . date("d/m/Y") .')' ?>.' + 'xlsx')
                    })
                }
                
                description.addEventListener('change', (e) => {
                    e.preventDefault()
                    
                    let xhr     = new XMLHttpRequest()
                    let query   = description.value
                    
                    if(query !== null || query !== undefined) {
                        xhr.open('GET', 'https://devisigeneralservicebss.com/refcode?d=' + query)
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.onload = function() {
                            if(xhr.readyState == 4 && xhr.status == 200) {
                                let data        = JSON.parse(this.responseText)
                                let input       = description.parentElement.nextElementSibling.children[1]
                                let list        = description.parentElement.nextElementSibling.children[2]
                                
                                input.value     = ''
                                list.innerHTML  = ''
                                
                                for(let i = 0; i < data.code.length; i++) {
                                    let el = '<option value="' + data.code[i] + '" />'
                                    list.insertAdjacentHTML('beforeend', el)
                                }
                            }
                        }
                        xhr.send(null)
                    }
                })
            })
        </script>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
    </body>
</html>