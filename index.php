<?php

$ID = "";
$nombre_pais = "";
$cod_int = "";
$cod_iso = "";

if (!empty($_POST) || !empty($_GET)) {
    $accion = $_GET['accion'];
    if (!empty($accion) && $accion != null) {
        switch ($accion) {
            case "nuevo":
					
				$ID = $_POST['ID'];
				$nombre_pais = $_POST['pais'];
				$cod_int = $_POST['cod_int'];
				$cod_iso = $_POST['cod_iso'];

                if (empty($ID)) {
                    if (empty($nombre_pais)) {
                        $ERROR = "Ingrese nombre del país.";
                    } 
					else {
                        if (Validar($nombre_pais, $cod_int, $cod_iso)) {
							include_once './php/db.php';
								
							$sql = "Insert into `pais`( `nombre`, `codigoISO`, `codigoInterno`) values ('$nombre_pais', '$cod_iso', '$cod_int')";
							
							$dbi = new DatabaseClass();
							$v = $dbi->Insert
							(
								$sql, 
								[]
							);
							
							if(is_numeric($v)){
								$EXITO = "Se han guardado los datos";
                                $ID = "";
                                $nombre_pais = "";
                                $cod_int = "";
                                $cod_iso = "";
							}
							else{
								$ERROR = "Error en ingreso de datos";
							}
						} 
						else {
                            $ERROR = "Por favor, complete los campos";
                        }
                    }
                } 
				else {
                    if (empty($nombre_pais)) {
                        $ERROR = "Ingrese nombre del país.";
                    } 
					else {
                        if (Validar($nombre_pais, $cod_int, $cod_iso)) {
							include_once './php/db.php';
								
							$sql = "update pais set nombre = '".$nombre_pais."', codigoISO = '".$cod_iso."', codigoInterno = '".$cod_int."' where id = ".$ID;
							
							$dbu = new DatabaseClass();
							$dbu->Update
							(
								$sql
							);

							$EXITO = "Se han guardado los datos";
							$ID = "";
							$nombre_pais = "";
							$cod_int = "";
							$cod_iso = "";
							
						} 
						else {
                            $ERROR = "Por favor, complete los campos";
                        }
                    }
                }
                
				break;
				
            case "ver":
                $ID = $_GET['ID'];
                if (!empty($ID)) {
                    include_once './php/db.php';

					$dbr = new DatabaseClass();
                    $sql = "SELECT * FROM pais WHERE id = " . $ID;
					
					$dataR = $dbr->Select($sql);
                    if (!empty($dataR)) {
                        foreach($dataR as $result)
						{
							$ID = $result['id'];
							$nombre_pais = $result['nombre'];
							$cod_iso = $result['codigoISO'];
							$cod_int = $result['codigoInterno'];
						}
                    } else {
                        $ERROR = "No se encontró datos.";
                    }
                } else {
                    $ERROR = "Datos incompletos para consultar.";
                }
                break;
				
            case "eliminar":
                $ID = $_GET['ID'];
                if (!empty($ID)) {
                    include_once './php/db.php';
								
					$sql = "delete from pais where id = ".$ID;
					
					$dbd = new DatabaseClass();
					$dbd->Remove
					(
						$sql
					);

					$EXITO = "Registro eliminado";
					$ID = "";
					$nombre_pais = "";
					$cod_int = "";
					$cod_iso = "";
                    
                } else {
                    $ERROR = "Datos incompletos para eliminar.";
                }
                break;
        }
    }
}

function Validar($nombre_pais, $cod_int, $cod_iso) {
    if (empty($nombre_pais)) {
        return FALSE;
    }
    if (empty($cod_int)) {
        return FALSE;
    }
    if (empty($cod_iso)) {
        return FALSE;
    }
    return TRUE;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Integral - A fully responsive, HTML5 based admin template">
        <meta name="keywords" content="Responsive, Web Application, HTML5, Admin Template, business, professional, Integral, web design, CSS3">
        <title>CRUD Paises</title>

        <!-- Entypo font stylesheet -->
        <link href="css/entypo.css" rel="stylesheet">
        <!-- /entypo font stylesheet -->

        <!-- Font awesome stylesheet -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <!-- /font awesome stylesheet -->

        <!-- Bootstrap stylesheet min version -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- /bootstrap stylesheet min version -->

        <!-- Integral core stylesheet -->
        <link href="css/integral-core.css" rel="stylesheet">
        <!-- /integral core stylesheet -->

        <!--Jvector Map-->
        <link href="plugins/jvectormap/css/jquery-jvectormap-2.0.3.css" rel="stylesheet">

        <link href="css/integral-forms.css" rel="stylesheet">
        <link href="plugins/datatables/css/jquery.dataTables.css" rel="stylesheet">
        <link href="plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
      
        <style>
            .alineadocenter{
                text-align: center;
            }
        </style>
    </head>
    <body>

        <!-- Loader Backdrop -->
        <div class="loader-backdrop">
            <!-- Loader -->
            <div class="loader">
                <div class="bounce-1"></div>
                <div class="bounce-2"></div>
            </div>
            <!-- /loader -->
        </div>
        <!-- loader backgrop -->

        <!-- Page container -->
        <div class="page-container">

            <!-- Main container -->
            <div class="main-container">

                <!-- Main header -->
                <div class="main-header row"></div>
                <!-- /main header -->

                <!-- Main content -->
                <div class="main-content">

                    <h1 class="page-title">Administración de Paises</h1>
                    <br>
                    <div class="panel-body">
					 <?php
                        if (!empty($ERROR)) {
                            //EXISTE ERROR
                            echo '<div class="alert alert-danger alert-dismissible"
                                  role="alert"><button type="button" class="close"
                                  data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                  <strong>Lo sentimos!</strong> ' . $ERROR . ' </div>';
                        }
                        if (!empty($EXITO)) {
                            echo '<div class="alert alert-success alert-dismissible"
                                 role="alert">
                                <button type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Éxito!</strong> ' . $EXITO . '</div>';
                        }
                    ?>
					</div>
                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Administrar Paises</h4>
                                    <ul class="panel-tool-options">
                                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <form id="formUsuario" action="index.php?accion=nuevo" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="ID">ID</label>
                                            <input type="text" value="<?php echo $ID ?>" class="form-control" readonly="readonly" id="ID" name="ID" placeholder="Se generará un nuevo ID" data-error=".errorNombres" >
                                            <div class="errorNombres" style="color: blue;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pais">Nombre del Pais</label>
                                            <input type="text" value="<?php echo $nombre_pais ?>" class="form-control" id="pais" name="pais" placeholder="Nombre del Pais" data-error=".errorpais" >
                                            <div class="errorCanal" style="color: red;"></div>
                                        </div>
                                     
                                        <div class="form-group">
                                            <label for="cod_int">Código de pais interno</label>
                                            <input type="text" value="<?php echo $cod_int ?>" class="form-control" id="cod_int" name="cod_int" placeholder="Codigo Interno" data-error=".errorcod_int" >
                                            <div class="errorcod_int" style="color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cod_iso">Código ISO(3166) de pais</label>
                                            <input type="text" value="<?php echo $cod_iso ?>" class="form-control" id="cod_iso" name="cod_iso" placeholder="Codigo ISO" data-error=".errorcod_iso" >
                                            <div class="errorcod_iso" style="color: red;"></div>
                                        </div>
                                     
                                        <input type="hidden" name="urllogo" value="<?php echo $logo_url; ?>">
                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                        <button type="button" onclick="Limpiar();" class="btn btn-secondary pull-right">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TABLA DE USUARIOS -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Paises Registrados</h4>
                                    <ul class="panel-tool-options">
                                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th class="alineadocenter">ID</th>
													<th class="alineadocenter">PAIS</th>
                                                    <th class="alineadocenter">CODIGO INTERNO</th>
                                                    <th class="alineadocenter">CODIGO ISO</th>
													<th class="alineadocenter">ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
												
													include_once './php/db.php';

													$db = new DatabaseClass();
													$data = $db->Select("Select * from pais");
													
													foreach($data as $result)
													{
														echo '
														<tr class="gradeX">
															<td class="alineadocenter">' . $result['id'] . '</td>
															<td class="alineadocenter">' . $result['nombre'] . '</td>
															<td class="alineadocenter">' . $result['codigoInterno'] . '</td>
															<td class="alineadocenter">' . $result['codigoISO'] . '</td>
															<td class="alineadocenter">
																<a href="index.php?accion=ver&ID=' . $result['id'] . '"><i class="icon-pencil"></i> Actualizar</a>
																<br>
																<a onclick="return confirm(\'¿Esta seguro de eliminar a : ' . $result['nombre'] . '? \')" href="index.php?accion=eliminar&ID=' . $result['id'] . '"><i class="icon-trash"></i> Eliminar</a>
															</td>
														</tr>';
													}
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="alineadocenter">ID</th>
                                                    <th class="alineadocenter">PAIS</th>
                                                    <th class="alineadocenter">CODIGO INTERNO</th>
                                                    <th class="alineadocenter">CODIGO ISO</th>
													<th class="alineadocenter">ACCIONES</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    
                    <!-- /footer -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /main container -->
        </div>
        <!-- /page container -->

        <!--Load JQuery-->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="plugins/metismenu/js/jquery.metisMenu.js"></script>
        <script src="plugins/blockui-master/js/jquery-ui.js"></script>
        <script src="plugins/blockui-master/js/jquery.blockUI.js"></script>

        <!--Knob Charts-->
        <script src="plugins/knob/js/jquery.knob.min.js"></script>

        <!--Jvector Map-->
        <script src="plugins/jvectormap/js/jquery-jvectormap-2.0.3.min.js"></script>
        <script src="plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js"></script>

        <!--ChartJs-->
        <script src="plugins/chartjs/js/Chart.min.js"></script>

        <!--Morris Charts-->
        <script src="plugins/morris/js/raphael-min.js"></script>
        <script src="plugins/morris/js/morris.min.js"></script>

        <!--Float Charts-->
        <script src="plugins/flot/js/jquery.flot.min.js"></script>
        <script src="plugins/flot/js/jquery.flot.tooltip.min.js"></script>
        <script src="plugins/flot/js/jquery.flot.resize.min.js"></script>
        <script src="plugins/flot/js/jquery.flot.pie.min.js"></script>
        <script src="plugins/flot/js/jquery.flot.time.min.js"></script>
        <!-- DATATABLE -->
        <script src="plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/js/dataTables.bootstrap.min.js"></script>
        <script src="plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
        <script src="plugins/datatables/js/jszip.min.js"></script>
        <script src="plugins/datatables/js/pdfmake.min.js"></script>
        <script src="plugins/datatables/js/vfs_fonts.js"></script>
        <script src="plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
        <script src="plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
        <!--<script src="plugins/datatables/js/dataTables-script.js"></script>-->
        <!--Functions Js-->
        <script src="js/functions.js"></script>

        <!--Dashboard Js-->
        <script src="js/dashboard.js"></script>

        <script src="js/loader.js"></script>
        <!--JQuery Validation-->
        <script type="text/javascript" src="plugins/jquery-validation/jquery.validate.min.js"></script>
        <script type="text/javascript" src="plugins/jquery-validation/additional-methods.min.js"></script>
        <script>
		//VALIDACION DE FORMULARIO FRMUSUARIOS
		$("#formUsuario").validate({
			rules: {
				pais: {
					required: true,
					minlength: 3
				},
				cod_int: {
					required: true,
					minlength: 3
				},
				cod_iso: {
					required: true,
					minlength: 3
				},
				activo: {
					required: true
				}
			},
			//For custom messages
			messages: {
				pais: {
					required: "No puede estar vacío",
					minlength: "Debe ser mayor o igual a 3 caracteres"
				},
				cod_int: {
					required: "No puede estar vacío",
					minlength: "Debe ser mayor o igual a 3 caracteres"
				},
				cod_iso: {
					required: "No puede estar vacío",
					minlength: "Debe ser mayor o igual a 3 caracteres"
				},
				activo: {
					required: "Seleccione una opción"
				}
			},
			errorElement: 'div',
			errorPlacement: function (error, element) {
				var placement = $(element).data('error');
				if (placement) {
					$(placement).append(error)
				} else {
					error.insertAfter(element);
				}
			}
		});
        </script>
        <script>
            //DATA TABLE DE USUARIOS
            $(document).ready(function () {
                $('.dataTables-example').DataTable({
                    dom: '<"html5buttons" B>lTfgitp',
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [0, ':visible']
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3]
                            }
                        },
                        'colvis'
                    ],
                    "language": {
                        "url": "plugins/datatables/es.json"
                    }
                });
            });

        </script>
        <script>
            //LIMPIAR
            function Limpiar() {
                $('#ID').val("");
                $('#logo').val("");
                $('#pais').val("");
                $('#activo').val("");
                $('#cod_int').val("");
                $('#cod_iso').val("");
            }
        </script>
    </body>
</html>