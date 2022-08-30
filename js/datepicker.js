const txtStart = '#start';
const txtEnd = '#end';

const start = flatpickr(txtStart, {
  dateFormat: 'Y-m-d', // format for database input
  altInput: true,
  altFormat: 'l J F, Y', // used to display the date and time in a user friendly format
  defaultDate: document.querySelector(txtStart).value !== '' ? document.querySelector(txtStart).value : new Date(),
  maxDate: document.querySelector(txtEnd).value,
  onChange: (selectedDates, dateStr, instance) => end.set('minDate', dateStr)

});
const end = flatpickr(txtEnd, {
  dateFormat: 'Y-m-d', // format for database input
  altInput: true,
  altFormat: 'l J F, Y', // used to display the date and time in a user friendly format
  defaultDate: document.querySelector(txtEnd).value !== '' ? document.querySelector(txtEnd).value : new Date().fp_incr(14),
  minDate: document.querySelector(txtStart).value,
  onChange: (selectedDates, dateStr, instance) => start.set('maxDate', dateStr),
  onReady : (dateObj, dateStr, instance) => start.set('maxDate', moment($(txtEnd).val()).format('YYYY-MM-DD'))
  
});


/*const txtStartDate = '#start1';
const txtEndDate = '#end1';


const startDateTime = flatpickr(txtStartDate, {
  enableTime: true,
  dateFormat: 'Y-m-d H:i', // format for database input
  altInput: false,
  altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
  defaultDate: document.querySelector(txtStartDate).value !== '' ? document.querySelector(txtStartDate).value : new Date(),
  maxDate: document.querySelector(txtEndDate).value,
  onChange: (selectedDates, dateStr, instance) => endDateTime.set('minDate', dateStr)

});

const endDateTime = flatpickr(txtEndDate, {
  enableTime: true,
  dateFormat: 'Y-m-d H:i', // format for database input
  altInput: false,
  altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
  defaultDate: document.querySelector(txtEndDate).value !== '' ? document.querySelector(txtEndDate).value : new Date().fp_incr(14),
  minDate: document.querySelector(txtStartDate).value,
  onChange: (selectedDates, dateStr, instance) => startDateTime.set('maxDate', dateStr),
  onReady : (dateObj, dateStr, instance) => startDateTime.set('maxDate', moment($(txtEndDate).val()).format('YYYY-MM-DD HH:mm'))
  
});*/