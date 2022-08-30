let spamCount = 0;
let notRequiredCount = 0;
let otherCount = 0;
function notRequired(id) {
  if ($('#spamTxt').is(':visible')) $('#spamTxt').hide();
  if ($('#otherTxt').is(':visible')) $('#otherTxt').hide();
  if ($('#notRequiredTxt').is(':hidden')) $('#notRequiredTxt').show();

  notRequiredCount++;
  if (notRequiredCount <= 1) {
    //$(id).append(`<p class="text-muted" id="${id.substring(1)}">kjdksjdksd</p>`)
    $(id).append(`
                          <p class="text-muted" id="${id.substring(1)}">
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label for="suggestion" class="form-label">Please explain how can improve our services</label>
                                  <textarea class="form-control" id="suggestion" name="suggestion" rows="3"></textarea>
                              </div>
                          </div>
                      </p>  
              `);
    document.getElementById('suggestion').focus();
    // $('input[type=text]').last().focus();
  } else {
    document.getElementById('suggestion').focus();
  }
}

function spam(id) {
  if ($('#spamTxt').is(':hidden')) $('#spamTxt').show();
  if ($('#notRequiredTxt').is(':visible')) $('#notRequiredTxt').hide();
  if ($('#otherTxt').is(':visible')) $('#otherTxt').hide();

  spamCount++;
  if (spamCount <= 1) {
    $(id).append(
      `<div class="col-sm-6">
      <p class="text-muted mt-3" id="${id.substring(
        1
      )}">Did you know that you can manage your <a href="updateProfile.php">Preferences</a> to reduce spam? Simply opt out from the relevant service that you are no longer interested in.</p>
      </div>`
    );
  }
}

function other(id) {
  if ($('#otherTxt').is(':hidden')) $('#otherTxt').show();

  if ($('#notRequiredTxt').is(':visible')) $('#notRequiredTxt').hide();
  if ($('#spamTxt').is(':visible')) $('#spamTxt').hide();

  otherCount++;
  if (otherCount <= 1) {
    $(id).append(`
                          <p class="text-muted" id="${id.substring(1)}">
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label for="answer" class="form-label">Please type your answer here</label>
                                  <input type="text" class="form-control" name="suggestion" id="answer" aria-describedby="emailHelp">
                              </div>
                          </div>
                      </p>`);
    document.getElementById('answer').focus();
  } else {
    document.getElementById('answer').focus();
  }
}
