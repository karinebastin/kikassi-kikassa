import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var dataDate = document.getElementById("data");
  var data = dataDate.firstChild.data;
  console.log(data);
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
    navLinks: true, // can click day/week names to navigate views
    editable: true,
    dayMaxEvents: true, // allow "more" link when too many events
    events: data,
    // events: [
    //   {
    //     id: 1,
    //     start: "2021-04-28",
    //     end: "2021-04-29",
    //     title: "essai",
    //     description: "essai",
    //     backgroundColor: "#2f53c1",
    //     borderColor: "#9e1010",
    //     textColor: "#000000",
    //     AllWeek: false,
    //   },
    //   {
    //     id: 2,
    //     start: "2021-04-30",
    //     end: "2021-05-01",
    //     title: "essai",
    //     description: "essai2",
    //     backgroundColor: "#7fa428",
    //     borderColor: "#1d8b6f",
    //     textColor: "#faf9f9",
    //     AllWeek: false,
    //   },
    // ],
  });

  calendar.render();
});
