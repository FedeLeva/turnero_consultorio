App.component("horario-personalizado", {
  emits: ["seleccionoHorario"],
  methods: {
    seleccionoHo(evento, fecha, horario) {
      this.$emit("seleccionoHorario", { evento, fecha, horario });
    },
  },
  updated() {
    const contenedor = document.getElementById("turno");
    contenedor.scrollIntoView({
      behavior: "smooth",
    });
  },
  mounted() {
    const contenedor = document.getElementById("turno");
    contenedor.scrollIntoView({
      behavior: "smooth",
    });
  },
  props: {
    fecha: Object,
    turnosDisponibles: Array,
  },
  template: `     <div id="turno" style="margin-top:50px;margin-bottom:30px" ><p style="margin-bottom: 10px">
  {{fecha.dia}}/{{fecha.mes}}/{{fecha.año}}
</p>
<div
style="
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
"
>
<div
  class="btn-horario"
  v-for="(horario,index) in turnosDisponibles"
  @click="seleccionoHo($event , fecha , horario)"
  :class="{horarioSelected : horario.select }"
>
  {{horario.desde}} -- {{horario.hasta}}
</div>
</div> </div>`,
});
