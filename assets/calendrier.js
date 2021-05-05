import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import bootstrap from "@fullcalendar/bootstrap";

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
    // dayMaxEvents: true,
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

    events: [
      {
        groupId: "association ouverte", // recurrent events in this group move together
        daysOfWeek: ["3", "6"],
        display: "background",
        color: "#5c995e",
      },
    ],

    timeZone: "UTC",
  });
  calendar.render();
});
