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
    if($_SESSION['type_person']!=0){
        header('Location: panelUser.php');
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
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-9">
                        <h1 class="mb-4">Transferencias</h1>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block btn-success btn-sm" onclick="abrirNuevaTransferencia()">
                            Agregar Transferencia <i class="fa fa-fw fa-plus-square"></i></button>

                    </div>
                </div>
                <table id="transferTable" class="table table-striped datatablePersonalizado">
                    <thead>
                        <tr>
                            <th>Responsable</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Canal</th>
                            <th>Voucher Url</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>



        </div>
        <div id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade in" style="display: none;">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="miFormulario" action="javascript:guardarTransferencia()" method="post" enctype="multipart/form-data">
                        <div class="modal-header backMorado text-center">
                            <h4 id="exampleModalLabel" class="modal-title">Nueva Transferencia</h4>
                        </div>

                        <div class="modal-body">

                            <div class=" box-success">

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="exampleInputEmail1">Cliente</label>
                                        <select id="selectCliente" name="selectCliente" required="required" class="form-control select2" style="width: 100%;">
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Canal</label>
                                        <select id="selectChannel" name="selectChannel" required="required" class="form-control select2" style="width: 100%;">
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Cuenta</label>
                                        <select id="selectAcountNumber" name="selectAcountNumber" required="required" class="form-control select2" style="width: 100%;">
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Monto</label>
                                        <input class="form-control" id="amount" oninput="validarNumerosDecimales(this)" name="amount" type="text"></input>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="exampleInputEmail1">Voucher</label>
                                        <input type="file" id="voucher" name="voucher">
                                        <iframe id="filePreview" style="display: none;" width="300" height="200"></iframe>
                                    </div>


                                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar </button>.
                            <button type="button" onclick="cerrarModal()" class="btn btn-danger">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="modalLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade in" style="display: none;">
            <div role="document" class="modal-dialog modal-lg">
                <form id="miFormulario" action="javascript:guardarTransferencia()" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header backMorado text-center">
                            <h4 id="exampleModalLabel" class="modal-title">Historial</h4>
                        </div>

                        <div class="modal-body">

                            <div class=" box-success">

                                <div>
                                    <table id="transferTable_log" class="table table-striped datatablePersonalizado">
                                        <thead>
                                            <tr>
                                                <th>Responsable</th>
                                                <th>Cliente</th>
                                                <th>Monto</th>
                                                <th>Fecha</th>
                                                <th>Canal</th>
                                                <th>Voucher Url</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" onclick="cerrarModalHistory()" class="btn btn-danger">Cancelar</button>
                        </div>

                </form>
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
        <script>
            var id_transfer = null
            var nuevo = false
            $(document).ready(function() {
                listar()
                document.getElementById('voucher').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        debugger
                        const fileURL = URL.createObjectURL(file);
                        const filePreview = document.getElementById('filePreview');
                        filePreview.src = fileURL;
                        filePreview.style.display = 'block';
                    }
                });
            });

            function cerrarModalHistory() {
                $('#modalLog').modal('hide')
            }

            function abrirNuevaTransferencia() {
                nuevo = true
                listClient()
                listAccountNumbers()
                listChannel()
                $('#amount').val('')
                document.getElementById('filePreview').src = "";
                $('#modalCreate').modal('show')
            }

            function listarSelectoresModal() {

            }

            function validarNumerosDecimales(input) {
                // Reemplazar cualquier caracter que no sea un número o un punto decimal con una cadena vacía
                input.value = input.value.replace(/[^0-9.]/g, '');

                // Si hay más de un punto decimal, eliminar los adicionales
                if ((input.value.match(/\./g) || []).length > 1) {
                    var parts = input.value.split('.');
                    input.value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Limitar la longitud máxima a 4 dígitos enteros y 2 decimales
                var parts = input.value.split('.');
                if (parts[0].length > 6) {
                    parts[0] = parts[0].substr(0, 6);
                }
                if (parts[1] && parts[1].length > 2) {
                    parts[1] = parts[1].substr(0, 2);
                }
                input.value = parts.join('.');
            }

            function listar() {
                $('#transferTable').DataTable().destroy();
                datatableRoles = $('#transferTable').DataTable({
                    searching: true,
                    data: null,
                    search: true,
                    "language": {
                        "lengthMenu": "Mostrar: _MENU_",
                        "zeroRecords": "&nbsp;&nbsp;&nbsp; No se encontraron resultados",
                        "info": "&nbsp;&nbsp;&nbsp; Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                        "infoEmpty": "&nbsp;&nbsp;&nbsp; Mostrando 0 de 0 registros",
                        "search": "Filtrar:",
                        "loadingRecords": "Cargando...",
                        "processing": '<span style="width:100%;"><img style="width:100%;height:150" src="../images/gif/cargando.gif"></span>',
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "ajax": {
                        method: "POST",
                        dataType: "json",
                        url: "../Controllers/TransferController.php?action=listTransfer",
                        data: {}
                    },
                    paging: true,
                    bLengthChange: true,
                    pageLength: 20,
                    lengthMenu: [20, 50, 100],
                    bFilter: true,
                    searchDelay: 350,
                    select: {
                        style: 'single'
                    },
                    LengthChange: true,
                    scrollX: true,
                    scroller: true,
                    "bLengthChange": true,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "columnDefs": [{
                            targets: 0,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 1,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 2,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 3,
                            orderable: false,
                            width: "15%",
                            className: "text-center"
                        },
                        {
                            targets: 4,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 5,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 6,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        }

                    ],
                    columns: [{
                            "data": "lastnameResponsable",
                            "render": (data, type, row) => {

                                return `<span style='font-weight: 400;'>${data} ${row.nameResponsable}</span>`;
                            }
                        },
                        {
                            "data": "lastnamePerson",
                            "render": (data, type, row) => {
                                return `<span style='font-weight: 400;'>${data} ${row.namePerson}</span>`;
                            }
                        },
                        {
                            "data": "mount",
                            "render": (data, type, row) => {
                                return `<span style='font-weight: 400;'>S./${data}</span>`;
                            }
                        },
                        {
                            "data": "update_date",
                            "render": (data, type, row) => {


                                return `<span style='font-weight: 400;'>${data}</span>`;

                            }
                        },
                        {
                            "data": "canalName",
                            "render": (data, type, row) => {
                                if (data == null) {
                                    return ``;
                                } else {
                                    return `<span style='font-weight: 400;'>${data}</span>`;
                                }
                            }
                        },
                        {
                            "data": "url_voucher",
                            "render": (data, type, row) => {
                                let jsonstring = JSON.stringify(row)
                                var escapedJsonString = jsonstring.replace(/"/g, "&quot;");
                                let html = `
                                            <a href="#" class="mr-2 editButton" 
                                             onclick="descargar('${data}')" data-toggle="tooltip"
                                              data-placement="left"  
                                            style="color:#3c8dbc" data-original-title="Download">
                                            <i class="fa fa-fw fa-file font-18"></i>
                                            </a>&nbsp;&nbsp;
                                        `

                                return `<div style="text-align: center;">${html}</div>`;


                            }
                        },
                        {
                            "data": "id_transfer",
                            "render": (data, type, row) => {
                                let jsonstring = JSON.stringify(row)
                                var escapedJsonString = jsonstring.replace(/"/g, "&quot;");
                                let html = `
                                            <a href="#" class="mr-2 editButton" 
                                             onclick="editar(${escapedJsonString})" data-toggle="tooltip"
                                              data-placement="left"  
                                            style="color:#3c8dbc" data-original-title="Editar Rol">
                                            <i class="fa fa-fw fa-pencil-square font-18"></i>
                                            </a>&nbsp;&nbsp;  
                                            <a href="#" class="mr-2 editButton" 
                                             onclick="listar_history(${escapedJsonString})" data-toggle="tooltip"
                                              data-placement="left"  
                                            style="color:#3c8dbc" data-original-title="Editar Rol">
                                            <i class="fa fa fa-fw fa-history font-18"></i>
                                            </a>&nbsp;&nbsp;
                                        `

                                return `<div style="text-align: center;">${html}</div>`;



                            }
                        }
                    ],
                    fnDrawCallback: () => {
                        $('[data-toggle="popover"]').popover();
                        $('.dataTables_scrollHeadInner').width('100%')
                        $('.datatablePersonalizado').width('100%')

                    }
                })
                $('.dataTables_scrollHeadInner').width('100%')
                $('.datatablePersonalizado').width('100%')

            }


            function listar_history(jsonGeneral) {
                debugger

                $('#modalLog').modal('show')
                $('#transferTable_log').DataTable().destroy();
                datatableRoles = $('#transferTable_log').DataTable({
                    searching: true,
                    data: null,
                    search: true,
                    "language": {
                        "lengthMenu": "Mostrar: _MENU_",
                        "zeroRecords": "&nbsp;&nbsp;&nbsp; No se encontraron resultados",
                        "info": "&nbsp;&nbsp;&nbsp; Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                        "infoEmpty": "&nbsp;&nbsp;&nbsp; Mostrando 0 de 0 registros",
                        "search": "Filtrar:",
                        "loadingRecords": "Cargando...",
                        "processing": '<span style="width:100%;"><img style="width:100%;height:150" src="../images/gif/cargando.gif"></span>',
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "ajax": {
                        method: "POST",
                        dataType: "json",
                        url: "../Controllers/TransferController.php?action=getHistory",
                        data: {
                            p_id_transfer: jsonGeneral.id_transfer

                        }
                    },
                    paging: true,
                    bLengthChange: true,
                    pageLength: 20,
                    lengthMenu: [20, 50, 100],
                    bFilter: true,
                    searchDelay: 350,
                    select: {
                        style: 'single'
                    },
                    LengthChange: true,
                    scrollX: true,
                    scroller: true,
                    "bLengthChange": true,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "columnDefs": [{
                            targets: 0,
                            orderable: true,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 1,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 2,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 3,
                            orderable: false,
                            width: "15%",
                            className: "text-center"
                        },
                        {
                            targets: 4,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        },
                        {
                            targets: 5,
                            orderable: false,
                            width: "15%",
                            className: "text-center  "
                        }

                    ],
                    columns: [{
                            "data": "lastnameResponsable",
                            "render": (data, type, row) => {

                                return `<span style='font-weight: 400;'>${data} ${row.nameResponsable}</span>`;
                            }
                        },
                        {
                            "data": "lastnamePerson",
                            "render": (data, type, row) => {
                                return `<span style='font-weight: 400;'>${data} ${row.namePerson}</span>`;
                            }
                        },
                        {
                            "data": "mount",
                            "render": (data, type, row) => {
                                return `<span style='font-weight: 400;'>S./${data}</span>`;
                            }
                        },
                        {
                            "data": "create_date",
                            "render": (data, type, row) => {


                                return `<span style='font-weight: 400;'>${data}</span>`;

                            }
                        },
                        {
                            "data": "canalName",
                            "render": (data, type, row) => {
                                if (data == null) {
                                    return ``;
                                } else {
                                    return `<span style='font-weight: 400;'>${data}</span>`;
                                }
                            }
                        },
                        {
                            "data": "url_voucher",
                            "render": (data, type, row) => {
                                let jsonstring = JSON.stringify(row)
                                var escapedJsonString = jsonstring.replace(/"/g, "&quot;");
                                let html = `
                                            <a href="#" class="mr-2 editButton" 
                                             onclick="descargar('${data}')" data-toggle="tooltip"
                                              data-placement="left"  
                                            style="color:#3c8dbc" data-original-title="Download">
                                            <i class="fa fa-fw fa-file font-18"></i>
                                            </a>&nbsp;&nbsp;
                                        `

                                return `<div style="text-align: center;">${html}</div>`;


                            }
                        }
                    ],
                    fnDrawCallback: () => {
                        $('[data-toggle="popover"]').popover();
                        $('.dataTables_scrollHeadInner').width('100%')
                        $('.datatablePersonalizado').width('100%')
                        //            desbloquearpagina()
                    }
                })

            }

            function guardarTransferencia() {
                if (nuevo) {
                    var formData = new FormData(document.getElementById('miFormulario'));

                    $.ajax({
                        type: "POST",
                        url: "../Controllers/TransferController.php?action=guardarTransferencia",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            Swal.fire({
                                title: 'Éxito',
                                text: 'Transferencia registrada correctamente',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    listar()
                                    // Limpiar el formulario
                                    document.getElementById('miFormulario').reset();

                                    // Resetear los selects de Select2
                                    $('#selectCliente').val(null).trigger('change');
                                    $('#selectChannel').val(null).trigger('change');
                                    $('#selectAcountNumber').val(null).trigger('change');

                                    // Aquí puedes cerrar el modal si es necesario
                                    $('#modalCreate').modal('hide');
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            alert('Error al registrar la transferencia');
                            console.error(error);
                        }
                    });
                } else {
                    actualizarTransferencia()
                }
            }

            function actualizarTransferencia() {
                var formData = new FormData(document.getElementById('miFormulario'));
                formData.append('p_id_transfer', id_transfer);
                $.ajax({
                    type: "POST",
                    url: "../Controllers/TransferController.php?action=actualizarTransferencia",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        Swal.fire({
                            title: 'Éxito',
                            text: 'Transferencia registrada correctamente',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                listar()
                                // Limpiar el formulario
                                document.getElementById('miFormulario').reset();

                                // Resetear los selects de Select2
                                $('#selectCliente').val(null).trigger('change');
                                $('#selectChannel').val(null).trigger('change');
                                $('#selectAcountNumber').val(null).trigger('change');

                                // Aquí puedes cerrar el modal si es necesario
                                $('#modalCreate').modal('hide');
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        alert('Error al registrar la transferencia');
                        console.error(error);
                    }
                });
            }

            function descargar(fileUrl) {
                // Crear un elemento <a>
                var a = document.createElement('a');
                a.href = fileUrl;
                // Definir el atributo download para forzar la descarga
                a.download = fileUrl.split('/').pop();
                // Añadir el elemento al DOM
                document.body.appendChild(a);
                // Simular un clic en el enlace
                a.click();
                // Remover el elemento del DOM
                document.body.removeChild(a);
            }

            function editar(json) {

                debugger
                $.ajax({
                    type: "POST",
                    url: "../Controllers/TransferController.php?action=getTransfer",
                    dataType: "json",
                    data: {
                        p_id_transfer: json.id_transfer
                    },
                    success: function(response) {
                        nuevo = false
                        Promise.all([listClient(), listAccountNumbers(), listChannel()])
                            .then(() => {
                                data = response.data[0]
                                id_transfer = json.id_transfer
                                $('#selectCliente').val(data.id_person).trigger('change');
                                $('#selectChannel').val(data.type_canal)
                                $('#selectAcountNumber').val(data.id_account_bank)
                                $('#amount').val(data.mount)
                                debugger
                                //    $('#voucher').text(data.url_voucher);

                                // Codificar la URL del archivo correctamente
                                const encodedUrl = encodeURI(data.url_voucher);

                                // Crear la URL completa del archivo
                                const fileURL = `../uploads/${encodedUrl}`;
                                const filePreview = document.getElementById('filePreview');
                                filePreview.src = fileURL;
                                filePreview.style.display = 'block';
                                debugger
                                $('#modalCreate').modal('show')
                            })
                            .catch(error => {
                                // Manejar errores si alguna de las promesas falla
                                console.error("Error al listar datos:", error);
                            });
                    }
                });
            }

            function listClient() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "POST",
                        url: "../Controllers/ClientController.php?action=listClient",
                        dataType: "json",
                        data: {},
                        success: function(response) {
                            pintarSelectClient(response)
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(error);
                        }
                    });
                });
            }

            function listChannel() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "POST",
                        url: "../Controllers/TransferController.php?action=listChannel",
                        dataType: "json",
                        data: {},
                        success: function(response) {
                            pintarSelectChannel(response)
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(error);
                        }
                    });
                });
            }

            function listAccountNumbers() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "POST",
                        url: "../Controllers/TransferController.php?action=listAccountNumbers",
                        dataType: "json",
                        data: {},
                        success: function(response) {
                            pintarSelectAcountNumber(response)
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(error);
                        }
                    });
                });
            }

            function pintarSelectClient(data) {

                // Variable para almacenar el HTML de las opciones
                var options = '';

                // Recorre los datos y construye el HTML de las opciones
                options += `<option value="">Seleccione</option>`;

                $.each(data.data, function(index, item) {

                    options += `<option value="${item.id_person}">${item.dni} - ${item.last_name} ${item.name}</option>`;
                });
                $('#selectCliente').html(options);
                $('#selectCliente').select2({
                    dropdownParent: $('#modalCreate')
                });
            }

            function cerrarModal() {
                $('#modalCreate').modal('hide')
            }

            function pintarSelectChannel(data) {
                // Variable para almacenar el HTML de las opciones
                var options = '';
                options += `<option value="">Seleccione</option>`;
                // Recorre los datos y construye el HTML de las opciones
                $.each(data.data, function(index, item) {
                    options += `<option value="${item.id_master_diccionare}">${item.value}</option>`;
                });
                $('#selectChannel').html(options);
            }

            function pintarSelectAcountNumber(data) {
                // Variable para almacenar el HTML de las opciones
                var options = '';
                options += `<option value="">Seleccione</option>`;
                // Recorre los datos y construye el HTML de las opciones
                $.each(data.data, function(index, item) {

                    options += `<option value="${item.id_account_bank}">${item.account_number} -
                         ${item.name}</option>`;
                });
                $('#selectAcountNumber').html(options);

            }
        </script>

    </body>

</html>