<!-- view checklist Modal -->
<div class="modal fade" id="viewChecklistData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="coursework-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="checklistData">
        <!-- Pie chart -->
        <canvas id="checkListPieChart"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Add classes modal -->
<div class="modal fade" id="addClassesModal" tabindex="-1" aria-labelledby="addClassesModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addClassesModalLabel">Add Classes</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form class="row g-3 needs-validation" action="" id="addClassForm" method="post" novalidate autocomplete="off">
        <div class="col-md-6">
          <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
          <select id="module_id" name="module_id" class="form-select module_id" required data-bs-toggle="tooltip" title="<?= Helper::getModuleTooltip() ?>" data-form_id="addClassForm">
            <option selected disabled value="">Select Module</option>
            <?php foreach ($db->getModulesTeacher() as $row) : ?>
            <option value="<?= Helper::html($row['module_id']) ?>"><?= Helper::html($row['module_code']) ?> <?= Helper::html($row['module_name']) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="form-text text-danger module_id_error"></small>
          <div class="invalid-feedback">Please choose a module.</div>
        </div>
        <div class="col-md-6">
          <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
          <select id="semester_id" name="semester_id" class="form-select semester_id" required>
            <option selected disabled value="">Select Semester</option>
            <?php foreach ($db->getSemester() as $row) : ?>
            <option value="<?= Helper::html($row['semester_id']) ?>"><?= Helper::html($row['name']) ?> <?= Helper::formatDate($row['start_date']) ?> - <?= Helper::formatDate($row['end_date']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please choose a semester.</div>
        </div>
        <div class="col-md-6">
          <label for="campus_id" class="form-label">Campus <span class="text-danger">*</span></label>
          <select id="campus_id" name="campus_id" class="form-select" data-bs-toggle="tooltip" title="<?=Helper::getCampusTooltip()?>"  required>
            <option selected disabled="disabled" value="">Select Campus</option>
            <?php foreach ($db->getCampuses() as $row) : ?>
            <option value="<?= Helper::html($row['campus_id']) ?>"><?= Helper::html($row['campus']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please choose a Campus.</div>
        </div>
        <div class="col-md-6">
          <label for="day_id" class="form-label">Day <span class="text-danger">*</span></label>
          <select id="day_id" name="day_id" class="form-select" required>
            <option selected disabled value="">Select Day</option>
            <?php foreach ($db->getDays() as $row) : ?>
            <option value="<?= Helper::html($row['day_id']) ?>"><?= Helper::html($row['day']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please choose a day.</div>
        </div>
        <div class="col-md-6">
          <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="start_time" name="start_time" placeholder="enter start time" required>
          <div class="invalid-feedback">Please choose a start time.</div>
        </div>
        <div class="col-md-6">
          <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
          <input type="text" class="form-control timepicker" id="end_time" name="end_time" placeholder="enter end time" required>
          <div class="invalid-feedback">Please choose a end time.</div>
        </div>
        <div class="col-md-6">
          <label for="room" class="form-label">Room</label>
          <input type="text" class="form-control" id="room" name="room" placeholder="enter room">
        </div>
        <div class="col-md-6">
          <label for="colour" class="form-label">Colour <span class="text-danger">*</span></label>
          <input type="color" class="form-control form-control-color" id="colour" name="colour" value="<?= Helper::getDefaultColour(); ?>" title="Choose class colour">
        </div>
        <div class="col-12">
          <label for="type_id" class="form-label">Type <span class="text-danger">*</span></label>
          <select id="type_id" name="type_id" class="form-select type_id" required>
            <option selected disabled value="">Select Class type</option>
            <?php foreach ($db->getClassTypes() as $row) : ?>
            <option value="<?= Helper::html($row['type_id']) ?>"><?= Helper::html($row['type']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please choose the class type.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCloseModal" value="#addClassForm" data-bs-dismiss="modal" >Close</button>
        <button type="submit" class="btn btn-success" name="addClass" id="addClass">Add Class</button>
      </div>
    </form>
  </div>
</div>
</div>





<!-- Add personal calendar event modal -->
<div class="modal fade" id="addPersonalCalendarEventModal" tabindex="-1" aria-labelledby="addPersonalCalendarLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addPersonalCalendarLabel">Add personal event</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form class="row g-3 needs-validation" action="" id="addPersonalEventForm" method="post" novalidate autocomplete="off">
        <div class="mb-1">
          <label for="event_title" class="form-label">Title<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="event_title" name="event_title" placeholder="event_title" autofocus required>
          <div class="invalid-feedback">Title is required!.</div>
        </div>
        <div class="mb-1">
          <label for="event_description" class="form-label">Description</label>
          <textarea class="form-control editor" id="event_description" name="event_description" rows="3" placeholder="Description"></textarea>
        </div>
        <div class="mb-1">
          <label for="location" class="form-label">Location</label>
          <input type="text" class="form-control" id="location" name="location" placeholder="location">
        </div>
        <div class="mb-1">
          <label for="event_start_date_time" class="form-label">Start Date and time<span class="text-danger">*</span></label>
          <input type="datetime" class="form-control" id="event_start_date_time" name="event_start_date_time" placeholder="Start date & time">
        </div>
        <div class="mb-1">
          <label for="event_end_date_time" class="form-label">End Date and time<span class="text-danger">*</span></label>
          <input type="datetime" class="form-control" id="event_end_date_time" name="event_end_date_time" placeholder="End date & time">
        </div>
        <div class="mb-1">
          <label for="event_status_id" class="form-label">Status <span class="text-danger">*</span></label>
          <select id="event_status_id" name="event_status_id" class="form-select" required>
            <option selected disabled value="">Select Status</option>
            <?php foreach ($db->getStatus() as $row) : ?>
            <option style="color:<?= $row['hex_colour'] ?>" value="<?= Helper::html($row['status_id']) ?>"><?= Helper::html($row['status_level']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please select a status!</div>
        </div>
        <div class="mb-1">
          <label for="event_priority_id" class="form-label">Priority <span class="text-danger">*</span></label>
          <select id="event_priority_id" name="event_priority_id" class="form-select" required>
            <option selected disabled value="">Select Priority</option>
            <?php foreach ($db->getPriority() as $row) : ?>
            <option style="color:<?= $row['hex_colour'] ?>" value="<?= Helper::html($row['priority_id']) ?>"><?= Helper::html($row['priority_level']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please select a priority!</div>
        </div>
        <div class="mb-1">
          <label for="event_type_id" class="form-label">Type <span class="text-danger">*</span></label>
          <select id="event_type_id" name="event_type_id" class="form-select" required>
            <option selected disabled value="">Select activity type</option>
            <?php foreach ($db->getActivity() as $row) : ?>
            <option style="color:<?= $row['hex_colour'] ?>" value="<?= Helper::html($row['activity_id']) ?>"><?= Helper::html($row['type']) ?></option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Please select a priority!</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCloseModal" value="#addPersonalEventForm" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="btnAddPersonalCalendar" id="btnAddPersonalCalendar">Add Event</button>
      </div>
    </form>
  </div>
</div>
</div>


<!-- terms and conditions -->
<div class="modal fade" id="termsAndConditionsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Terms & conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h1>personal details</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, voluptates laudantium ut dolores itaque, ex veritatis, voluptatum assumenda numquam illum optio. Voluptatibus quasi repudiandae impedit labore! Quasi, quae praesentium. Rerum!
        Quidem ad facilis repellendus! Excepturi minima inventore nam et quae commodi. Reprehenderit impedit laudantium minima minus dolor beatae, incidunt, numquam quidem accusantium, labore doloremque doloribus qui nihil consequatur possimus. Ad.
        Commodi ad facere ea obcaecati nulla tenetur impedit dolor magnam adipisci mollitia sequi illo, quos aut nisi ratione? Laborum ipsam ipsum explicabo quae voluptatum obcaecati id esse voluptatibus officiis eum?
        Corrupti, in. Adipisci tempora excepturi corporis ut alias sunt ad quos! Magnam, incidunt. Amet fugit dignissimos veniam commodi. Soluta quo aliquid officia impedit earum voluptatibus nostrum obcaecati. Accusamus, perspiciatis est.
        Perspiciatis officiis eos, consequuntur quae eveniet voluptas libero repudiandae rem cumque rerum sed tempore ex quas facilis repellat magni veniam. Aliquam delectus deleniti, vero repellat dignissimos officiis. Blanditiis, quisquam laudantium!
        Dignissimos voluptates rem eius dolor atque natus laudantium incidunt, esse, enim vel corporis? Deserunt, praesentium! Ipsam vel minus accusamus impedit laborum, odio at unde, labore officia fugiat porro, voluptate illum.
        Tempore ea eum et ratione doloremque quod repellat accusamus? Distinctio non nesciunt pariatur quo soluta maxime est corrupti saepe, ea et aut numquam sit! Sunt suscipit in quia accusantium corrupti.
        Quia, et cupiditate. Commodi fugit architecto sed. Excepturi rem, quo animi repellat nesciunt nihil eveniet, assumenda nisi mollitia totam veritatis hic ad est modi sapiente eos nobis accusamus doloribus amet.
        Quibusdam libero a asperiores. Unde, ut reiciendis velit mollitia quibusdam ducimus aspernatur eligendi ipsa at odit dolorem commodi explicabo asperiores est. Cum eligendi necessitatibus adipisci natus quod id dolor? Repellat.
        Harum fugit laudantium nesciunt debitis voluptatem eligendi sit libero sint tempore eum recusandae iusto cum odio deserunt pariatur accusamus rem ut reprehenderit atque, similique mollitia magnam reiciendis? Est, sit officia?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Add semester modal -->
<div class="modal fade" id="addSemesterModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addPersonalCalendarLabel">Add semester</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form class="row g-3" action="" id="SemesterForm" method="post"  autocomplete="off" onsubmit="document.getElementById('btnAddSemester').disabled = true">
        <div class="mb-1">
          <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="name" name="name" placeholder="name" autofocus required>
          <div class="invalid-feedback">Name is required!.</div>
        </div>

        <div class="mb-1">
          <label for="start" class="form-label">Start Date<span class="text-danger">*</span></label>
          <input type="datetime" class="form-control" id="start" name="start" placeholder="Start date & time" required>

        </div>
        <div class="mb-1">
          <label for="end" class="form-label">End Date<span class="text-danger">*</span></label>
          <input type="datetime" class="form-control" id="end" name="end" placeholder="End date & time" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnAddSemester" class="btn btn-secondary btnCloseModal" value="#addPersonalEventForm" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="btnAddSemester" id="btnAddSemester">Add Semester</button>
      </div>
    </form>
  </div>
</div>
</div>



<!-- Add Activity modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="">Add Activity</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <form class="row g-3 needs-validation" action="" id="add_activity" method="post"  autocomplete="off">
        <div class="mb-1">
          <label for="type" class="form-label">Activity Type:<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="type" name="type" placeholder="activity_name" autofocus required>
          <div class="invalid-feedback">activity is required!.</div>
        </div>

        <div class="mb-3">
                <label for="colour_id" class="form-label">Colour preference</label>
                <select id="colour_id" name="colour_id" class="form-select" required>
                    <option selected disabled value="">Select colour preference</option>
                    <?php foreach ($db->getColours() as $row) : ?>
                        <option style="color:<?= $row['hex_colour'] ?>" value="<?= Helper::html($row['colour_id'])?>"><?= Helper::html($row['colour_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small id="colourHelpBlock" class="form-text text-muted">this is the colour of the acitivity</small>

            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCloseModal" value="#addPersonalEventForm" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="btnAddActivity" id="btnAddActivity">Add Activity</button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- view, edit and delete modal -->
<div id="viewClasses"></div>
<div id="viewPersonalEvent"></div>
<div id="viewSemester"></div>