
<?php
$status = json_decode($_POST['error'] , true );
$error = $status['status'];
$razon = $status['status_detail'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Roboto:wght@500&display=swap"
      rel="stylesheet"
    />
    <title>Document</title>
    <style>

        .text {
            text-align:center;color:#fff;font-size:20px;margin:0;padding-bottom:2px;min-height:20px;margin-bottom:10px;
            font-family: "Roboto", sans-serif;
        }
        .container {
    
    display: inline-block;
    border-radius: 2px;
    padding: 1px 2px;
   border:none;
    outline: 1px solid rgb(118, 118, 118);
    min-height:35px;
    border-radius:5px;
    box-sizing:border-box;
    padding:5px;
    padding-left:10px;
    font-size:14px;
    background-color :#fff;
    font-family: "Roboto", sans-serif;
    margin:auto;
    margin-top:20px;
  }
        .btn-process{
  font-size: 20px;
  background-color: #256EFF;
  border:none;
  outline:none;
 
  padding: 10px 10px;
  border-radius:5px;
  color:#fff;
  cursor:pointer;
  font-family: "Roboto", sans-serif;
}
    </style>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="banner">
        <img src="../banner.jpg" alt="" />
      </div>
    <div style="width:100%;background:#E90064;margin:auto;padding-bottom:50px;">
    <h1 style="text-align:center;color:#fff;padding-top:20px;font-size:2rem;">Algo salió mal… </h1>
    <h2 style="text-align:center;color:#fff;padding-top:20px;padding-bottom:20px;font-size:1.2rem;"> <?php 
        switch( $error) {
          case 'rejected' :
              switch($razon) {
                case 'cc_rejected_other_reason' :
                  echo 'Tu tarjeta rechazó el pago';
                  break;
                case 'cc_rejected_call_for_authorize':
                  echo 'Tu tarjeta no autorizó el pago';
                  break;
                case 'cc_rejected_insufficient_amount':
                    echo 'Tu tarjeta no tiene  saldo suficiente';
                    break;
                case 'cc_rejected_bad_filled_security_code':
                  echo "Algún dato de la tarjeta es inválido";
                    break;
                    case 'cc_rejected_bad_filled_date' :
                      echo "Algún dato de la tarjeta es inválido";
                    break;
                    case 'cc_rejected_bad_filled_other' :
                      echo "Algún dato de la tarjeta es inválido";
                    break;    
                    case 'cc_rejected_bad_filled_card_number' :
                      echo "Algún dato de la tarjeta es inválido";
                    break;
                    default:
                    echo 'No pudimos procesar tu pago';
                      break;
              }
           break;
           default:
           echo 'No pudimos procesar tu pago';
             break;
        }
    ?></h2>

 <div style="background:rgba(255 , 255 , 255 , 0.94);width:50%;margin:auto;border-radius:10px;padding-top:20px;padding-bottom:20px;">
  <p class="text" style="color:#000;">¿Qué puedo hacer?</p>
  <ul style="color:#000;display:block;text-align:center;list-style:disc inside;">


   <?php 
    switch( $error) {
      case 'rejected' :
        switch($razon) {
          case 'cc_rejected_other_reason' :
            echo '   <li class="text" style="font-size:18px;color:#000;">Usar otra tarjeta.</li>   <li class="text" style="font-size:18px;color:#000;">Hablar con su banco , seguramente  usted tiene alguna limitación o necesita autorizar este pago.</li>' ;
            break;
            case 'cc_rejected_call_for_authorize':
              echo '   <li class="text" style="font-size:18px;color:#000;">Usar otra tarjeta.</li>   <li class="text" style="font-size:18px;color:#000;">Hablar con su banco , seguramente  usted tiene alguna limitación o necesita autorizar este pago.</li>';
              break;
              case 'cc_rejected_insufficient_amount':
               echo ' <li class="text" style="font-size:18px;color:#000;">Usar otra tarjeta.</li> ' ;
                break;
              case 'cc_rejected_bad_filled_security_code':
                  echo '  <li class="text" style="font-size:18px;color:#000;">Revisar los datos al completar el formulario de pago.</li> ';
                    break;
            case 'cc_rejected_bad_filled_date' :
              echo '  <li class="text" style="font-size:18px;color:#000;">Revisar los datos al completar el formulario de pago.</li> ';
              break;
              case 'cc_rejected_bad_filled_other' :
                echo '  <li class="text" style="font-size:18px;color:#000;">Revisar los datos al completar el formulario de pago.</li> ';
                break; 
                 case 'cc_rejected_bad_filled_card_number' :
                echo '  <li class="text" style="font-size:18px;color:#000;">Revisar los datos al completar el formulario de pago.</li> ';
                break;
                default:
                echo '   <li class="text" style="font-size:18px;color:#000;">Usar otra tarjeta.</li>   <li class="text" style="font-size:18px;color:#000;">Hablar con su banco , seguramente  usted tiene alguna limitación o necesita autorizar este pago.</li> <li class="text" style="font-size:18px;color:#000;">Revisar los datos al completar el formulario de pago.</li><li class="text" style="font-size:18px;color:#000;">Intentarlo mas tarde</li>' ;
                 break;
        }
           break;
           default:
           echo '   <li class="text" style="font-size:18px;color:#000;">Usar otra tarjeta.</li>   <li class="text" style="font-size:18px;color:#000;">Hablar con su banco , seguramente  usted tiene alguna limitación o necesita autorizar este pago.</li> <li class="text" style="font-size:18px;color:#000;">Revisar los datos al completar el formulario de pago.</li><li class="text" style="font-size:18px;color:#000;">Intentalo mas tarde</li>' ;
            break;
    }
   ?>

  

   
   <button   type="submit" id="form-checkout__submit" class="container btn-process" style="max-width:300px;width:100%;"> Regresar al formulario de pago </button>
  </ul>
 </div>

</div>
    </div>

    <footer style="background: #f1dede;">
        <section class="contact">
          <h2
            style="
              margin-bottom: 20px;
              letter-spacing: 3px;
              text-transform: uppercase;
              padding-top: 20px;
            "
            ;
          >
            Contacto
          </h2>
          <div class="contact__containerInstagram">
            <svg
              fill="#000000"
              width="40px"
              height="40px"
              viewBox="0 0 32 32"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title />

              <g id="Instagram">
                <path
                  d="M26.49,30H5.5A3.35,3.35,0,0,1,3,29a3.35,3.35,0,0,1-1-2.48V5.5A3.35,3.35,0,0,1,3,3,3.35,3.35,0,0,1,5.5,2h21A3.35,3.35,0,0,1,29,3,3.35,3.35,0,0,1,30,5.5v21A3.52,3.52,0,0,1,26.49,30ZM24.74,10.56a3.45,3.45,0,0,0-3.48-3.49H10.71a3.47,3.47,0,0,0-3.48,3.49V21.1a3.45,3.45,0,0,0,3.48,3.49H21.26a3.43,3.43,0,0,0,3.48-3.49Zm-8.73.9a4.09,4.09,0,0,0-1.38.24,5.36,5.36,0,0,0-1.24.63H9v-.87a2.56,2.56,0,0,1,2.61-2.62h8.75a2.63,2.63,0,0,1,1.89.75A2.48,2.48,0,0,1,23,11.46v.87H18.6a6.14,6.14,0,0,0-1.22-.63A3.87,3.87,0,0,0,16,11.46Zm4.35,11.41H11.61a2.48,2.48,0,0,1-1.86-.78A2.57,2.57,0,0,1,9,20.24v-7h3.49a5.49,5.49,0,0,0-.63,1.23,3.82,3.82,0,0,0-.25,1.4A4.19,4.19,0,0,0,12,17.55a5,5,0,0,0,.93,1.39,4.28,4.28,0,0,0,1.4.95,4.24,4.24,0,0,0,1.72.35,4.29,4.29,0,0,0,3.08-1.3A5,5,0,0,0,20,17.55a4.19,4.19,0,0,0,.35-1.69,3.82,3.82,0,0,0-.25-1.4,6.37,6.37,0,0,0-.6-1.23H23v7a2.52,2.52,0,0,1-.78,1.85A2.57,2.57,0,0,1,20.36,22.87ZM16,13.23a2.55,2.55,0,0,1,1.85.75,2.63,2.63,0,0,1,0,3.74,2.55,2.55,0,0,1-1.85.75,2.63,2.63,0,0,1-1.9-.75,2.66,2.66,0,0,1,0-3.74A2.63,2.63,0,0,1,16,13.23Zm3.5-1.77h1.75V9.71H19.51Z"
                />
              </g>
            </svg>
            <p
              style="
                line-height: 40px;
                font-size: 16px;
                font-weight: 800;
                color: #343837;
                margin-left: 10px;
              "
            >
              Instagram
            </p>
          </div>
          <div class="contact__containerEmail">
            <svg
              fill="#000000"
              width="40px"
              height="40px"
              viewBox="0 0 32 32"
              xmlns="http://www.w3.org/2000/svg"
            >
              <title />

              <g id="Email">
                <path
                  d="M26.49,30H5.5A3.35,3.35,0,0,1,3,29a3.35,3.35,0,0,1-1-2.48V5.5A3.35,3.35,0,0,1,3,3,3.35,3.35,0,0,1,5.5,2h21A3.35,3.35,0,0,1,29,3,3.35,3.35,0,0,1,30,5.5v21A3.52,3.52,0,0,1,26.49,30Zm-2.62-6.9a1,1,0,0,0,.57-.19,1.23,1.23,0,0,0,.7-1.1V9.93A.93.93,0,0,0,25,9.4a1.32,1.32,0,0,0-1.13-.74H7.93a.69.69,0,0,0-.3.1A1.26,1.26,0,0,0,6.77,9.9V21.81a1,1,0,0,0,.17.55,1.28,1.28,0,0,0,1.12.74Zm-1.36-2.66H9.41V13L16,18.21,22.51,13ZM16,14.81c-2.89-2.28-4.37-3.46-4.44-3.52H20.4Z"
                />
              </g>
            </svg>
            <p
              style="
                line-height: 40px;
                font-size: 18px;
                margin-left: 10px;
                color: #343837;
              "
            >
              Email
            </p>
          </div>
        </section>
      </footer>


      <script>
        const post =   function (path, params, method = "POST") {
       const form = document.createElement("form");
        form.method = method;
        form.action = path;
        for (const key in params) {
        if (params.hasOwnProperty(key)) {
          const hiddenField = document.createElement("input");
          hiddenField.type = "hidden";
          hiddenField.name = key;
          hiddenField.value = params[key];
          form.appendChild(hiddenField);
          }
        }
      document.body.appendChild(form);
      form.submit();
    }

    const objeto = {
            nombre: "<?php  echo $_POST['nombre'] ?>",
            apellido:" <?php  echo $_POST['apellido'] ?>",
            email: "<?php  echo $_POST['mail'] ?>",
            telefono: <?php  echo $_POST['telefono'] ?>,
            horario: JSON.stringify(<?php  echo $_POST['horario'] ?>),
            fecha: JSON.stringify(<?php  echo $_POST['fecha'] ?>),
            modalidad: "<?php  echo $_POST['modalidad'] ?>",
            encuentro: "<?php  echo $_POST['encuentro'] ?>",
            precio : "<?php echo  $_POST['precio'] ?>"
          }
          console.log(typeof objeto.horario);
        document.querySelector("#form-checkout__submit").addEventListener('click' , (e) => {
          post("./checkout2.php" , objeto);
        })
      </script>
</body>
</html>