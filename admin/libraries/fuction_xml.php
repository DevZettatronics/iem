<?php
/* function crear_xml($rfc){

$cadena='<?xlm version="1.0" encoding="utf-8"?>
<nodo>
 <dato id_xml="">"'.$rfc.'"</dato>
</nodo>';
//aqui ira la cadena string del xlm
$xlm=$cadena;
$url_xml="./storage/xml";
$nombre=$url_xml."/archivo_testing.xml";
$archivo=fopen($nombre, "w+");
fwrite($archivo,$xlm);
fclose($archivo);

} */
function crear_xml(){
    $xml = new XMLWriter();
    $xml->openUri('storage/xml/output.xml');
    $xml->startDocument('1.0', 'utf-8');
    $xml->startElement('foo');
$xml->writeAttribute('bar', 'baz');
$xml->writeCdata('Lorem ipsum');
$xml->endElement();
}

?>