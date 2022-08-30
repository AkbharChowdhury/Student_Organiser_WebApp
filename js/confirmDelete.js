// delete coursework
function deleteCoursework(title, coursework_id) {
  Swal.fire({
    title: `Are you sure you want to delete ${title}?`,
    text: "you won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      // hide card
      $.ajax({
        url: 'delete_coursework.inc.php',
        method: 'POST',
        data: { coursework_id: coursework_id },
        success: function (data) {
          $('#' + coursework_id).fadeOut('slow');

          document.querySelector('#errorMessageJS').innerHTML =
            setErrorMessage(data);
        },
      });
    }
  });
}

function setErrorMessage(message) {
  return ` <div class="container"> 
  
  <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
    <use xlink:href="#exclamation-triangle-fill"/>
  </svg>
  
  ${message}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  </div>`;
}
$(document).ready(function () {
  // replace existing js-disabled class
  $('.delete').prop('class', 'btn btn-danger');

  if ($('#totalCampusCount').length) getTotalRecords('count-total-campus.inc.php', '#totalCampusCount');

  function getTotalRecords(url, selector) {
    $.ajax({
      url: url,
      method: 'POST',
      success: function (data) {
        $(selector).text(data);
      },
    });
  }

  // delete checklist item
  $('.btnDeleteItem').on('click', function (e) {
    e.preventDefault();
    let checklist_id = $(this).val();
    deleteItem();
    function deleteItem() {
      $.ajax({
        url: 'delete_checklist.inc.php',
        method: 'POST',
        data: {
          checklist_id: checklist_id,
        },
        success: function (data) {
          // hide deleted row
          $('#delete_checklist_id' + checklist_id).fadeOut('slow');
        },
        error: (error) =>
          console.error(`unable to delete checklist item ${error.message}`),
      });
    }
  });

  $('.delete_module').on('click', function () {
    Swal.fire({
      title: `Are you sure you want to delete ${$(this).data('module')}`,
      text: 'Doing so will delete this module and and all coursework, teachers and notes associated with it.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `${window.location.href}?deleteModuleID=${$(
          this
        ).val()}&module=${$(this).data('module')}`;
      }
    });
  });

  $('.delete_teacher').on('click', function () {
    Swal.fire({
      title: `Are you sure you want to delete ${$(this).data('teacher')}`,
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `${window.location.href}?deleteTeacherID=${$(
          this
        ).val()}&teacher=${$(this).data('teacher')}`;
      }
    });
  });

  const btnDeleteModuleTeacher = document.querySelectorAll(
    '.deleteModuleTeacher'
  );
  if (btnDeleteModuleTeacher) {
    btnDeleteModuleTeacher.forEach((i) => {
      i.addEventListener('click', () => {
        const teacherData = Object.freeze({
          teacher: i.getAttribute('data-teacher'),
          teacherID: i.value,
          moduleID: i.getAttribute('data-moduleID'),
          module: i.getAttribute('data-module'),
        });
        Swal.fire({
          title: `Are you sure you want to delete ${teacherData.teacher} from ${teacherData.module}`,
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = `${window.location.href}?module_id=${teacherData.moduleID}&teacher_id=${teacherData.teacherID}&status=1`;
          }
        });
      }); // click
    }); // foreach
  }
  // delete campus
  $('table').on('click', '#deleteCampus', function () {
    let campus_id = $(this).val();

    // get the current row
    let currentRow = $(this).closest('tr');

    Swal.fire({
      title: `Are you sure you want to delete ${$(this).data('campus')}`,
      text: 'Doing so will delete this campus and and all coursework, teachers and notes associated with it.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_campus.inc.php',
          method: 'POST',
          data: { campus_id: campus_id },
          success: function (data) {
            // getTotalAuthorCount();
            getTotalRecords('count-total-campus.inc.php', '#totalCampusCount');
            currentRow.hide('slow');

            getTotalRecords('count-total-campus.inc.php', '#totalCampusCount');
            //alert(data)
            document.querySelector('#errorMessageJS').innerHTML =
              setErrorMessage(data);
          },
        });
      }
    });
  });
});

function deleteSemester(title, semester_id) {
  Swal.fire({
    title: `Are you sure you want to delete ${title}?`,
    text: "you won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `${window.location.href}?deleteSemester=${semester_id}`;

    }
  });
}


function deleteActivity(title, activity_id) {
  Swal.fire({
    title: `Are you sure you want to delete ${title}?`,
    text: "you won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `${window.location.href}?deleteActivity=${activity_id}`;
    }
  });

}





