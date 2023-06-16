App.component("user-form", {
  emits: ["valueChange"],
  props: {
    name: String,
    surname: String,
    email: String,
    phone: String,
    area: String,
    errors: Object,
    loading: Boolean,
  },
  data() {
    return {
      valueName: this.name,
      valueSurname: this.surname,
      valueMail: this.email,
      valueArea: this.area,
      valuePhone: this.phone,
    };
  },
  methods: {
    valueChange(type) {
      let value;
      switch (type) {
        case "name":
          value = this.valueName;
          break;
        case "surname":
          value = this.valueSurname;
          break;
        case "email":
          value = this.valueMail;
          break;
        case "area":
          value = this.valueArea;
          break;
        case "phone":
          value = this.valuePhone;
          break;
      }
      this.$emit("valueChange", { type, value });
    },
  },
  template: `   
  <el-skeleton :loading="loading" animated>
      <template #template>
      <div
      class="skeleton__formUserContainer"
    >
      <div
      class="formUserContainer__inputContainer"
       
      >
        <el-skeleton-item class="form__label form__label--center skeleton__label--height" > <span >*</span>Nombre</el-skeleton-item>
        <el-skeleton-item
          
          class="skeleton__input"
         
        ></el-skeleton-item>
       
      </div>
      <div
      class="formUserContainer__inputContainer"
      >
        <el-skeleton-item class="form__label  form__label--center skeleton__label--height" >Apellido</el-skeleton-item>
        <el-skeleton-item
          
        class="skeleton__input"
       
        ></el-skeleton-item>
       
      </div>
      <div
      class="formUserContainer__inputContainer"
      >
        <el-skeleton-item   class="form__label form__label--center skeleton__label--height">
        Mail (toda la información llega a este correo)
        </el-skeleton-item>
        <el-skeleton-item
       class="skeleton__input"
        ></el-skeleton-item>
      </div>
      <div
      class="formUserContainer__inputContainer"
      >
        <el-skeleton-item class="form__label form__label--center skeleton__label--height" >
        Telefono / Celular
        </el-skeleton-item>
        <el-skeleton-item
      class="skeleton__input"
        ></el-skeleton-item>
      </div>
    </div>
      </template>
      <template #default>
      <div
      class="formUserContainer"
    >
      <div
      class="formUserContainer__inputContainer"
       
      >
        <p class="form__label form__label--center"> <span class="form__label--red">*</span>Nombre</p>
        <el-input
          v-model="valueName"
          size="large"
          placeholder="Nombre"
          class="formUserContainer__input"
  
          @input="valueChange('name')"
        ></el-input>
        <p
          v-if="errors.name"
          class="form__labelError form__labelError--user"
        >
          {{errors.name}}
        </p>
      </div>
      <div
      class="formUserContainer__inputContainer"
      >
        <p class="form__label form__label--center"><span class="form__label--red">*</span>Apellido</p>
        <el-input
          v-model="valueSurname"
          size="large"
          placeholder="Apellido"
          class="formUserContainer__input"
          @input="valueChange('surname')"
        ></el-input>
        <p
          v-if="errors.surname"
          class="form__labelError form__labelError--user"
      
        >
          {{errors.surname}}
        </p>
      </div>
      <div
      class="formUserContainer__inputContainer"
      >
        <p class="form__label form__label--center">
        <span class="form__label--red">*</span>Mail (toda la información llega a este correo)
        </p>
        <el-input
          v-model="valueMail"
          size="large"
          placeholder="Mail"
         class="formUserContainer__input"
          @input="valueChange('email')"
        ></el-input>
   
        <p
          
        class="form__labelError form__labelError--user"
        v-if="errors.mail"
        >
          {{ errors.mail}}
        </p>
      </div>
      <div
      class="formUserContainer__inputContainer"
      >
        <p class="form__label form__label--center">
        <span class="form__label--red">*</span>Telefono / Celular
        </p>
        <div class="formUserContainer__cellPhoneNumberContainer">
          <el-input
            v-model="valueArea"
            size="large"
            placeholder="Area"
            class="formUserContainer__input formUserContainer__input--area"
            @input="valueChange('area')"
          ></el-input>
          <el-input
            v-model="valuePhone"
            size="large"
            placeholder="Telefono"
            class="formUserContainer__input formUserContainer__input--phone"
            @input="valueChange('phone')"
          ></el-input>
    
          <p
            v-if="errors.phone"
            class="form__labelError form__labelError--user"
            
          >
          {{errors.phone}}
          </p>
        </div>
    
   
      </div>
    </div>
      </template>
    </el-skeleton>
  
  
  `,
});
