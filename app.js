const Formulario = {
  data() {
    return {
      turnReserved: [],

      weeklySchedules: [],

      personalInformation: {
        name: null,

        surname: null,
        email: null,

        phone: null,
      },
      events: [],
      errors: {},
      valueName: "Federico",
      // valueApellido
      valueSurname: "Levatti",
      valueMail: "federico.levatti@gmail.com",
      valueArea: "342",
      valuePhone: "5082610",
      title: "Tu info",
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

      valueScheduleSelected: null,
      valueSchedule: null,
      showSchedule: false,
      turnsAvailable: [],

      turns: {
        completedFields: {
          turn: false,

          calendar: false,

          information: false,

          pay: false,
        },
        current: 1,

        turn: false,

        calendar: false,

        information: false,

        confirmPayment: false,
      },

      valueModality: "",

      valueMeeting: "",

      optionsModality: [
        { value: "Online", label: "Consultorio Online" },
        {
          value: "Presencial",
          label: "Consultorio Presencial (Dirección)",
        },
      ],

      optionsMotives: [
        {
          value: "Primera Vez",
          label: "Primera vez",

          price: "3.000,00",
        },
        {
          value: "Seguimiento",
          label: "Seguimiento",
          price: "5.000,00",
        },
        {
          value: "Consulta",
          label: "Consulta",
          price: "3.000,00",
        },
      ],

      date: {},
      loading: true,
      coupon: null,
    };
  },

  computed: {
    // Get 	Day of Week (Sunday as 0, Saturday as 6)
    // Return [0-6]
    // indiceDia
    getDay() {
      const date = new Date(this.date.year, this.date.month - 1, this.date.day);
      const date_dayJS = dayjs(date);
      return date_dayJS.get("day");
    },
  },
  async mounted() {
    switch (this.turns.current) {
      case 1:
        this.turns.turn = true;
        break;
      case 2:
        this.turns.calendar = true;
        break;
      case 3:
        this.turns.information = true;
        break;
      case 4:
        this.turns.confirmPayment = true;
        break;
    }

    const response = await fetch(`./backend/getSchedule.php`);
    const data = await response.json();
    data.forEach((schedule) => {
      let array = this.weeklySchedules[schedule.dayIndex] || [];
      this.weeklySchedules[schedule.dayIndex] = [
        ...array,
        {
          from: schedule.from,
          to: schedule.to,
          select: false,
        },
      ];
    });

    //setTimeout(() => {
    this.loading = false;
    //}, 2000);
  },
  methods: {
    async setBusyShifts(month, year) {
      const response = await fetch(
        `./backend/getReservedShifts.php?month=${month}&year=${year}`
      );
      const data = await response.json();
      let busyShifts = [];
      data.forEach((e) => {
        let oldValue = busyShifts[e.day] || [];
        busyShifts[e.day] = [...oldValue, e];
      });
      this.turnReserved = busyShifts;
    },

    async initialCalendar({ date }) {
      const month = date.get("month") + 1;
      const year = date.get("year");
      await this.setBusyShifts(month, year);
    },
    getDayByDate({ year, month, day }) {
      const date = new Date(year, month - 1, day);
      const date_dayJS = dayjs(date);
      return date_dayJS.get("day");
    },
    async valueChange(e) {
      switch (e.type) {
        case "modality":
          this.valueModality = e.value;
          break;
        case "meeting":
          this.valueMeeting = e.value;
          break;
        case "name":
          this.valueName = e.value;
          break;
        case "surname":
          this.valueSurname = e.value;
          break;
        case "email":
          this.valueMail = e.value;
          break;
        case "area":
          this.valueArea = e.value;
          break;
        case "phone":
          this.valuePhone = e.value;
          break;
        case "coupon":
          this.coupon = e.value;
          const response = await fetch(
            `./backend/getPatient.php?id=${this.coupon.id_patient}`
          );
          const data = await response.json();
          const patient = data[0];
          this.valueName = patient.name.trim();
          this.valueSurname = patient.surname.trim();
          this.valueMail = patient.mail.trim();
          this.valueArea = patient.phone.split("-")[0];
          this.valuePhone = patient.phone.split("-")[1];
          this.personalInformation.name = this.valueName;
          this.personalInformation.surname = this.valueSurname;
          this.personalInformation.email = this.valueMail;
          this.personalInformation.phone =
            "+" + this.valueArea + " " + this.valuePhone;
          break;
      }
    },
    post(path, params, method = "POST") {
      const form = document.createElement("form");
      form.method = method;
      form.action = path;
      for (const key in params) {
        if (params.hasOwnProperty(key)) {
          const hiddenField = document.createElement("input");
          hiddenField.type = "hidden";
          hiddenField.name = key;
          hiddenField.value = params[key];
          form.appendChild(hiddenField);
        }
      }
      document.body.appendChild(form);
      form.submit();
    },
    async changeMonth(e) {
      this.loading = true;
      const month = e.date.get("month") + 1;
      const year = e.date.get("year");
      await this.setBusyShifts(month, year);
      this.showSchedule = false;
      //setTimeout(() => {
      this.loading = false;
      if (this.date.month == e.month) {
        this.showSchedule = true;
      }
      //}, 2000);
    },

    async selectDate(date) {
      let busyShifts = this.turnReserved[date.day];
      if (busyShifts) {
        this.turnsAvailable = this.weeklySchedules[
          this.getDayByDate(date)
        ].filter((date) => {
          let find = true;
          busyShifts.forEach((e) => {
            if (e.from == date.from) {
              find = false;
            }
          });

          return find;
        });
      } else {
        this.turnsAvailable = this.weeklySchedules[this.getDayByDate(date)];
      }

      if (this.valueScheduleSelected) {
        let find = false;

        this.turnsAvailable.forEach((e) => {
          if (e.from == this.valueScheduleSelected.from) {
            find = true;
            e.select = true;
            this.valueSchedule =
              "" +
              this.monthsInSpanish[date.month - 1] +
              " " +
              date.day +
              ",  " +
              date.year +
              " - " +
              e.from;
            this.valueScheduleSelected = {
              from: e.from,
              to: e.to,
              select: e.select,
            };
          } else {
            e.select = false;
          }
        });

        if (!find) {
          this.turnsAvailable[0] = {
            ...this.turnsAvailable[0],
            select: true,
          };

          this.valueSchedule =
            "" +
            this.monthsInSpanish[date.month - 1] +
            " " +
            date.day +
            ",  " +
            date.year +
            " - " +
            this.turnsAvailable[0].from;

          this.valueScheduleSelected = {
            from: this.turnsAvailable[0].from,
            to: this.turnsAvailable[0].to,
            select: this.turnsAvailable[0].select,
          };
        }
      } else {
        this.turnsAvailable.forEach((turn, index) => {
          if (index == 0) {
            turn.select = true;
          } else {
            turn.select = false;
          }
        });

        this.valueSchedule =
          "" +
          this.monthsInSpanish[date.month - 1] +
          " " +
          date.day +
          ",  " +
          date.year +
          " - " +
          this.turnsAvailable[0].from;
        this.valueScheduleSelected = {
          from: this.turnsAvailable[0].from,
          to: this.turnsAvailable[0].to,
          select: this.turnsAvailable[0].select,
        };
      }

      if (
        this.date.year === date.year &&
        this.date.day === date.day &&
        this.date.month === date.month
      ) {
        this.date = {};
        this.valueScheduleSelected = "";
        this.valueSchedule = "";
        this.showSchedule = false;
        return;
      }

      this.date = date;

      if (!this.showSchedule) {
        this.showSchedule = true;
      }
    },
    selectSchedule({ date, schedule }) {
      this.turnsAvailable.forEach((e) => {
        if (e.from != schedule.from) {
          e.select = false;
        } else {
          e.select = true;
        }
      });
      this.valueScheduleSelected = schedule;
      this.valueSchedule =
        "" +
        this.monthsInSpanish[date.month - 1] +
        " " +
        date.day +
        ",  " +
        date.year +
        " - " +
        schedule.from;
    },
    next(page) {
      if (this.loading) {
        return;
      }
      switch (page) {
        case 1:
          this.errors.modality = null;
          this.errors.meeting = null;
          if (!this.valueModality) {
            this.errors.modality = "Seleccione una opcion";
          }
          if (!this.valueMeeting) {
            this.errors.meeting = "Seleccione una opcion";
          }
          if (this.errors.meeting || this.errors.modality) {
            return;
          }

          this.turns.turn = false;

          this.turns.current++;
          this.turns.calendar = true;
          this.turns.completedFields.turn = true;
          this.title = "Fecha y Hora";

          break;
        case 2:
          if (!this.date || !this.valueSchedule) {
            return;
          }
          this.turns.calendar = false;
          this.turns.current++;
          this.turns.information = true;
          this.turns.completedFields.calendar = true;
          this.title = "Tu info";

          break;
        case 3:
          const validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
          this.errors.name = null;
          this.errors.surname = null;
          this.errors.mail = null;
          this.errors.phone = null;
          if (!this.valueName) {
            this.errors.name = "Ingrese su nombre";
          }
          if (!this.valueSurname) {
            this.errors.surname = "Ingrese su apellido";
          }
          if (!this.valueMail || !validEmail.test(this.valueMail)) {
            this.errors.mail = "Ingrese su Mail";
          }
          if (
            !this.valueArea ||
            !this.valuePhone ||
            !Number(this.valueArea) ||
            !Number(this.valuePhone) ||
            String(this.valueArea).length < 2 ||
            String(this.valueArea).length > 4 ||
            String(this.valuePhone).length > 8 ||
            String(this.valuePhone).length < 6
          ) {
            this.errors.phone = "Ingrese su telefono / celular";
          }
          if (
            this.errors.name ||
            this.errors.surname ||
            this.errors.mail ||
            this.errors.phone
          ) {
            return;
          }

          this.turns.current++;
          this.personalInformation.name = this.valueName;
          this.personalInformation.surname = this.valueSurname;
          this.personalInformation.email = this.valueMail;
          this.personalInformation.phone =
            "+" + this.valueArea + " " + this.valuePhone;
          this.turns.information = false;

          this.turns.completedFields.information = true;
          this.turns.confirmPayment = true;
          this.title = "Confirmar pago";

          break;
        case 4:
          let price;
          this.optionsMotives.forEach((e) => {
            if (e.value === this.valueMeeting) {
              price = e.price.replaceAll(".", "");
              price = price.split(",")[0];
            }
          });
          let formData = {
            name: this.valueName.trim(),
            surname: this.valueSurname.trim(),
            mail: this.valueMail.trim(),
            phone: "" + this.valueArea.trim() + "-" + this.valuePhone.trim(),
            schedule: JSON.stringify({
              from: this.valueScheduleSelected.from.trim(),
              to: this.valueScheduleSelected.to.trim(),
              indexDay: this.getDay,
            }),
            date: JSON.stringify({
              ...this.date,
              nameMonth: this.monthsInSpanish[this.date.month - 1].trim(),
            }),
            modality: this.valueModality.trim(),
            meeting: this.valueMeeting.trim(),
            price,
          };

          if (this.coupon) {
            formData = {
              ...formData,
              MP_identifier: this.coupon.MP_identifier,
            };

            this.post("./backend/createReservation.php", formData);
          } else {
            this.post("./pago/pagoPro.php", formData);
          }
      }
    },
    back(page) {
      switch (page) {
        case 2:
          this.turns.turn = true;
          this.turns.current--;
          this.turns.calendar = false;
          this.title = "Tu turno";
          break;
        case 3:
          this.turns.information = false;
          this.turns.calendar = true;
          this.turns.current--;
          this.title = "Fecha y Hora";
          break;
        case 4:
          this.turns.current--;
          this.turns.confirmPayment = false;
          this.turns.information = true;
          this.title = "Tu info";
          break;
      }
    },
  },
};

const App = Vue.createApp(Formulario);
App.use(ElementPlus);
