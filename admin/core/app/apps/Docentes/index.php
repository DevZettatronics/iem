<!DOCTYPE html>

<html lang="en">
<?php
require("comunes/head.php");
require("conectar.php");
require("determinar_movimiento.php");
?>
<body>
  <?php require("comunes/nav.php"); ?>
  <header>
    <div align="center">
      <br><br>
      <br><br>
      <form class="form-signin" action="index.php" method="POST">
        <div style="text-align:center;color:red;font-weight:900">

<img style="width:300px" src="./img/IEM_Registro.png" />
<br>
<h2 style="font-weight: bold; color: #000;">Control de Acceso</h2>
<br><br>

          <?php
          if (isset($_GET["error"])) {
          ?>
            <div class="alert alert-danger">
              <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo "No existe un docente registrado con esta credencial "; ?>
            </div>
          <?php
          }
          ?>
          <?php
          if (isset($movimiento) and ($movimiento == 0)) {
          ?>
            <div style="color:black" class="borrable">
              <?php echo "Usuario: " . $row["code"];
              echo "<br>"; ?>
              <?php echo  $row["name"];
              echo " ";
              echo $row["lastname"];
              echo "<br>";  ?>
              <img src="../../<?php echo $row['foto']; ?>" class="img-rounded" width="300px" height="350px" />
              <?php echo "<br>"; ?>
            </div>
            <?php echo "<br>"; ?>
            <div class="alert alert-success fade in borrable">
              <img style="width:30px" src="./img/marcados.png" />
              <?php echo $tipo;
              echo ": ";
              echo $hora; ?>
            </div>
          <?php
          }
          if (isset($movimiento) and ($movimiento == 1)) {
          ?>
            <div style="color:black"  class="borrable">
              <?php echo "Usuario: " . $row["code"];
              echo "<br>"; ?>
              <?php echo  $row["name"];
              echo " ";
              echo $row["lastname"];
              echo "<br>"; ?>
              <img src="../../<?php echo $row['foto']; ?>" class="img-rounded" width="300px" height="350px" />
              <?php echo "<br>"; ?>
            </div>
            <?php echo "<br>"; ?>
            <div class="alert alert-danger fade in borrable">
              <img style="width:30px" src="./img/marcados.png" />
              <?php echo $tipo;
              echo ":";
              echo $hora; ?>
            </div>
          <?php
          }
          ?>
        </div>
        <input type="text" class="form-control" name="tarjeta" maxlength="10" onkeypress="return isNumberKey(event)" placeholder="Acerque su credencial" required="" autofocus="" />
      </form>
    </div>
  </header>
  <?php require("comunes/scripts.php"); ?>
  <script type="text/javascript">
    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }
    $(function () {
      window.setTimeout(function () {
        $(".borrable").fadeTo(500, 0).slideUp(500, function () {
          $(this).remove();
        });
        }, 10000);
    });
  </script>
</body>

</html>