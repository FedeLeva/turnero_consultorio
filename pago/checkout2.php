<?php 
// Paciente
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];
$phone = $_POST['phone'];
//Fecha
$date = json_decode($_POST['date'] , true );
$day = $date['day'];
$month = $date['month'];
$year = $date['year'];
$nameMonth = $date['nameMonth'];
// Horario
$schedule = json_decode($_POST['schedule'] , true );
$from = $schedule['from'];
$to = $schedule['to'];
$indexDay = $schedule['indexDay'];
// Reserva
$meeting = $_POST['meeting'];
$modality = $_POST['modality'];
// Datos para crear el checkout
$price = intval($_POST['price']);
$description = '[Especialidad] [Nombre] ' . $meeting;
$service = '[Especialidad]  ' . $meeting . "  " . $modality . " (Nombre)";
$customerTime =  $nameMonth . " " . $day . ", " . $year . " - " . $from;















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

    /* Globals */
      p {
    margin:0;
  }


input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active{
    -webkit-box-shadow: 0 0 0 30px #fff inset !important;
    background:white !important;
}
hr {
  height:1px;
  background-color:#E9E8E8;
  border:none;
}
/* form-checkout */
    #formCheckout {
      display: flex;
      flex-direction: column;
      max-width: 600px;
    }

    .formCheckout__input {
      display: inline-block;
   border:none;
    outline: 1px solid rgb(118, 118, 118);
    height:40px;
    border-radius:5px;
    box-sizing:border-box;
    padding:5px;
    padding-left:10px;
    font-size:14px;
    background-color :#fff;
    }



  .formCheckout__payButton{
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



    .formCheckout__label {
      margin:0;
    }

  
    
    .formCheckout__errorMessage {
        color:#F23D4F;
      font-size:13px;
    }



   .formCheckout__inputContainer {
    min-height:80px;
    margin-top:5px;
   }
    

  
  .formCheckout__input--borderRed {
    outline: 1px solid #F23D4F;
  }

 
  .formCheckout__input--focus {
    outline: 2px solid #000;
  }
#formCheckout__submit {
  transition: 0.3s background;
}
  #formCheckout__submit:hover {
    
    cursor:pointer;
  }




  .formCheckout__ring{
  display: none;
}

  .formCheckout__ring:after {
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

.formCheckout__safetyInformationContainer {
  display:flex;margin:auto;
}

.formCheckout__documentHolderContainer {
  display:flex;
}

.formCheckout__inputContainer--ml10 {
  margin-left:10px;
}

.formCheckout__input--wm159 {
  width:100%;max-width:159px;
}

.formCheckout__input--wm334 {
  width:100%;max-width:334px;
}
.formCheckout__input--wm280 {
  width:100%;max-width:280px;
}
.formCheckout__input--wm300 {

  max-width:300px;width:100%;
}
/* informationContainer */
.informationContainer {
  width:42%;
  margin-top:20px;
  margin-bottom:20px;
}

.informationContainer__text {
  text-transform:uppercase;font-size:14px;
}

.informationContainer__text--service {
  font-size:16px;
}

.informationContainer--border {
  min-height:200px;;margin:auto;border-radius:3px;padding:20px;border:1px solid #E9E8E8;
}

.informationContainer__title {
  text-align:left;margin-left:10px;font-size:1.2em
}

/* CheckoutContainer */
.CheckoutContainer {
  display:flex;width:90%;margin:auto;
}

.CheckoutContainer__formContainer {
  width:58%;
}




/* Responsive */
@media(max-width:700px){
  .CheckoutContainer {
    flex-direction:column;
  }
  .CheckoutContainer__formContainer {
  width:100%;
}
.informationContainer {
  width:100%;
}

}


@media (max-width:340px) {
  .formCheckout__safetyInformationContainer {
    flex-direction:column;
  }


  .formCheckout__inputContainer--ml10 {
  margin-left:0;
}
}

@media(max-width:322px) {
  .formCheckout__documentHolderContainer  {
    flex-wrap:wrap;
  }

  #formCheckout__identificationNumber {
    margin-top:5px;
    width:100%;
  }
}

@media(max-width:200px) {
  h1,h2,h3,h4 {
    font-size:15px;
  }

  .informationContainer__text {
  text-transform:none;
}

.informationContainer--border {
  padding:0;
}
}

@media (max-width:128px) {
   .formCheckout__payButton {
    padding:0;
   }

   .informationContainer__text--service {
  font-size:14px;
}
}

/* Animations */
@keyframes ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Modifiers */

.mt-10 {
  margin-top:10px;
}

.mr-5 {
  margin-right:5px;
}

.w80 {
  width:80%;
}
.w70 {
  width:70%;
}
.pt-10 {
  padding-top:10px;
}

.flexWrap {
  display:flex;flex-wrap:wrap;
}


  </style>
</head>
<body>
<h1>Checkout -- Core </h1>
  <div id="formulario">

  <div class="CheckoutContainer" >
  <div class="CheckoutContainer__formContainer" >
<h1>Realiza tu pago</h1>
  <form id="formCheckout" action="http://localhost/web/pago/process_payment/checkout2.php" method="POST" @submit="submitHandler($event)">
    <div  class="formCheckout__inputContainer" id="cardNumber" >
    <p class="formCheckout__label">Número de tarjeta</p>
    <div id="formCheckout__cardNumber" :class="{'formCheckout__input' : true , 'formCheckout__input--wm334' : true , 'formCheckout__input--borderRed' :  errors.cardNumber , 'formCheckout__input--focus' : elementFocused.cardNumber}" >
    </div>
    <p  v-if="errors.cardNumber" class="formCheckout__errorMessage"  >{{errors.cardNumber}}</p>
  </div>
  

   <div  class="formCheckout__inputContainer" id="securityCode">
   <div class="formCheckout__safetyInformationContainer">
     <div class="formCheckout__inputContainer" >
      <p class="formCheckout__label">Vencimiento</p>
       <div  id="formCheckout__expirationDate" :class="{'formCheckout__input' : true , 'formCheckout__input--wm159' : true ,'formCheckout__input--borderRed' :  errors.expiration , 'formCheckout__input--focus' : elementFocused.expiration}">
       </div>
       <p  class="formCheckout__errorMessage" v-if="errors.expiration" >{{errors.expiration}}</p>
    </div>
     <div class="formCheckout__inputContainer--ml10 formCheckout__inputContainer">
      <p class="formCheckout__label">Código de seguridad</p>
     <div    id="formCheckout__securityCode" :class="{'formCheckout__input' : true , 'formCheckout__input--wm159' : true, 'formCheckout__input--borderRed' :  errors.code , 'formCheckout__input--focus' : elementFocused.code}"></div>
     <p  class="formCheckout__errorMessage" v-if="errors.code" >{{errors.code}}</p>
       </div>
    </div>

   </div>
  
   
    <div id="cardholderName"  class="formCheckout__inputContainer">
    <p class="formCheckout__label">Nombre del titular como aparece en la tarjeta</p>
    <input   type="text" id="formCheckout__cardholderName" v-model="cardHolder" :class="{'formCheckout__input' : true , 'formCheckout__input--wm334' : true ,'formCheckout__input--borderRed' :  errors.cardHolder , 'formCheckout__input--focus' : elementFocused.cardHolder}" autocomplete="off" placeholder="Titular de la tarjeta" @focus="focus('cardHolder')" @blur="blur('cardHolder')" />
    <p  v-if="errors.cardHolder" class="formCheckout__errorMessage" >Ingrese el nombre del titular</p>
    </div>
    <div  class="formCheckout__inputContainer">
    <p class="formCheckout__label">Banco Emisor</p>
   
<select id="formCheckout__issuer" name="issuer"   :class="{'formCheckout__input' : true , 'formCheckout__input--wm280' : true , 'formCheckout__input--focus' : elementFocused.emisor}" @focus="focus('emisor')" @blur="blur('emisor')" >
      <option class="mt-10" value="" disabled selected>Banco emisor</option>
    </select>



    </div>
 
    <div class="formCheckout__inputContainer" >
    <p class="formCheckout__label">Cuotas</p>
    <select  :class="{'formCheckout__input':true , 'formCheckout__input--wm280' : true , 'formCheckout__input--focus' : elementFocused.cuotas}" id="formCheckout__installments" name="installments" @focus="focus('cuotas')" @blur="blur('cuotas')">
      <option  value="" disabled selected>Cuotas</option>
    </select>
    </div>
   
    <div  id="identificationNumber" class="formCheckout__inputContainer" >
    <p class="formCheckout__label mr-5" >Documento del titular</p>
    <div class="formCheckout__documentHolderContainer">
      
      <select id="formCheckout__identificationType" name="identificationType" :class="{'formCheckout__input' : true , 'formCheckout__input--borderRed' :  errors.document , 'formCheckout__input--focus': elementFocused.tipoDocumento , 'mr-5' : true }"  @focus="focus('tipoDocumento')" @blur="blur('tipoDocumento')">
      <option value="" disabled selected>Tipo de documento</option>
    </select>
      
   
   <input autocomplete="off" type="text" 
    id="formCheckout__identificationNumber" name="identificationNumber" placeholder="Numero de documento" :class="{'formCheckout__input' : true , 'formCheckout__input--borderRed' :  errors.document , 'formCheckout__input--focus' : elementFocused.document  }"  v-model="document"  @focus="focus('document')" @blur="blur('document')"/>
   



    </div>
    <p  v-if="errors.document" class="formCheckout__errorMessage">{{errors.document}}</p>
    </div>
 
    <div id="email" class="formCheckout__inputContainer">
    <p class="formCheckout__label">E-mail</p>
    <input type="email" id="formCheckout__email" name="email" placeholder="E-mail" v-model="email"  :class="{'formCheckout__input' : true , 'formCheckout__input--wm334' : true,'formCheckout__input--borderRed' :  errors.email , 'formCheckout__input--focus' : elementFocused.email }"  @focus="focus('email')" @blur="blur('email')"/>

    <p  v-if="errors.email" class="formCheckout__errorMessage">{{errors.email}}</p>
    </div>
    <input id="token" name="token" type="hidden">
    <input id="paymentMethodId" name="paymentMethodId" type="hidden">
    <input id="transactionAmount" name="transactionAmount" type="hidden" value=<?php echo $price?>>
    <input id="description" name="description" type="hidden" value="value=<?php echo $service?>">
<input type="hidden" name="name" value="<?php echo $name  ?>">
<input type="hidden" name="surname" value="<?php echo $surname  ?>">
<input type="hidden" name="mail" value="<?php echo $mail  ?>">
<input type="hidden" name="phone" value="<?php echo $phone  ?>">
 <input type="hidden" name="date" value='<?php echo $_POST['date']  ?>'>
 <input type="hidden" name="schedule" value='<?php echo $_POST['schedule']  ?>'>
 <input type="hidden" name="meeting" value='<?php echo  $meeting ?>'>
 <input type="hidden" name="modality" value='<?php echo  $modality ?>'>
 <input type="hidden" name="price" value='<?php   echo number_format(
   $price , 2 , '.' , '.') ?>'>
    <button    type="submit" id="formCheckout__submit" class="formCheckout__input formCheckout__payButton formCheckout__input--wm300" > <span>Pagar</span>   <span class="formCheckout__ring"></span></button>
  </form>
  
  </div>
  <div class="informationContainer" >
  <div class="informationContainer--border" >
  <p class="informationContainer__title">Detalle de tu compra</p>
  <div class="flexWrap">
       <div class="w80">    <h2 >Producto</h2></div>
       <div> <h2>Precio</h2></div>
       <div class="w80"><p class="informationContainer__text" ><?php echo $description?> X1</p></div><p>$ <?php echo number_format(
   $price , 0 , '.' , '.') ?></p><div></div>
       </div>
       <hr>
       <p class="pt-10">Información sobre la reserva:</p>
       <p>Hora del cliente: <?php echo $customerTime ?> </p>
       <p class="informationContainer__text--service">Servicio: <?php echo $service?> </p>
       <?php 
        if ($modality == 'Presencial') {
          echo '       <p>Dirección: Calle 2568 </p>';
        }
       ?>
       <hr>
       <div class="flexWrap">
       <div class="w70">    <h2 >Total</h2></div>
       <div> <h2>$ <?php echo number_format(
   $price , 0 , '.' , '.');?></h2></div>
    
     
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
          const form = {
            mounted() {
         

                 const {cardNumberElement , expirationDateElement , securityCodeElement}  = initialize();
 
                 cardNumberElement.on("focus", (e) => {
                this.focus('cardNumber');
                  });

                cardNumberElement.on("blur", (e) => {
               this.blur('cardNumber');
    
                    });
                    expirationDateElement.on("focus", (e) => {
                this.focus('expiration');
                  });

                  expirationDateElement.on("blur", (e) => {
               this.blur('expiration');
    
                    });

                    securityCodeElement.on("focus", (e) => {
                this.focus('code');
                  });

                  securityCodeElement.on("blur", (e) => {
               this.blur('code');
    
                    });

            } , 
            data() {
              return {
                cardHolder : '' ,
                document : '' , 
                email : '' , 
                errors : {} ,
                elementFocused : {}
              }
            
            } , 
            methods: {
              focus(name) {
                this.elementFocused[name] = true;
                  this.errors[name] = null;
              } , 
              blur(name) {
                this.elementFocused[name] = false;
              } , 
              async submitHandler(e) {

                const validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
                const formElement = document.getElementById('formCheckout');
             
                this.errors = {};
               const error = await createCardToken(e);
                   if (error) {
                   
                    error.forEach(e => {

                    
                switch(e.field) {
                    case 'cardNumber' : 
                   
                      this.errors.cardNumber = "Ingrese bien su numero de tarjeta";
                      break; 
                  case "expirationDate" :
                    this.errors.expiration = "Vencimiento invalido";
                    break; 
                  case "expirationMonth" : 
                    this.errors.expiration = "Vencimiento invalido";
                    break; 
                  case "expirationYear" :
                    this.errors.expiration = "Vencimiento invalido";
                    break; 
                  case 'securityCode' :
                    this.errors.code = "Código de seguridad invalido";
                    break; 
                   
               }
               })
                    }
               if (!this.cardHolder) {
                  this.errors.cardHolder = "Ingrese el titular de la tarjeta"
                  
               } 
               if (!this.document ) {
                this.errors.document = "Ingrese el  documento del titular"
               }   

               
               if (!this.email  || !validEmail.test(this.email)) {
                this.errors.email = "Ingrese un email valido"
               }
           
              
               if (error  ||  this.errors.cardHolder || this.errors.document || this.errors.email) {
                return;
               }
           
               formElement.submit();
              
              }
            }


          }
          const App = Vue.createApp(form);
          App.mount("#formulario");
        </script>
</body>
</html>