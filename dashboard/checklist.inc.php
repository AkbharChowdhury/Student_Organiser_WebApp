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