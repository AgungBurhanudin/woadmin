<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="Wedding Organizer Wedding Organizer App">
        <meta name="author" content="Salatiga Web">
        <meta name="keyword" content="Wedding, WO, Wedding Organizer, Nikah, Kawin, Pernikahan">
        <title>Wedding Organizer </title>
        <!-- Icons-->
        <link rel="icon" type="image/ico" href="<?= base_url() ?>assets/icon.jpg" sizes="any" />
        <link href="<?= base_url() ?>assets/vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
        <!-- Main styles for this application-->
        <link href="<?= base_url() ?>assets/css/style.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
        <!-- Include SmartWizard CSS -->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard.min.css" rel="stylesheet" type="text/css" />-->

        <!-- Optional SmartWizard theme -->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard_theme_circles.min.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />-->
        <!--<link href="<?= base_url() ?>assets/smartWizard/css/smart_wizard_theme_dots.min.css" rel="stylesheet" type="text/css" />-->
        <!-- Global site tag (gtag.js) - Google Analytics-->
        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>

        <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/sweet/min/jquery.sweet-modal.min.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.scrolling-tabs.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/datatable.min.css" />
        <!--        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />-->

        <script>

            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            // Shared ID
            gtag('config', 'UA-118965717-3');
            // Bootstrap ID
            gtag('config', 'UA-118965717-5');
        </script>
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <?php $this->load->view($main_content);?>
    </body>
</html>
    