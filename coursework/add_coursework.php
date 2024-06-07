<?php
$current_page = 'coursework';
$page_title = 'Add coursework';
require_once '../templates/header.php';
require_once 'add_coursework.inc.php';
?>
<div class="container">
    <h1>Add Coursework</h1>
    <hr>
    <form class="row g-3 needs-validation" action="" method="post" autocomplete="off" novalidate>
        <h1 class="text-capitalize text-success p-2">Coursework Details</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="col-md-6">
            <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
            <select id="module_id" name="module_id" class="form-select" required>
                <option selected disabled value="">Select Module</option>
                <?php foreach ($db->getModules() as $row) : ?>
                    <option value="<?= Helper::html($row['module_id']) ?>"><?= Helper::html($row['module_code']) ?> <?= Helper::html($row['module_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please choose a module.</div>
            <small class="form-text text-danger"><?= $errors['module_id'] ?? '' ?></small>

        </div>
        <div class="col-md-4">
            <label for="priority_id" class="form-label">Priority <span class="text-danger">*</span></label>
            <select id="priority_id" name="priority_id" class="form-select" required>
                <option selected disabled value="">Select priority</option>
                <?php foreach ($db->getPriority() as $row) : ?>
                    <option value="<?= Helper::html($row['priority_id']) ?>"><?= Helper::html($row['priority_level']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please choose a priority level.</div>
            <small class="form-text text-danger"><?= $errors['priority_id'] ?? '' ?></small>

        </div>
        <div class="col-md-2">
            <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
            <select id="status_id" name="status_id" class="form-select" required>
                <option selected disabled value="">Select status</option>
                <?php foreach ($db->getStatus() as $row) : ?>
                    <option value="<?= Helper::html($row['status_id']) ?>"><?= Helper::html($row['status_level']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Status is required!</div>
            <small class="form-text text-danger"><?= $errors['status'] ?? '' ?></small>

        </div>
        <div class="col-12">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" maxlength="100"
                   placeholder="Enter coursework title" required>
            <div class="invalid-feedback">Please choose a title.</div>
            <small class="form-text text-danger"><?= $errors['title'] ?? '' ?></small>

        </div>
        <div class="col-12">
            <label for="description" class="form-label">Coursework Description</label>
            <textarea class="form-control editor" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="col-12">
            <label for="colour_tag" class="form-label">Colour tag:</label>
            <input type="color" class="form-control form-control-color" id="colour_tag" name="colour_tag"
                   value="<?= Helper::getDefaultColour() ?>" title="Choose your color">
        </div>
        <div class="col-md-6">
            <label for="due_date" class="form-label">Coursework Due Date & time <span
                        class="text-danger">*</span></label>
            <input type="text" class="form-control due_dates" id="due_date" name="due_date" maxlength="100"
                   placeholder="Enter coursework due date" required>
            <div class="invalid-feedback">Please choose a Due date</div>
            <small class="text-danger" id="due_date_error"></small>
            <small class="form-text text-danger"><?= $errors['due_date'] ?? '' ?></small>

        </div>

        <h1 class="text-capitalize text-success p-2">Note Details</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="col-12">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control editor" id="notes" name="notes" rows="3"></textarea>
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" id="image" name="image" placeholder="Enter image URL">
        </div>
        <h1 class="text-capitalize text-success p-2">Coursework Checklist</h1>
        <div class="border-bottom border-3 border-success"></div>
        <div class="row my-4">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Add items</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="post" id="add_form">
                            <div class="col-md-2 mb-3 d-grid">
                                <button class="btn btn-success btnAddItem">+ Add Item</button>
                            </div>
                            <div id="show_item">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="checklist_title[]"
                                                   placeholder="Title">
                                            <label>Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating">
                                            <input type="datetime-checklist" class="form-control"
                                                   name="checklist_due_date[]" placeholder="Due date & time">
                                            <label for="floatingPassword">Due date & time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-floating">
                                            <select id="check_list_status_id" name="check_list_status[]"
                                                    class="form-select" aria-label="Floating label select example">
                                                <option selected disabled value="">Select status</option>
                                                <?php foreach ($db->getStatus() as $row) : ?>
                                                    <option value="<?= Helper::html($row['status_id']) ?>"><?= Helper::html($row['status_level']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="floatingSelectGrid">Status</label>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- #show_item -->
                    </div>
                </div> <!-- .card -->
            </div> <!-- col-lg-10 mx-auto -->
        </div> <!-- row -->
        <div class="col-12">
            <button type="submit" class="btn btn-success" name="add_coursework">Add coursework</button>
            <?= Helper::getRequiredFieldMessage(); ?>
        </div>
    </form>
</div>
<?php require_once '../templates/footer.php'; ?>
<!--<script src="../js/add_coursework_checklist.js"></script>-->
<!--<script src="../js/addCoursework.js">-->
<script>


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
    const date = '#due_date'
    flatpickr('#due_date', {
        dateFormat: 'Y-m-d H:i',
        enableTime: true,
        altInput: true,
        altFormat: 'l J F, Y H:i',
        defaultDate: document.querySelector(date).value !== '' ? document.querySelector(date).value : new Date(),
        minDate: 'today'

    });


    $('.btnAddItem').click(function (e) {


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
                success: function (data) {
                    data = JSON.parse(data)
                    for (let i = 0; i < data.length; i++) {
                        output += `<option value="${data[i]['status_id']}">${data[i]['status_level']}</option>`;
                    }
                }
            });
            return output;
        }


    });
    $(document).on('click', '.btnRemoveItem', function (e) {
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


</script>


