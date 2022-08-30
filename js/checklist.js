init = false;
document.addEventListener('DOMContentLoaded', () => {
    const allEditors = document.querySelectorAll('.editor');
    if (allEditors) {
      for (let i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i]).catch((error) =>
          console.error(error)
        );
      }
    }
});
    $(document).ready(function() {
        const editCWCheckList = document.querySelector('#editCWCheckList');
        editCWCheckList ?  getEditedDateTimePicker() :getDateTimePicker();
        const cwDueDate = document.querySelector('#due_date');
        $('form').submit((e)=>{
          if($('#due_date').val() === ''){
            alert('due date is required')
            return false;
          }
          return true;

        })
        $('.btnAddItem').click(function(e) {
            e.preventDefault();

            $('#show_item').append(`
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control checkListTitle" name="checklist_title[]" placeholder="Title" required>
                                <label>Title</label>
                                <div class="invalid-feedback">Title is required!</div>

                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="datetime-checklist" class="form-control" name="checklist_due_date[]" placeholder="Due date & time" required=required>
                                <label for="floatingPassword">Due date & time</label>
                                <div class="invalid-feedback">Due date/time is required!</div>

                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <select id="check_list_status_id" name="check_list_status[]" class="form-select" required aria-label="Status label">
                                    <option selected disabled value="">Select status</option>
                                    ${getStatus()}
                                </select>
                                <label for="floatingSelectGrid">Status</label>
                                <div class="invalid-feedback">Status is required!</div>
                            </div>
                        </div>
                        
                        <div class="col-md-2 mb-3 d-grid">
                            <button class="btn btn-danger btnRemoveItem">- Remove</button>
                        </div>
                    </div>

                    
            
            `);
            editCWCheckList ?  getEditedDateTimePicker(cwDueDate.value) : getDateTimePicker(cwDueDate.value);

            // document.querySelector('#editCWCheckList') ? getEditedDateTimePicker() : getDateTimePicker(document.querySelector('#due_date').value);
            $('.checkListTitle').last().focus();

        });

        function getStatus() {
			let output = '';
			$.ajax({
				url: 'getStatus.inc.php',
				method: 'POST',
				async: false,
				success: function(data) {
					data = JSON.parse(data)
					for (let i = 0; i < data.length; i++) {
						output += `<option value="${data[i]['status_id']}">${data[i]['status_level']}</option>`;
					}
				}
			});
			return output;
		}

        $(document).on('click', '.btnRemoveItem', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });


        // EDIT COURSEWORK
        function getEditedDateTimePicker(updatedDueDate) {
          $('#due_date').flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i', // format for database input
            altInput: true,
            altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
            defaultDate: document.querySelector('#due_date').value,
            onChange: function (selectedDates, dateStr, instance) {
              checkListDueDateEdit.set('maxDate', dateStr);
            },
          });

          const checkListDueDateEdit = $(
            'input[type=datetime-checklist]'
          ).flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i', // format for database input
            altInput: true,
            altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
            maxDate: moment(document.querySelector('#due_date').value).format(
              'YYYY-MM-DD HH:mm'
            ),
          });

          if (updatedDueDate) checkListDueDateEdit.set('maxDate', moment(updatedDueDate).format('YYYY-MM-DD HH:mm'));
          
        }

        // ADD COURSEWORK
        function getDateTimePicker(updatedDueDate) {
            $('#due_date').flatpickr({
                enableTime: true,
                dateFormat: 'Y-m-d H:i', // format for database input
                altInput: true,
                altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
                defaultDate:  updatedDueDate? updatedDueDate:'today', 
                minDate:'today',


                onChange: (selectedDates, dateStr, instance) => checkListDueDate.set('maxDate', dateStr)
              });

            const checkListDueDate = $('input[type=datetime-checklist]').flatpickr({
              enableTime: true,
              dateFormat: 'Y-m-d H:i', // format for database input
              altInput: true,
              altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
              defaultDate:  'today',
              // maxDate: 'today',
              minDate:'today'
            });

            if(updatedDueDate) checkListDueDate.set('maxDate', (moment(updatedDueDate).format('YYYY-MM-DD HH:mm')));
            
          }

      
        
    }); // doc ready
