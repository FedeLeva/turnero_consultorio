<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout API</title>

   
</head>
<style>
  /* Change the white to any color */
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active{
    -webkit-box-shadow: 0 0 0 30px #fff inset !important;
    background:white !important;
}
  p {
    margin:0;
  }
    #form-checkout {
      display: flex;
      flex-direction: column;
      max-width: 600px;
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
<body >
<h1>Checkout -- Cardform </h1>
<p>Personalizacion : Media</p>
<p>Orden de validación raro</p>
<div style="display:flex;width:80%;margin:auto;">

<div style="width:60%;">
<h1>Realiza tu pago</h1>
  <form id="form-checkout">
  <div  class="height" id="cardNumber" >
    <p class="label">Número de tarjeta</p>
    <div id="form-checkout__cardNumber" class="container MyClass" style="width:100%;max-width:334px;height:40px;position:relative;">
    </div>
    <p   class="msj_error" style="display:none;" >Ingrese bien su número de tarjeta</p>
  </div>
  

   <div  class="height" id="securityCode">
   <div style="display:flex;margin:auto">
     <div >
      <p class="label">Vencimiento</p>
       <div style="width:100%;max-width:159px;" id="form-checkout__expirationDate" class="container">
       </div>
       <p  class="msj_error" style="display:none;" >Vencimiento invalido</p>
    </div>
     <div style="margin-left:10px;">
      <p class="label">Código de seguridad</p>
     <div  style="width:100%;max-width:159px;"  id="form-checkout__securityCode" class="container"></div>
     <p  class="msj_error" style="display:none;" >Código de seguridad invalido</p>
       </div>
    </div>

   </div>
  
   
    <div id="cardholderName"  class="height">
    <p class="label">Nombre del titular como aparece en la tarjeta</p>
    <input  style="max-width:334px;width:100%;" type="text" id="form-checkout__cardholderName" class="container" autocomplete="off" />
    <p  style="display:none;" class="msj_error" >Ingrese el nombre del titular</p>
    </div>
    <div  class="height">
    <p class="label">Banco Emisor</p>
    <select style="width:100%;max-width:280px;" id="form-checkout__issuer" class="container"></select>
    </div>
 
    <div class="height" >
    <p class="label">Cuotas</p>
    <select style="width:280px;" id="form-checkout__installments" class="container"></select>
    </div>
   
    <div  id="identificationNumber" class="height" >
    <p class="label" style="margin-right:5px;">Documento del titular</p>
    <div style="display:flex;">
    <select id="form-checkout__identificationType" class="container" style="margin-right:5px;" ></select>
    <input type="text"  autocomplete="off" id="form-checkout__identificationNumber" class="container" />

    </div>
    <p  style="display:none;" class="msj_error">Ingrese el documento del titular</p>
    </div>
 
    <div id="email" class="height">
    <p class="label">E-mail</p>
    <input  style="max-width:334px;width:100%;" type="email" id="form-checkout__cardholderEmail"   class="container" />
    <p  style="display:none;" class="msj_error">Ingrese un email valido</p>
    </div>
  
    <button   type="submit" id="form-checkout__submit" class="container btn-process" style="max-width:300px;width:100%;"> <span>Pagar</span>   <span class="btn-ring"></span></button>
   
  </form>
  </div>
  <div style="width:40%;">
     <div style="min-height:200px;;margin:auto;border-radius:3px;padding:20px;border:1px solid #E9E8E8;">
      <p style="text-align:left;margin-left:10px;font-size:1.2em;">Detalle de tu compra</p>
       <div>
       
    
       <div style="display:flex;flex-wrap:wrap;">
       <div style="width:80%;">    <h2 >Producto</h2></div>
       <div> <h2>Precio</h2></div>
       <div style="width:80%;"><p style="text-transform:uppercase;font-size:16px;">Consulta Médica Presencial X1</p></div><p>$10.000</p><div></div>
       </div>
       <hr>
       <p style="padding-top:10px;">Información sobre la reserva:</p>
       <p>Hora del cliente: Mayo 9, 2023 - 14:30 Pm </p>
       <p>Servicio: Consulta Medica Online </p>
       <hr>
       <div style="display:flex;flex-wrap:wrap;">
       <div style="width:70%;">    <h2 >Total</h2></div>
       <div> <h2>$10.000</h2></div>
    
     
       </div>
       <hr>
       <p>
        Tus datos personales se utilizarán para procesar tu pedido y mejorar tu experiencia en esta web.
       </p>
      </div>


    </div>
  
</div>
  </div>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
     <script>
            const mp = new MercadoPago('TEST-ee10fc35-6c13-4ede-bf9d-3575251ec436', {
            locale: 'es-AR'
        });



        
    const cardForm = mp.cardForm({
      amount: "10000",
      iframe: true,
      form: {
        id: "form-checkout",
        cardNumber: {
          id: "form-checkout__cardNumber",
          placeholder: "1234 1234 1234 1234",
        },
        expirationDate: {
          id: "form-checkout__expirationDate",
          placeholder: "MM/AA",
        },
        securityCode: {
          id: "form-checkout__securityCode",
          placeholder: "123",
        },
        cardholderName: {
          id: "form-checkout__cardholderName",
          placeholder: "Titular de la tarjeta",
        },
        issuer: {
          id: "form-checkout__issuer",
          placeholder: "Banco emisor",
        },
        installments: {
          id: "form-checkout__installments",
          placeholder: "Cuotas",
        },        
        identificationType: {
          id: "form-checkout__identificationType",
          placeholder: "Tipo de documento",
        },
        identificationNumber: {
          id: "form-checkout__identificationNumber",
          placeholder: "Número del documento",
        },
        cardholderEmail: {
          id: "form-checkout__cardholderEmail",
          placeholder: "E-mail",
        },
      },
      callbacks: {
        onFormMounted: error => {
          if (error) return console.warn("Form Mounted handling error: ", error);
         
        },
        onSubmit: event => {
          document.querySelector("#form-checkout__submit > span:nth-child(1)").textContent = "Validando los datos"
         document.querySelector("#form-checkout__submit > span.btn-ring").style = "display:block;"
         document.querySelector("#form-checkout__submit").setAttribute('disabled' , true)
          event.preventDefault();
          document.querySelector("#email > p.msj_error").style = "display:none";
          document.querySelector("#form-checkout__cardholderEmail").classList.remove('borderRed');
          const validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
           let valueEmail =  document.querySelector("#form-checkout__cardholderEmail").value
          if (!validEmail.test(valueEmail)) {
             document.querySelector("#email > p.msj_error").style = "display:block";
             document.querySelector("#form-checkout__cardholderEmail").classList.add('borderRed');
             document.querySelector("#form-checkout__submit > span.btn-ring").style = "display:none;"
          document.querySelector("#form-checkout__submit > span:nth-child(1)").textContent = "Pagar"
          document.querySelector("#form-checkout__submit").removeAttribute('disabled' , true)
            return;
          }
       
     
          const {
            paymentMethodId: payment_method_id,
            issuerId: issuer_id,
            cardholderEmail: email,
            amount,
            token,
            installments,
            identificationNumber,
            identificationType,
          } = cardForm.getCardFormData();

          fetch("http://localhost/web/pago/process_payment/checkout.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              token,
              issuer_id,
              payment_method_id,
              transaction_amount: Number(amount),
              installments: Number(installments),
              description: "Descripción del producto",
              payer: {
                email,
                identification: {
                  type: identificationType,
                  number: identificationNumber,
                },
              },
            }),
          })
          .then(response => response.json())
          .then( data => {
            if (data.status == 'approved' || 'in_process') {
               window.location.href = './Pagoexitoso.html';
            } else {
              console.log(data)
            }
           
          
          })

        },
        onFetching: (resource) => {
            console.log(resource);
          
         

         
        } ,
        onError : (error , evento) => {
          console.log(error , evento);
        } ,
        onValidityChange : (error , evento) => {
          console.log(error , evento);
        } ,
        onCardTokenReceived : (error , data) => {
          document.querySelector("#form-checkout__submit > span:nth-child(1)").textContent = "Validando los datos"
         document.querySelector("#form-checkout__submit > span.btn-ring").style = "display:block;"
         document.querySelector("#form-checkout__submit").setAttribute('disabled' , true)



          document.querySelector("#form-checkout__cardholderEmail").classList.remove('borderRed');
          document.querySelector("#form-checkout__identificationNumber").classList.remove('borderRed');
                document.querySelector("#form-checkout__identificationType").classList.remove('borderRed')
          document.querySelector("#form-checkout__cardNumber").classList.remove('borderRed');
          document.querySelector("#form-checkout__expirationDate").classList.remove('borderRed');
          document.querySelector("#form-checkout__cardholderName").classList.remove('borderRed');
          document.querySelector("#form-checkout__securityCode").classList.remove('borderRed');
          document.querySelector("#cardNumber > p:nth-child(3)").style = "display:none;"
          document.querySelector("#cardholderName > p:nth-child(3)").style = "display:none";

          document.querySelector("#identificationNumber > p:nth-child(3)").style = "display:none"
          document.querySelector("#email > p.msj_error").style = "display:none";
          document.querySelector("#securityCode > div > div:nth-child(2) > p.msj_error").style="display:none";
          document.querySelector("#securityCode > div > div:nth-child(1) > p.msj_error").style="display:none"
          const validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
           let valueEmail =  document.querySelector("#form-checkout__cardholderEmail").value
          if (!validEmail.test(valueEmail)) {
             document.querySelector("#email > p.msj_error").style = "display:block";
             document.querySelector("#form-checkout__cardholderEmail").classList.add('borderRed');
          }


          if (error) {
            error.forEach( (e) => {
           switch (e.field) {
             case 'cardNumber' :
               document.querySelector("#cardNumber > p:nth-child(3)").style = "display:block;"
               document.querySelector("#form-checkout__cardNumber").classList.add('borderRed');
                 break;
             case 'securityCode':
              document.querySelector("#form-checkout__securityCode").classList.add('borderRed')
              document.querySelector("#securityCode > div > div:nth-child(2) > p.msj_error").style="display:block";
                      break;
             case 'expirationDate' , 'expirationMonth' , 'expirationYear' :
              
              document.querySelector("#form-checkout__expirationDate").classList.add('borderRed')
                document.querySelector("#securityCode > div > div:nth-child(1) > p.msj_error").style="display:block"
                      break;
             
             }

            switch(e.message) {
                case 'parameter cardholderName can not be null/empty' :
                   document.querySelector("#cardholderName > p:nth-child(3)").style = "display:block";
                   document.querySelector("#form-checkout__cardholderName").classList.add('borderRed');
                    break;
                case 'parameter identificationNumber can not be null/empty':
                document.querySelector("#identificationNumber > p:nth-child(3)").style = "display:block"
                document.querySelector("#form-checkout__identificationNumber").classList.add('borderRed');
                document.querySelector("#form-checkout__identificationType").classList.add('borderRed')
                    break;
             }
            })

          }
         
          
          document.querySelector("#form-checkout__submit > span.btn-ring").style = "display:none;"
          document.querySelector("#form-checkout__submit > span:nth-child(1)").textContent = "Pagar"
          document.querySelector("#form-checkout__submit").removeAttribute('disabled' , true)
         console.log(data);
        }
      },
    });


 
     </script>
</body>
</html>