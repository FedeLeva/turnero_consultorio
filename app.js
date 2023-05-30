const Formulario = {
  data() {
    return {
      turnosReservados: {},
      horariosSemanales: [],
      datePersonal: {
        nombre: null,
        apellido: null,
        email: null,
        telefono: null,
      },
      eventos: [],
      activeHorario: false,
      errors: {},
      valueNombre: "Federico",
      valueApellido: "Levatti",
      valueMail: "federico.levatti@hotmail.com",
      valueArea: "342",
      valueTelefono: "5082610",
      title: "Tu info",
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
      valueHorarioSelected: null,
      valueHorario: null,
      horario: false,
      turnosDisponibles: [],
      turnos: {
        camposCompletados: {
          turno: false,
          calendario: false,
          info: false,
          pago: false,
        },
        actual: 2,
        turno: false,
        calendario: true,
        info: false,
        confirmarPago: false,
      },
      valueModalidad: "Online",
      valueEncuentro: "Primera Vez",
      optionsModalidad: [
        { value: "Online", label: "Consultorio Online" },
        {
          value: "Presencial",
          label: "Consultorio Presencial (Dirección)",
        },
      ],
      optionsMotivo: [
        {
          value: "Primera Vez",
          label: "Primera vez",
          precio: "3.000,00",
        },
        {
          value: "Seguimiento",
          label: "Seguimiento",
          precio: "5.000,00",
        },
        {
          value: "Consulta",
          label: "Consulta",
          precio: "3.000,00",
        },
      ],
      fecha: {},
      loading: true,
    };
  },

  computed: {
    indiceDia() {
      const date = new Date(this.fecha.año, this.fecha.mes - 1, this.fecha.dia);
      const fecha = dayjs(date);
      return fecha.get("day");
    },
  },
  async mounted() {
    const response = await fetch(`./backend/getHorarios.php`);
    const data = await response.json();
    data.forEach((e) => {
      let array = this.horariosSemanales[e.indice_dia] || [];

      this.horariosSemanales[e.indice_dia] = [
        ...array,
        {
          desde: e.desde,
          hasta: e.hasta,
          select: false,
        },
      ];
    });

    setTimeout(() => {
      this.loading = false;
    }, 2000);
  },
  methods: {
    async initialCalendar({ date }) {
      const month = date.get("month") + 1;
      const year = date.get("year");
      const response = await fetch(
        `./backend/getTurnos.php?month=${month}&year=${year}`
      );
      const data = await response.json();
      let turnos_ocupados = [];
      data.forEach((e) => {
        let oldValue = turnos_ocupados[e.dia] || [];
        turnos_ocupados[e.dia] = [...oldValue, e];
      });
      this.turnosReservados = turnos_ocupados;
    },
    getDay(fecha) {
      const date = new Date(fecha.año, fecha.mes - 1, fecha.dia);
      const fechaDay = dayjs(date);
      return fechaDay.get("day");
    },
    changeValue(e) {
      switch (e.tipo) {
        case "modalidad":
          this.valueModalidad = e.valor;
          break;
        case "encuentro":
          this.valueEncuentro = e.valor;
          break;
        case "nombre":
          this.valueNombre = e.valor;
          break;
        case "apellido":
          this.valueApellido = e.valor;
          break;
        case "email":
          this.valueMail = e.valor;
          break;
        case "area":
          this.valueArea = e.valor;
          break;
        case "telefono":
          this.valueTelefono = e.valor;
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
    async cambiarMes(e) {
      this.loading = true;
      const month = e.date.get("month") + 1;
      const year = e.date.get("year");
      const response = await fetch(
        `./backend/getTurnos.php?month=${month}&year=${year}`
      );
      const data = await response.json();
      let turnos_ocupados = [];
      data.forEach((e) => {
        let oldValue = turnos_ocupados[e.dia] || [];
        turnos_ocupados[e.dia] = [...oldValue, e];
      });
      this.turnosReservados = turnos_ocupados;
      this.horario = false;
      setTimeout(() => {
        this.loading = false;

        if (this.fecha.mes == e.mes) {
          this.horario = true;
        }
      }, 2000);
    },
    async selectedFecha(date) {
      let turnos_ocupados = this.turnosReservados[date.dia];
      if (turnos_ocupados) {
        this.turnosDisponibles = this.horariosSemanales[
          this.getDay(date)
        ].filter((elemento) => {
          let find = true;
          turnos_ocupados.forEach((e) => {
            if (e.desde == elemento.desde) {
              find = false;
            }
          });

          return find;
        });
      } else {
        this.turnosDisponibles = this.horariosSemanales[this.getDay(date)];
      }

      if (this.valueHorarioSelected) {
        let encontro = false;

        this.turnosDisponibles.forEach((e) => {
          if (e.desde == this.valueHorarioSelected.desde) {
            encontro = true;
            e.select = true;
            this.valueHorario =
              "" +
              this.meses[date.mes - 1] +
              " " +
              date.dia +
              ",  " +
              date.año +
              " - " +
              e.desde;
            this.valueHorarioSelected = {
              desde: e.desde,
              hasta: e.hasta,
              select: e.select,
            };
          } else {
            e.select = false;
          }
        });

        if (!encontro) {
          this.turnosDisponibles[0] = {
            ...this.turnosDisponibles[0],
            select: true,
          };

          this.valueHorario =
            "" +
            this.meses[date.mes - 1] +
            " " +
            date.dia +
            ",  " +
            date.año +
            " - " +
            this.turnosDisponibles[0].desde;

          this.valueHorarioSelected = {
            desde: this.turnosDisponibles[0].desde,
            hasta: this.turnosDisponibles[0].hasta,
            select: this.turnosDisponibles[0].select,
          };
        }
      } else {
        this.turnosDisponibles[0] = {
          ...this.turnosDisponibles[0],
          select: true,
        };

        this.valueHorario =
          "" +
          this.meses[date.mes - 1] +
          " " +
          date.dia +
          ",  " +
          date.año +
          " - " +
          this.turnosDisponibles[0].desde;

        this.valueHorarioSelected = {
          desde: this.turnosDisponibles[0].desde,
          hasta: this.turnosDisponibles[0].hasta,
          select: this.turnosDisponibles[0].select,
        };
      }

      if (
        this.fecha.año === date.año &&
        this.fecha.dia === date.dia &&
        this.fecha.mes === date.mes
      ) {
        this.fecha = {};
        this.valueHorarioSelected = "";
        this.valueHorario = "";
        this.horario = false;
        return;
      }

      this.fecha = date;

      if (this.horario) {
      } else {
        this.horario = true;
      }
    },

    selectedHorario({ evento, fecha, horario }) {
      this.turnosDisponibles.forEach((e) => {
        if (e.desde != horario.desde) {
          e.select = false;
        } else {
          e.select = true;
        }
      });
      this.valueHorarioSelected = horario;
      this.valueHorario =
        "" +
        this.meses[fecha.mes - 1] +
        " " +
        fecha.dia +
        ",  " +
        fecha.año +
        " - " +
        horario.desde;
    },
    next(page) {
      if (this.loading) {
        return;
      }

      switch (page) {
        case 1:
          this.errors.modalidad = null;
          this.errors.encuentro = null;
          if (!this.valueModalidad) {
            this.errors.modalidad = "Seleccione una opcion";
          }
          if (!this.valueEncuentro) {
            this.errors.encuentro = "Seleccione una opcion";
          }
          if (this.errors.encuentro || this.errors.modalidad) {
            return;
          }

          this.turnos.turno = false;

          this.turnos.actual++;
          this.turnos.calendario = true;
          this.turnos.camposCompletados.turno = true;
          this.title = "Fecha y Hora";

          break;
        case 2:
          if (!this.fecha || !this.valueHorario) {
            return;
          }
          this.turnos.calendario = false;
          this.turnos.actual++;
          this.turnos.info = true;
          this.turnos.camposCompletados.calendario = true;
          this.title = "Tu info";

          break;
        case 3:
          const validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
          this.errors.nombre = null;
          this.errors.apellido = null;
          this.errors.mail = null;
          this.errors.telefono = null;
          if (!this.valueNombre) {
            this.errors.nombre = "Ingrese su nombre";
          }
          if (!this.valueApellido) {
            this.errors.apellido = "Ingrese su apellido";
          }
          if (!this.valueMail || !validEmail.test(this.valueMail)) {
            this.errors.mail = "Ingrese su Mail";
          }
          if (
            !this.valueArea ||
            !this.valueTelefono ||
            !Number(this.valueArea) ||
            !Number(this.valueTelefono) ||
            String(this.valueArea).length < 2 ||
            String(this.valueArea).length > 4 ||
            String(this.valueTelefono).length > 8 ||
            String(this.valueTelefono).length < 6
          ) {
            this.errors.telefono = "Ingrese su telefono / celular";
          }
          if (
            this.errors.nombre ||
            this.errors.apellido ||
            this.errors.mail ||
            this.errors.telefono
          ) {
            return;
          }

          this.turnos.actual++;
          this.datePersonal.nombre = this.valueNombre;
          this.datePersonal.apellido = this.valueApellido;
          this.datePersonal.email = this.valueMail;
          this.datePersonal.telefono =
            "+" + this.valueArea + " " + this.valueTelefono;
          this.turnos.info = false;

          this.turnos.camposCompletados.info = true;
          this.turnos.confirmarPago = true;
          this.title = "Confirmar pago";

          break;
        case 4:
          let precio;
          this.optionsMotivo.forEach((e) => {
            if (e.value === this.valueEncuentro) {
              precio = e.precio.replaceAll(".", "");
              precio = precio.split(",")[0];
            }
          });

          this.post("./pago/checkout2.php", {
            nombre: this.valueNombre,
            apellido: this.valueApellido,
            email: this.valueMail,
            telefono: "" + this.valueArea + this.valueTelefono,
            horario: JSON.stringify({
              desde: this.valueHorarioSelected.desde,
              hasta: this.valueHorarioSelected.hasta,
              indice: this.indiceDia,
            }),
            fecha: JSON.stringify({
              ...this.fecha,
              nombreMes: this.meses[this.fecha.mes - 1],
            }),
            modalidad: this.valueModalidad,
            encuentro: this.valueEncuentro,
            precio,
          });
      }
    },
    back(page) {
      switch (page) {
        case 2:
          this.turnos.turno = true;
          this.turnos.actual--;
          this.turnos.calendario = false;
          this.title = "Tu turno";
          break;
        case 3:
          this.turnos.info = false;
          this.turnos.calendario = true;
          this.turnos.actual--;
          this.title = "Fecha y Hora";
          break;
        case 4:
          this.turnos.actual--;
          this.turnos.confirmarPago = false;
          this.turnos.info = true;
          this.title = "Tu info";
          break;
      }
    },
  },
};

const App = Vue.createApp(Formulario);
App.use(ElementPlus);
