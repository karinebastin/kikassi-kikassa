// console.log("essai");
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

window.FullCalendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
// window.interactionPlugin = interactionPlugin;

document.addEventListener("DOMContentLoaded", () => {
  var calendarEl = document.getElementById("calendrier");

  let calendar = new Calendar(calendarEl, {
    initialView: "dayGridMonth",
    // editable: true,
    // eventSources: [
    //   {
    //     url: "/fc-load-events",
    //     method: "POST",
    //     extraParams: {
    //       filters: JSON.stringify({}),
    //     },
    //     failure: () => {
    //       // alert("There was an error while fetching FullCalendar!");
    //     },
    //   },
    // ],
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    plugins: ["interaction", "dayGrid", "timeGrid"], // https://fullcalendar.io/docs/plugin-index
    timeZone: "UTC",
  });
  calendar.render();
});
