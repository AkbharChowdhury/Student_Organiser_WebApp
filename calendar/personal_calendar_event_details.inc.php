<?php
date_default_timezone_set('Europe/London');
// session_start();
require_once '../includes/class-autoload.php';
$db = Database::getInstance();
?>

<?php if (isset($_POST['personal_calendar_id'])) : ?>
    <?php foreach ($db->editPersonalCalendar($_POST['personal_calendar_id']) as $row) : ?>
        <div class="modal fade" id="viewEditPersonalEventDetails" tabindex="-1" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= Helper::html($row['title']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="row g-3 needs-validation" id="updatePersonalEventDetailsForm" method="post" novalidate>
                            <input type="hidden" name="personal_calendar_id" id="personal_calendar_id" value="<?= Helper::html($row['personal_calendar_id']) ?>">
                            <div class="mb-1">
                                <label for="event_title" class="form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="event_title" name="event_title" placeholder="event_title" autofocus required value="<?= Helper::html($row['title']) ?? Helper::html($_POST['title']) ?>">
                                <div class="invalid-feedback">Title is required!.</div>
                            </div>
                            <div class="mb-1">
                                <label for="event_description" class="form-label">Description</label>
                                <textarea class="form-control editor" id="event_description" name="event_description" rows="3" placeholder="Description"><?= nl2br($row['description']) ?? nl2br($row['description']) ?></textarea>
                            </div>

                            <div class="mb-1">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" placeholder="location" value="<?= Helper::html($row['location']) ?? Helper::html($_POST['location']) ?>">
                            </div>
                            <div class="mb-1">
                                <label for="event_start_date_time" class="form-label">Start Date and time<span class="text-danger">*</span></label>
                                <input type="datetime" class="form-control" id="event_start_date_time_edited" name="event_start_date_time_edited" placeholder="Start date & time" value="<?= Helper::html($row['start']) ?? Helper::html($_POST['start']) ?>">
                            </div>
                            <div class="mb-1">
                                <label for="event_end_date_time" class="form-label">End Date and time<span class="text-danger">*</span></label>
                                <input type="datetime" class="form-control end" id="event_end_date_time_edited" name="event_end_date_time_edited" placeholder="End date & time" value="<?= Helper::html($row['end']) ?? Helper::html($_POST['end']) ?>">
                            </div>
                            <div class="mb-1">
                                <label for="event_status_id" class="form-label">Status <span class="text-danger">*</span></label>
                                <select id="event_status_id" name="event_status_id" class="form-select" required>
                                    <option selected disabled value="">Select Status</option>
                                    <?php foreach ($db->getStatus() as $status) : ?>
                                        <option <?php if ($status['status_id'] === $row['status_id']) echo ' selected' ?> style="color:<?= $row['hex_colour'] ?>" value="<?= Helper::html($status['status_id']) ?>"><?= Helper::html($status['status_level']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Please select a status!</div>
                            </div>
                            <div class="mb-1">
                                <label for="event_priority_id" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select id="event_priority_id" name="event_priority_id" class="form-select" required>
                                    <option selected disabled value="">Select Priority</option>
                                    <?php foreach ($db->getPriority() as $priority) : ?>
                                        <option style="color:<?= $priority['hex_colour'] ?>" <?php if ($priority['priority_id'] === $row['priority_id']) echo ' selected' ?> value="<?= Helper::html($priority['priority_id']) ?>"><?= Helper::html($priority['priority_level']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Please select a priority!</div>
                            </div>

                            <div class="mb-1">
                                <label for="event_type_id" class="form-label">Type <span class="text-danger">*</span></label>
                                <select id="event_type_id" name="event_type_id" class="form-select" required>
                                    <option selected disabled value="">Select activity type</option>
                                    <?php foreach ($db->getActivity() as $activity) : ?>
                                        <option style="color:<?= $activity['hex_colour'] ?>" <?php if ($activity['activity_id'] === $row['activity_id']) echo ' selected' ?> value="<?= Helper::html($activity['activity_id']) ?>"><?= Helper::html($activity['type']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Please select an event type!</div>
                            </div>
                            <button type="submit" class="btn btn-success" name="btnUpdateEvent" id="btnUpdateEvent">Update event</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="btnDeleteEvent">Delete event</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>