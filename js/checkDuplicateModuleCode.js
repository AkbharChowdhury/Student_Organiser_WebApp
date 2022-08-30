const initialModuleCodeVal = $('#module_code').val();

function initialModuleCode() {
  document.getElementById('module_code').value = initialModuleCodeVal;
  document.querySelector('#module_code').classList.remove('error');
  document.querySelector('#moduleCodeErrorMessage').innerHTML = '';
  document.querySelector('form').setAttribute('onsubmit', 'return true;');
}

$(document).ready(function () {
  // check duplicate module code
  if (document.querySelector('#module_code')) {
    const initialModuleCode = $('#module_code').val(); // initial module code value for updating

    $('#module_code').on('input blur focus', function () {
      const moduleError = '#moduleCodeErrorMessage';

      if ($(this).val() === initialModuleCode) return;

      checkModule($(this).val());

      async function checkModule(moduleCode) {
        try {
          const response = await fetch('checkModuleCode.inc.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
              module_code: moduleCode,
            }),
          });
          let data = await response.text();
          if (Boolean(data)) {
            // add error
            document.querySelector('#module_code').classList.add('error');
            document.querySelector('form').setAttribute('onsubmit', 'return false;');
            document.querySelector(moduleError).innerHTML = `This module code already exists! Revert back to <a href="#"  onclick="initialModuleCode()" class="link-success">${initialModuleCode}</a>`;

            return;
          }
          // remove error
          document.querySelector(moduleError).textContent = '';
          document.querySelector('#module_code').classList.remove('error');
          document.querySelector('form').setAttribute('onsubmit', 'return true;');
        } catch (error) {
          console.error(
            `there was a problem finding duplicate module code ${error.message}`
          );
        }
      }
    }); // module code event listener
  }
});
