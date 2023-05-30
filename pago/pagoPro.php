<?php

// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken('TEST-5952401225197401-042414-2c01f5121619fe18a5dc28ecae3bd178-284444760');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();
$preference->back_urls = array(
    "success" => "https://www.google.com/",
    "failure" => "https://www.google.com/",
    "pending" => "https://www.google.com/"
);
// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$preference->items = array($item );
$payer = new MercadoPago\Payer();
$payer->email = "felipe@hotmail.com";
$payer->name = "Federico";
$payer->surname = "Levatti";
$payer->phone = array(
    "area_code" => "342",
    "number" => "5698536",
);
$preference->payer = $payer;
$preference->save();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 
</head>

<body>
    <h1>Checkout Pro</h1>
    <p>No tiene personalización , lo gestiona todo mercado pago <br>Se debe implementar "Notificacion" para saber que se realizo la compra </p>
    <div id="wallet_container"></div>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('TEST-ee10fc35-6c13-4ede-bf9d-3575251ec436', {
            locale: 'es-AR'
        });
        const bricksBuilder = mp.bricks();
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: "<?php echo $preference->id ?>",
            },
            
        });
    </script>
</body>

</html>