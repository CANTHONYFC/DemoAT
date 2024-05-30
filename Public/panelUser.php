<?php
// Iniciar la sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    // Si no hay user_id en la sesión, redirigir al index
    header('Location: index.html');
    exit(); // Asegúrate de usar exit() después de header() para detener la ejecución del script
}else{
    if($_SESSION['type_person']!=1){
        header('Location: transfer.php');
    }
   
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables with AJAX</title>
    <link rel="stylesheet" href="./css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="./css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>


    <style>
        .main-header {
            background-color: #FF9A00;
            color: white;
        }

        .text-center {
            text-align: center !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #fff transparent transparent transparent !important;
        }

        .select2-container--default .select2-selection--single {

            background-color: #84b2ff !important;
            color: white !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff !important;
        }
        .slider-container {
            width: 100%;
            margin: 0 auto;
            height: 100px; /* Ajusta la altura según tus necesidades */
        }

        .slider img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
        <!-- Site wrapper -->
        <div class="wrapper" style="height: auto; min-height: 100%;">
            <header class="main-header" style="height: 50px;padding:5px">
                <form action="../Services/logout.php" method="post">
                    <img style="width: 11rem;" src="./logofull.5b236246.png" alt="">

                    <button type="submit" style="float: right;" class="btn btn-default btn-flat">Cerrar Sesión</button>
                </form>

            </header>
            <div class="slider">
                <div><img src="../Public/casino1.png" style="height: 350px;" alt="Imagen 1"></div>
                <div><img src="../Public/casino2.png" style="height: 350px;" alt="Imagen 2"></div>
                <div><img src="../Public/casino3.png" style="height: 350px;" alt="Imagen 3"></div>
            </div>
            <div style="margin-left: 20px;">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="mb-4">User:<span id="userPrint"></span></h1>
                    </div>
                    <div class="col-md-3">
                        <h2 class="mb-4">Saldo:S./<span id="montoPrint"></span></h1>
                    </div>
                    <div class="col-md-3">
                    
                    </div>
                </div>
                <img alt="Anksunamun The Queen Of Egypt" src="https://www.apuestatotal.com//cms/img/logos/mascot2/22941/Anksunamun-the-Queen-of-Egypt.png" loading="lazy">
                <img alt="Hook up! Fishing Wars" src="https://www.apuestatotal.com//cms/img/logos/mascot2/23021/hook_up_fishing_wars.png" loading="lazy">
                <img alt="Zeus the Thunderer deluxe" src="https://www.apuestatotal.com//cms/img/logos/mascot2/23022/zeus_the_thunderer_deluxe.png" loading="lazy">
                <img alt="Reveal&nbsp;the&nbsp;Kraken" src="https://www.apuestatotal.com//cms/img/logos/mascot2/23026/reveal_the_kraken.png" loading="lazy">
            </div>




        </div>
 
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  
        <script>
            $(document).ready(function(){
        $('.slider').slick({
            autoplay: true, // Reproducción automática
            autoplaySpeed: 2000, // Velocidad de reproducción automática en milisegundos (2 segundos)
            dots: true, // Muestra los puntos de navegación
            arrows: true, // Muestra las flechas de navegación
            infinite: true, // Reproduce el slider en un bucle infinito
            speed: 200, // Velocidad de transición entre diapositivas en milisegundos (0.5 segundos)
            slidesToShow: 1, // Número de diapositivas que se mostrarán a la vez
            slidesToScroll: 1 // Número de diapositivas que se desplazarán con cada clic
        });
        calcularSaldo()
    });

    function calcularSaldo(){
        $.ajax({
                    type: "POST",
                    url: "../Controllers/TransferController.php?action=listTransferUser",
                    dataType: "json",
                    data: {},
                    success: function(response) {
                        var acumulador=0
                        var name=""
                        $.each(response.data, function(index, item) {
                            name=item.namePerson
                            acumulador=acumulador+parseFloat(item.mount)
                        });
                    $('#montoPrint').text(acumulador)
                    var name =response.name
                    debugger
                    $('#userPrint').text(name)
                    }
                });
    }
        </script>

    </body>

</html>