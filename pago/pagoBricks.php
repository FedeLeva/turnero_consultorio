<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Bricks</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

</head>

<body>
    <h1>Checkout Bricks</h1>
    <p>Tiene poca personalización</p>
    <div id="paymentBrick_container" style="width:400px;"></div>
    <script>
        const mp = new MercadoPago('TEST-ee10fc35-6c13-4ede-bf9d-3575251ec436', {
            locale: 'es-AR'
        });
        const bricksBuilder = mp.bricks();
        const renderPaymentBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {

                    amount: 100,
                     payer : {
                        email:"jose@maria.com",
                     }
                    
                },
             
                customization: {
                    paymentMethods: {
                        ticket: "all",
                        creditCard: "all",
                        debitCard: "all",
                        mercadoPago: "all",
                    },
                
                },
                callbacks: {
                    onReady: () => {
                        /*
                         Callback llamado cuando el Brick está listo.
                         Aquí puede ocultar cargamentos de su sitio, por ejemplo.
                        */
                    },
                    onSubmit: ({
                        selectedPaymentMethod,
                        formData
                    }) => {
                        
                        // callback llamado al hacer clic en el botón enviar datos
                        return new Promise((resolve, reject) => {
                            fetch("http://localhost/web/pago/process_payment/bricks.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify(formData),
                                })
                                .then((response) => {
                                return response.json()})
                                .then((response) => {
                                    // recibir el resultado del pago
                                    console.log(response);
                                    resolve();
                                })
                                .catch((error) => {
                                    // manejar la respuesta de error al intentar crear el pago
                                    console.log("error al crear el pago" , error);
                                    reject();
                                });
                        }).then( () => {
                            alert('Se realizo la compra')
                        })
                    },
                    onError: (error) => {
                        // callback llamado para todos los casos de error de Brick
                        console.log("error de Brick" , error);
                    },
                },
            };
            window.paymentBrickController = await bricksBuilder.create(
                "payment",
                "paymentBrick_container",
                settings
            );
        };
        renderPaymentBrick(bricksBuilder);
    </script>

</body>

</html>