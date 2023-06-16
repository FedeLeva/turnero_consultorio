App.component("confirm-payment", {
  props: {
    modality: String,
    meeting: String,
    optionsMotives: Array,
    loading: Boolean,
  },
  computed: {
    service() {
      return `${this.meeting} ${this.modality}`;
    },
    price() {
      let price;
      this.optionsMotives.forEach((motive) => {
        if (this.meeting == motive.value) {
          price = "AR$" + motive.price;
        }
      });
      return price;
    },
  },
  template: ` 
  <el-skeleton  :loading="loading" animated>
  <template #template>
  <div>
  <h2 class="skeleton__titlePayment"> <el-skeleton-item variant="h1" class="skeleton__titlePayment--size" /></h2>
    <el-skeleton-item class="skeleton__paymentContainer">
        
       
    </el-skeleton-item>
    <p class="skeleton__payInfo"  ><el-skeleton-item variant="h1" class="skeleton__payInfo--w80" /></p>
    <p class="skeleton__payInfo"><el-skeleton-item variant="h1" class="skeleton__payInfo--w80 skeleton__payInfo--h40" /></p>
 </div>
  </template>
  <template #default>
  <div class="w-90">
  <h2 class="titlePayment" >Resumen de pago</h2>
    <div class="paymentContainer" >
        <div class="paymentContainer__serviceContainer" >
         <p class="paymentContainer__titleService" >Servicios</p>
         <p class="paymentContainer__textService" >{{service}} ({{price}}) <br> {{price}} x 1 person</p>
        </div>
        <div class="paymentContainer__priceContainer" >
        <p  class="paymentContainer__text">Total:</p>
        <span class="paymentContainer__space" ></span>
        <p class="paymentContainer__price" >{{price}}</p>
        </div>
       
    </div>
    <p class="payInfo" >Podrás pagar en cuotas a través de mercado pago</p>
    <p  class="payInfo  payInfo--mb20" >Haz clic en el botón Continuar para ser redireccionado a la página de pago. Todavía tu reserva no fue confirmada</p>
 </div>
  </template>
</el-skeleton>
  
  `,
});
