<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de lista de frases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="fuentes/fuentes.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php
include("fuentes/google_fonts_link.php");
if (!empty($_POST["archivo_csv"])) {
    $nombre_lista = $_FILES['lista']['name'];
    $peso_archivo = ($_FILES['lista']['size']) / 1024;
    $peso_archivo = round($peso_archivo, 1) . " KB.";
    $tmp_name = $_FILES['lista']['tmp_name'];
    $archivo = fopen("$tmp_name", "r");
    while(($datos = fgetcsv($archivo, 1000, ",")) == true) {
        $frases[]=$datos[0];
    }
}
$_SESSION["frases"] = $frases;
?>
</head>

<body>
<br>
<div class="container">
    <hr class="border border-primary border-3"><br>
    <div class="row">
      <div class="col-6">
      <h1>Cofre de la Motivación</h1>
      </div>
      <div class="col-3">
      <b>Desarrollo:</b> Saúl Ruiz M.<br>
      <b>Autor:</b> Francisco J. Ramírez<br>
      <b>Última actualización:</b> 2024-11-05<br>
      <a target="_blank" href="changelog.html">Changelog</a>
      </div>
      <div class="col-3">
        <b>Apache:</b> <?php print apache_get_version(); ?><br>
        <b>PHP:</b> <?php print phpversion();?><br>
        <b>PDF:</b> Dompdf 3.0.0<br>
        <b>MySQL:</b> N/A<br>
        </div>
    </div>
    <br><hr class="border border-primary border-3"><br>
    <div class="row">
        <div class="col-5">
            <form action="index.php" name="carga_archivo" id="carga_archivo" method="post" enctype="multipart/form-data">
            <b>Seleccionar archivo CSV UTF-8 <font color=red> * necesario</font></b><br>
            <input class="form-control" type="file" name="lista" id="lista" accept=".csv" required><br><br>
            <input type="hidden" name="archivo_csv" id="archivo_csv" value="1">
            <input class="btn btn-primary" type="submit" value="Cargar"> <a class="btn btn-primary" href="index.php">Borrar todo</a>
            </form>
        </div>
        <div class="col-3">
        <b>Caracteres máximos por frase:</b><br>
        150<br><br>
        <b>Archivo:</b><br>
          <?php print "$nombre_lista<br> $peso_archivo"; ?>
        </div>
        <div class="col estado">
          <h5>Estado:</h5>
          <?php 
          if (!empty($nombre_lista)) {
            unset($frases[0]);
            $total_frases = count($frases);
            print "<b>Se encontraron $total_frases frases.</b><p>";
            $mensaje_frase = "";
            foreach ($frases as $key => $value) {
                $conteo_caracteres = strlen($value);
                if ($conteo_caracteres > 150) {
                    $contador++;
                    $mensaje_frase .= "<b>$contador.</b> Frase $key tiene $conteo_caracteres caracteres.<br>\n";
                }
            }
            if (empty($contador)) {
                print "<font color=green><b>Longitud de frases correcta.</b></font><p>";
            } else {
            print "<font color=#b00c00><b>Se encontraron $contador frases con más de 150 caracteres.</b><p>
            $mensaje_frase</font>";
            }
          }
         ?>
        </div>
    </div>
    <br><hr class="border border-primary border-3"><br>
    <div class="row">
        <div class="col">
        <form action="tarjetas.php" name="generar_documento" id="generar_documento" method="post" target="_blank" enctype="multipart/form-data">
            <b>Seleccionar logo o imágen (opcional)</b><br>
            <input class="form-control" type="file" name="imagen" id="imagen" accept=".gif, .jpg, .png">
        </div>
        <div class="col-2">
        <b>Tamaño cm.</b><br>
        <select class="form-select" aria-label="Default select example" name="centimetros" id="centimetros">
          <option selected value="7">8 x 6</option>
          <option value="1">9 x 6</option>
          <option value="2">9 x 6.5</option>
          <option value="3">9.5 x 6</option>
          <option value="4">9.5 x 6.5</option>
          <option value="5">10 x 6</option>
          <option value="6">10 x 6.5</option>
        </select>
        </div>
        <div class="col-2">
        <b>Frases numeradas</b><br>
        <input class="form-check-input" type="radio" name="numeracion" id="numeracion" value="0" checked> no &nbsp;&nbsp;
        <input class="form-check-input" type="radio" name="numeracion" id="numeracion" value="1"> si
        </div>
        <div class="col-3">
            <b>Dedicatoria o nombre (opcional)</b>
            <input type="text" class="form-control" name="dedicatoria" maxlength="25" placeholder="Max. 25 caracteres">
        </div>
    </div>
    <br><hr class="border border-primary border-3"><br>
    <b>Seleccionar fuente</b><br><br><br>
    <div class="row">
        <div class="col">
            <ul>
            <input class="form-check-input" type="radio" name="fuente" id="dancing-script-uniquifier" value="dancing-script-uniquifier" checked> <span style="font-size: 40px;" class="dancing-script-uniquifier">Dancing-script-uniquifier</span><p>

            <input class="etiqueta form-check-input" type="radio" name="fuente" id="playwrite-gb-s-uniquifier" value="playwrite-gb-s-uniquifier"> <span style="font-size: 30px;" class="playwrite-gb-s-uniquifier etiqueta">Playwrite-gb-s-uniquifier</span><p>

            <input class="etiqueta form-check-input" type="radio" name="fuente" id="quintessential-regular" value="quintessential-regular"> <span style="font-size: 30px;" class="quintessential-regular">Quintessential-regular</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="mali-regular" value="mali-regular">
            <span style="font-size: 30px;" class="mali-regular">Mali-regular</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="cormorant-uniquifier" value="cormorant-uniquifier"> <span style="font-size: 40px;" class="cormorant-uniquifier">Cormorant-uniquifier</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="merienda-uniquifier" value="merienda-uniquifier"> <span style="font-size: 30px;" class="merienda-uniquifier">Merienda-uniquifier</span><p>
            </ul>
        </div>
        <div class="col">
            <ul>
            <input class="form-check-input" type="radio" name="fuente" id="montserrat-alternates-regular" value="montserrat-alternates-regular"> <span style="font-size: 30px;" class="montserrat-alternates-regular">Montserrat-alternates-regular</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="philosopher-regular" value="philosopher-regular"> <span style="font-size: 30px;" class="philosopher-regular">Philosopher-regular</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="tsukimi-rounded-regular" value="tsukimi-rounded-regular"> <span style="font-size: 30px;" class="tsukimi-rounded-regular">Tsukimi-rounded-regular</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="raleway-uniquifier" value="raleway-uniquifier"> <span style="font-size: 30px;" class="raleway-uniquifierr">Raleway-uniquifier</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="delius-swash-caps-regular" value="delius-swash-caps-regular"> <span style="font-size: 30px;" class="delius-swash-caps-regular">Delius-swash-caps-regular</span><p>

            <input class="form-check-input" type="radio" name="fuente" id="borel-regular" value="borel-regular"> <span style="font-size: 30px;" class="borel-regular">Borel-regular</span>
            </ul>
        </div>
    </div>
    <br><hr class="border border-primary border-3"><br>
    <b>Seleccionar esquinero</b><br><br><br>
    <div class="row">
      <?php
        for ($i=1; $i <= 13 ; $i++) { 
          print "<div class='col-md-2 m-3'>
          <input class='btn-check' type='radio' autocomplete='off' name='marco' id='cofre_esquina_$i' value='cofre_esquina_$i'>
          <label class='btn btn-outline-primary' for='cofre_esquina_$i'><img width=200 border='1' src='img/cofre_esquina_$i.png'></label><br><a target='_blank' href='vista_previa.php?img=cofre_esquina_$i'>Vista previa</a>
          </div>";
        }
      ?>
    </div>
    <hr>
    <h4>Seleccionar marco</h4>
    <div class="row">
      <?php
        for ($i=1; $i <= 3 ; $i++) { 
          print "<div class='col-md-2 m-3'>
          <input class='btn-check' type='radio' autocomplete='off' name='marco' id='cofre_marco_$i' value='cofre_marco_$i'>
          <label class='btn btn-outline-primary' for='cofre_marco_$i'><img width=200 border='1' src='img/cofre_marco_$i.png'></label><br><a target='_blank' href='vista_previa.php?img=cofre_marco_$i'>Vista previa</a>
          </div>";
        }
      ?>
    </div>
    <p>
      <br><hr class="border border-primary border-3"><br>
<style>
  .centro1 {
    place-items: center;
}
</style>
<?php
    if (!empty($nombre_lista)) {
    ?>
    <div class="row">
      <div class="col form-check form-switch centro1">
      <b>Vista previa</b><br>
        <input class="form-check-input" name="preview" type="checkbox" role="switch" id="preview">
        <label class="form-check-label" for="preview">  Off / On</label>
     </div>
      <div class="col form-check form-switch centro1">
        <b>Imagen redonda</b><br>
        <input class="form-check-input" name="imagen_redonda" type="checkbox" role="switch" id="imagen_redonda">
        <label class="form-check-label" for="imagen_redonda">  Off / On </label> &nbsp;&nbsp; <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Se sugiere aplicar solo a imágenes cuadradas">Nota</button>
      </div>
      <div class="col form-check form-switch centro1">
        <b>Proteger con contraseña</b><br>
        <input class="form-check-input" name="proteccion" type="checkbox" role="switch" id="proteccion">
        <label class="form-check-label" for="proteccion"> Off / On</label>
        <div class="input-group">
              <input type="password" class="form-control pwd" name="clave" id="clave">
              <span class="input-group-btn">
                <button class="btn btn-outline-secondary reveal" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                  </svg></button>
              </span>          
            </div>
      </div>
      <div class="col centro1"> 
        <h5><font color="blue">Generar documento</font></h5></font>
        <input class="btn btn-primary" type="submit" value="Generar PDF" onclick="alert('El proceso puede tomar tiempo\nNo cerrar la ventana mientras se procesa el documento.');">
      </div>
  </div>
<?php
} else {
  print "<h3>No se ha cargado el archivo CSV.<p>";
}
?>

    <br><br><br><br>
    </form></div>
</div>
<script>
$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
</script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
</body>
</html>
