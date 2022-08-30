<?php
session_start();
require_once '../includes/class-autoload.php';
$db = Database::getInstance();

if (isset($_POST['module_id_search'])) $db->setModuleID(trim(Helper::html($_POST['module_id_search'])));

if (isset($_POST['coursework_title'])) $db->setCourseworkTitle(trim(Helper::html($_POST['coursework_title'])));

$page_array = [];
$page = 1;
$db->setPageNumber($page);

// set page
if (isset($_POST['page']) && $_POST['page'] > 1) {

    $start = (($_POST['page'] - 1) * $db->getRecordsPerPage());
    $db->setStart($start);
    $page = $_POST['page'];
} else {
    $start = 0;
    $db->setStart($start);
}
$pagination_output = '';

$pagination_output .= '
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center pt-4">
  ';

$total_links = ceil($db->getCourseworkCount() / $db->getRecordsPerPage());
$previous_link = '';
$next_link = '';
$page_link = '';


if ($total_links > 4) {
    if ($page < 5) {
        for ($count = 1; $count <= 5; $count++) {
            $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
    } else {
        $end_limit = $total_links - 5;
        if ($page > $end_limit) {
            $page_array[] = 1;
            $page_array[] = '...';
            for ($count = $end_limit; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        } else {
            $page_array[] = 1;
            $page_array[] = '...';
            for ($count = $page - 1; $count <= $page + 1; $count++) {
                $page_array[] = $count;
            }
            $page_array[] = '...';
            $page_array[] = $total_links;
        }
    }
} else {
    for ($count = 1; $count <= $total_links; $count++) {
        $page_array[] = $count;
    }
}

for ($count = 0; $count < count($page_array); $count++) {
    if ($page == $page_array[$count]) {
        $page_link .= '
      <li class="page-item active">
        <a class="page-link" href="#">' . $page_array[$count] . '</a>
      </li>
      ';

        $previous_id = $page_array[$count] - 1;
        if ($previous_id > 0) {
            $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="getPage(this.getAttribute(\'data-page_number\'))" data-page_number="' . $previous_id . '">Previous</a></li>';
            $db->setPageNumber($page);
        } else {
            $previous_link = '
        <li class="page-item disabled">
          <a class="page-link" href="#">Previous</a>
        </li>
        ';
        }
        $next_id = $page_array[$count] + 1;
        if ($next_id >= $total_links) {
            $next_link = '
        <li class="page-item disabled">
          <a class="page-link" href="#">Next</a>
        </li>
          ';
        } else {
            $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="getPage(this.getAttribute(\'data-page_number\'))" data-page_number="' . $next_id . '">Next</a></li>';
            $db->setPageNumber($page);
        }
    } else {
        if ($page_array[$count] == '...') {
            $page_link .= '
        <li class="page-item disabled">
            <a class="page-link" href="#">...</a>
        </li>
        ';
        } else {
            $page_link .= '
        <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="getPage(this.getAttribute(\'data-page_number\'))" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</a></li>
        ';
            $db->setPageNumber($page);
        }
    }
}

$pagination_output .= $previous_link . $page_link . $next_link;
$pagination_output .= '
  </ul>
  </nav>
  ';
?>

<?php if ($db->getCourseworkCount() > 0) : ?>
    <p class="lead pt-3"><?= $db->getCourseworkCount() ?> result<?= $db->getCourseworkCount() == 1 ? '' : 's' ?> found</p>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" id="courseworkList">
        <?php foreach ($db->getCourseworkSearchResults() as $row) : ?>
            <div class="col">
                <div class="card h-100" id="<?= $row['coursework_id'] ?>">
                    <?php if(!empty($row['image'])):?>
                        <div class="inner">
                            <a role="button"
                            href="edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">
                            <img src="<?= $row['image'] ?>" class="card-img-top card-image " alt="coursework image">
                            </a>
                        </div>
                    <?php endif?>
                    <div class="card-body">
                        <h5 class="card-title"><?= Helper::html($row['title']) ?></h5>
                        <p class="text-muted"><?= $row['module_code'] ?> <?= $row['module_name'] ?></p>
						<?php if(!empty($row['description'])): ?>
						<p class="card-text"><small class="text-muted">Description:</small> <br>
                            <?= nl2br($row['description']) ?></p>
						<?php endif;?>
                        
						<p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
						
                            <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) !== 'success') : ?>
                             <strong> 
                             <?=Helper::dueDateMsg($row['due_date']) ?> (<?= date("dS M Y", strtotime($row['due_date'])) ?>)
                              </strong>
                              <?php else: ?>
                                <strong>Due: <?= date("dS M Y", strtotime($row['due_date'])) ?>           </strong>
                              <?php endif; ?>
						</p>
							
                        <p class="card-text"><small class="text-muted">Status:</small>
                            <span class="badge bg-<?= $row['status_colour'] ?>"><?= $row['status_level'] ?></span>
                        </p>
                        <?php if ($row['status_level'] !== 'Completed') : ?>
                            <p class="card-text"><small class="text-muted">Priority:</small>
                                <span><?= Helper::getPriorityMessage($row['priority_level']) ?></span>
                            </p>
                        <?php endif; ?>
                        <a role="button" class="btn btn-warning" href="edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">View</a>
                        <button type="button deleteCoursework" onclick="deleteCoursework('<?= $row['title'] ?>','<?= $row['coursework_id'] ?>')" class="btn btn-danger">
                            Delete
                        </button>

                        <noscript>
                            <button type="button" class="btn btn-danger">
                                Delete
                            </button>
                        </noscript>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="mt-5">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                No coursework found
            </div>
        </div>
    <p>Related coursework <?php if (!empty($_POST['module_id_search'])) echo 'for ' . $db->getModuleName($_POST['module_id_search']) ?></p>
    <?php if($db->relatedCourseworkResults($_POST['module_id_search'])):?>
       
      <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" id="courseworkList">
        <?php foreach ($db->relatedCourseworkResults($_POST['module_id_search']) as $row) : ?>
            <div class="col">
                <div class="card h-100" id="<?= $row['coursework_id'] ?>">
                <?php if(!empty($row['image'])):?>
                     
                        <div class="inner">
                            <a role="button"
                            href="edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">
                            <img src="<?= $row['image'] ?>" class="card-img-top card-image " alt="coursework image">
                            </a>
                        </div>
                    <?php endif?>
					 <div class="card-body">
                        <h5 class="card-title"><?= Helper::html($row['title']) ?></h5>
                        <p class="text-muted"><?= $row['module_code'] ?> <?= $row['module_name'] ?></p>
						<?php if(!empty($row['description'])): ?>
						<p class="card-text"><small class="text-muted">Description:</small> <br>
                            <?= nl2br($row['description']) ?></p>
						<?php endif;?>
                        
						<p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>">
						
                            <?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) !== 'success') : ?>
                             <strong> 
                             <?=Helper::dueDateMsg($row['due_date']) ?> (<?= date("dS M Y", strtotime($row['due_date'])) ?>)
                              </strong>
                              <?php else: ?>
                                <strong>Due: <?= date("dS M Y", strtotime($row['due_date'])) ?>           </strong>
                              <?php endif; ?>
						</p>
							
                        <p class="card-text"><small class="text-muted">Status:</small>
                            <span class="badge bg-<?= $row['status_colour'] ?>"><?= $row['status_level'] ?></span>
                        </p>
                        <?php if ($row['status_level'] !== 'Completed') : ?>
                            <p class="card-text"><small class="text-muted">Priority:</small>
                                <span><?= Helper::getPriorityMessage($row['priority_level']) ?></span>
                            </p>
                        <?php endif; ?>
                        <a role="button" class="btn btn-warning" href="edit_coursework.php?editCoursework=<?= Helper::html($row['coursework_id']) ?>">View</a>
                        <button type="button deleteCoursework" onclick="deleteCoursework('<?= $row['title'] ?>','<?= $row['coursework_id'] ?>')" class="btn btn-danger">
                            Delete
                        </button>

                        <noscript>
                            <button type="button" class="btn btn-danger">
                                Delete
                            </button>
                        </noscript>
                    </div>
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
        <?php else: ?>
            <div class="mt-5">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                Unable to fetch related coursework
            </div>
        </div>
    <?php endif; // related results?> 
<?php endif; // coursework count ?>
<?= $pagination_output; ?>