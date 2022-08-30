<?php
$current_page = 'coursework';
$page_title = 'Edit coursework';
require_once '../templates/header.php';
require_once 'edit_coursework.inc.php';
// $cwDue = $coursework_data['due_date'].' '.$coursework_data['due_time'];

?>
<div id="editCWCheckList"></div>
<div class="container">
    <h1>Edit Coursework</h1>
    <hr>
    <form class="row g-3 needs-validation" action="" method="post" autocomplete="off" novalidate>
        <input type="hidden" name="coursework_id" value="<?= $coursework_data['coursework_id'] ?>">
        <h1 class="text-success p-2">Coursework Details</h1>
        <hr class="custom-line">
        <div class="col-md-6">
            <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
            <select id="module_id" name="module_id" class="form-select">
                <option selected disabled value="">Select Module</option>
                <?php foreach ($db->getModules() as $row) : ?>
                    <option <?php if ($coursework_data['module_id'] == $row['module_id']) echo ' selected' ?> value="<?= Helper::html($row['module_id']) ?>"><?= Helper::html($row['module_code']) ?> <?= Helper::html($row['module_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please choose a module.</div>
        </div>
        <div class="col-md-4">
            <label for="priority_id" class="form-label">Priority <span class="text-danger">*</span></label>
            <select id="priority_id" name="priority_id" class="form-select">
                <option selected disabled value="">Select priority</option>
                <?php foreach ($db->getPriority() as $row) : ?>
                    <option <?php if ($coursework_data['priority_id'] == $row['priority_id']) echo ' selected' ?> value="<?= Helper::html($row['priority_id']) ?>"><?= Helper::html($row['priority_level']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Please choose a priority level.</div>
        </div>
        <div class="col-md-2">
            <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
            <select id="status_id" name="status_id" class="form-select">
                <option selected disabled value="">Select status</option>
                <?php foreach ($db->getStatus() as $row) : ?>
                    <option <?php if ($coursework_data['status_id'] == $row['status_id']) echo ' selected' ?> value="<?= Helper::html($row['status_id']) ?>"><?= Helper::html($row['status_level']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Status is required!</div>
        </div>
        <div class="col-12">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" maxlength="100" placeholder="Enter coursework title" value="<?= htmlspecialchars($_POST['title'] ?? $coursework_data['title']) ?>" required>
            <div class="invalid-feedback">Please choose a title.</div>
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Coursework Description</label>
            <textarea class="form-control editor" id="description" name="description" rows="3"><?= $_POST['description'] ?? $coursework_data['description'] ?></textarea>
        </div>
        <div class="col-12">
            <label for="colour_tag" class="form-label">Colour tag:</label>
            <input type="color" class="form-control form-control-color" id="colour_tag" name="colour_tag" value="<?= $_POST['colour_tag'] ?? $coursework_data['colour_tag'] ?>" title="Choose your color">
        </div>
        <div class="col-md-6">
            <label for="due_date" class="form-label">Due Date & time <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="due_date" name="due_date" maxlength="100" placeholder="Enter coursework due date" value="<?= $_POST['due_date'] ?? $coursework_data['due_date']?>" required>
            <div class="invalid-feedback">Please choose a Due date</div>
        </div>
        <h1 class="text-success p-2">Note Details</h1>
        <hr class="custom-line">
        <div class="col-12">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control editor" id="notes" name="notes" rows="3"><?= nl2br($_POST['note_description'] ?? $coursework_data['note_description']) ?></textarea>
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" id="image" name="image" placeholder="Enter image URL" value="<?= $_POST['image'] ?? $coursework_data['image'] ?>">
        </div>
        <h1 class="text-success p-2">Coursework Checklist</h1>
        <hr class="custom-line">
        <div class="row my-4">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Add items</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="post" id="add_form">
                            <div class="col-md-2 mb-3 d-grid">
                                <button class="btn btn-success btnAddItem">Add Item</button>
                            </div>
                            <div id="show_item">
                                <?php foreach ($db->getCourseworkChecklist($coursework_data['coursework_id']) as $checklist_row) : ?>

                                    <div class="row" id="delete_checklist_id<?= $checklist_row['checklist_id'] ?>">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="<?= $checklist_row['checklist_id'] ?>" name="checklist_title[]" placeholder="Title" value="<?= Helper::html($_POST['checklist_title'] ?? $checklist_row['title']); ?>">
                                                <label>Title</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-floating">
                                                <input type="datetime-checklist" class="form-control" name="checklist_due_date[]" placeholder="Due date & time" value="<?= $_POST['checklist_due_date'] ?? $checklist_row['due_date'] ?>">
                                                <label for="floatingPassword">Due date & time</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="form-floating">
                                                <select id="check_list_status_id" name="check_list_status[]" class="form-select" aria-label="Floating label select example">
                                                    <option selected disabled value="">Select status</option>
                                                    <?php foreach ($db->getStatus() as $row) : ?>
                                                        <option <?php if ($row['status_id'] === $checklist_row['status_id']) echo ' selected'; ?> value="<?= Helper::html($row['status_id']) ?>"><?= Helper::html($row['status_level']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="floatingSelectGrid">Status</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3 d-grid">
                                            <button class="btn btn-danger btnDeleteItem" value="<?= $checklist_row['checklist_id'] ?>">Delete</button>
                                        </div>
                                    </div> <!-- row -->
                                <?php endforeach ?>
                            </div> <!-- #show_item -->
                    </div>
                </div> <!-- .card -->
            </div> <!-- col-lg-10 mx-auto -->
        </div> <!-- row -->
        <div class="col-12">
            <button type="submit" class="btn btn-warning" name="updateCoursework">Update coursework</button>

            <?= Helper::getRequiredFieldMessage(); ?>
        </div>
    </form>
</div>
<?php require_once '../templates/footer.php'; ?>
<!-- <script src="../js/checklist.js"></script> -->
<script src="../js/confirmDelete.js"></script>
<script>
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
            getEditedDateTimePicker(cwDueDate.value)   //  editCWCheckList ?  getEditedDateTimePicker(cwDueDate.value) : getDateTimePicker(cwDueDate.value);

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
            dateFormat: 'Y-m-d H:i', // format for database input

            altInput: false,

            enableTime: true,
            altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
            // defaultDate: document.querySelector('#due_date').value,
            // onChange: function (selectedDates, dateStr, instance) {
            // //   checkListDueDateEdit.set('maxDate', dateStr);
            // },
          });

          const checkListDueDateEdit = $(
            'input[type=datetime-checklist]'
          ).flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i', // format for database input
            altInput: false,
            altFormat: 'l J F, Y (h:i K)', // used to display the date and time in a user friendly format
            maxDate: moment(document.querySelector('#due_date').value).format(
              'YYYY-MM-DD HH:mm'
            ),
          });

          if (updatedDueDate) checkListDueDateEdit.set('maxDate', moment(updatedDueDate).format('YYYY-MM-DD HH:mm'));
          
        }

       

      
        
    }); // doc ready

</script>

