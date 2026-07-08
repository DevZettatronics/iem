<?php
require_once("bin/conekta-php-master/lib/Conekta.php");
require_once("../admin/core/controller/Core.php");
require_once("../admin/core/controller/Database.php");
require_once("../admin/core/controller/Executor.php");
require_once("../admin/core/controller/Model.php");
require_once("../admin/core/app/model/PagosData.php");
require_once("../admin/core/app/model/PlandepagoData.php");
require_once("../admin/core/app/model/ProductsData.php");
require_once('../keys_conekta/conekta.php');

class Payment
{

  private $ApiKey = key_privada_conekta;
  private $ApiVersion = "2.0.0";


  /* recibe los datos */
  public function __construct($token, $card, $name, $description, $total, $email, $idAlumno)
  {

    $this->token = $token;
    $this->card = $card;
    $this->name = $name;
    $this->description = $description;
    $this->total = $total;
    $this->email = $email;
    $this->idAlumno = $idAlumno;
  }

  public function Pay()
  {
      \Conekta\Conekta::setApiKey($this->ApiKey);
      \Conekta\Conekta::setApiVersion($this->ApiVersion);

      // Validar datos
      if (!$this->Validate()) {
          return false; // Detenemos si la validación falla
      }

      // Crear cliente
      if (!$this->CreateCustomer()) {
          return false; // Detenemos si la creación del cliente falla
      }

      // Guardar los datos en la base de datos después de la creación de la orden
      // if (!$this->Save()) {
      //     return false; // Detenemos si no se puede guardar el pago
      // }

      // Guardar los datos en la base de datos después de la creación del pago
      $paymentId = $this->Save();
      if (!$paymentId) {
          return false; // Detenemos si no se puede guardar el pago
      }

      // Crear orden (solo si el cliente fue creado correctamente) y se dispara el pago a conekta
      if (!$this->CreateOrder()) {
          $deleteRegister = PagosData::deleteRegister($paymentId); //Eliminamos el registro por que fallo la orden
          if ($deleteRegister) {
            $this->error = "Ocurrió un error al crear la orden. Intenta de nuevo";
            return false; // Detenemos si no se pudo actualizar el número de orden
        }
          // return false; // Detenemos si la creación de la orden falla
      }

      // Si la orden fue creada correctamente, actualizar el pago con el número de orden
      $orderId = $this->order->id;  // Obtener el ID de la orden creada
      $updateResult = PagosData::updateOrderNumber($paymentId, $orderId);
      if (!$updateResult) {
          $this->error = "Ocurrió un error al guardar el N. de orden.";
          // return false; // Detenemos si no se pudo actualizar el número de orden )el pago se procesa por la orden que es correcta pero no se inserto el id orden (solucion ponerlo en la bd pagos)
      }

      return true; // Si todo se procesa correctamente
  }

  public function Save()
  {
    try {
      $idProducto = PlandepagoData::getById($this->description)->concepto;

      $data = [
        "total" => $this->total,
        "description" => $idProducto,
        "name" => $this->name,
        "number_card" => substr($this->card, strlen($this->card) - 5, 4),
        "email" => $this->email,
        "idPerson" => $this->idAlumno,
        // "order_id" => $this->order->id,
        "planp" => isset($_POST['description']) ? $_POST['description'] : ""
      ];
      // convertir $data a objeto
      $data = (object) $data;
      // PagosData::insertPago($data);
      $result = PagosData::insertPago($data);

      if (!$result) {
          $this->error = "Ocurrió un error al guardar el pago. Intenta de nuevo.";
          return false;
      }

      return $result; //retorna el id obtenido de la insercion en pagos
    } catch (Exception $e) {
      $this->error = "Excepción atrapada: " . $e->getMessage();
      return false;
    }
  }

  public function CreateOrder()
  {
    try {
      // Simulación de un error intencional
      // throw new \Conekta\ProcessingError('Error simulado en la creación de la orden');


      $this->order = \Conekta\Order::create(
        array(
          "amount" => $this->total,
          "line_items" => array(
            array(
              "name" => $this->description . " " . 'Producto',
              // "unit_price" => $this->total * 100, //se multiplica por 100 conekta
              "unit_price" => intval($this->total * 100),
              "quantity" => 1
            ) //first line_item
          ), //line_items
          "currency" => "MXN",
          "customer_info" => array(
            "customer_id" => $this->customer->id
            // "customer_id" => 'invalid_customer_id' // ID inválido para forzar el error
          ), //customer_info
          "charges" => array(
            array(
              "payment_method" => array(
                "type" => "default"
              )
            ) //first charge
          ) //charges
        ) //order
      );
      /* errores por si no se hace bien la orden */
    } catch (\Conekta\ProcessingError $error) {
      $this->error = $error->getMessage();
      return false;
    } catch (\Conekta\ParameterValidationError $error) {
      $this->error = $error->getMessage();
      return false;
    } catch (\Conekta\Handler $error) {
      $this->error = $error->getMessage();
      return false;
    }

    return true;
  }
  public function CreateCustomer()
  { /* crea el cliente para conekta */
    try {
      $this->customer = \Conekta\Customer::create(
        array(
          "name" => $this->name,
          "email" => $this->email,
          //"phone" => "+52181818181",
          "payment_sources" => array(
            array(
              "type" => "card",
              "token_id" => $this->token
            )
          ) //payment_sources
        ) //customer
      );
    } catch (\Conekta\ProccessingError $error) {
      $this->error = $error->getMesage();/* atributo para ver el error */
      return false;
    } catch (\Conekta\ParameterValidationError $error) {
      $this->error = $error->getMessage();
      return false;
    } catch (\Conekta\Handler $error) {
      $this->error = $error->getMessage();
      return false;
    }

    return true;
  }

  /* validar los datos a recibir */

  public function Validate()
  {/* datos obligatorios por conekta */
    if ($this->card == "" || $this->name == "" || $this->description == "" || $this->total == "" || $this->email == "") {
      $this->error = "El número de tarjeta, el nombre, concepto, monto y correo electrónico son obligatorios";
      return false;
    }
    /* la tarjeta que no sea superior a 14 digitos */
    if (strlen($this->card) <= 14) {
      $this->error = "El número de tarjeta debe tener al menos 15 caracteres";
      return false;
    }
    /* correo tenga formato valido */
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $this->error = "El correo electrónico no tiene un formato de correo valido";
      return false;
    }
    /* el costo no sea menor a 50 pesos */
    if ($this->total <= 50) {
      $this->error = "El monto debe ser mayor a 50 pesos";
      return false;
    }

    return true;
  }
}
