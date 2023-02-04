<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Formulir Penerimaan Pendapatan</title>
        <meta name="HandheldFriendly" content="True" />
        <meta name="MobileOptimized" content="320" />
        <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
        <link rel="stylesheet" href="<?= base_url('/css/app.css') ?>" >
        <script src="https://kit.fontawesome.com/ff94f270b6.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?= $this->include('partials/nav'); ?>
        <main>
            <div id="alertWrapper"></div>
            <div class="container-fluid bg-primary text-center py-4">
                <h1 class="h3 mb-0 text-center text-white">Pemerimaan Pendapatan</h1>
            </div>
            <div class="container py-4">
                <?= form_open_multipart(base_url('/submit')); ?>
                    <?= csrf_field(); ?>
                    <input type="type" class="form-control d-none" id="type" name="type" value="penerimaan pendapatan" required />
                    <div class="row py-4 border-bottom">
                        <div class="col-lg-3">
                            <figure class="position-sticky">
                                <blockquote class="blockquote">
                                    <h2 class="h5">Data Pribadi</h2>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    Email diisi otomatis berdasarkan email yang digunakan untuk log in.
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-lg-9">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control is-valid" id="email" name="email" value="<?= $authenticated ?>" required readOnly />
                                <div class="invalid-feedback">
                                    Masukkan email dengan format mail@ptbss.com.
                                </div>
                            </div>
                            <div class="mb-3">
                                <a href="/change_email" class="btn btn-link">Ganti email</a>
                            </div>
                        </div>
                    </div>
                    <div class="row py-4 border-bottom">
                        <div class="col-lg-3">
                            <figure class="position-sticky">
                                <blockquote class="blockquote">
                                    <h2 class="h5">Tentang Dokumen</h2>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    Masukkan informasi mengenai data yang akan diajukan.
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="date" class="form-label">Tanggal Pengajuan</label>
                                    <input type="date" class="form-control" id="date" name="date" placeholder="mm/dd/yy" aria-validate="false" required />
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label for="proofNumber" class="form-label">Nomor Bukti</label>
                                    <input type="text" class="form-control" id="proofNumber" name="proofNumber" placeholder="GS .../../..." aria-validate="false" required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="projectCode" class="form-label">Referensi / Kode Proyek</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="projectCodeText">P</span>
                                        <input type="text" class="form-control" id="projectCode" name="projectCode" placeholder="000" aria-validate="false" aria-describedby="projectCodeText" required />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <!-- automatic -->
                                    <label for="contractNumber" class="form-label">Nomor Kontrak</label>
                                    <input type="text" class="form-control" id="contractNumber" name="contractNumber" placeholder=".../.../..." aria-validate="false" required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <!-- automatic -->
                                    <label for="customerName" class="form-label">Nama Pelanggan</label>
                                    <input type="name" class="form-control" id="customerName" name="customerName" placeholder="Masukkan nama pelanggan" required />
                                    <div class="invalid-feedback">
                                        Nama tidak boleh mengandung angka
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="recipientName" class="form-label">Asal Setoran</label>
                                    <input type="name" class="form-control" id="recipientName" name="recipientName" placeholder="Masukkan nama asal setoran" required />
                                    <div class="invalid-feedback">
                                        Nama tidak boleh mengandung angka
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <!-- database set -->
                                    <label for="category">Beban Unit / Kategori</label>
                                    <select class="form-select" id="category" name="category" aria-label="Beban unit / kategori" aria-validate="false" required />
                                        <option selected>Pilih kategori</option>
                                        <?php for ($i = 0; $i < count($categories); $i++){ ?>
                                            <option value="<?= $categories[$i] ?>"><?= $categories[$i] ?></option>
                                        <?php } ?>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                                <div id="otherCategoryWrapper" class="col-md-12 mb-3">
                                    <!-- database set -->
                                    <label for="otherCategory" class="form-label">Kategori Lainnya</label>
                                    <input type="text" class="form-control" id="otherCategory" name="otherCategory" placeholder="Kategori lainnya" />
                                    <div class="invalid-feedback">
                                        Kategory lainnya tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-4 border-ybottom">
                        <div class="col-lg-3">
                            <figure class="position-sticky">
                                <blockquote class="blockquote">
                                    <h2 class="h5">Rincian</h2>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    Masukkan rincian dokumen meliputi keperluan, jumlah, harga satuan, dan total harga.
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-lg-9 text-end">
                            <div class="descriptionBackups d-none visibility-hidden" id="descriptionBackups">
                                <?php for ($i = 0; $i < count($description); $i++){ ?>
                                    <option value="<?= $description[$i] ?>" />
                                <?php } ?>
                            </div>
                            <ul id="itemWrapper" class="text-start mb-3 list-unstyled">
                                <li class="d-flex align-items-center justify-content-between border-bottom pt-3">
                                    <div class="row w-100">
                                        <div class="col-12 col-lg-7 mb-3">
                                            <label for="description" class="form-label">Keperluan</label>
                                            <input type="text" class="form-control description" list="descriptionList" id="description" name="description[]" placeholder="Keperluan" onChange="getRefcode(this)" autocomplete="off" required/>
                                            <datalist class="descriptionList" id="descriptionList">
                                                <?php for ($i = 0; $i < count($description); $i++){ ?>
                                                    <option value="<?= $description[$i] ?>" />
                                                <?php } ?>
                                            </datalist>
                                        </div>
                                        <div class="col-12 col-lg-5 mb-3">
                                            <label for="unitRef" class="form-label">Kode Ref.</label>
                                            <input type="text" class="form-control unitRef" list="codeList"  id="unitRef" name="unitRef[]" placeholder="Kode referensi" autocomplete="off" />
                                            <datalist class="codeList" id="codeList">
                                            </datalist>
                                        </div>
                                        <div class="col-4 col-lg-2 mb-3">
                                            <label for="amount" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="amount" name="amount[]" placeholder="Jumlah" onBlur="getTotal(this.parentElement.parentElement)" step="any" required />
                                        </div>
                                        <div class="col-8 col-lg-4 mb-3">
                                            <label for="unit" class="form-label">Satuan</label>
                                            <input type="text" class="form-control" id="unit" name="unit[]" placeholder="Satuan" required />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="unitPrice" class="form-label">Harga satuan</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="unitPriceText">Rp</span>
                                                <input type="text" class="form-control" id="unitPrice" name="unitPrice[]" placeholder="Harga satuan" onBlur="getTotal(this.parentElement.parentElement.parentElement)" required />
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="totalPrice" class="form-label">Harga Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="unitPriceText">Rp</span>
                                                <input type="text" class="form-control totalPrice" id="totalPrice" value="-" name="totalPrice[]" required />
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="moreDescription" class="form-label">Keterangan</label>
                                            <input type="text" class="form-control" id="moreDescription" name="moreDescription[]" placeholder="Keterangan" />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="beginningPeriod" class="form-label">Periode Awal</label>
                                            <input type="date" class="form-control" id="beginningPeriod" name="beginningPeriod[]" aria-validate="false" required />
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3">
                                            <label for="endPeriod" class="form-label">Periode Akhir</label>
                                            <input type="date" class="form-control" id="endPeriod" name="endPeriod[]" aria-validate="false" required />
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close mb-3 ms-3" aria-label="Close" onClick="removeItem(this.parentElement, )"></button>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary mb-3" id="addMore">
                                Tambah <i class="fa-solid fa-plus ms-2"></i>
                            </button>
                            <div class="mb-3 text-start">
                                <label for="total" class="form-label">Total</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="unitPriceText">Rp</span>
                                    <input type="text" class="form-control" id="total" value="-" name="total" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-4 border-bottom">
                        <div class="col-lg-3">
                            <figure class="position-sticky">
                                <blockquote class="blockquote">
                                    <h2 class="h5">Lampiran</h2>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    Lampirkan dokumen berupa png, jpg, jpeg, atau pdf yang berkaitan dengan dokumen pengajuan (Opsional).
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-lg-9 mb-3">
                            <label for="attachment" class="form-label mb-3">Unggah lampiran <span class="badge border border-secondary text-muted">Opsional</span></label>
                            <input type="file" class="form-control" id="attachment" name="attachment[]" placeholder="Unggah lampiran" accept="image/png, image/jpg, image/jpeg, application/pdf, application/vnd.ms-excel, application/msexcel, application/x-msexcel, application/x-ms-excel, application/vnd.ms-excel, application/x-excel, application/x-dos_ms_excel, application/xls" multiple />
                        </div>
                    </div>
                    <div class="row py-4">
                        <div class="col-12 d-flex align-items-center justify-content-between gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="checked" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    Konfirmasi bahwa data yang dimasukkan sudah benar
                                </label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <?= $this->include('partials/footer'); ?>
        <script src="<?= base_url('/js/form.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
    </body>
</html>