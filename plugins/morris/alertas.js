  function inicio_correcto(titulo,texto){
    Swal.fire({
      icon: "success",
      title: titulo,
      showConfirmButton:false,
      text: texto,
      timer: 2500,
      timerProgressBar: true,
    });
    

  }
  function inicio_mal(titulo,texto,proceso) {
    var a= proceso 
    Swal.fire({
      icon: "error",
      title: titulo,
      showConfirmButton:false,
      text: texto,
      timer: 2500,
      timerProgressBar: true,
    });
    }