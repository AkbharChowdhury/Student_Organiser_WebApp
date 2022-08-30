<?php
session_start();
require_once 'class-autoload.php';
$db = Database::getInstance();

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .text-muted {
      color: grey
    }

    .text-danger {
      color: red;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      max-width: 300px;
      margin: auto;
      text-align: center;
      font-family: arial;
    }

    .price {
      color: grey;
      font-size: 22px;
    }

    .card button {
      border: none;
      outline: 0;
      padding: 12px;
      color: white;
      background-color: #000;
      text-align: center;
      cursor: pointer;
      width: 100%;
      font-size: 18px;
    }

    .card button:hover {
      opacity: 0.7;
    }
  </style>

  <title>Coursework reminder</title>
</head>

<body>
  <?php if ($db->getUpcomingCourseworkByMonth()) : ?>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">

      <?php foreach ($db->getUpcomingCourseworkByMonth() as $row) : ?>
        <div class="card">
          <?php if (!empty($row['image'])) : ?>
            <img src="<?= $row['image'] ?>" alt="coursework image" style="width:100%">                                               
          <?php endif ?>
          <h1><?= Helper::html($row['title']) ?></h1>
          <small class="text-muted">description</small>
          <p><?= nl2br($row['description']) ?></p>

          <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>"><?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) == 'danger') : ?>Due in <?= Helper::calculateDeadlineDate($row['due_date']) ?><?php endif; ?></p>
          <p class="card-text text-<?= Helper::cwDateColour($row['due_date'], $row['status_level']) ?>"><?php if (Helper::cwDateColour($row['due_date'], $row['status_level']) !== 'success') : ?>Due: <?= Helper::dueDateMsg($row['due_date']) ?> (<?= date("dS M Y", strtotime($row['due_date'])) ?>)<?php endif; ?></p>
          <p class="card-text"><small class="text-muted">Status:</small>
            <span class="badge bg-<?= $row['status_colour'] ?>"><?= $row['status_level'] ?></span>
          </p>
          <?php if ($row['status_level'] !== 'Completed') : ?>
            <p class="card-text"><small class="text-muted">Priority:</small>
              <span><?= Helper::getPriorityMessage($row['priority_level']) ?></span>
            </p>
          <?php endif; ?>

        </div>

      <?php endforeach; ?>
    </div>
  <?php else : ?>
    <p class="text-success">No upcoming coursework</p>
  <?php endif; ?>


</body>

</html>