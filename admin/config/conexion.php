<?php
	# conectare la base de datos
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($con, "utf8");
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
	# obtengo la zona horaria registrada en la db
	function get_timezone($con){
		global $timezone;
		$sql=mysqli_query($con, "SELECT timezones.name FROM business_profile, timezones WHERE business_profile.timezone_id=timezones.id AND business_profile.id=1");	
		$rw=mysqli_fetch_array($sql);
		$timezone_name=$rw['name'];
		$timezone=date_default_timezone_set($timezone_name);
		if(mysqli_error($con)){
			$error = "Se ha encontrado el siguiente error en la base de datos: ".mysqli_error($con);
			error_log($error);
		}
		return $timezone;
		
		
	}
	
	# obtengo los datos de la moneda actual
	function get_currency($con){
		global $timezone;
		$sql=mysqli_query($con, "SELECT currencies.name,  currencies.symbol, currencies.precision_currency, currencies.thousand_separator, currencies.decimal_separator, currencies.code FROM business_profile,  currencies WHERE business_profile.currency_id=currencies.id AND business_profile.id=1");	
		$rw=mysqli_fetch_array($sql);
		return $rw;
	}	
	get_timezone($con);//Establece la zona horaria
	$currency_format= get_currency($con);//Arrary que devuelve los datos de 1 moneda
?>