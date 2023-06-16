App.component("calendar", {
  template: ` 
    
  <el-skeleton  animated  :loading="loading" >
  <template #template>
  <div  id="calendar" >
    <div class="buttonsContainer">  
      <el-skeleton-item
        class="skeleton__btnSelectMonth"
        
    >
       
       </el-skeleton-item>
       
        <el-skeleton-item class="skeleton__btnChangeMonth"    ></el-skeleton-item>

        
       
    
    </div>
    <div><el-skeleton-item   class="skeleton__location" >Argentina - Santa Fe <br> {{calendarYear}}</el-skeleton-item></div>
   
    <ul class="dates ">
                <el-skeleton-item   class="dates__nameDay skeleton__date" v-for="nameDay in days"> <span>{{nameDay}} </span></el-skeleton-item>
        <li v-for="blank in firstDayOfMonth" class="dates__day dates__day--idle"></li>
        <el-skeleton-item  v-for="date in daysInMonth.days"
        class="dates__day skeleton__date--borderNone" >
            <span>{{date}}</span>
        </el-skeleton-item>
    </ul>
  </div>
  </template>
 

<template #default>

<div  id="calendar" >
    <div class="buttonsContainer">  
      <el-select
       v-model="valueMonth"
        class="m-10 "
        placeholder="Mes"
       size="large"
       @change="selectMonth($event)">
       <el-option v-for="option in optionsMonth" :key="option.value"  :label = "option.label"  :value = "option.value"/>
       </el-select>

        <div >
        <el-button  @click="lastMonth"><svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  
        <title/>
        
        <g id="Complete">
        
        <g id="F-Chevron">
        
        <polyline fill="none" id="Left" points="15.5 5 8.5 12 15.5 19" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        
        </g>
        
        </g>
        
        </svg></el-button>
        <el-button class="buttonsContainer__btnNextMonth"  @click="nextMonth"><svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  
        <title/>
        
        <g id="Complete">
        
        <g id="F-Chevron">
        
        <polyline fill="none" id="Right" points="8.5 5 15.5 12 8.5 19" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
        
        </g> </g>
  
        </svg></el-button>
        </div>
    
    </div>
    <div><p class="location" >Argentina - Santa Fe <br> {{calendarYear}}</p></div>
   
    <ul class="dates ">

                <li class="dates__nameDay" v-for="nameDay in days"> <span class="dates__day--text dates__day--decorationNone">{{nameDay}} </span></li>
        <li v-for="blank in firstDayOfMonth" class="dates__day dates__day--idle"></li>
        <li v-for="date in daysInMonth.days" @click="openday( date , $event  )"
        :class="{dates__day : true  , 'dates__day--busy' : daysInMonth.notAvailable['day' + date]  || isCurrent(date)   , 'dates__day--active' :  isCurrentDate &&  dateSelected.day == date }"   >
            <span class="dates__day--text">{{date}}</span>
        </li>
    </ul>
  </div>
</template>


</el-skeleton>


  `,
  props: {
    loading: Boolean,
    dateSelected: Object,
  },
  mounted() {
    this.$emit("mountedCalendar", { date: this.dateContext });
  },
  data() {
    return {
      reservedDays: [],
      monthsInSpanish: [
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
      valueMonth: null,
      optionsMonth: [],
    };
  },
  async created() {
    const currentMonth = parseInt((dayjs().get("month") + 1).toString());
    this.valueMonth = this.monthsInSpanish[currentMonth - 1];
    for (let i = 1; i < 4; i++) {
      this.optionsMonth.push({
        value: currentMonth + i,
        label: this.monthsInSpanish[currentMonth + i - 1],
      });
    }
    if (Object.entries(this.dateSelected).length !== 0) {
      this.dateContext = this.dateContext.set(
        "month",
        this.dateSelected.month - 1
      );
      this.dateContext = this.dateContext.set("year", this.dateSelected.year);
      this.valueMonth = this.monthsInSpanish[this.dateSelected.month - 1];
      await this.setEvents(this.dateSelected.month);
    } else {
      const month = dayjs().month() + 1;
      await this.setEvents(month);
    }
  },
  methods: {
    async setEvents(month) {
      fetch(`./backend/getReservedDays.php?month=${month}`)
        .then((response) => response.json())
        .then((response) => {
          this.reservedDays = response;
        });
    },
    isCurrent: function (date) {
      // Estamos en el mismo mes?
      if (
        this.dateContext.get("month") + 1 == this.currentMonth &&
        this.currentYear == this.dateContext.get("year")
      ) {
        // Estamos un dia atras?
        if (date < this.currentDate) {
          return true;
        }
        return false;
      } else {
        // Estamos un año atras?
        if (this.currentYear > this.dateContext.get("year")) {
          return true;
        } else {
          // Estamos  un mes atras?
          if (
            this.dateContext.get("month") + 1 < this.currentMonth &&
            this.currentYear == this.dateContext.get("year")
          ) {
            return true;
          } else {
            return false;
          }
        }
      }
    },

    selectMonth: async function (month) {
      await this.setEvents(month);

      let year = parseInt(dayjs().get("year").toString());
      const currentMonth = parseInt((dayjs().get("month") + 1).toString());

      // Probar si funciona
      if (month < currentMonth) {
        year += 1;
      }

      var t = this;
      t.dateContext = t.dateContext.set("month", month - 1);
      t.dateContext = t.dateContext.set("year", year);

      this.$emit("change-month", {
        type: "change",
        month: month,
        date: t.dateContext,
      });
    },
    nextMonth: async function () {
      var t = this;
      t.dateContext = dayjs(t.dateContext).add(1, "month");
      const indexMonth = t.dateContext.get("month");
      await this.setEvents(indexMonth + 1);
      this.valueMonth = this.monthsInSpanish[indexMonth];
      this.$emit("change-month", {
        type: "next",
        month: indexMonth + 1,
        date: t.dateContext,
      });
    },
    lastMonth: async function () {
      var t = this;
      t.dateContext = dayjs(t.dateContext).subtract(1, "month");
      const indexMonth = t.dateContext.get("month");
      await this.setEvents(indexMonth + 1);
      this.valueMonth = this.monthsInSpanish[indexMonth];
      this.$emit("change-month", {
        type: "last",
        month: indexMonth + 1,
        date: t.dateContext,
      });
    },
    openday: function (date) {
      if (this.daysInMonth.notAvailable["day" + date] || this.isCurrent(date)) {
        return;
      }
      const month = this.dateContext.get("month") + 1;
      const year = this.dateContext.get("year");
      this.$emit("selected", {
        day: date,
        month: month,
        year: year,
      });
    },
  },
  computed: {
    isCurrentDate: function () {
      return (
        this.dateSelected.year == this.calendarYear &&
        this.dateSelected.month == this.calendarMonth &&
        Object.entries(this.dateSelected).length !== 0
      );
    },

    calendarYear: function () {
      var t = this;
      return t.dateContext.format("YYYY");
    },

    calendarMonth: function () {
      var t = this;
      return t.dateContext.month() + 1;
    },

    weekends: function () {
      const weekends = [];
      let context = this.dateContext.startOf("month");

      for (let i = 1; i <= context.daysInMonth(); i++) {
        if (context.day() == 6 || context.day() == 0) {
          const day = context.get("date");
          const month = context.get("month") + 1;
          const year = context.get("year");
          weekends.push({ day, month, year });
        }
        context = context.add(1, "day");
      }

      return weekends;
    },
    daysInMonth: function () {
      var t = this;
      const days = t.dateContext.daysInMonth();
      let daysInMonth;
      var weekendsCalendar = [];

      this.weekends.forEach((weekend) => {
        if (
          weekend.year === this.dateContext.get("year") &&
          weekend.month === this.dateContext.get("month") + 1
        ) {
          weekendsCalendar["day" + weekend.day] = true;
        }
      });

      if (!this.reservedDays) {
        daysInMonth = { days, events: weekendsCalendar };
      } else {
        let reservedDays = [];
        this.reservedDays.forEach((reservedDay) => {
          if (
            parseInt(reservedDay.year) === this.dateContext.get("year") &&
            parseInt(reservedDay.month) === this.dateContext.get("month") + 1
          ) {
            console.log("entro");
            reservedDays["day" + reservedDay.day] = true;
          }
        });
        daysInMonth = {
          days,
          notAvailable: { ...weekendsCalendar, ...reservedDays },
        };
      }

      return daysInMonth;
    },
    firstDayOfMonth: function () {
      var t = this;
      var firstDay = dayjs(t.dateContext).startOf("Month");
      return firstDay.day();
    },
    currentDate: function () {
      var t = this;
      return t.today.get("date");
    },
    currentMonth: function () {
      var t = this;
      return t.today.get("month") + 1;
    },
    currentYear: function () {
      var t = this;
      return t.today.get("year");
    },
  },
  emits: ["selected", "change-month", "mountedCalendar"],
});
