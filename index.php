<?php
session_start();
header('refresh:4; url=core.html');
?>

<!DOCTYPE HTML>
<html lang='es' class=''>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Instituto Ejecutivo Mexicano IEM-UEEM</title>
<link rel="icon" type="image/x-icon" href="assets/images/aguila_dorada.ico" />
<meta name="author" content="Instituto Ejecutivo Mexicano IEM - UEEM" />
<meta name="description" content="Soluciones Tecnológicas IEM - Un espacio creado para ti. ">
<meta property="og:image" content="https://aula.iemueem.edu.mx/Servicios/iem/00home/assets/img/Logo-2023-IEM-web.png">


<!--<link rel="stylesheet" href="00home/css/style_IEM.css">-->

<style type="text/css">

  /* Estilo para la imagen */
  #img {
    max-width: 100%; /* La imagen se ajustará al ancho máximo del contenedor */
    height: auto; /* La altura se ajustará automáticamente para mantener la proporción original */
    display: block; /* Para asegurar que la imagen tenga un flujo de bloque */
    margin: 0 auto; /* Centra horizontalmente la imagen */
    max-height: 300px; /* Tamaño máximo de altura para la imagen */
  }
  
  /* Estilo para hacer la imagen responsive */
  @media screen and (max-width: 600px) {
    #img {
      max-height: 150px; /* Tamaño máximo de altura para la imagen en pantallas pequeñas */
    }
  }
  
  
  
          #img {
            margin-top: 150px;
            width: 500px; /* Ancho deseado */
            height: auto; /* Altura auto para mantener la proporción */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Sombras */
        }
</style>


<style id="INLINE_PEN_STYLESHEET_ID">
    body {
  /*display: flex;*/
  align-items: center;
  position: relative;
  background: linear-gradient(to bottom right, #070630 0%, #060454 100%);
  min-height: 100vh;
}

.animation-container {
  display: block;
  position: relative;
  width: 800px;
  max-width: 100%;
  margin: 0 auto;
  margin-top: 200px;
}
.animation-container .lightning-container {
  position: absolute;
  top: 50%;
  left: 0;
  display: flex;
  transform: translateY(-50%);
}
.animation-container .lightning-container .lightning {
  position: absolute;
  display: block;
  height: 12px;
  width: 12px;
  border-radius: 12px;
  transform-origin: 6px 6px;
  -webkit-animation-name: woosh;
          animation-name: woosh;
  -webkit-animation-duration: 1.5s;
          animation-duration: 1.5s;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: cubic-bezier(0.445, 0.05, 0.55, 0.95);
          animation-timing-function: cubic-bezier(0.445, 0.05, 0.55, 0.95);
  -webkit-animation-direction: alternate;
          animation-direction: alternate;
}
.animation-container .lightning-container .lightning.white {
  background-color: white;
  box-shadow: 0px 50px 50px 0px rgba(255, 255, 255, 0.3);
}
.animation-container .lightning-container .lightning.red {
  background-color: #fc7171;
  box-shadow: 0px 50px 50px 0px rgba(252, 113, 113, 0.3);
  -webkit-animation-delay: 0.2s;
          animation-delay: 0.2s;
}
.animation-container .boom-container {
  position: absolute;
  display: flex;
  width: 80px;
  height: 80px;
  text-align: center;
  align-items: center;
  transform: translateY(-50%);
  left: 200px;
  top: -145px;
}
.animation-container .boom-container .shape {
  display: inline-block;
  position: relative;
  opacity: 0;
  transform-origin: center center;
}
.animation-container .boom-container .shape.triangle {
  width: 0;
  height: 0;
  border-style: solid;
  transform-origin: 50% 80%;
  -webkit-animation-duration: 1s;
          animation-duration: 1s;
  -webkit-animation-timing-function: ease-out;
          animation-timing-function: ease-out;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  margin-left: -15px;
  border-width: 0 2.5px 5px 2.5px;
  border-color: transparent transparent #42e599 transparent;
  -webkit-animation-name: boom-triangle;
          animation-name: boom-triangle;
}
.animation-container .boom-container .shape.triangle.big {
  margin-left: -25px;
  border-width: 0 5px 10px 5px;
  border-color: transparent transparent #fade28 transparent;
  -webkit-animation-name: boom-triangle-big;
          animation-name: boom-triangle-big;
}
.animation-container .boom-container .shape.disc {
  width: 8px;
  height: 8px;
  border-radius: 100%;
  background-color: #d15ff4;
  -webkit-animation-name: boom-disc;
          animation-name: boom-disc;
  -webkit-animation-duration: 1s;
          animation-duration: 1s;
  -webkit-animation-timing-function: ease-out;
          animation-timing-function: ease-out;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
}
.animation-container .boom-container .shape.circle {
  width: 20px;
  height: 20px;
  -webkit-animation-name: boom-circle;
          animation-name: boom-circle;
  -webkit-animation-duration: 1s;
          animation-duration: 1s;
  -webkit-animation-timing-function: ease-out;
          animation-timing-function: ease-out;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  border-radius: 100%;
  margin-left: -30px;
}
.animation-container .boom-container .shape.circle.white {
  border: 1px solid white;
}
.animation-container .boom-container .shape.circle.big {
  width: 40px;
  height: 40px;
  margin-left: 0px;
}
.animation-container .boom-container .shape.circle.big.white {
  border: 2px solid white;
}
.animation-container .boom-container .shape:after {
  background-color: rgba(178, 215, 232, 0.2);
}
.animation-container .boom-container .shape.triangle, .animation-container .boom-container .shape.circle, .animation-container .boom-container .shape.circle.big, .animation-container .boom-container .shape.disc {
  -webkit-animation-delay: 0.38s;
          animation-delay: 0.38s;
  -webkit-animation-duration: 3s;
          animation-duration: 3s;
}
.animation-container .boom-container .shape.circle {
  -webkit-animation-delay: 0.6s;
          animation-delay: 0.6s;
}
.animation-container .boom-container.second {
  left: 485px;
  top: 155px;
}
.animation-container .boom-container.second .shape.triangle, .animation-container .boom-container.second .shape.circle, .animation-container .boom-container.second .shape.circle.big, .animation-container .boom-container.second .shape.disc {
  -webkit-animation-delay: 1.9s;
          animation-delay: 1.9s;
}
.animation-container .boom-container.second .shape.circle {
  -webkit-animation-delay: 2.15s;
          animation-delay: 2.15s;
}

@-webkit-keyframes woosh {
  0% {
    width: 12px;
    transform: translate(0px, 0px) rotate(-35deg);
  }
  15% {
    width: 50px;
  }
  30% {
    width: 12px;
    transform: translate(214px, -150px) rotate(-35deg);
  }
  30.1% {
    transform: translate(214px, -150px) rotate(46deg);
  }
  50% {
    width: 110px;
  }
  70% {
    width: 12px;
    transform: translate(500px, 150px) rotate(46deg);
  }
  70.1% {
    transform: translate(500px, 150px) rotate(-37deg);
  }
  85% {
    width: 50px;
  }
  100% {
    width: 12px;
    transform: translate(700px, 0) rotate(-37deg);
  }
}

@keyframes woosh {
  0% {
    width: 12px;
    transform: translate(0px, 0px) rotate(-35deg);
  }
  15% {
    width: 50px;
  }
  30% {
    width: 12px;
    transform: translate(214px, -150px) rotate(-35deg);
  }
  30.1% {
    transform: translate(214px, -150px) rotate(46deg);
  }
  50% {
    width: 110px;
  }
  70% {
    width: 12px;
    transform: translate(500px, 150px) rotate(46deg);
  }
  70.1% {
    transform: translate(500px, 150px) rotate(-37deg);
  }
  85% {
    width: 50px;
  }
  100% {
    width: 12px;
    transform: translate(700px, 0) rotate(-37deg);
  }
}
@-webkit-keyframes boom-circle {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  30% {
    opacity: 0;
    transform: scale(3);
  }
}
@keyframes boom-circle {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  30% {
    opacity: 0;
    transform: scale(3);
  }
}
@-webkit-keyframes boom-triangle-big {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  40% {
    opacity: 0;
    transform: scale(2.5) translate(50px, -50px) rotate(360deg);
  }
}
@keyframes boom-triangle-big {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  40% {
    opacity: 0;
    transform: scale(2.5) translate(50px, -50px) rotate(360deg);
  }
}
@-webkit-keyframes boom-triangle {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  30% {
    opacity: 0;
    transform: scale(3) translate(20px, 40px) rotate(360deg);
  }
}
@keyframes boom-triangle {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  30% {
    opacity: 0;
    transform: scale(3) translate(20px, 40px) rotate(360deg);
  }
}
@-webkit-keyframes boom-disc {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  40% {
    opacity: 0;
    transform: scale(2) translate(-70px, -30px);
  }
}
@keyframes boom-disc {
  0% {
    opacity: 0;
  }
  5% {
    opacity: 1;
  }
  40% {
    opacity: 0;
    transform: scale(2) translate(-70px, -30px);
  }
}
.footer {
  color: white;
  font-size: 10px;
  position: fixed;
  bottom: 0;
  font-weight: 200;
  padding: 10px 20px;
}
.footer a, .footer a:hover, .footer a:focus, .footer a:visited {
  color: #c6c6c6;
}
  </style>
  
<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>
<script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeConsoleRunner-6d8bf8b4b479137260842506acbb12717dace0823c023e08b96360e60b0840d9.js"></script>
<script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRefreshCSS-44fe83e49b63affec96918c9af88c0d80b209a862cf87ac46bc933074b8c557d.js"></script>
<script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRuntimeErrors-4f205f2c14e769b448bcf477de2938c681660d5038bc464e3700256713ebe261.js"></script>


</head>

<body>
    
    <center>
        <img id="img" src="00home/assets/img/Logo-2023-IEM-web.png" alt=""/>
        <br><br>
        <h1 style="color: white;">C A R G A N D O . . .</h1>
     </center>




  <div class="animation-container">
	<div class="lightning-container">
		<div class="lightning white"></div>
		<div class="lightning red"></div>
	</div>
	<div class="boom-container">
		<div class="shape circle big white"></div>
		<div class="shape circle white"></div>
		<div class="shape triangle big yellow"></div>
		<div class="shape disc white"></div>
		<div class="shape triangle blue"></div>
	</div>
	<div class="boom-container second">
		<div class="shape circle big white"></div>
		<div class="shape circle white"></div>
		<div class="shape disc white"></div>
		<div class="shape triangle blue"></div>
	</div>

</div>


  <script  src="https://cdpn.io/cpe/boomboom/pen.js?key=pen.js-e1f735d4-2b4d-8421-a1e4-290143183386" crossorigin></script>

<center>
<h2 style="color: white;    margin-top: 600px;">¡ E S T A B L E C I E N D O<br>CONEXIÓN SEGURA!</h2>
  </center>

</body>
</html>