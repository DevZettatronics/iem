<?php

class ProductsData

{

	public static $tablename = "products";



	public function ProductsData()

	{

		$this->name = "";

		$this->lastname = "";

		$this->email = "";

		$this->password = "";

		$this->date_added = "NOW()";

	}



	public function add()

	{

	}





	public static function delById($id)

	{

		$sql = "delete from " . self::$tablename . " where id=$id";

		Executor::doit($sql);

	}

	public function del()

	{

		$sql = "delete from " . self::$tablename . " where product_id=$this->product_id";

		Executor::doit($sql);

	}

	// partiendo de que ya tenemos creado un objecto ConceptData previamente utilizamos el contexto

	public function update()

	{

		$sql = "update " . self::$tablename . " set category_id=\"$this->category_id\", product_code=\"$this->product_code\", product_name=\"$this->product_name\", note=\"$this->note\", selling_price=\"$this->selling_price\" , clave_sat=\"$this->clave_sat\" where product_id=$this->product_id";


		Executor::doit($sql);

	}



	public static function getById($id)

	{

		$sql = "select * from " . self::$tablename . " where id=$id";

		$query = Executor::doit($sql);

		return Model::one($query[0], new ProductsData());


	}



	/* midificaicon  */


	public static function getCambio($descripcion)

	{

		$sql = "SELECT * FROM " . self::$tablename . " WHERE product_id = $descripcion ";


		$query = Executor::doit($sql);

		return Model::one($query[0], new ProductsData());

	}


	public static function getByIdd($id)

	{

		$sql = "SELECT * FROM " . self::$tablename . " WHERE product_id = '$id' ";

		$query = Executor::doit($sql);

		return Model::one($query[0], new ProductsData());

	}

	/* modificacion */



	/* para vista en pagos  */

	public static function getPago($product_n)

	{

		$sql = "select * from " . self::$tablename . " where product_name=$product_n";

		$query = Executor::doit($sql);

		return Model::one($query[0], new ProductsData());

	}





	/* pagos fin  */

	public static function getAllAll()

	{

		$sql = "select * from " . self::$tablename;

		$query = Executor::doit($sql);

		return Model::many($query[0], new ProductsData());

	}


	public static function getAll()

	{

		$sql = "select * from " . self::$tablename ." WHERE STATUS = 1 ";

		$query = Executor::doit($sql);

		return Model::many($query[0], new ProductsData());

	}

	// vista en categoria

	public static function getStock($id)

	{

		//left buscas la tabla del lado izquierdo

		//right lado derecho

		//where para que solo traiga los productos de dicha categoria 

		$sql = "SELECT * FROM `products` `p`  LEFT JOIN `categories` `c`  ON  `p`.`category_id` = `c`.`id` WHERE `c`.`id` = $id";

		$query = Executor::doit($sql);

		return Model::many($query[0], new CategoriesData());

	}



	public static function getAllByUserId($id)

	{

		$sql = "select * from " . self::$tablename . " where user_id=$id";

		$query = Executor::doit($sql);

		return Model::many($query[0], new ProductsData());

	}



	public static function getFavoritesByUserId($id)

	{

		$sql = "select * from " . self::$tablename . " where user_id=$id and is_favorite=1";

		$query = Executor::doit($sql);

		return Model::many($query[0], new ProductsData());

	}





	public static function getLike($q)

	{

		$sql = "select * from " . self::$tablename . " where name like '%$q%'";

		$query = Executor::doit($sql);

		return Model::many($query[0], new ProductsData());

	}



	public function getPro()

	{

		return CategoriesData::getById($this->category_id);

	}



	public function getTotal($beca) {
		$sql = "SELECT porcentaje, name FROM becas WHERE id=$beca";
		$query = Executor::doit($sql);
		$result = Model::one($query[0], new ProductsData());
		return $result ? ['porcentaje' => $result->porcentaje, 'name' => $result->name] : ['porcentaje' => 0, 'name' => '']; // Devuelve el porcentaje y nombre o valores predeterminados si no se encuentra
	}

	public function getDescuentos($idPerson_prom, $idPerson_beca) {
		// Incluimos el campo 'id' en la consulta
		$sql = "SELECT id, name, porcentaje FROM becas WHERE id = $idPerson_prom OR id = $idPerson_beca";
		$query = Executor::doit($sql);
		$result = Model::many($query[0], new ProductsData());
		
		// Definir las variables de descuento
		$descuentos = ['promocion' => ['porcentaje' => 0, 'name' => ''], 'beca' => ['porcentaje' => 0, 'name' => '']];
		
		foreach ($result as $row) {
			// Verificamos si el ID coincide con promoción o beca
			if ($row->id == $idPerson_prom) {
				$descuentos['promocion'] = ['porcentaje' => $row->porcentaje, 'name' => $row->name];
			} elseif ($row->id == $idPerson_beca) {
				$descuentos['beca'] = ['porcentaje' => $row->porcentaje, 'name' => $row->name];
			}
		}
	
		return $descuentos; // Devolver los descuentos
	}
	
	public static function getNameConceptos($id_plan) {
		
		// Ahora, consultamos sale_product para obtener el registro usando el sale_id obtenido y el mismo id_plan
		$sql = "SELECT p.product_name 
				FROM sale_product sp 
				INNER JOIN products p ON sp.product_id = p.product_id 
				WHERE  sp.id_plan = $id_plan";
		$query = Executor::doit($sql);
		
		// Se utiliza Model::many para obtener un array de objetos de ProductsData.
		return Model::many($query[0], new ProductsData());
	}
	

	public static function getNameConceptos2($id_plan,$sale_number) {
		// Primero, obtenemos el sale_id de la tabla sales donde id_plan coincide.
		$sqlSale = "SELECT sale_id FROM sales WHERE sale_number = $sale_number LIMIT 1";
		$querySale = Executor::doit($sqlSale);
		// Se asume que tienes un método para obtener un único objeto de resultado, por ejemplo Model::one()
		$saleData = Model::one($querySale[0], new ProductsData());
		
		if (!$saleData) {
			throw new Exception("No se encontró un registro en sales para id_plan = $id_plan");
		}
		$sale_id = $saleData->sale_id;
		
		// Ahora, consultamos sale_product para obtener el registro usando el sale_id obtenido y el mismo id_plan
		$sql = "SELECT p.product_name 
				FROM sale_product sp 
				INNER JOIN products p ON sp.product_id = p.product_id 
				WHERE sp.sale_id = $sale_id AND sp.id_plan = $id_plan";
		$query = Executor::doit($sql);
		
		// Se utiliza Model::many para obtener un array de objetos de ProductsData.
		return Model::many($query[0], new ProductsData());
	}
}

