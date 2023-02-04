<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Edit <?= $breadcrumb ?> | Dashboard | Dashboard</title>
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
                        <h1 class="h2 mt-4">Edit <?= $document['proofNumber'] ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item">Edit</li>
                            <li class="breadcrumb-item active"><?= $breadcrumb ?></li>
                        </ol>
                        <?php if (!empty(session()->getFlashdata('error'))): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <p class="mb-0"><?= session()->getFlashdata('error') ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <h2 class="h5">Edit <?= ucwords($document['type'])?></h2>
                        <?php if (!empty(session()->getFlashdata('success'))): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0"><?= session()->getFlashdata('success') ?></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div id="alertWrapper" style="z-index:9999"></div>
                        <?= form_open_multipart(base_url('save')); ?>
                            <div class="border p-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="date" class="form-label">Tanggal Pengajuan</label>
                                        <input type="date" class="form-control" id="date" name="date" placeholder="mm/dd/yy" aria-validate="false" value="<?= $document['date'] ?>" readonly />
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="proofNumber" class="form-label">Nomor Bukti</label>
                                        <input type="text" class="form-control" id="proofNumber" name="proofNumber" placeholder="GS .../../..." aria-validate="false" value="<?= $document['proofNumber'] ?>" required />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="projectCode" class="form-label">Referensi / Kode Proyek</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="projectCodeText">P</span>
                                            <input type="text" class="form-control" id="projectCode" name="projectCode" placeholder="000" aria-validate="false" aria-describedby="projectCodeText" value="<?= str_replace('P', '', $document['projectCode']) ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <!-- automatic -->
                                        <label for="contractNumber" class="form-label">Nomor Kontrak</label>
                                        <input type="text" class="form-control" id="contractNumber" name="contractNumber" placeholder=".../.../..." aria-validate="false" value="<?= $document['contractNumber'] ?>" required />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <!-- automatic -->
                                        <label for="customerName" class="form-label">Nama Pelanggan</label>
                                        <input type="name" class="form-control" id="customerName" name="customerName" placeholder="Masukkan nama pelanggan" value="<?= $document['customerName'] ?>" required />
                                        <div class="invalid-feedback">
                                            Nama tidak boleh mengandung angka
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="recipientName" class="form-label">Nama Penerima</label>
                                        <input type="name" class="form-control" id="recipientName" name="recipientName" placeholder="Masukkan nama pelanggan" value="<?= $document['recipientName'] ?>" required />
                                        <div class="invalid-feedback">
                                            Nama tidak boleh mengandung angka
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="category">Beban Unit / Kategori</label>
                                        <select class="form-select" id="category" name="category" aria-label="Beban unit / kategori" aria-validate="false" required />
                                            <option>Pilih kategori</option>
                                            <?php $selectedCategory = false; ?>
                                            <?php for ($i = 0; $i < count($categories); $i++){ ?>
                                                <?php if($document['category'] == $categories[$i]){$selectedCategory = true;} ?>
                                                <option value="<?= $categories[$i] ?>" <?= $document['category'] == $categories[$i] ? 'selected' : '' ?>><?= $categories[$i] ?></option>
                                            <?php } ?>
                                            <option value="other">Lainnya</option>
                                        </select>
                                    </div>
                                    <div id="otherCategoryWrapper" class="col-md-12 mb-3 <?= $selectedCategory == false ? 'd-block' : '' ?>">
                                        <!-- database set -->
                                        <label for="otherCategory" class="form-label">Kategori Lainnya</label>
                                        <input type="text" class="form-control" id="otherCategory" name="otherCategory" <?= $selectedCategory == false ? 'value="' . $document['category'] . '"' : '' ?> placeholder="Kategori lainnya" />
                                        <div class="invalid-feedback">
                                            Kategory lainnya tidak boleh kosong
                                        </div>
                                    </div>
                                    <div class="text-end border-top border-bottom mb-3">
                                        <div class="descriptionBackups d-none visibility-hidden" id="descriptionBackups">
                                            <?php for($j = 0; $j < count($description); $j++){ ?>
                                                <option value="<?= $description[$j] ?>" />
                                            <?php } ?>
                                        </div>
                                        <ul id="itemWrapper" class="text-start mb-3 list-unstyled">
                                            <?php for ($i = 0; $i < count($document['items']); $i++) { ?>
                                                <li class="d-flex align-items-center justify-content-between border-bottom border-light pt-3">
                                                    <div class="row w-100">
                                                        <div class="col-12 col-lg-7 mb-3">
                                                            <label for="description" class="form-label">Keperluan</label>
                                                            <input type="text" class="form-control description" list="descriptionList" id="description" name="description[]" placeholder="Keperluan"  value="<?= $document['items'][$i]['description'] ?>" onChange="getRefcode(this)" autocomplete="off" required/>
                                                            <datalist class="descriptionList" id="descriptionList">
                                                                <?php for($j = 0; $j < count($description); $j++){ ?>
                                                                    <option value="<?= $description[$j] ?>" />
                                                                <?php } ?>
                                                            </datalist>
                                                        </div>
                                                        <div class="col-12 col-lg-5 mb-3">
                                                            <label for="unitRef" class="form-label">Kode Ref.</label>
                                                            <input type="text" class="form-control unitRef" list="codeList"  id="unitRef" name="unitRef[]" placeholder="Kode referensi" value="<?= $document['items'][$i]['unitRef'] ?>" autocomplete="off" />
                                                            <datalist class="codeList" id="codeList">
                                                            </datalist>
                                                        </div>
                                                        <div class="col-4 col-lg-2 mb-3">
                                                            <label for="amount" class="form-label">Jumlah</label>
                                                            <input type="number" class="form-control" id="amount" name="amount[]" placeholder="Jumlah" value="<?= $document['items'][$i]['amount'] ?>" onBlur="getTotal(this.parentElement.parentElement)" step="any" required />
                                                        </div>
                                                        <div class="col-8 col-lg-4 mb-3">
                                                            <label for="unit" class="form-label">Satuan</label>
                                                            <input type="text" class="form-control" id="unit" name="unit[]" placeholder="Satuan" value="<?= $document['items'][$i]['unit'] ?>" required />
                                                        </div>
                                                        <div class="col-12 col-lg-6  mb-3">
                                                            <label for="unitPrice" class="form-label">Harga satuan</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="unitPriceText">Rp</span>
                                                                <input type="text" class="form-control" id="unitPrice" name="unitPrice[]" value="<?= preg_replace("/\B(?=(\d{3})+(?!\d))/", ".", strval($document['items'][$i]['unitPrice'])) ?>" onBlur="getTotal(this.parentElement.parentElement.parentElement)" placeholder="Harga satuan" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="totalPrice" class="form-label">Harga Total</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="unitPriceText">Rp</span>
                                                                <input type="text" class="form-control totalPrice" id="totalPrice" value="<?= preg_replace("/\B(?=(\d{3})+(?!\d))/", ".", strval($document['items'][$i]['totalPrice'])) ?>" name="totalPrice[]" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="moreDescription" class="form-label">Keterangan</label>
                                                            <input type="text" class="form-control" id="moreDescription" name="moreDescription[]" value="<?= $document['items'][$i]['moreDescription'] ?>" placeholder="Keterangan" />
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="beginningPeriod" class="form-label">Periode Awal</label>
                                                            <input type="date" class="form-control" id="beginningPeriod" name="beginningPeriod[]" value="<?= $document['items'][$i]['beginningPeriod'] ?>"  aria-validate="false" required />
                                                        </div>
                                                        <div class="col-12 col-lg-6 mb-3">
                                                            <label for="endPeriod" class="form-label">Periode Akhir</label>
                                                            <input type="date" class="form-control" id="endPeriod" name="endPeriod[]" value="<?= $document['items'][$i]['endPeriod'] ?>"  aria-validate="false" required />
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close mb-3 ms-3" aria-label="Close" onClick="removeItem(this.parentElement)"></button>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <button type="button" class="btn btn-outline-primary" id="addMore">
                                            Tambah <i class="fa-solid fa-plus ms-2"></i>
                                        </button>
                                        <div class="mb-3 text-start">
                                            <label for="total" class="form-label">Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="unitPriceText">Rp</span>
                                                <input type="text" class="form-control" id="total" value="<?= preg_replace("/\B(?=(\d{3})+(?!\d))/", ".", strval($document['total'])) ?>" name="total" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="attachments" class="form-label">Lampiran</label>
                                    <div class="d-flex align-items-center flex-wrap mx-auto mb-3 gap-2" id="attachmentsWrapper">
                                        <?php if ($document['file']['attachment'] != null || !empty($document['file']['attachment'])): ?>
                                            <?php foreach($document['file']['attachment'] as $key => $attacment) { ?>
                                                <div class="d-flex flex-column align-items-center gap-2 mb-2 p-3 border rounded">
                                                    <a href="https://form.devisigeneralservicebss.com/attachments/<?= $attacment ?>" target="_blank" class="text-decoration-none">
                                                        <?= $attacment ?>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-secondary delete-attach" data-attach="<?= $key ?>"><i class="fa-solid fa-trash me-2"></i>Hapus</button>
                                                </div>
                                            <?php } ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($as == 'Supervisor_I' || $as == 'Supervisor_II'): ?>
                                        <label for="attachment" class="form-label">Tambah Lampiran</label>
                                        <input type="file" class="form-control" id="attachment" name="attachment[]" placeholder="Unggah lampiran" accept="image/png, image/jpg, image/jpeg, application/pdf, application/vnd.ms-excel, application/msexcel, application/x-msexcel, application/x-ms-excel, application/vnd.ms-excel, application/x-excel, application/x-dos_ms_excel, application/xls" multiple />
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan</button>
                            </div>
                        </form>
                    </div>    
                </main>
                <?= $this->include('partials/footer'); ?>
            </div>
        </div>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                const attachments   = document.getElementsByClassName('delete-attach')
                const wrapper       = document.getElementById('attachmentsWrapper')
                
                if(wrapper.children.length < 1) {
                    wrapper.previousElementSibling.style.display    = "none";
                    wrapper.style.display                           = "none";
                    wrapper.classList.remove('mb-3')
                }
                
                for(let i = 0; i < attachments.length; i++){
                    attachments[i].addEventListener("click", function(e){
                        e.preventDefault()
                        
                        let xhr             = new XMLHttpRequest()
                        let attachment      = attachments[i].dataset.attach
                        let submission      = "<?= $document['file']['submission'] ?>"
                        
                        xhr.open('POST', 'https://devisigeneralservicebss.com/delete')
                        xhr.setRequestHeader('Content-Type', 'application/json')
                        xhr.onload = function() {
                            if(xhr.readyState == 4 && xhr.status == 200) {
                                attachments[i].parentElement.remove()
                                
                                if(wrapper.children.length < 1) {
                                    wrapper.previousElementSibling.style.display    = "none";
                                    wrapper.style.display                           = "none";
                                    wrapper.classList.remove('mb-3')
                                }
                            }
                        }
                        xhr.send(JSON.stringify({attachment: attachment, submission: submission}))
                        
                        // console.log(attachments[i].dataset.attach)
                    })
                }
            })
        </script>
        <script src="<?= base_url('js/form.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('js/scripts.js') ?>" type="text/javascript"></script>
    </body>
</html>