<?php
$current_page = 'dashboard';
$page_title = 'Dashboard - my progress';
require_once '../templates/header.php';
require_once 'dashboard.inc.php';
?>

<?php require_once '../includes/modals.inc.php'; ?>
<div class="container mt-3">
    <?php require_once '../includes/session_message.inc.php'; ?>
    <section class="pt-3 pb-3">
        <h1 class="text-capitalize text-dark p-2">Dashboard</h1>
        <div class="border-bottom border-3 border-dark mb-4"></div>
        <h3 class="text-primary text-center text-capitalize">
            my coursework
        </h3>
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="text-dark">Total coursework this academic year <strong>Sep <?= date('Y', strtotime('-1 year')) ?> - Aug <?= date('Y') ?></strong></p>
                <div id="coursework-bar"></div>
            </div>

            <h3 class="text-primary text-center text-capitalize">my Activities</h3>

            <div class="col-md-12 text-center">

                <p class="text-dark">My activities this year <strong>Sep <?= date('Y', strtotime('-1 year')) ?> - Aug <?= date('Y') ?></strong></p>
                <div id="yearlyActivityDiv"></div>

            </div>

        </div>
        <div class="accordion pt-5" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <h3>Upcoming coursework this month <?= date('M Y') ?></h3>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <?= $cwProgressData['icon'] ?>
                        <?php if ($db->getUpcomingCourseworkByMonth()) : ?>
                            <div class="col-md-10">
                                <div class="progress mt-3">
                                    <div class="progress-bar <?= $progress_bar_class ?>" role="progressbar" style="width: <?= $percentageCompleted ?>%;" aria-valuenow="<?= $percentageCompleted ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= $percentageCompleted ?>%
                                    </div>
                                </div>
                                <?= $cwProgressData['text']; ?>
                                <?php if (intval($percentageCompleted) !== 100) : ?>
                                    <div class="progress" aria-valuemax="100">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $cwProgress['percentage_not_completed'] ?>%" aria-valuenow="<?= $cwProgress['percentage_not_completed'] ?>" aria-valuemin="0">
                                            <?= $cwProgress['percentage_not_completed'] ?>% not completed (
                                            <?= $cwProgress['total_not_completed'] ?>)
                                        </div>
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $cwProgress['percentage_in_progress'] ?>%" aria-valuenow="<?= $cwProgress['percentage_in_progress'] ?>" aria-valuemin="0">
                                            <?= $cwProgress['percentage_in_progress'] ?>% in progress (
                                            <?= $cwProgress['total_in_progress'] ?>)
                                        </div>
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $cwProgress['percentage_completed'] ?>%" aria-valuenow="<?= $cwProgress['percentage_completed'] ?>" aria-valuemin="0">
                                            <?= $cwProgress['percentage_completed'] ?>% completed (
                                            <?= $cwProgress['total_completed'] ?>)
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" id="productsList">
                                <?php foreach ($db->getUpcomingCourseworkByMonth() as $row) : ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="coursework_id" value="<?= $row['coursework_id'] ?>">
                                        <input type="hidden" name="title" value="<?= Helper::html($row['title']) ?>">
                                        <div class="col">
                                            <div class="card h-100">
                                                <?php if (!empty($row['image'])) : ?>
                                                    <div class="inner">
                                                        <a href="../coursework/edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">
                                                            <img src="<?= $row['image'] ?>" class="card-img-top card-image " alt="coursework image">
                                                        </a>
                                                    </div>
                                                <?php endif ?>
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <?= Helper::html($row['title']) ?>
                                                    </h5>
                                                    <p class="text-muted">
                                                        <?= $row['module_code'] ?>
                                                        <?= $row['module_name'] ?>
                                                    </p>
                                                    <p class="card-text">
                                                        <small class="text-muted">Description:
                                                        </small>
                                                        <br>
                                                        <?= nl2br($row['description']) ?>
                                                    </p>
                                                    <p>
                                                        <?php foreach ($db->countCheckListItemsByCW($row['coursework_id']) as $items) : ?>
                                                            <?php if (intval($items['total_items'] > 0)) : ?>
                                                                <a class="link-success btnViewChecklist" data-cw-title="<?= $row['title'] ?>" data-coursework-id="<?= $row['coursework_id'] ?>" role="button">Checklist details:
                                                                    <?= $items['total_completed'] . '/' . $items['total_items']; ?>
                                                                </a>
                                                            <?php else : ?>
                                                                No checklist added
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </p>
                                                    <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
                                                        <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) == 'danger') : ?>
                                                            <strong><?=Helper::dueDateMsg($row['due_date']) == 'Overdue' ? 'Overdue by:' : 'Due within:';?></strong>
                                                        <?=Helper::calculateDeadlineDate($row['due_date']) ?>
                                                    <?php endif; ?>
                                                    </p>
                                                    <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
                                                        <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) !== 'success') : ?>
                                                            <strong> 
                                                                <?=Helper::dueDateMsg($row['due_date']) ?> (<?= date("dS M Y", strtotime($row['due_date'])) ?>)
                                                            </strong>
                                                            <?php else: ?>
                                                                <strong>Due: <?= Helper::dueDateMsg($row['due_date']) ?> (<?= date("dS M Y", strtotime($row['due_date'])) ?>)</strong>
                                                        <?php endif; ?>
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
                                                            <small class="text-muted">Priority:
                                                            </small>
                                                            <span>
                                                                <?= Helper::getPriorityMessage($row['priority_level']) ?>
                                                            </span>
                                                        </p>
                                                    <?php endif; ?>

                                                    <a role="button" class="btn btn-warning" href="../coursework/edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">View</a>

                                                    <?php if ($row['status_level'] !== 'Completed') : ?>
                                                        <button type="submit" class="btn btn-success" name="btnSetCompleted">Completed
                                                        </button>
                                                    <?php endif; ?>
                                    </form>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php else : ?>

            <p class="text-success"><i class="fas fa-laugh-beam fa-2x"></i><br>
                No upcoming coursework this month
            </p>
        <?php endif; ?>
        </div>
</div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            <h3>Upcoming events
            </h3>
        </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
        <div class="accordion-body">
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
        </div>
    </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <h3>coursework to-do-list</h3>
        </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <?php if ($db->getUpcomingCWChkList()) : ?>
                <?php foreach ($db->getUpcomingCWChkList() as $k => $v) : ?>
                    <h4 class="pt-3"><?= $k ?></h4>
                    <hr style="height:1px;border:none;color:#333;background-color:#333;" />
                    <?php foreach ($v as $coursework) : ?>
                        <span>
                            <h4 class="pt-3 text-muted"><?= $coursework['coursework_title'] ?></h4>
                        </span>
                        <a class="btn btn-warning mt-2 mb-2" href="../coursework/edit_coursework.php?editCoursework=<?= Helper::html($coursework['coursework_id']) ?>">Manage coursework</a>

                        <ol class="list-group list-group">
                            <?php foreach ($db->getCheckListDetails($coursework['coursework_id']) as $item) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><?= $item['title'] ?></div>
                                        <span class="text-<?= Helper::showStatusColour($item['status_level']) ?>"><?= $item['status_level'] ?></span>
                                    </div>
                                    <span class="badge bg-<?= Helper::showStatusColour($item['status_level']) ?> rounded-pill"><?= date('F d, Y H:ia', strtotime($item['due_date'])) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-success"><i class="fas fa-laugh-beam fa-2x"></i><br>to-do-list is empty</p>
            <?php endif; ?>

        </div> <!-- accordion-body -->
    </div>
</div>

</div>
</section>
</div>

<?php require_once '../templates/footer.php'; ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="../js/chart.js"></script>