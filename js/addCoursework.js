const date = '#due_date'
flatpickr('#due_date', {
    dateFormat: 'Y-m-d H:i',
    enableTime: true,
    altInput: true,
    altFormat: 'l J F, Y H:i',
    defaultDate: document.querySelector(date).value !== '' ? document.querySelector(date).value : new Date(),
    minDate: 'today'

});



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
    getDateTimePicker(date);

    $('.checkListTitle').last().focus();



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




});
$(document).on('click', '.btnRemoveItem', function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
});


function getDateTimePicker(updatedDueDate) {

    flatpickr('#due_date', {
        dateFormat: 'Y-m-d H:i', // format for database input
        enableTime: true,
        altInput: false,
        altFormat: 'l J F, Y', // used to display the date and time in a user friendly format
        defaultDate: document.querySelector('#due_date').value !== '' ? document.querySelector('#due_date').value : new Date(),
        onChange: (selectedDates, dateStr, instance) => checkListDueDate.set('maxDate', dateStr)

    });

    const checkListDueDate = $('input[type=datetime-checklist]').flatpickr({
        enableTime: true,
        dateFormat: 'Y-m-d H:i', // format for database input
        altInput: false,
        altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
        defaultDate: $('#due_date').val(),//'today',
        minDate: 'today'
    });



    if (updatedDueDate) checkListDueDate.set('maxDate', (moment(updatedDueDate).format('YYYY-MM-DD HH:mm')));

}

