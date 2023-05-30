App.component("turno-personalizado", {
  emits: ["changeValue"],
  template: `  <div  style="height: 90%; padding-top: 20px">
  
  <div style="padding-bottom:30px;position: relative;">
    <el-skeleton animated :loading=loading>
      <template #template>
      <el-skeleton-item style="height:27px;max-width:200px;text-align:left;display:block;"  class="marginL-10" />
      <el-skeleton-item style="margin-top:10px;width:80%;display:block;height:20px;height:38px;" class="marginL-10"  />
      </template >
         
      <template #default>
      <p  class="form__label">
      <span style="color:#cb0505;">*</span>Modalidad:
    </p>
    <el-select
    v-model="valueModalidad"
    class="m-2"
    placeholder=" Presencial / Online"
    size="large"
    @change = "cambioValor('modalidad')"
  >
    <el-option
      v-for="item in optionsModalidad"
      :key="item.value"
      :label="item.label"
      :value="item.value"
    />
  </el-select>

     <p  v-if="this.errors.modalidad" style="position:absolute;bottom:17px;left:13px;color:#f00;font-size:13px;font-family: Roboto, sans-serif;"  >{{this.errors.modalidad}}</p>
      </template>
    </el-skeleton>
   
   
  </div>
  <div style="padding-bottom:30px;position: relative;">

  <el-skeleton animated :loading=loading>
  <template #template>
  <el-skeleton-item style="height:27px;max-width:200px;text-align:left;display:block;" class="marginL-10"  />
  <el-skeleton-item style="margin-top:10px;width:80%;display:block;height:20px;height:38px;"  class="marginL-10" />
  </template >
     
  <template #default>
  <p class="form__label">
  <span style="color:#cb0505;">*</span>Encuentro:
</p>
<el-select
 :fit-input-width="true"
  v-model="valueEncuentro"
  class="m-2"
  placeholder=" Primera Vez / Seguimiento"
  size="large"
  @change = "cambioValor('encuentro')"
>
  <el-option
    v-for="item in optionsMotivo"
    :key="item.value"
    :label="item.label"
    :value="item.value"
  >
  <span style="float:left;">{{item.label}}</span>
  <span style="float:right;">AR $ {{item.precio}}</span>

</el-option>
</el-select>
<p  v-if="this.errors.encuentro" style="position:absolute;bottom:17px;left:13px;color:#f00;font-size:13px;font-family: Roboto, sans-serif;" > {{this.errors.encuentro}} </p>
  </template>
</el-skeleton>

   
  </div>
  
</div>`,
  props: {
    modalidad: String,
    encuentro: String,
    errors: Object,
    optionsModalidad: Array,
    optionsMotivo: Array,
    loading: Boolean,
  },
  data() {
    return {
      valueModalidad: this.modalidad,
      valueEncuentro: this.encuentro,
    };
  },
  mounted() {
    // console.log(this.optionsModalidad);
  },
  methods: {
    cambioValor(tipo) {
      let valor;
      if (tipo === "encuentro") {
        valor = this.valueEncuentro;
      } else {
        valor = this.valueModalidad;
      }
      this.$emit("changeValue", { tipo, valor });
    },
  },
});
