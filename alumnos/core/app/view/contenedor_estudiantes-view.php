<?php
$inscription = InscriptionData::getActive($_SESSION["alumn_id"]);
?>



	  


		  
        <!--- - - - - - - - - - - - - - - - - - -->
        <div class="col-md-12">
        <h4><img src="../storage/posts/contrato.png"  width="52px"> Documentos para Estudiantes</h4>
			
			<a href="./?view=home" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a> 
		
<br><br>

    <?php
    $teams = PostData::getAllByQ("where kind_pub=1 and (kind=1 or kind=4)");
    if(count($teams)>0){
      // si hay usuarios
      ?>
      <div class="box box-primary">
      <div class="box-body">
      <table class="table table-bordered datatable table-hover">
      <thead>
      <th colspan="3">Los Documentos que se encuentran en este espacio son indispensables para tu incorporación. Serán validados por Servicios Escolares</th>
      
      </thead>
      <?php
      
        ?>
       <th colspan="3" style="text-align: center; background-color: #4682B4; color: white;" >Documentos aplicables para todos los estudiantes</th>
        
        

        <!-- - - - - - - - - -Primer Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/formato-de-archivo-doc.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Código Ético</h3>
                <p>Descarga, firma y sube a tu contenedor. </p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/docs_word/Código_Ético.docx" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
        
                <!-- - - - - - - - - -Segundo Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/formato-de-archivo-doc.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Contrato de Prestación de Servicios</h3>
                <p>Descarga, firma y sube a tu contenedor. </p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/docs_word/Contrato_de_Prestamo_de_Servicios.docx" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
        
                <!-- - - - - - - - - -Tercer Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/formato-de-archivo-doc.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Aviso de Sesiones en Google Meet</h3>
                <p>Descarga, firma y sube a tu contenedor. </p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/docs_word/Aviso_de_Sesiones_en_Google_Meet.docx" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
              <!-- - - - - - - - - -Cuarto Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/formato-de-archivo-doc.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Formato de Renovación de Beca</h3>
                <p>Descarga, llena los campos solicitados, firma el documento y envia. </p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/docs_word/FMT_Renov_Beca.docx" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
                      <!-- - - - - - - - - -Quinto Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/formato-de-archivo-doc.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Carta de Aceptación de Beca</h3>
                <p>Descarga, llena los campos solicitados, firma el documento y envia. </p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/docs_word/Carta_aceptación_beca.doc" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
        
        <th colspan="3" style="text-align: center; background-color: #FFA500; color: white;" >Documentos aplicables para Licenciatura</th>
        
                <!-- - - - - - - - - -Primer Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/formato-de-archivo-doc.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Formato de Liberación de Servicio Social</h3>
                <p>Descarga, llena el formato y entrega para Firma y Sello</p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/docs_word/Carta_de_Liberación_de_SS.docx" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
        
        
        
        
        
                <th colspan="3" style="text-align: center; background-color: #2ECC71; color: white;" >Documentos aplicables para Especialidad</th>
        
                        <!-- - - - - - - - - -Primer Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/documento-pdf.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Requisitos Titulación Especialidad</h3>
                <p>Descarga, llena el formato y entrega en Servicios Escolares o sube a tu contenedor</p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/pdf/Requisitos_Titulación_Especialidad.pdf" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>

        
        
        
        
        <th colspan="3" style="text-align: center; background-color: #C71585; color: white;" >Documentos aplicables para Maestría</th>
        
                        <!-- - - - - - - - - -Primer Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/documento-pdf.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Carta Constancia de Asesorías Didácticas - MPG</h3>
                <p>Descarga, llena los datos que te solicitan, entrega a tu asesor, entrega para firma y sube a tu contenedor</p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/pdf/CARTA_CONSTANCIA_ASESORIAS_DIDACTICAS.pdf" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
        
        
                <!-- - - - - - - - - -Segundo Documento ---------------------- - - - - - - - - -->
        <tr>
              <!-- - - - - - - - - -Icono - - - - - - - - - -->
			<td>
			    <img src="../storage/posts/documento-pdf.png"  width="52px">
			</td>
			  <!-- - - - - - - - - - Titulo y Contenido- - - - - - - - - -->
            <td><h3>Boleta de Supervisiones - MPG</h3>
                <p>Descarga, entrega a tu asesor, entrega para firma y sube a tu contenedoro</p>
            </td> 
			  <!-- - - - - - - - - Botón y Link - - - - - - - -->
			<td>
			    <a href="../storage/pdf/Boleta_de_Supervisiones.pdf" class="btn btn-primary btn-sm" target="_blank">Ir al documento</a> 	
			</td>
			
        </tr>
    <?php
    
      echo "</table></div></div>";
    }
    ?>
    </table>
    </div>
        <!-- - - - - - - - - - - - - - - - - - - -->

</div>
