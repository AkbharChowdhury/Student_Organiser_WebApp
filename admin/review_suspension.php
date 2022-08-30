<?php
$current_page = 'admin_dashboard';
$page_title = 'Admin Dashboard';
require_once '../templates/header.php';
require_once 'review_suspension.inc.php';
?>

<div class="container py-5">
<?= Helper::breadcrumb('Student review', 'admin_dashboard.php') ?>

<h1 class="text-capitalize"><?=$studentData['firstname'].' '.$studentData['lastname']?> account Review</h1>

<form class="row g-3 needs-validation" method="post" action="" novalidate>
  <div class="col-md-6">
    <label for="account_suspended" class="form-label">Account Suspended</label>
    <select id="account_suspended" class="form-select" name="account_suspended" required  onchange="checkReason(this.value)">
      <option selected disabled>Account</option>
      <option value="Yes" <?php if(!empty($studentData['student_account_deleted'])) echo 'selected'?>>Yes</option>
      <option value="No" <?php if(empty($studentData['student_account_deleted'])) echo 'selected'?>>No</option>
    </select>
    <div class="invalid-feedback">Account required</div>
  </div>
 
  <div class="col-12">
    <label for="reason" class="form-label">Reason</label>
    <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Reason" ><?=nl2br($studentData['reason'])?></textarea>
  </div>
  <div class="col-12">
    <label for="reason" class="form-label">Action taken</label>
    <textarea class="form-control editor" id="action_taken" name="action_taken" rows="3" placeholder="action" required ><?$_POST['action_taken']?? ''?></textarea>
    <div class="invalid-feedback">Action taken is required</div>

  </div>
  
  
  
  <div class="col-12">
    <button type="submit" class="btn btn-success">Submit action</button>
  </div>
</form>
</div>

<?php require_once '../templates/footer.php'; ?>
<script>
  // document.getElementById('account_suspended').onchange = ()=>{
  //   if(this.value === 'Yes'){
  //     document.getElementById('reason').value = '';
  //     document.getElementById('reason').true;
  //     return;
  //   }
  //   document.getElementById('reason').disabled = false;

    
  // }
  let reason = document.getElementById('reason');
  let account_suspended = document.getElementById('account_suspended');
  if(account_suspended  === 'No'){
    reason.disabled = true;

  }
  if(reason.value !==''){
    // reason.value = 'asa'

  }
  function checkReason(v){
       if(v === 'Yes'){
         alert('s')
      document.getElementById('reason').value = '';
      document.getElementById('reason').true;
    } else{
      document.getElementById('reason').disabled = false;


    }

  }
</script>
<script src="../js/checklist.js"></script>

