// (function () {
//   'use strict';
//
//   // Fetch all the forms we want to apply custom Bootstrap validation styles to
//   var forms = document.querySelectorAll('.needs-validation');
//
//   // Loop over them and prevent submission
//   Array.prototype.slice.call(forms).forEach(function (form) {
//     form.addEventListener(
//       'submit',
//       function (event) {
//         if (!form.checkValidity()) {
//           event.preventDefault();
//           event.stopPropagation();
//         }
//
//         form.classList.add('was-validated');
//       },
//       false
//     );
//   });
// })();
//


window.onerror =()=> { return ''}

// get all form id
const forms = Object.freeze({
  register: document.getElementById('register-form'),
  updatePassword: document.getElementById('updatePassword')

})

// tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

const validateNumber = (e) => (e.value = e.value.replace(/[^0-9]/g, ''));

$(document).ready(function () {
  const eventStartDate = '#start_date';
  const eventEndDate = '#end_date';
  const dueDate = '#due_date';

  const datepickerSettings = {
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    minDate: new Date(),
  };
  // get the original minDate value
  const minDate = datepickerSettings.minDate;
  // nullify the minDate
  datepickerSettings.minDate = null;
  $(eventStartDate)
    .datepicker(datepickerSettings)
    .on('change', function () {
      $(eventEndDate).datepicker('option', 'minDate', $(this).val());
    });

  $(eventEndDate)
    .datepicker(datepickerSettings)
    .on('change', function () {
      $(eventStartDate).datepicker('option', 'maxDate', $(this).val());
    });
  // reset the minDate
  datepickerSettings.minDate = minDate;
  $(dueDate).datepicker(datepickerSettings);
});
