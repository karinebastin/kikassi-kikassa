import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

document.addEventListener("DOMContentLoaded", () => {
  var calendarEl = document.getElementById("calendar");

  var calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    headerToolbar: {
      left: "prev,next",
      center: "title",
      right: "dayGridMonth,listWeek",
    },
    buttonText: {
      today: "Aujourd'hui",
      month: "mois",
      week: "semaine",
      day: "jour",
      list: "liste",
    },
    initialDate: Date.now(),
    locale: "fr",
    firstDay: "1",
    editable: true,
    dayMaxEvents: true,
    eventSources: [
      {
        url: "/fc-load-events",
        method: "POST",
        extraParams: {
          filters: JSON.stringify({}),
        },
        failure: () => {
          alert("There was an error while fetching FullCalendar!");
        },
      },
    ],
    timeZone: "UTC",
  });
  calendar.render();
});
