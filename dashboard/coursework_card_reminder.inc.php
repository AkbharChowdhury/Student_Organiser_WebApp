<?php foreach ($db->getUpcomingCourseworkByMonth() as $row) : ?>
    <form action="" method="post">
        <input type="hidden" name="coursework_id" value="<?= $row['coursework_id'] ?>">
        <input type="hidden" name="title" value="<?= Helper::html($row['title']) ?>">
        <div class="col">
            <div class="card h-100">
                <?php if (!empty($row['image'])) : ?>
                    <div class="inner">
                        <a href="../coursework/edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">
                            <img src="<?= $row['image'] ?>" class="card-img-top card-image "
                                 alt="coursework image">
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
                                <a class="link-success btnViewChecklist"
                                   data-cw-title="<?= $row['title'] ?>"
                                   data-coursework-id="<?= $row['coursework_id'] ?>"
                                   role="button">Checklist details:
                                    <?= $items['total_completed'] . '/' . $items['total_items']; ?>
                                </a>
                            <?php else : ?>
                                No checklist added
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                    <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
                        <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) == 'danger') : ?>
                            <strong><?= Helper::dueDateMsg($row['due_date']) == 'Overdue' ? 'Overdue by:' : 'Due within:'; ?></strong>
                            <?= Helper::calculateDeadlineDate($row['due_date']) ?>
                        <?php endif; ?>
                    </p>
                    <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
                        <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) !== 'success') : ?>
                            <strong>
                                <?= Helper::dueDateMsg($row['due_date']) ?>
                                (<?= date("dS M Y", strtotime($row['due_date'])) ?>)
                            </strong>
                        <?php else: ?>
                            <strong>Due: <?= Helper::dueDateMsg($row['due_date']) ?>
                                (<?= date("dS M Y", strtotime($row['due_date'])) ?>)</strong>
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

                    <a role="button" class="btn btn-warning"
                       href="../coursework/edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">View</a>

                    <?php if ($row['status_level'] !== 'Completed') : ?>
                        <button type="submit" class="btn btn-success" name="btnSetCompleted">
                            Completed
                        </button>
                    <?php endif; ?>
    </form>
    </div>
    </div>
    </div>
<?php endforeach; ?>