<?php

date_default_timezone_set('Europe/London');
session_start();
require_once '../includes/class-autoload.php';
$db = Database::getInstance();
$id = $_POST['class_id'];

?>

<?php if (isset($id) && $_POST['isCoursework'] == 'false') : ?>
  <?php foreach ($db->editClass($id) as $row) : ?>
    <div class="modal fade" id="viewEditClassDetails" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="personalEventTitle"><?= Helper::html($row['module_name']) ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="">
            <p class="card-text"><strong>Time </strong>
              <?= date('h:i A', strtotime($row['start_time'])) ?> -<?= date('h:i A', strtotime($row['end_time'])) ?> </p>
            <p><strong>Duration</strong> <?= Helper::formatTime(Helper::toMinutes($row['start_time'], $row['end_time'])) ?></p>

            <form action="" class="row g-3 needs-validation" id="updateClassForm" method="post" novalidate autocomplete="off">
              <input type="hidden" name="class_id" id="class_id" value="<?= Helper::html($row['class_id']) ?>">


              <div class="col-md-6">
                <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
                <select id="module_id" name="module_id" class="form-select module_id" required>
                  <option selected disabled value="">Select Semester</option>
                  <?php foreach ($db->getModulesTeacher() as $module) : ?>
                    <option <?php if ($row['module_id'] === $module['module_id']) echo 'selected' ?> value="<?= Helper::html($module['module_id']) ?>"><?= $module['module_code'] ?> <?= $module['module_name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <small class="form-text text-danger module_id_error"></small>

                <div class="invalid-feedback">Please choose a module.</div>
              </div>

              <div class="col-md-6">
                <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                <select id="semester_id" name="semester_id" class="form-select semester_id" required>
                  <option selected disabled value="">Select Semester</option>
                  <?php foreach ($db->getSemester() as $semester) : ?>
                    <option <?php if ($row['semester_id'] === $semester['semester_id']) echo 'selected' ?> value="<?= Helper::html($semester['semester_id']) ?>"><?= Helper::html($semester['name']) ?> <?= Helper::html($semester['start_date']) ?> - <?= Helper::html($semester['end_date']) ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please choose a semester.</div>
              </div>

              <div class="col-md-6">
                <label for="campus_id" class="form-label">Campus <span class="text-danger">*</span></label>
                <select id="campus_id" name="campus_id" class="form-select" required>
                  <option value="" disabled>Select Campus</option>
                  <?php foreach ($db->getCampuses() as $campus) : ?>
                    <option value="<?= $campus['campus_id'] ?>" <?php if ($campus['campus_id'] === $row['campus_id']) echo ' selected' ?>><?= $campus['campus'] ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please choose a campus.</div>
              </div>
              <div class="col-md-6">
                <label for="day_id" class="form-label">Day <span class="text-danger">*</span></label>
                <select id="day_id" name="day_id" class="form-select" required>
                  <option selected disabled value="">Select Day</option>
                  <?php foreach ($db->getDays() as $day) : ?>
                    <option value="<?= Helper::html($day['day_id']) ?>" <?php if ($day['day_id'] === $row['day_id']) echo ' selected' ?>><?= Helper::html($day['day']) ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please choose a day.</div>
              </div>
              <div class="col-md-6">
                <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                <input type="text" class="form-control timepicker" id="start_time" name="start_time" placeholder="enter start time" value="<?= Helper::html($row['start_time']) ?? Helper::html($_POST['start_time']) ?>" required>
                <div class="invalid-feedback">Please choose a start time.</div>
              </div>

              <div class="col-md-6">
                <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                <input type="text" class="form-control timepicker" id="end_time" name="end_time" placeholder="enter end time" value="<?= Helper::html($row['end_time']) ?? Helper::html($_POST['end_time']) ?>" required>
                <div class="invalid-feedback">Please choose a end time.</div>
              </div>
              <div class="col-md-6">
                <label for="room" class="form-label">Room</label>
                <input type="text" class="form-control" id="room" name="room" placeholder="enter room" value="<?= $row['room'] ?? $_POST['room'] ?>">
              </div>

              <div class="col-md-6">
                <label for="colour" class="form-label">Colour</label>
                <input type="color" class="form-control form-control-color" id="colour" name="colour" value="<?= $row['colour'] ?? $_POST['colour'] ?>" title="Choose class colour">
              </div>

              <div class="col-12">
                <label for="type_id" class="form-label">Type <span class="text-danger">*</span></label>
                <select id="type_id" name="type_id" class="form-select type_id" required>
                  <option selected disabled value="">Select Class type</option>
                  <?php foreach ($db->getClassTypes() as $type) : ?>
                    <option value="<?= Helper::html($type['type_id']) ?>" <?php if ($type['type_id'] === $row['type_id']) echo ' selected' ?>><?= Helper::html($type['type']) ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please choose the class type.</div>
              </div>
              <button type="submit" class="btn btn-success" name="btnUpdateClass" id="btnUpdateClass">Update class</button>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="btnDeleteClass">Delete class</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else :  // show coursework deadlines 
?>

  <?php foreach ($db->getCourseworkDetails($_POST['class_id']) as $row) : ?>
    <div class="modal fade" id="viewEditClassDetails" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php echo $row['module_info'] ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="">
            <?php if (!empty($row['image'])) : ?>
              <img src="<?= $row['image'] ?>" class="img-fluid" alt="coursework image">
            <?php endif; ?>
            <p class="card-text pt-3">
              <strong>Title:</strong> <?= $row['title'] ?> <br>
              <strong>Due:</strong> <?= Helper::formatDueDate($row['due_date']) ?>
            </p>
            <?php if ($db->getCourseworkChecklist($id)) : ?>
              <h3>Checklist</h3>

              <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <caption>checklist items</caption>
                  <thead>
                    <tr>
                      <th scope="col">Item</th>
                      <th scope="col">Due</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($db->getCheckListDetails($id) as $item) : ?>
                      <td><?= Helper::html($item['title']) ?></td>
                      <td><?= date('F d, Y H:ia', strtotime($item['due_date'])) ?></td>
                      <td>
                        <span class="text-<?= Helper::showStatusColour($item['status_level']) ?>"><?= $item['status_level'] ?></span>
                      </td>
                      </tr>
                    <?php endforeach; ?>

                  </tbody>
                </table>
              </div><!-- table-responsive -->
            <?php endif ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <a class="btn btn-warning mt-2 mb-2" href="../coursework/edit_coursework.php?editCoursework=<?= Helper::html($id) ?>">Edit coursework</a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>