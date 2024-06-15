<html style="box-sizing:border-box;" >
    <head style="box-sizing:border-box;" >
        <meta charset="UTF-8" style="box-sizing:border-box;" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" style="box-sizing:border-box;" />
        <title style="box-sizing:border-box;" >Autentifikasi Email</title>
    </head>
    <body class="bg-light" style="box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:'Open Sans', sans-serif;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:rgba(0, 0, 0, 0);" >
        <p>Hallo, <?= $email ?></p>
        <p>Kode ini berlaku untuk 3 hari kedepan sampai <b><?= $expired ?></b></p>
        <p>Salin kode autentikasi di bawah ini untuk masuk.</p>
        <br>
        <div class="card-subject shadow-sm rounded p-3 mb-4" style="box-sizing:border-box;margin-bottom:1.5rem!important;padding-top:1rem !important;padding-bottom:1rem !important;padding-right:1rem !important;padding-left:1rem !important;border-radius:0.375rem!important;color:#fff;background-color:#001c46;" >
            <p style="font-size:2rem;font-weight:700;"><?= $code ?></p></p>
        </div>
        <p>Simpan dengan baik kode di atas untuk 3 hari kedepan!</p>
    </body>
</html>