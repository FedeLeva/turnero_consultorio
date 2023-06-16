App.component("custom-turn", {
  emits: ["valueChange"],
  template: `  <div class="turn" >
  
  <div  class="turn__selectContainer"  >
    <el-skeleton animated :loading=loading>
      <template #template>
      <el-skeleton-item   class="skeleton__label skeleton__label--ml10" />
      <el-skeleton-item  class="skeleton__select skeleton__select--ml10"  />
      </template >
      <template #default>
      <p  class="form__label">
      <span class="form__label--red">*</span>Modalidad:
    </p>
    <el-select
    v-model="valueModality"
    class="m-2"
    placeholder=" Presencial / Online"
    size="large"
    @change = "valueChange('modality')"
  >
    <el-option
      v-for="option in optionsModality"
      :key="option.value"
      :label="option.label"
      :value="option.value"
    />
  </el-select>

     <p  v-if="this.errors.modality" class="form__labelError form__labelError--turn" >{{this.errors.modality}}</p>
      </template>
    </el-skeleton>
   
   
  </div>
  <div class="turn__selectContainer">

  <el-skeleton animated :loading=loading>
  <template #template>
  <el-skeleton-item  class="skeleton__label--ml10 skeleton__label"  />
  <el-skeleton-item   class="skeleton__select--ml10 skeleton__select" />
  </template >
     
  <template #default>
  <p class="form__label">
  <span class="form__label--red">*</span>Encuentro:
</p>
<el-select
 :fit-input-width="true"
  v-model="valueMeeting"
  class="m-2"
  placeholder=" Primera Vez / Seguimiento"
  size="large"
  @change = "valueChange('meeting')"
>
  <el-option
    v-for="option in optionsMotivesSelectable"
    :key="option.value"
    :label="option.label"
    :value="option.value"
  >
  
  <span class="float-l">{{option.label}}</span>
  <span class="float-r" >AR $ {{option.price}}</span>

</el-option>
</el-select>
<p  v-if="this.errors.meeting" class="form__labelError form__labelError--turn"> {{this.errors.meeting}} </p>
  </template>
</el-skeleton>

   
  </div>
  
</div>`,
  props: {
    modality: String,
    meeting: String,
    errors: Object,
    optionsModality: Array,
    optionsMotives: Array,
    loading: Boolean,
    coupon: String,
  },
  async created() {
    if (this.coupon) {
      alert("Es un cupon");
      const response = await fetch(`./backend/getCoupon.php?id=${this.coupon}`);
      const data = await response.json();
      if (data[0]) {
        const optionsSelectable = this.optionsMotives.filter((item) => {
          if (item.value == data[0].meeting) {
            this.valueMeeting = item.value;
            this.valueChange("meeting");
            return true;
          }
          return false;
        });
        this.$emit("valueChange", { type: "coupon", value: data[0] });
        this.optionsMotivesSelectable = optionsSelectable;
      } else {
        this.optionsMotivesSelectable = this.optionsMotives;
      }
    } else {
      this.optionsMotivesSelectable = this.optionsMotives;
    }
  },
  data() {
    return {
      valueModality: this.modality,
      valueMeeting: this.meeting,
      optionsMotivesSelectable: Array,
    };
  },
  methods: {
    valueChange(type) {
      let value;
      if (type === "meeting") {
        value = this.valueMeeting;
      } else {
        value = this.valueModality;
      }
      this.$emit("valueChange", { type, value });
    },
  },
});
