<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultats rame en 5e</title>
    <link rel="stylesheet" href="/css/keen.css">
</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <style id="compiled-css" type="text/css">
        .login {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('/img/images/bg_login.jpg');
            background-size: cover;
            background-position: center;
        }





        /* EOS */
    </style>
    <div class="container-fluid ps-md-0">

        <div class="bg-image"></div>
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>

            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="my-6">
                                <img src="img/logo/logo_scolaire.png" alt="" class="img-fluid rounded mx-auto d-block mb-6" style="width:50%">
                            </div>
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>