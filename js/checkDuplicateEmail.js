
let isDuplicateEmail = false;
$(document).ready(function () {
    // check duplicate
    if (document.querySelector('#email')) {
      const initialEmail = $('#email').val(); // initial module email value for updating

      $('#email').on('input blur focus', function () {
        const emailError = '#emailErrorMessage';

       if($(this).val() === initialEmail) return
  
       checkEmail($(this).val());
        async function checkEmail(email) {
          try {
            const response = await fetch('checkEmail.inc.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: new URLSearchParams({
                email: email
              }),
            });
            let data = await response.text();
       
            if (Boolean(data)) {
              isDuplicateEmail = true;
              document.querySelector(emailError).textContent =
                'This email already exists!';
              document.querySelector('#email').classList.add('error');
  
              document
                .querySelector('form')
                .setAttribute('onsubmit', 'return false;');

              return;
            } 
            isDuplicateEmail = false
            document.querySelector(emailError).textContent = '';
            document.querySelector('#email').classList.remove('error');
  
            document
              .querySelector('form')
              .setAttribute('onsubmit', 'return true;');
          } catch (error) {
            console.error(
              `there was a problem finding duplicate email ${error.message}`
            );
          }
        }
      }); // email event listener
    }
  });
  