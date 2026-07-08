<?php 
if(isset($_POST['id'])){
    $id = ($_POST['id']);//Obtiene el id del ticket
    $contador = 0;//Contador para obtener el total de tickets guardados en el servidor
    $identificadorA = 0;//Auxiliar identificador
    $identificadorB = 0;//Auxiliar identificador
    if(file_exists('../storage/tickets/' . $id . '-1.pdf')){//Verifica si existe el archivo con terminacion -1.pf
        $contador++;//El primer ticket sí existe, el contador aumenta en 1
        $identificadorA = 1;//Para identificar que el primer ticket sí existe se requiere un idetificador
    }
    if(file_exists('../storage/tickets/' . $id . '-2.pdf')){//Verifica si existe el archivo con terminacion -2.pf
        $contador++;//El primer ticket sí existe, el contador aumenta en 1
        $identificadorB = 1;//Para identificar que el segundo ticket sí existe se requiere un idetificador
    }
    if($identificadorA){//Verificar si el primer ticket existe a travéz de su identificador
        unlink('../storage/tickets/' . $id . '-1.pdf');//Se elimina el archivo de la carpeta
        echo --$contador;//Se resta en uno al contador antes de imprimir, si se colocara como $contador-- se imprimiría primero y a continuación se restaría
    }else if($identificadorB){//El primer ticket no existe, se procede a verificar si el segundo ticket existe a travéz de su identificador
        unlink('../storage/tickets/' . $id . '-2.pdf');//Se elimina el archivo de la carpeta
        echo --$contador;//Se resta en uno al contador antes de imprimir, si se colocara como $contador-- se imprimiría primero y a continuación se restaría
    }    
}
?>