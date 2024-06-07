<?php if ($db->getUpcomingEventsByMonth()) : ?>
    <div class="mt-2 py-2">
        <a class="btn btn-warning text-capitalize" href="../calendar/calendar.php?calendar=personal" role="button">Go to personal calendar</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" id="productsList">
        <?php foreach ($db->getUpcomingEventsByMonth() as $row) : ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize">
                            <?= Helper::html($row['title']) ?>
                        </h5>
                        <p class="card-text">
                            <small class="text-muted">Description:
                            </small>
                            <br>
                            <?= nl2br($row['description']) ?>
                        </p>
                        <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
                            <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) == 'danger') : ?>
                                Starts in:
                                <?= Helper::calculateDeadlineDate($row['start']) ?>

                            <?php endif; ?>
                        </p>
                        <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
                            <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) !== 'success') : ?>Due:
                            <strong>
                                <?=Helper::dueDateMsg($row['end']) ?> (
                                <?= date("dS M Y", strtotime($row['end'])) ?>)
                                <?php endif; ?>
                            </strong>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">Status:
                            </small>
                            <span class="badge bg-<?= $row['status_colour'] ?>">
                                            <?= $row['status_level'] ?>
                                        </span>
                        </p>
                        <?php if ($row['status_level'] !== 'Completed') : ?>

                            <p class="card-text">
                                <small class="text-muted">Priority:</small>
                                <span>
                                                <?= Helper::getPriorityMessage($row['priority_level']) ?>
                                            </span>
                            </p>
                        <?php endif; ?>
                        <?php if ($row['status_level'] !== 'Completed') : ?>
                            <form action="" method="post">
                                <input type="hidden" name="personal_calendar_id" value="<?= $row['personal_calendar_id'] ?>">
                                <input type="hidden" name="title" value="<?= $row['title'] ?>">
                                <button type="submit" class="btn btn-success" name="btnSetCompletedPersonal">Completed</button>

                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>

    <p class="text-success"><i class="fas fa-laugh-beam fa-2x"></i><br>
        No upcoming personal events this month
    </p>
<?php endif; ?>