App.component("confirmar-pago", {
  props: {
    modalidad: String,
    encuentro: String,
    precios: Array,
    loading: Boolean,
  },
  computed: {
    servicio() {
      return `${this.encuentro} ${this.modalidad}`;
      // Seguimiento Presencial
    },
    precio() {
      let precio;
      this.precios.forEach((e) => {
        if (this.encuentro == e.value) {
          precio = "AR$" + e.precio;
        }
      });
      return precio;
    },
  },
  template: ` 
  <el-skeleton  :loading="loading" animated>
  <template #template>
  <div>
  <h2 style="font-size:20px; font-family: 'Roboto', sans-serif;text-align:left;padding-left:20px;padding-top:20px;"> <el-skeleton-item variant="h1" style="height:27px;width:200px;" /></h2>
    <el-skeleton-item style="width:80%;height:200px;margin:auto;margin-top:20px;border-radius:10px;">
        
       
    </el-skeleton-item>
    <p style="padding-top:20px;font-family: 'Roboto', sans-serif;color:#524A4E;font-size:16px;"><el-skeleton-item variant="h1" style="width:80%;" /></p>
    <p style="padding-top:20px;font-family: 'Roboto', sans-serif;color:#524A4E;font-size:16px;"><el-skeleton-item variant="h1" style="width:80%;height:40px;" /></p>
 </div>
  </template>
  <template #default>
  <div style="width:90%">
  <h2 class="titlePay" >Resumen de pago</h2>
    <div class="containPay" >
        <div class="containPay__containService" >
         <p class="containPay__titleService" >Servicios</p>
         <p class="containPay__textService" >{{servicio}} ({{precio}}) <br> {{precio}} x 1 person</p>
        </div>
        <div class="containPay__containerPrice" >
        <p  class="containPay__text">Total:</p>
        <span class="containPay__space" ></span>
        <p class="containPay__price" >{{precio}}</p>
        </div>
       
    </div>
    <p class="payInfo" >Podrás pagar en cuotas a través de mercado pago</p>
    <p  class="payInfo" style="margin-bottom:20px;">Haz clic en el botón Continuar para ser redireccionado a la página de pago. Todavía tu reserva no fue confirmada</p>
 </div>
  </template>
</el-skeleton>
  
  `,
});
