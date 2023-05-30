App.component("info-personalizado", {
  emits: ["changeValue"],
  props: {
    nombre: String,
    apellido: String,
    email: String,
    telefono: String,
    area: String,
    errors: Object,
    loading: Boolean,
  },
  data() {
    return {
      valueNombre: this.nombre,
      valueApellido: this.apellido,
      valueMail: this.email,
      valueArea: this.area,
      valueTelefono: this.telefono,
    };
  },
  methods: {
    cambioValor(tipo) {
      let valor;
      switch (tipo) {
        case "nombre":
          valor = this.valueNombre;
          break;
        case "apellido":
          valor = this.valueApellido;
          break;
        case "email":
          valor = this.valueMail;
          break;
        case "area":
          valor = this.valueArea;
          break;
        case "telefono":
          valor = this.valueTelefono;
          break;
      }
      this.$emit("changeValue", { tipo, valor });
    },
  },
  template: `   
  <el-skeleton :loading="loading" animated>
      <template #template>
      <div
      style="display: flex; flex-wrap: wrap; align-items: flex-end"
    >
      <div
      class="form__containerInput"
       
      >
        <el-skeleton-item class="form__label form__label--center" style="height:21px;"> <span >*</span>Nombre</el-skeleton-item>
        <el-skeleton-item
          
          style="width:100%;max-width: 216px; height: 40px;margin-top:2px;"
         
        ></el-skeleton-item>
       
      </div>
      <div
      class="form__containerInput"
      >
        <el-skeleton-item class="form__label  form__label--center" style="height:21px;"><span style="color:#cb0505;">*</span>Apellido</el-skeleton-item>
        <el-skeleton-item
          
        style="width:100%;max-width: 216px; height: 40px;margin-top:2px;"
       
        ></el-skeleton-item>
       
      </div>
      <div
      class="form__containerInput"
      >
        <el-skeleton-item  style="height:21px;" class="form__label form__label--center">
        <span style="color:#cb0505;">*</span>Mail (toda la información llega a este correo)
        </el-skeleton-item>
        <el-skeleton-item
        style="width:100%;max-width: 216px; height: 40px;margin-top:2px;"
        ></el-skeleton-item>
   
        <p
          
        class="form__labelError"
        >
          {{ errors.mail}}
        </p>
      </div>
      <div
      class="form__containerInput"
      >
        <el-skeleton-item class="form__label form__label--center" style="height:21px;">
        <span style="color:#cb0505;">*</span>Telefono / Celular
        </el-skeleton-item>
        <el-skeleton-item
        style="width:100%;max-width: 216px; height: 40px;margin-top:2px;"
        ></el-skeleton-item>
    
   
      </div>
    </div>
      </template>
      <template #default>
      <div
      style="display: flex; flex-wrap: wrap; align-items: flex-end"
    >
      <div
      class="form__containerInput"
       
      >
        <p class="form__label form__label--center"> <span style="color:#cb0505;">*</span>Nombre</p>
        <el-input
          v-model="valueNombre"
          size="large"
          placeholder="Nombre"
          style="width:100%;max-width: 216px; height: 40px"
          @input="cambioValor('nombre')"
        ></el-input>
        <p
          v-if="errors.nombre"
          class="form__labelError"
        >
          {{errors.nombre}}
        </p>
      </div>
      <div
      class="form__containerInput"
      >
        <p class="form__label form__label--center"><span style="color:#cb0505;">*</span>Apellido</p>
        <el-input
          v-model="valueApellido"
          size="large"
          placeholder="Apellido"
          style="width:100%;max-width: 216px; height: 40px"
          @input="cambioValor('apellido')"
        ></el-input>
        <p
          v-if="errors.apellido"
          class="form__labelError"
      
        >
          {{errors.apellido}}
        </p>
      </div>
      <div
      class="form__containerInput"
      >
        <p class="form__label form__label--center">
        <span style="color:#cb0505;">*</span>Mail (toda la información llega a este correo)
        </p>
        <el-input
          v-model="valueMail"
          size="large"
          placeholder="Mail"
          style="width:100%;max-width: 216px; height: 40px"
          @input="cambioValor('email')"
        ></el-input>
   
        <p
          
        class="form__labelError"
        >
          {{ errors.mail}}
        </p>
      </div>
      <div
      class="form__containerInput"
      >
        <p class="form__label form__label--center">
        <span style="color:#cb0505;">*</span>Telefono / Celular
        </p>
        <div class="heightSMALL-80">
          <el-input
            v-model="valueArea"
            size="large"
            placeholder="Area"
            style="width:100%;max-width: 70px; height: 40px"
            @input="cambioValor('area')"
          ></el-input>
          <el-input
            v-model="valueTelefono"
            size="large"
            placeholder="Telefono"
            style="width:100%;max-width: 100px; height: 40px"
            @input="cambioValor('telefono')"
          ></el-input>
    
          <p
            v-if="errors.telefono"
            class="form__labelError"
            
          >
          {{errors.telefono}}
          </p>
        </div>
    
   
      </div>
    </div>
      </template>
    </el-skeleton>
  
  
  `,
});
