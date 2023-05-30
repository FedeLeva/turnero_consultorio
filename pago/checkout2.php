<?php 



// Paciente
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$mail = $_POST['email'];
$telefono = $_POST['telefono'];
//Fecha
$fecha = json_decode($_POST['fecha'] , true );
$dia = $fecha['dia'];
$mes = $fecha['mes'];
$año = $fecha['año'];
$nombreMes = $fecha['nombreMes'];
// Horario
$horario = json_decode($_POST['horario'] , true );
$desde = $horario['desde'];
$hasta = $horario['hasta'];
$indice_dia = $horario['indice'];
// Reserva
$encuentro = $_POST['encuentro'];
$modalidad = $_POST['modalidad'];
// Datos para crear el checkout
$precio = intval($_POST['precio']);
$descripcion = '[Especialidad] [Nombre] ' . $encuentro;
$servicio = '[Especialidad]  ' . $encuentro . "  " . $modalidad . " (Nombre)";
$horaCliente =  $nombreMes . " " . $dia . ", " . $año . " - " . $desde;















?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/vue@3"></script>
    <title>Checkout API</title>
  <style>
      p {
    margin:0;
  }
  </style>

<style>

input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active{
    -webkit-box-shadow: 0 0 0 30px #fff inset !important;
    background:white !important;
}
    #form-checkout {
      display: flex;
      flex-direction: column;
      max-width: 600px;
    }

    .container {
      height: 18px;
      display: inline-block;
      border: 1px solid rgb(118, 118, 118);
      border-radius: 2px;
      padding: 1px 2px;
    }
    .container {
    
    display: inline-block;
    border-radius: 2px;
    padding: 1px 2px;
   border:none;
    outline: 1px solid rgb(118, 118, 118);
    height:35px;
    border-radius:5px;
    box-sizing:border-box;
    padding:5px;
    padding-left:10px;
    font-size:14px;
    background-color :#fff;
  }

 

  .btn-process{
  font-size: 16px;
  font-family: 'Montserrat', sans-serif;
  background-color: #256EFF;
  border:none;
  outline:none;
  display: flex;
  align-items:center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem 3rem;
  border-radius:1rem;
  color:#fff;
  cursor:pointer;
}

    .label {
      margin:0;
    }


    .msj_error {
        color:#F23D4F;
      font-size:13px;
    }

   .height {
    height:80px;
   }
    

  .borderRed {
    outline: 1px solid #F23D4F;
  }

  .focus {
    outline: 2px solid #000;
  }
#form-checkout__submit {
  transition: 0.3s background;
}
  #form-checkout__submit:hover {
    
    cursor:pointer;
  }
  .btn-ring{
  display: none;
}

  .btn-ring:after {
  content: "";
  display: block;
  width: 15px;
  height: 15px;
  margin: 8px;
  border-radius: 50%;
  border: 3px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: ring 1.2s linear infinite;
}

hr {
  height:1px;
  background-color:#E9E8E8;
  border:none;
}

@keyframes ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


  </style>
</head>
<body>
<h1>Checkout -- Core </h1>
  <div id="formulario">

  <div style="display:flex;width:90%;margin:auto;">
  <div style="width:58%;">
<h1>Realiza tu pago</h1>
  <form id="form-checkout" action="http://localhost/web/pago/process_payment/checkout2.php" method="POST" @submit="submitHandler($event)">
    <div  class="height" id="cardNumber" >
    <p class="label">Número de tarjeta</p>
    <div id="form-checkout__cardNumber" :class="{container : true , borderRed :  errors.nroTarjeta , focus : focus.nroTarjeta}" style="width:100%;max-width:334px;height:40px;position:relative;">
    </div>
    <p  v-if="errors.nroTarjeta" class="msj_error"  >{{errors.nroTarjeta}}</p>
  </div>
  

   <div  class="height" id="securityCode">
   <div style="display:flex;margin:auto">
     <div >
      <p class="label">Vencimiento</p>
       <div style="width:100%;max-width:159px;" id="form-checkout__expirationDate" :class="{container : true , borderRed :  errors.vencimiento , focus : focus.vencimiento}">
       </div>
       <p  class="msj_error" v-if="errors.vencimiento" >{{errors.vencimiento}}</p>
    </div>
     <div style="margin-left:10px;">
      <p class="label">Código de seguridad</p>
     <div  style="width:100%;max-width:159px;"  id="form-checkout__securityCode" :class="{container : true , borderRed :  errors.codigo , focus : focus.codigo}"></div>
     <p  class="msj_error" v-if="errors.codigo" >{{errors.codigo}}</p>
       </div>
    </div>

   </div>
  
   
    <div id="cardholderName"  class="height">
    <p class="label">Nombre del titular como aparece en la tarjeta</p>
    <input  style="max-width:334px;width:100%;" type="text" id="form-checkout__cardholderName" v-model="titularTarjeta" :class="{container : true , borderRed :  errors.titularTarjeta , focus : focus.titularTarjeta}" autocomplete="off" placeholder="Titular de la tarjeta" @focus="enfocar('titularTarjeta')" @blur="desenfocar('titularTarjeta')" />
    <p  v-if="errors.titularTarjeta" class="msj_error" >Ingrese el nombre del titular</p>
    </div>
    <div  class="height">
    <p class="label">Banco Emisor</p>
   
<select id="form-checkout__issuer" name="issuer" style="width:100%;max-width:280px;"  :class="{container : true , focus : focus.emisor}" @focus="enfocar('emisor')" @blur="desenfocar('emisor')" >
      <option style="margin-top:10px;" value="" disabled selected>Banco emisor</option>
    </select>



    </div>
 
    <div class="height" >
    <p class="label">Cuotas</p>
    <select style="width:280px;" :class="{container:true , focus : focus.cuotas}" id="form-checkout__installments" name="installments" @focus="enfocar('cuotas')" @blur="desenfocar('cuotas')">
      <option  value="" disabled selected>Cuotas</option>
    </select>
    </div>
   
    <div  id="identificationNumber" class="height" >
    <p class="label" style="margin-right:5px;">Documento del titular</p>
    <div style="display:flex;">
    <select id="form-checkout__identificationType" name="identificationType" :class="{container : true , borderRed :  errors.documento , focus: focus.tipoDocumento}" style="margin-right:5px;" @focus="enfocar('tipoDocumento')" @blur="desenfocar('tipoDocumento')">
      <option value="" disabled selected>Tipo de documento</option>
    </select>


    <input autocomplete="off" type="text" id="form-checkout__identificationNumber" name="identificationNumber" placeholder="Numero de documento" :class="{container : true , borderRed :  errors.documento , focus : focus.documento}"  v-model="documento"  @focus="enfocar('documento')" @blur="desenfocar('documento')"/>
    </div>
    <p  v-if="errors.documento" class="msj_error">{{errors.documento}}</p>
    </div>
 
    <div id="email" class="height">
    <p class="label">E-mail</p>
    <input type="email" id="form-checkout__email" name="email" placeholder="E-mail" v-model="email"  :class="{container : true , borderRed :  errors.email , focus : focus.email}" style="max-width:334px;width:100%;" @focus="enfocar('email')" @blur="desenfocar('email')"/>

    <p  v-if="errors.email" class="msj_error">{{errors.email}}</p>
    </div>
    <input id="token" name="token" type="hidden">
    <input id="paymentMethodId" name="paymentMethodId" type="hidden">
    <input id="transactionAmount" name="transactionAmount" type="hidden" value=<?php echo $precio?>>
    <input id="description" name="description" type="hidden" value="value=<?php echo $servicio?>">
<input type="hidden" name="nombre" value="<?php echo $nombre  ?>">
<input type="hidden" name="apellido" value="<?php echo $apellido  ?>">
<input type="hidden" name="mail" value="<?php echo $mail  ?>">
<input type="hidden" name="telefono" value="<?php echo $telefono  ?>">
 <input type="hidden" name="fecha" value='<?php echo $_POST['fecha']  ?>'>
 <input type="hidden" name="horario" value='<?php echo $_POST['horario']  ?>'>
 <input type="hidden" name="encuentro" value='<?php echo  $encuentro ?>'>
 <input type="hidden" name="modalidad" value='<?php echo  $modalidad ?>'>
 <input type="hidden" name="precio" value='<?php   echo number_format(
   $precio , 2 , '.' , '.') ?>'>
    <button    type="submit" id="form-checkout__submit" class="container btn-process" style="max-width:300px;width:100%;"> <span>Pagar</span>   <span class="btn-ring"></span></button>
  </form>
  
  </div>
  <div style="width:42%;">
  <div style="min-height:200px;;margin:auto;border-radius:3px;padding:20px;border:1px solid #E9E8E8;">
  <p style="text-align:left;margin-left:10px;font-size:1.2em;">Detalle de tu compra</p>
  <div style="display:flex;flex-wrap:wrap;">
       <div style="width:80%;">    <h2 >Producto</h2></div>
       <div> <h2>Precio</h2></div>
       <div style="width:80%;"><p style="text-transform:uppercase;font-size:14px;"><?php echo $descripcion?> X1</p></div><p>$ <?php echo number_format(
   $precio , 0 , '.' , '.') ?></p><div></div>
       </div>
       <hr>
       <p style="padding-top:10px;">Información sobre la reserva:</p>
       <p>Hora del cliente: <?php echo $horaCliente ?> </p>
       <p>Servicio: <?php echo $servicio?> </p>
       <?php 
        if ($modalidad == 'Presencial') {
          echo '       <p>Dirección: Calle 2568 </p>';
        }
       ?>
       <hr>
       <div style="display:flex;flex-wrap:wrap;">
       <div style="width:70%;">    <h2 >Total</h2></div>
       <div> <h2>$ <?php echo number_format(
   $precio , 0 , '.' , '.');?></h2></div>
    
     
       </div>
       <hr>
       <p>
        Tus datos personales se utilizarán para procesar tu pedido y mejorar tu experiencia en esta web.
       </p>
      </div>
  </div>
  </div>
  </div>
  </div>


  
  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script src="./core.js"></script>
     <script>
      



 

        </script>
        <script>
          const Formulario = {
            mounted() {
         

                 const {cardNumberElement , expirationDateElement , securityCodeElement}  = inicializar();
 
                 cardNumberElement.on("focus", (e) => {
                this.enfocar('nroTarjeta');
                  });

                cardNumberElement.on("blur", (e) => {
               this.desenfocar('nroTarjeta');
    
                    });
                    expirationDateElement.on("focus", (e) => {
                this.enfocar('vencimiento');
                  });

                  expirationDateElement.on("blur", (e) => {
               this.desenfocar('vencimiento');
    
                    });

                    securityCodeElement.on("focus", (e) => {
                this.enfocar('codigo');
                  });

                  securityCodeElement.on("blur", (e) => {
               this.desenfocar('codigo');
    
                    });

            } , 
            data() {
              return {
                titularTarjeta : '' ,
                documento : '' , 
                email : '' , 
                errors : {} ,
                focus : {}
              }
            
            } , 
            methods: {
              enfocar(name) {
                this.focus[name] = true;
                  this.errors[name] = null;
              } , 
              desenfocar(name) {
                this.focus[name] = false;
              } , 
              async submitHandler(e) {

                const validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
                const formElement = document.getElementById('form-checkout');
               console.log(formElement)
                this.errors = {};
               const error = await createCardToken(e);
                   if (error) {
                    console.log(error);
                    error.forEach(e => {

                    
                switch(e.field) {
                    case 'cardNumber' : 
                   
                      this.errors.nroTarjeta = "Ingrese bien su numero de tarjeta";
                      break; 
                  case "expirationDate" :
                    this.errors.vencimiento = "Vencimiento invalido";
                    break; 
                  case "expirationMonth" : 
                    this.errors.vencimiento = "Vencimiento invalido";
                    break; 
                  case "expirationYear" :
                    this.errors.vencimiento = "Vencimiento invalido";
                    break; 
                  case 'securityCode' :
                    this.errors.codigo = "Código de seguridad invalido";
                    break; 
                   
               }
               })
                    }
               if (!this.titularTarjeta) {
                  this.errors.titularTarjeta = "Ingrese el titular de la tarjeta"
                  
               } 
               if (!this.documento ) {
                this.errors.documento = "Ingrese el  documento del titular"
               }   

               
               if (!this.email  || !validEmail.test(this.email)) {
                this.errors.email = "Ingrese un email valido"
               }
           
              
               if (error  ||  this.errors.titularTarjeta || this.errors.documento || this.errors.email) {
                return;
               }
           
               formElement.submit();
              
              }
            }


          }
          const App = Vue.createApp(Formulario);
          App.mount("#formulario");
        </script>
   
</body>
</html>