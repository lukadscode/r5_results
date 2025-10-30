<!DOCTYPE html>
<html lang="en" data-bs-theme-mode="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultats rame en 5e</title>
    <link rel="stylesheet" href="/css/keen.css">
    <link href="https://preview.keenthemes.com/html/keen/docs/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="https://preview.keenthemes.com/keen/demo8/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-37564768-1');
    </script>
    <!--end::Google tag-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>


<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-header="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script> <?= $content ?>
    <?php
    if (!empty($signupErrors)) {
        foreach ($signupErrors as $error) {
            echo displayAlert('danger', 'Erreur', htmlspecialchars($error));
        }
    }
    ?>

    <!--begin::Footer-->
    <div id="kt_app_footer" class="app-footer ">
        <!--begin::Footer container-->
        <div class="app-container  container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3 ">
            <!--begin::Copyright-->
            <div class="text-gray-900 order-2 order-md-1">
                <span class="text-muted fw-semibold me-1">2024&copy;</span>
                <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">FFAviron</a>
            </div>
            <!--end::Copyright-->

            <!--begin::Menu-->
            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">

                <li class="menu-item"><a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a></li>
            </ul>
            <!--end::Menu-->
        </div>
        <!--end::Footer container-->
    </div>
    <!--end::Footer-->

    <script src="https://kit.fontawesome.com/3f0cec6f2e.js" crossorigin="anonymous"></script>
    <script src="/js/plugins.bundle.js"></script>
    <script src="https://preview.keenthemes.com/keen/demo8/assets/js/scripts.bundle.js"></script>


    <script src="https://preview.keenthemes.com/keen/demo8/assets/js/custom/documentation/documentation.js"></script>
    <script src="https://preview.keenthemes.com/keen/demo8/assets/js/custom/documentation/search.js"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="https://preview.keenthemes.com/html/keen/docs/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <script src="https://preview.keenthemes.com/html/keen/docs/assets/js/custom/documentation/forms/select2.js"></script>



</body>

</html>