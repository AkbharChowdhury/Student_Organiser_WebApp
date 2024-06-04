
const calendarOptions = Object.freeze({
  viewOptions: "today,month,listWeek,listMonth",
  navButtons: "prev,next"
});

let errors = [];
const requiredFieldsIsEmpty = (requiredFields) =>!Object.values(requiredFields).every((value) => value);
const instructionsDiv = document.querySelector("#instructions");

const updateClassForm = document.querySelector("#updateClassForm");
const customTooltip = ".custom-tooltip";
const modal = (id) => bootstrap.Modal.getInstance(document.getElementById(id));
const titleCase = (str) => str.toLowerCase().split(" ").map((word) => word.replace(word[0], word[0].toUpperCase())).join(" ");
function removeBootstrapValidation() {
  let removeValidation = document.getElementsByClassName("needs-validation");
  for (let i = 0; i < removeValidation.length; i++) {
    removeValidation[i].classList.remove("was-validated");
  }
}

function deleteClass() {
  $("#btnDeleteClass").on("click", (e) => {
    e.preventDefault();
    Swal.fire({
      title: "Are you sure you want to delete this class?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "deleteClass.inc.php",
          data: {
            class_id: $("#class_id").attr("value"),
          },
          success: function (response) {
            if (Boolean(response)) {
              $("#viewEditClassDetails").modal("hide");
              getCalendarKey("academic");

              academicCalendar.fullCalendar("refetchEvents");
              Swal.fire("deleted!", `class deleted`, "success");

              return;
            }
            Swal.fire("unable to delete class!", `class error`, "danger");
          },
          error: (xhr) => console.error(xhr.responseText),
        }); // ajax
      } // confirm
    }); // swal
  }); // click event
}

// ACADEMIC CALENDAR DATE_TIME PICKER
function showCustomTimePicker(editedClassStartTime, editedClassEndTime) {
  const startTime = $("#addClassForm #start_time").flatpickr({
    enableTime: true,

    allowInput: true,
    dateFormat: "H:i", // format for database input
    altInput: false,
    altFormat: "(h:i K)", // used to display the date and time in a user friendly format
    noCalendar: true,
    defaultHour: new Date().getHours(),
    defaultMinute: new Date().getMinutes(),
    defaultDate: "09:00",
    onChange: (selectedDates, dateStr, instance) =>
      endTime.set("minDate", dateStr), // validate startTime
  });

  const endTime = $("#addClassForm #end_time").flatpickr({
    enableTime: true,
    allowInput: true,
    dateFormat: "H:i", // format for database input
    altInput: false,
    altFormat: "(h:i K)", // used to display the date and time in a user friendly format
    noCalendar: true,
    defaultDate: "17:00",
    onChange: (selectedDates, dateStr, instance) =>
      startTime.set("maxDate", dateStr), // validate endTime
  });

  const editedStartTime = $("#updateClassForm #start_time").flatpickr({
    allowInput: true,
    enableTime: true,
    dateFormat: "H:i", // format for database input
    altInput: false,
    altFormat: "(h:i K)", // used to display the date and time in a user friendly format
    noCalendar: true,
    defaultHour: new Date().getHours(),
    defaultMinute: new Date().getMinutes(),
    // defaultDate: 'today',
    defaultDate: "09:00",
    onChange: (selectedDates, dateStr, instance) =>
      editedEndTime.set("minDate", dateStr), // validate startTime
  });

  const editedEndTime = $("#updateClassForm #end_time").flatpickr({
    allowInput: true,

    enableTime: true,
    dateFormat: "H:i", // format for database input
    altInput: false,
    altFormat: "(h:i K)", // used to display the date and time in a user friendly format
    noCalendar: true,
    defaultHour: new Date().getHours(),
    defaultMinute: new Date().getMinutes(),
    defaultDate: "09:00",
    onChange: (selectedDates, dateStr, instance) =>
      editedStartTime.set("maxDate", dateStr), // validate endTime
    onReady: (dateObj, dateStr, instance) =>
      editedStartTime.set(
        "maxDate",
        moment($("#updateClassForm #start_time").val()).format("HH:mm")
      ),
  });

  if (editedClassStartTime) editedStartTime.setDate(editedClassStartTime);
  if (editedClassEndTime) editedEndTime.setDate(editedClassEndTime);
}

$(document).ready(function () {
  // delete selected class
  $("#btnDeleteClass").on("click", (e) => {
    e.preventDefault();
    Swal.fire({
      title: "Are you sure you want to delete this class?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "deleteClass.inc.php",
          data: {
            class_id: $("#class_id").attr("value"),
          },
          success: function (response) {
            if (Boolean(response)) {
              $("#viewEditClassDetails").modal("hide");
              academicCalendar.fullCalendar("refetchEvents");
              Swal.fire("deleted!", `class deleted`, "success");
              return;
            }
            Swal.fire("unable to delete class!", `class error`, "danger");
          },
          error: (xhr) => console.error(xhr.responseText),
        }); // ajax
      } // confirm
    }); // swal
  }); // click event

  // add academic classes
  const addClassForm = document.querySelector("#addClassForm");
  const addClassModal = document.querySelector("#addClassesModal");
  let moduleID = document.querySelector("#module_id");
  let typeID = document.querySelector("#type_id");
  let semesterID = document.querySelector("#semester_id");

  async function addClassDetails(form) {
    try {
      const response = await fetch("add_class_details.inc.php", {
        method: "POST",
        body: new FormData(form),
      });

      const data = await response.text();

      // check if url is found
      if (!response.ok) {
        modal("addClassesModal").hide();
        Swal.fire("unable to add class!", "class error", "error");
        return;
      }
      if (Boolean(data)) {
        form.reset();
        removeBootstrapValidation();
        modal("addClassesModal").hide();
        getCalendarKey("academic");
        academicCalendar.fullCalendar("refetchEvents");
        Swal.fire("class added!", "class added", "success");
        return;
      }
    } catch (error) {
      console.error(`there was a problem adding classes ${error.message}`);
    }
  }

  if (addClassForm) {
    addClassForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const form = e.target.id;
      const requiredFields = Object.freeze({
        module_id: document.querySelector(`#${form} #module_id`).value.trim(),
        semester_id: document
          .querySelector(`#${form} #semester_id`)
          .value.trim(),
        campus_id: document.querySelector(`#${form} #campus_id`).value.trim(),
        day_id: document.querySelector(`#${form} #day_id`).value.trim(),
        start_time: document.querySelector(`#${form} #start_time`).value.trim(),
        end_time: document.querySelector(`#${form} #end_time`).value.trim(),
        day_id: document.querySelector(`#${form} #day_id`).value.trim(),
        colour: document.querySelector(`#${e.target.id} #colour`).value.trim(),
        type_id: document.querySelector(`#${form} #type_id`).value.trim(),
      });

      if (!requiredFieldsIsEmpty(requiredFields) && !checkDuplicateClasses()) {
        addClassDetails(addClassForm);
        return true;
      }
    });
  }

  function checkDuplicateClasses() {
    let returnValue;
    $.ajax({
      async: false, // required to return a value
      type: "POST",
      url: "checkDuplicateClasses.inc.php",
      data: {
        module_id: $("#module_id").val(),
        type_id: $("#type_id").val(),
        semester_id: $("#semester_id").val(),
      },
      success: function (data) {
        returnValue = Boolean(data);
      },
    });
    return returnValue;
  }
  // check duplicate on change for add classes form
  $(".module_id, .type_id, .semester_id").on("change", () => {
    if (moduleID.value && typeID.value && semesterID.value) {
      if (checkDuplicateClasses()) {
        $(".module_id_error").text(
          "you have already entered a class for this module and the class type"
        );
        $(".module_id").addClass("error");
        return;
      }

      // remove error
      $(".module_id_error").text("");
      $(".module_id").removeClass("error");
    }
  });

  // Academic and personal Calendars
  // Academic
  function constructAcademicCalender() {

    async function getEventDetails(event) {
      try {
        const response = await fetch(
          "academic_calendar_event_details.inc.php",

          {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
              class_id: event.id,
              isCoursework: event.isCoursework,
            }),
          }
        );
        const data = await response.text();
        if (!response.ok) {
          Swal.fire("unable to get classes details!", "class error", "error");
          return;
        }

        document.getElementById("viewClasses").innerHTML = data;
        $("#viewEditClassDetails").modal("show");
        //showTimepicker();
        deleteClass(); // if delete button was clicked
        let startTime = document.querySelector(
          "#updateClassForm #start_time"
        ).value;
        let endTime = document.querySelector(
          "#updateClassForm #end_time"
        ).value;

        showCustomTimePicker(startTime, endTime);

        $("[readonly]").prop("disabled", true);

        $("#updateClassForm").on("submit", function (e) {
          e.preventDefault();
          const form = e.target.id;
          const requiredFields = Object.freeze({
            module_id: document
              .querySelector(`#${form} #module_id`)
              .value.trim(),
            semester_id: document
              .querySelector(`#${form} #semester_id`)
              .value.trim(),
            campus_id: document
              .querySelector(`#${form} #campus_id`)
              .value.trim(),
            day_id: document.querySelector(`#${form} #day_id`).value.trim(),
            start_time: document
              .querySelector(`#${form} #start_time`)
              .value.trim(),
            end_time: document.querySelector(`#${form} #end_time`).value.trim(),
            day_id: document.querySelector(`#${form} #day_id`).value.trim(),
            colour: document.querySelector(`#${form} #colour`).value.trim(),
            type_id: document.querySelector(`#${form} #type_id`).value.trim(),
          });

          if (
            !requiredFieldsIsEmpty(requiredFields) &&
            !checkDuplicateClasses()
          ) {
            $("[readonly]").prop("disabled", false);
            updateClassDetails(document.querySelector("#updateClassForm"));
          }

          async function updateClassDetails(form, fd) {
            try {
              const response = await fetch("update_class_details.inc.php", {
                method: "POST",
                headers: new Headers({
                  Accept: "application/json",
                  "Content-Type": "application/x-www-form-urlencoded",
                }),

                body: new URLSearchParams({
                  class_id: document.querySelector("#updateClassForm #class_id")
                    .value,
                  module_id: document.querySelector(
                    "#updateClassForm #module_id"
                  ).value,
                  semester_id: document.querySelector(
                    "#updateClassForm #semester_id"
                  ).value,
                  day_id: document.querySelector("#updateClassForm #day_id")
                    .value,
                  campus_id: document.querySelector(
                    "#updateClassForm #campus_id"
                  ).value,
                  start_time: document.querySelector(
                    "#updateClassForm #start_time"
                  ).value,
                  end_time: document.querySelector("#updateClassForm #end_time")
                    .value,
                  room: document.querySelector("#updateClassForm #room").value,
                  colour: document.querySelector("#updateClassForm #colour")
                    .value,
                  type_id: document.querySelector("#updateClassForm #type_id")
                    .value,
                }),
              });

              const data = await response.text();

              // check if url is found
              if (!response.ok) {
                modal("viewEditClassDetails").hide();
                Swal.fire(
                  "unable to edit the class detsails class!",
                  "class error",
                  "error"
                );
                return;
              }

              if (Boolean(data)) {
                form.reset();
                removeBootstrapValidation();
                getCalendarKey("academic");
                modal("viewEditClassDetails").hide();
                academicCalendar.fullCalendar("refetchEvents");
                Swal.fire("class updated!", "class updated", "success");
                return;
              }
            } catch (error) {
              console.error(
                `there was a problem updating classes ${error.message}`
              );
            }
          }
        });
      } catch (error) {
        console.error(
          `there was a problem fetching class details ${error.message}`
        );
      }
    }




    //
    $.ajax({

      type: "POST",
      url: "students_classes_details.inc.php",
      data: {
        personal_event_id: $("#personal_calendar_id").attr("value"),
      },
      success: function (response) {
        // let data =  response.filter((i) => i.isCoursework == false);
        let data = JSON.parse(response);
        let d = data.filter(i=> Boolean(i['isCoursework']) == true)
        console.log(d)


      },
      error: (xhr) => console.error(xhr.responseText),
    }); // ajax

    academicCalendar = $("#academic_calendar").fullCalendar({
      events: "students_classes_details.inc.php",
      // properties
      eventLimit: true, // allow "more" link when too many events
      selectable: true,
      selectHelper: true,
      timeFormat: "h:mma",
      defaultView: "month",
      scrollTime: "08:00", // undo default 6am scrollTime
      eventOverlap: false,
      allDaySlot: false,

      header: {
        left: calendarOptions.navButtons,
        center: "title",
        right: calendarOptions.viewOptions,
      },
      views: {
        listDay: {
          buttonText: "List day",
        },
        listWeek: {
          buttonText: "List week",
        },
        listMonth: {
          buttonText: "List month",
        },
        month: {
          buttonText: "Month",
        },
        today: {
          buttonText: "Today",
        },
        agendaWeek: {
          buttonText: "Week",
        },
      },

      // get start and end dates for classes
      eventRender: (event) => {
        if (event.ranges) {
          return (event.ranges.filter(function (range) {
              return (
                moment(event.start).isBefore(range.end) &&
                moment(event.end).isAfter(range.start)
              );
            }).length > 0
          );
         
        } else {
           // show coursework deadlines
          return true;
        }
      },
      // show tooltip based on if the event is a coursework
      eventMouseover: (event) => {
        let tooltip;
        if (Boolean(event.isCoursework)) {
          tooltip = `<div class="${customTooltip.substring(1)}">
                        ${event.title}: <strong>${titleCase(
            event.cwTitle
          )}</strong> <br>
                         Deadline: <strong>${event.due}</strong>
                  </div>`;
        } else {
          tooltip = `<div class="${customTooltip.substring(1)}">
                  ${event.type}: <strong>${titleCase(event.title)}</strong> <br>
                  Time: <strong>${moment(event.start).format(
                    "HH:mma"
                  )} - ${moment(event.end).format("HH:mma")}</strong> <br>
                  Duration:  <strong>${event.duration}</strong> <br>
                  teachers: <strong>${event.teacher_name}</strong></strong> <br>
                  class type: <strong>${event.type}</strong> <br>
                   Room: <strong>${
                     event.room !== "" ? event.room : "No room added"
                   }</strong>  
              </div>`;
        }

        $tooltip = $(tooltip).appendTo("body");

        $(this)
          .mouseover(() => {
            $(this).css("z-index", 10000);
            $tooltip.fadeIn("600");
            $tooltip.fadeTo("10", 1.9);
          })
          .mousemove((e) => {
            $tooltip.css("top", e.pageY + 10);
            $tooltip.css("left", e.pageX + 20);
          });
      },

      // Hide tool-tip
      eventMouseout: () => {
        $(this).css("z-index", 8);
        $(customTooltip).remove();
      },

      // show event details
      eventClick: (event) => getEventDetails(event),
    }); // Academic fullCalendar
  }
  // personal Calendar

  function constructPersonalCalender() {
    //PERSONAL CALENDAR DATE_TIME PICKER
    const getDateTimePickerEditEvent = (start, end) => {

      const txtStartDateEdited = "#event_start_date_time_edited";
      const txtEndDateEdited = "#event_end_date_time_edited";

      let minDate = moment(start).format("YYYY-MM-DD HH:mm");
      let maxDate = moment(end).format("YYYY-MM-DD HH:mm");

      const startDateTime = flatpickr(txtStartDateEdited, {
        allowInput: true,
        enableTime: true,
        dateFormat: "Y-m-d H:i", // format for database input
        altInput: false,
        altFormat: "l J F, Y (h:i K)", // used to display the date and time in a user friendly format
        defaultDate: start ? minDate : new Date(), 
        maxDate: end ? maxDate : new Date(),
        onChange: (selectedDates, dateStr, instance) => endDateTime.set("minDate", dateStr)
      });

      const endDateTime = flatpickr(txtEndDateEdited, {
        allowInput: true,
        enableTime: true,
        dateFormat: "Y-m-d H:i", // format for database input
        altInput: false,
        altFormat: "l J F, Y (h:i K)", // used to display the date and time in a user friendly format
        defaultDate: end ? maxDate : new Date(),
        minDate: start ? minDate : new Date(), 
        onChange: (selectedDates, dateStr, instance) => startDateTime.set("maxDate", dateStr),
        onReady: (dateObj, dateStr, instance) => startDateTime.set("maxDate", maxDate)
      });
    }

    const getDateTimePickerAddEvent = (start, end) =>{
      const txtStartDate = "#event_start_date_time";
      const txtEndDate = "#event_end_date_time";
      let minDate = moment(start).format("YYYY-MM-DD HH:mm");
      let maxDate = moment(end).format("YYYY-MM-DD HH:mm");
      const startDateTime = flatpickr(txtStartDate, {
        allowInput: true,
        enableTime: true,
        dateFormat: "Y-m-d H:i", // format for database input
        altInput: false,
        altFormat: "l J F, Y (h:i K)", // used to display the date and time in a user friendly format
        defaultDate: start ? minDate : new Date(), 
        maxDate: end ? maxDate : new Date(),
        onChange: (selectedDates, dateStr, instance) => endDateTime.set("minDate", dateStr)
      });

      const endDateTime = flatpickr(txtEndDate, {
        allowInput: true,
        enableTime: true,
        dateFormat: "Y-m-d H:i", // format for database input
        altInput: false,
        altFormat: "l J F, Y (h:i K)", // used to display the date and time in a user friendly format
        defaultDate: end ? maxDate : new Date(),
        minDate: start ? minDate : new Date(), 
        onChange: (selectedDates, dateStr, instance) => startDateTime.set("maxDate", dateStr),
        onReady: (dateObj, dateStr, instance) => startDateTime.set("maxDate", maxDate)
      });
    }

    function deletePersonalEvent() {
      $("#btnDeleteEvent").on("click", () => {
        Swal.fire({
          title: "Are you sure you want to delete this event?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "deletePersonalEvent.inc.php",
              data: {
                personal_event_id: $("#personal_calendar_id").attr("value"),
              },
              success: function (response) {
                if (Boolean(response)) {
                  //$('#viewEditPersonalEventDetails').modal('hide');

                  personalCalendar.fullCalendar("refetchEvents");

                  modal("viewEditPersonalEventDetails").hide();
                  Swal.fire("deleted!", "event deleted", "success");
                  return;
                }
                Swal.fire("unable to delete class!", `class error`, "danger");
              },
              error: (xhr) => console.error(xhr.responseText),
            }); // ajax
          } // confirm
        }); // swal
      }); // click event
    }

    personalCalendar = $("#personal_calendar").fullCalendar({
      events: "students_personal_calendar_details.inc.php",

      plugins: ["interaction", "dayGrid", "timeGrid", "list"],
      header: {
        left: calendarOptions.navButtons,
        center: "title",
        //right: 'month,agendaWeek,agendaDay,listDay,listWeek,listMonth',
        right: calendarOptions.viewOptions,
      },
      views: {
        listDay: {
          buttonText: "List day",
        },
        listWeek: {
          buttonText: "List week",
        },
        listMonth: {
          buttonText: "List month",
        },
        month: {
          buttonText: "Month",
        },
        today: {
          buttonText: "Today",
        },
        agendaWeek: {
          buttonText: "Week",
        },
      },
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      selectable: true,
      selectHelper: true,
      timeFormat: "h:mma",
      defaultView: "month",
      scrollTime: "08:00", // undo default 6am scrollTime
      eventOverlap: false,
      allDaySlot: false,

      select: (start, end) => {
        getDateTimePickerAddEvent(start, end);
        $("#addPersonalCalendarEventModal").modal("show");
      },
      eventRender: function (event, element) {
        element.bind("dblclick", () => {
          getPersonalEventDetails(event);
          $("#viewEditPersonalCalendarEventModal").modal("show");
        });
      },

      eventDrop: (e) => updateEvent(e),
      eventResize: (e) => updateEvent(e),

      eventMouseover: function (event) {
        let tooltip = `
          <div class="${customTooltip.substring(1)}">
          Activity <strong>${titleCase(event.title)}</strong> <br>
          Type: <strong>${event.type}</strong> <br>


        Duration:  <strong>${event.duration}</strong> <br>  
		Starts: <strong>${moment(event.start).format(
      "Do of MMMM YYYY [at] HH:mm"
    )}</strong> <br>
		Ends: <strong>${moment(event.end).format(
      "Do of MMMM YYYY [at] HH:mm"
    )}</strong> <br>
        </div>`;

        let $tooltip = $(tooltip).appendTo("body");

        $(this).mouseover(()=> {
          
          $(this).css("z-index", 10000);
          $tooltip.fadeIn("500");
          $tooltip.fadeTo("10", 1.9);
          }).mousemove(function (e) {
            $tooltip.css("top", e.pageY + 10);
            $tooltip.css("left", e.pageX + 20);
          });
      },

      eventMouseout:  () =>{
        $(this).css("z-index", 8);
        $(customTooltip).remove();
      },
    });

    // add personal calendar event
    $("#addPersonalEventForm").on("submit", (e) => {
      let addPersonalEventForm = "#addPersonalEventForm";
      e.preventDefault();

      const requiredFields = Object.freeze({
        event_title: document.querySelector(`#${e.target.id} #event_title`).value.trim(),
        event_start_date_time: document.querySelector(`#${e.target.id} #event_start_date_time`).value.trim(),
        event_status_id: document.querySelector(`#${e.target.id} #event_status_id`).value.trim(),
        event_priority_id: document.querySelector(`#${e.target.id} #event_priority_id`).value.trim(),
        event_type_id: document.querySelector(`#${e.target.id} #event_type_id`).value.trim(),
      });

      const requiredFieldsIsEmpty = !Object.values(requiredFields).every(
        (value) => value
      );
      if (!requiredFieldsIsEmpty)
        addNonAcademicEvent(document.querySelector(addPersonalEventForm));

      async function addNonAcademicEvent(form) {
        try {
          const response = await fetch("add_personal_event_details.inc.php", {
            method: "POST",
            body: new FormData(form),
          });

          const data = await response.text();
          if (!response.ok) {
            modal("addPersonalCalendarEventModal").hide();
            Swal.fire("unable to add event!", "event error", "error");
            return;
          }
          if (Boolean(data)) {
            form.reset();
            removeBootstrapValidation();
            modal("addPersonalCalendarEventModal").hide();
            personalCalendar.fullCalendar("refetchEvents");
            Swal.fire(
              `${requiredFields.event_title} Event has successfully been added`,
              "Event added",
              "success"
            );
            return;
          }
        } catch (error) {
          console.error(`there was a problem adding event ${error.message}`);
        }
      }
    }); // add personal event button

    async function getPersonalEventDetails(event) {
      try {
        const response = await fetch(
          "personal_calendar_event_details.inc.php",

          {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
              personal_calendar_id: event.id,
            }),
          }
        );
        const data = await response.text();
        if (!response.ok) {
          Swal.fire("unable to get classes details!", "class error", "error");
          return;
        }

        document.getElementById("viewPersonalEvent").innerHTML = data;
        $("#viewEditPersonalEventDetails").modal("show");
        let startDateTime = document.querySelector(
          "#updatePersonalEventDetailsForm #event_start_date_time_edited"
        ).value;

        let endDateTime = document.querySelector(
          "#updatePersonalEventDetailsForm #event_end_date_time_edited"
        ).value;

        getDateTimePickerEditEvent(startDateTime, endDateTime);
        $("[readonly]").prop("disabled", true);
        deletePersonalEvent();

        $("#updatePersonalEventDetailsForm").on("submit", function (e) {
          e.preventDefault();
          const form = e.target.id;
          const requiredFields = Object.freeze({
            event_title: document.querySelector(`#${form} #event_title`).value.trim(),
            event_start_date_time: document.querySelector(`#${form} #event_start_date_time_edited`).value.trim(),
            event_end_date_time: document.querySelector(`#${form} #event_end_date_time_edited`).value.trim(),
            event_status_id: document.querySelector(`#${form} #event_status_id`).value.trim(),
            event_priority_id: document.querySelector(`#${form} #event_priority_id`).value.trim(),

            event_type_id: document .querySelector(`#${form} #event_type_id`).value.trim(),
          });

          if (!requiredFieldsIsEmpty(requiredFields)) {
            $("[readonly]").prop("disabled", false);
            updatePersonalEventDetails(
              document.querySelector("#updatePersonalEventDetailsForm")
            );
          }
          async function updatePersonalEventDetails(form) {
            try {
              const response = await fetch(
                "update_personal_event_details.inc.php",
                {
                  method: "POST",
                  body: new FormData(form), //test updated
                }
              );

              const data = await response.text();

              // check if url is found
              if (!response.ok) {
                modal("viewEditPersonalEventDetails").hide();
                Swal.fire("unable to update event!", "event error", "error");
                return;
              }

              if (Boolean(data)) {
                form.reset();
                removeBootstrapValidation();
                modal("viewEditPersonalEventDetails").hide();
                personalCalendar.fullCalendar("refetchEvents");
                Swal.fire("event updated!", "event updated", "success");
                return;
              }
            } catch (error) {
              console.error(
                `there was a problem updating event ${error.message}`
              );
            }
          }
        });
      } catch (error) {
        console.error(
          `there was a problem fetching class details ${error.message}`
        );
      }
    }
    // update end date for personal calendar event
    function updateEvent(event) {
      let start = event.start.format("YYYY-MM-DD HH:mm:ss");
      event.end ? end = event.end.format("YYYY-MM-DD HH:mm:ss") : end = start;

      const personalEventDetails = Object.freeze({
        start: start,
        end: end,
        personal_calendar_id: event.id,
      });
      let personalEventDetailsStr = JSON.stringify(personalEventDetails);
      const  url = "editEventDate.inc.php";




      const xhr = new XMLHttpRequest();
      xhr.open("POST", "editEventDate.inc.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          if (Boolean(this.responseText)) {
            Swal.fire(
              "Event moved!",
              `The event: ${
                event.title
              } has been successfully moved to ${event.start.format(
                "DD-MM-YYYY"
              )}`,
              "success"
            );
            return;
          }
          Swal.fire(
            "Error!",
            `Cannot update ${event.title}. Please contact the admin`,
            "error"
          );
        }
      };
      xhr.send(`personalEventDetails=${personalEventDetailsStr}`);
    }



  }

  $(".btnCloseModal").click(function (e) {
    const formID = this.value;
    $(formID).trigger("reset");
    removeBootstrapValidation();
  });

  function createCalendarUI(title, selectedCalendar) {
    title.trim();
    const instructions = ` <div class="col-12 py-3">
    <div class="alert alert-warning" role="alert">
        <h4><i class="fas fa-exclamation-circle"></i> <strong>Please ensure that you have assigned a module to a teacher and added a campus before adding a class! </strong></h3>
        <h4 class="alert-heading">How to add classes</h4>
        <p>to add a class simply follow the instructions below</p>
        <ol>
            <li><strong>Add a a module and a teacher if you haven't done so already</strong></li>
            <p><i class="fas fa-exclamation-triangle"></i> <u>Ensure that your module is assigned to a teacher first!</u></p>
            <li><strong>add a campus</strong></li>
        </ol>
        <p>Please ensure that you add a module .</p>
        <hr>
        <p class="mb-0"><i class="fas fa-thumbs-up"></i> You can now successfully add a class</p>
    </div>
</div>`;
    const ShowAcademicButton = `
                <div class="col-sm-6 mb-2">
                  <span class="float-left">
                  <button type="button" id="btnShowClassesModal" onclick="showCustomTimePicker()" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClassesModal">
  Add classes
</button>
                  </span>
                </div>`;
    const ShowPersonalButton = `<div class="col-sm-6 mb-2">
	
	<span class="float-left"><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPersonalCalendarEventModal">
		Add  event
	</button></span>
</div>`;

    selectedCalendar === "academic_calendar" && instructionsDiv ? (instructionsDiv.innerHTML = instructions): "";

    document.querySelector("#calendar_content").innerHTML = `<h2 class="mt-2">${titleCase(title)}</h2>
        <div class="border-bottom border-2 border-dark"></div>
            <p class="text-muted">View your ${title} below</p>
            ${selectedCalendar === "academic_calendar"? ShowAcademicButton : ShowPersonalButton}`;

    // show selected calendar
    selectedCalendar === "academic_calendar" ? ShowAcademicCalendar() : ShowPersonalCalendar();
  }

  const ShowAcademicCalendar = () => {
    getCalendarKey("academic");
    document.querySelector(personal).style.display = "none";
    document.querySelector(academic).style.display = "block";
    if (instructionsDiv) instructionsDiv.style.display = "block";
  }

  const ShowPersonalCalendar = () => {
    getCalendarKey("personal");
    document.querySelector(academic).style.display = "none";
    if (instructionsDiv) instructionsDiv.style.display = "none";
    document.querySelector(personal).style.display = "block";
  }

  const academic = "#academic_calendar";
  const personal = "#personal_calendar";

  // create the calendar objects and hide them on load
  $(academic).html(constructAcademicCalender());
  $(personal).html(constructPersonalCalender());
  $(academic).hide();
  $(personal).hide();
  const calendarType = document.querySelector("#calender_type");

  if (calendarType) {
    calendarType.value === "academic_calendar" ? createCalendarUI("academic calendar", "academic_calendar") : createCalendarUI("personal calendar", "personal_calendar")

    calendarType.addEventListener("change", (e) =>
      createCalendarUI(e.target.value.replace("_", " "), e.target.value)
    );
  }
});

const getCalendarKey  = (calenderType = "academic") => {
  $.ajax({
    url: "getCalendarKey.inc.php",
    data: {
      calenderType: calenderType,
    },
    method: "POST",
    async: false,
    success: (data) => (document.querySelector("#key").innerHTML = data),
  });
}
