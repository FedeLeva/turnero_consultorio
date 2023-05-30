App.component("Calendario", {
  template: ` 
    
  <el-skeleton  animated  :loading="loading" >
  <template #template>
  <div  id="calendar" style="width:100%;margin:auto;overflow:hidden;">
    <div class="buttonsContainer">  
      <el-skeleton-item
 
        style="height:38px;width:60%;margin-bottom:2px;"
    >
       
       </el-skeleton-item>
       
        <el-skeleton-item style="height:38px;width:76px;margin-bottom:2px;"   ></el-skeleton-item>

        
       
    
    </div>
    <div><el-skeleton-item style="height:40px;width:200px;">Argentina - Santa Fe <br> {{year}}</el-skeleton-item></div>
   
    <ul class="dates month">
                <el-skeleton-item style="max-height:40px;height:100%" class="dow" v-for="dow in days"> <span>{{dow}} </span></el-skeleton-item>
        <li v-for="blank in firstDayOfMonth" class="day inactivo"></li>
        <el-skeleton-item style="max-height:40px;height:100%;border:none;z-index:-1" v-for="date in daysInMonth.dias"
        class="day" >
            <span>{{date}}</span>
        </el-skeleton-item>
    </ul>
  </div>
  </template>
 

<template #default>

<div  id="calendar" style="width:100%;margin:auto">
    <div class="buttonsContainer">  
      <el-select
       v-model="valueMes"
        class="m-10 "
        placeholder="Mes"
       size="large"
       @change="seleccionarMes($event)">
       <el-option v-for="item in optionsMotivo" :key="item.value"  :label = "item.label"  :value = "item.value"/>
       </el-select>
        <div style="">
        <el-button  @click="lastMonth"><svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  
        <title/>
        
        <g id="Complete">
        
        <g id="F-Chevron">
        
        <polyline fill="none" id="Left" points="15.5 5 8.5 12 15.5 19" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        
        </g>
        
        </g>
        
        </svg></el-button>
        <el-button  @click="nextMonth"><svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  
        <title/>
        
        <g id="Complete">
        
        <g id="F-Chevron">
        
        <polyline fill="none" id="Right" points="8.5 5 15.5 12 8.5 19" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        
        </g> </g>
  
        </svg></el-button>
        </div>
    
    </div>
    <div><p style="text-align:center;font-size:15px;">Argentina - Santa Fe <br> {{year}}</p></div>
   
    <ul class="dates month">

                <li class="dow" v-for="dow in days"> <span>{{dow}} </span></li>
        <li v-for="blank in firstDayOfMonth" class="day inactivo"></li>
        <li v-for="date in daysInMonth.dias" @click="openday( date , $event  )"
        :class="{day : true  , ocupado : daysInMonth.eventos['dia' + date]  || isCurrent(date)   , activo :  initial_date &&  fecha_inicial.dia == date }"   >
            <span>{{date}}</span>
        </li>
    </ul>
  </div>
</template>


</el-skeleton>


  `,
  props: {
    fecha_inicial: Object,
    loading: Boolean,
  },
  mounted() {
    this.$emit("renderizado", { date: this.dateContext });
  },
  data() {
    return {
      eventos: [],
      meses: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      today: dayjs(),
      dateContext: dayjs(),
      days: ["do", "lu", "ma", "mié", "jue", "vie", "sab"],
      valueMes: null,
      optionsMotivo: [],
      dateSeleccionado: undefined,
    };
  },
  created() {
    const mes = dayjs().month() + 1;
    fetch(`./backend/eventos.php?mes=${mes}`)
      .then((response) => response.json())
      .then((response) => {
        this.eventos = response;
      });

    const mesActual = parseInt((dayjs().get("month") + 1).toString());

    this.valueMes = this.meses[mesActual - 1];
    for (let i = 1; i < 4; i++) {
      this.optionsMotivo.push({
        value: mesActual + i,
        label: this.meses[mesActual + i - 1],
      });
    }
    if (Object.entries(this.fecha_inicial).length !== 0) {
      this.dateContext = this.dateContext.set(
        "month",
        this.fecha_inicial.mes - 1
      );
      this.dateContext = this.dateContext.set("year", this.fecha_inicial.año);
      this.valueMes = this.meses[this.fecha_inicial.mes - 1];
    }
  },
  methods: {
    isCurrent: function (date) {
      // Estamos en el mismo mes?
      if (
        this.dateContext.get("month") + 1 == this.initialMonth &&
        this.initialYear == this.dateContext.get("year")
      ) {
        if (date < this.initialDate) {
          return true;
        }
        return false;
      } else {
        // Estamos un año atras?

        if (this.initialYear > this.dateContext.get("year")) {
          return true;
        } else {
          // Estamos  un mes atras?
          if (
            this.dateContext.get("month") + 1 < this.initialMonth &&
            this.initialYear == this.dateContext.get("year")
          ) {
            return true;
          } else {
            return false;
          }
        }
      }
    },
    seleccionarMes: function (e) {
      fetch(`./backend/eventos.php?mes=${e}`)
        .then((response) => response.json())
        .then((response) => {
          this.eventos = response;
        });
      let año = parseInt(dayjs().get("year").toString());
      const mesActual = parseInt((dayjs().get("month") + 1).toString());

      if (e < mesActual) {
        año += 1;
      }

      this.dateSeleccionado = undefined;
      var t = this;
      t.dateContext = t.dateContext.set("month", e - 1);
      t.dateContext = t.dateContext.set("year", año);

      this.$emit("change-month", {
        type: "changue",
        mes: e,
        date: t.dateContext,
      });
    },
    nextMonth: function () {
      var t = this;

      this.dateSeleccionado = undefined;
      t.dateContext = dayjs(t.dateContext).add(1, "month");

      const indice = t.dateContext.get("month");

      fetch(`./backend/eventos.php?mes=${indice + 1}`)
        .then((response) => response.json())
        .then((response) => {
          this.eventos = response;
        });

      this.valueMes = this.meses[indice];
      this.$emit("change-month", {
        type: "next",
        mes: indice + 1,
        date: t.dateContext,
      });
    },
    lastMonth: function () {
      this.dateSeleccionado = undefined;
      var t = this;
      t.dateContext = dayjs(t.dateContext).subtract(1, "month");
      const indice = t.dateContext.get("month");

      fetch(`./backend/eventos.php?mes=${indice + 1}`)
        .then((response) => response.json())
        .then((response) => {
          this.eventos = response;
        });

      this.valueMes = this.meses[indice];
      this.$emit("change-month", {
        type: "last",
        mes: indice + 1,
        date: t.dateContext,
      });
    },
    openday: function (date, e) {
      // console.log("date", date);
      // console.log("initialdate", this.initialDate);
      // console.log("date <= initialDate", date <= this.initialDate);
      if (this.daysInMonth.eventos["dia" + date] || this.isCurrent(date)) {
        return;
      }

      const mes = this.dateContext.get("month") + 1;
      const año = this.dateContext.get("year");

      if (date === this.dateSeleccionado) {
        const objeto = {
          dia: date,
          mes,
          año,
        };
        this.dateSeleccionado = undefined;
        this.$emit("selected", objeto);
        return;
      } else {
        this.dateSeleccionado = date;
      }

      if (this.daysInMonth.eventos["dia" + date]) {
        return;
      }

      const objeto = {
        dia: date,
        mes,
        año,
      };
      this.$emit("selected", objeto);
    },
  },
  computed: {
    initial_date: function () {
      const boolean =
        this.fecha_inicial.año == this.year &&
        this.fecha_inicial.mes == this.monthName &&
        Object.entries(this.fecha_inicial).length !== 0;
      return boolean;
    },
    year: function () {
      var t = this;
      return t.dateContext.format("YYYY");
    },
    month: function () {
      var t = this;
      return t.dateContext.format("MMMM");
    },
    monthName: function () {
      var t = this;
      return t.dateContext.month() + 1;
    },
    findes: function () {
      const findes = [];
      let context = this.dateContext.startOf("month");

      for (let i = 1; i <= context.daysInMonth(); i++) {
        if (context.day() == 6 || context.day() == 0) {
          const dia = context.get("date");
          const mes = context.get("month") + 1;
          const año = context.get("year");
          findes.push({ date: dia, mes, año });
        }
        context = context.add(1, "day");
      }
      return findes;
    },
    daysInMonth: function () {
      var t = this;
      const dias = t.dateContext.daysInMonth();
      let objeto;
      var eventosCalendario = {};
      this.findes.forEach((e) => {
        if (
          e.año === this.dateContext.get("year") &&
          e.mes === this.dateContext.get("month") + 1
        ) {
          eventosCalendario["dia" + e.date] = true;
        }
      });
      if (this.eventos.length === 0) {
        objeto = { dias, eventos: eventosCalendario };
      } else {
        this.eventos.forEach((e) => {
          if (
            parseInt(e.año) === this.dateContext.get("year") &&
            parseInt(e.mes) === this.dateContext.get("month") + 1
          ) {
            eventosCalendario["dia" + e.date] = true;
          }
        });
        objeto = { dias, eventos: eventosCalendario };
      }

      return objeto;
    },
    currentDate: function () {
      var t = this;
      return t.dateContext.get("date");
    },
    firstDayOfMonth: function () {
      var t = this;
      var firstDay = dayjs(t.dateContext).startOf("Month");
      return firstDay.day();
    },
    //Previous Code Above
    initialDate: function () {
      var t = this;
      return t.today.get("date");
    },
    initialMonth: function () {
      var t = this;
      return t.today.get("month") + 1;
    },
    initialYear: function () {
      var t = this;
      return t.today.get("year");
    },
  },

  emits: ["selected", "change-month", "renderizado"],
});
