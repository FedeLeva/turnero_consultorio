App.component("custom-schedule", {
  emits: ["selectedSchedule"],

  methods: {
    selectedSchedule(event, date, schedule) {
      this.$emit("selectedSchedule", { event, date, schedule });
    },
  },
  updated() {
    const shiftsContainer = document.getElementById("schedule");
    shiftsContainer.scrollIntoView({
      behavior: "smooth",
    });
  },
  mounted() {
    const shiftsContainer = document.getElementById("schedule");
    shiftsContainer.scrollIntoView({
      behavior: "smooth",
    });
  },
  props: {
    date: Object,
    turnsAvailable: Array,
  },
  template: `     <div id="schedule"  >
  <p  class="schedule__date">
  {{date.day}}/{{date.month}}/{{date.year}}
</p>
<div
  class="schedule__scheduleContainer"
>
<div
  class="schedule__btnSchedule"
  v-for="(schedule,index) in turnsAvailable"
  @click="selectedSchedule($event , date , schedule)"
  :class="{'schedule__btnSchedule--selected' : schedule.select }"
>
  {{schedule.from}} -- {{schedule.to}}
</div>
</div> </div>`,
});
