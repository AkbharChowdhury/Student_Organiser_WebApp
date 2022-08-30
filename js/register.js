const errorList = document.getElementById('errorList');
let showErrorList = false;

/*********************************** toggle password checkbox   *********************************/
const password = document.querySelector('#password');
const chkPassword = document.querySelector('#chkPassword');
const passCriteria = document.getElementById('password_criteria');
const refresh = document.querySelector('#refresh');
const togglePassword = document.querySelector('#togglePassword');
let btnPasswordToggleClicked = false;
let errors = [];

const inlineError = { phone: [] };
const customErrorList = {};

const validation = Object.freeze({
  // isNumeric: str => (isNaN(str.value) || str.value.indexOf(" ") !== -1),
  is8CharsStr: '<strong>password</strong> must be 8 characters long',

  is11CharsStr:
    '<strong>Phone number must be 11 digits long</strong>\n E.g. 08374327853</strong>',
  startsWith0Str: '<strong>phone number must start with 0</strong>',
  nameStr: (str) =>
    // `${str} cannot contain spaces, numbers or special characters`,
    `<strong>${str}</strong> cannot contain spaces, numbers or special characters`,

  is11Chars: (str) => str.value.length === 11,
  is8Chars: (str) => str.value.length >= 8,

  startsWith0: (str) => str.value.indexOf('0') == 0,
  namePattern: (str) => str.value.match(new RegExp(/^[A-Za-z]+$/)),
});

const decreaseStrengthBar = (id) =>
  (document.getElementById(id).className = 'fa fa-times');
//set initial default values for register form
if (forms.register || forms.updatePassword) {
  document.querySelector('.progress-bar').setAttribute('aria-valuenow', '0');
  decreaseStrengthBar('number');
  decreaseStrengthBar('specialChar');
  decreaseStrengthBar('uppercase');
  decreaseStrengthBar('minLength');
  decreaseStrengthBar('lowercase');
}

if (togglePassword) {
  togglePassword.addEventListener('click', function () {
    // toggle the type attribute
    const type =
      password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye icon
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
    passCriteria.style.display = 'block';

    btnPasswordToggleClicked = true;
  });
}

if (chkPassword)
  chkPassword.addEventListener(
    'change',
    (e) => (password.type = e.target.checked ? 'text' : 'password')
  );

/*********************************** toggle password checkbox ends here   *********************************/

// change image source when the refresh button is clicked
if (refresh) {
  refresh.addEventListener('click', (e) => {
    e.preventDefault();
    document.querySelector('#img-captcha').src = 'includes/captcha.inc.php';
  });
}
/*********************************** password strength meter starts here      *********************************/

passCriteria ? (passCriteria.style.display = 'none') : '';

if (password)
  password.addEventListener('keyup', () => checkPassword(password.value));
if (password)
  password.addEventListener('focus', () =>
    passCriteria
      ? (passCriteria.style.display = 'block')
      : checkPassword(password.value)
  ); // Show password criteria
if (password)
  password.addEventListener('focusout', () => {
    if (
      !passCriteria.getAttribute('style') === 'display block;' &&
      !btnPasswordToggleClicked
    ) {
      passCriteria.style.display = 'block';
      return;
    }
    passCriteria.style.display = 'none';
  }); // Hide password criteria

const checkPassword = (password) => {
  const strengthBar = document.querySelector('.progress-bar');
  let strength = 0;

  // password passwordStrengthMeter regex
  const passwordStrengthMeter = Object.freeze({
    containsUpperCase: (str) => /[A-Z]/.test(str),
    containsLowerCase: (str) => /[a-z]/.test(str),
    containsNumber: (str) => str.match('.*\\d.*'),
    containsSpecialChars: (str) =>
      /[!@#£$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(str),
    is8Chars: (str) => str.length >= 8,
  });

  const updateStrengthBar = (id) => {
    document.querySelector(`#${id}`).className = 'fa fa-check-circle';
    strength++;
  };

  passwordStrengthMeter.containsNumber(password)
    ? updateStrengthBar('number')
    : decreaseStrengthBar('number');
  passwordStrengthMeter.containsSpecialChars(password)
    ? updateStrengthBar('specialChar')
    : decreaseStrengthBar('specialChar');
  passwordStrengthMeter.containsUpperCase(password)
    ? updateStrengthBar('uppercase')
    : decreaseStrengthBar('uppercase');
  passwordStrengthMeter.is8Chars(password)
    ? updateStrengthBar('minLength')
    : decreaseStrengthBar('minLength');
  passwordStrengthMeter.containsLowerCase(password)
    ? updateStrengthBar('lowercase')
    : decreaseStrengthBar('lowercase');

  switch (strength) {
    default:
      setStrength(strengthBar, 0, 'bg-danger');
      break;
    case 1:
      setStrength(strengthBar, 20, 'bg-warning', 'Very weak');
      break;
    case 2:
      setStrength(strengthBar, 40, 'bg-info', 'Average');
      break;
    case 3:
      setStrength(strengthBar, 60, 'bg-success', 'Medium');
      break;
    case 4:
      setStrength(strengthBar, 80, 'bg-dark', 'Strong');
      break;
    case 5:
      setStrength(strengthBar, 100, 'bg-success', 'Very strong');
      break;
  }
};

const setStrength = (
  strengthBar,
  strengthNumber,
  colour = 'bg-success',
  status = 'weak'
) => {
  strengthBar.className = `progress-bar ${colour}`;
  strengthBar.style.width = `${strengthNumber}%`;
  strengthBar.innerText = `${strengthNumber}% ${status}`;
  strengthBar.setAttribute('aria-valuenow', strengthNumber);
};
if (forms.register) {
  let firstName = document.querySelector(
    `#${forms.register.getAttribute('id')} #firstname`
  );
  let lastName = document.querySelector(
    `#${forms.register.getAttribute('id')} #lastname`
  );
  let phone = document.querySelector(
    `#${forms.register.getAttribute('id')} #phone`
  );
  forms.register.addEventListener('submit', (e) => {
    if(!document.getElementById('policy').checked) return false;
    
    if (validateRegisterForm()) {
      if(isDuplicateEmail !== true){
        forms.register.submit();
        return;
      }
    }
    e.preventDefault();
  });

  firstName.addEventListener('focusout', validateFirstName);
  lastName.addEventListener('focusout', validateLastName);
  phone.addEventListener('focusout', validatePhone);
  password.addEventListener('input', validatePassword);

  function validatePassword() {
    const errorFieldMsg = document.getElementById('passwordErrorMessage');

    if (!validation.is8Chars(password)) {
      customErrorList.password = validation.is8CharsStr;
      errors.push(true);
      addError(errorFieldMsg, password, validation.is8CharsStr);
    } else {
      delete customErrorList.password;
      errors.pop();
      removeError(errorFieldMsg, password);
    }

    setErrorOutputList(customErrorList);
  }
  function validateFirstName() {
    const errorFieldMsg = document.getElementById('firstNameErrorMessage');

    if (!validation.namePattern(firstName)) {
      customErrorList.firstName = validation.nameStr('FirstName');
      errors.push(true);
      addError(errorFieldMsg, firstName, validation.nameStr('FirstName'));
    } else {
      delete customErrorList.firstName;
      errors.pop();
      removeError(errorFieldMsg, firstName);
    }

    setErrorOutputList(customErrorList);
  }

  function validateLastName() {
    const errorFieldMsg = document.getElementById('lastNameErrorMessage');

    if (!validation.namePattern(lastName)) {
      addError(errorFieldMsg, lastName, validation.nameStr('LastName'));
      customErrorList.lastName = validation.nameStr('LastName');
      errors.push(true);
    } else {
      delete customErrorList.lastName;
      removeError(errorFieldMsg, lastName);
      errors.pop();
    }

    setErrorOutputList(customErrorList);
  }

  function validatePhone() {
    const errorFieldMsg = document.getElementById('phoneErrorMessage');

    if (!validation.is11Chars(phone)) {
      inlineError.phone.is11Chars = validation.is11CharsStr;
      customErrorList.phoneIs11Chars = validation.is11CharsStr;
      errors.push(true);
    } else {
      delete inlineError.phone.is11Chars;
      delete customErrorList.phoneIs11Chars;
      errors.pop();
    }

    if (!validation.startsWith0(phone)) {
      inlineError.phone.startsWith0 = `${validation.startsWith0Str}`;
      customErrorList.startsWith0 = `${validation.startsWith0Str}`;
      errors.push(true);
    } else {
      delete inlineError.phone.startsWith0;
      delete customErrorList.startsWith0;
      errors.pop();
    }

    setInlineErrors(inlineError.phone, errorFieldMsg, phone);
    setErrorOutputList(customErrorList);
  }

  const validateRegisterForm = () => {
    errors = [];
    validateFirstName();
    validateLastName();
    validatePhone();
    validatePassword();
    return errors.length === 0;
  };

  const setInlineErrors = (errorData, output, errorBorder) => {
    let errorMsg = '';
    showErrorList = true;
    if (Object.keys(errorData).length === 0) {
      output.style.display = 'none';
      errorBorder.classList.remove('error');
      return;
    }

    if (Object.keys(errorData).length !== 0) {
      for (const [key, value] of Object.entries(errorData)) {
        errorMsg += `<p class="mb-0" id="${key}">${value}</p>`;
      }

      output.innerHTML = errorMsg;
      output.style.display = 'block';
      errorBorder.classList.add('error');
    }
  };

  const setErrorOutputList = (output) => {
    let errorMsg = '';
    showErrorList = true;
    if (Object.keys(output).length === 0) $('#errorList').fadeOut('slow');

    if (Object.keys(output).length !== 0) {
      for (const [key, value] of Object.entries(output)) {
        errorMsg += `<p class="mb-0" id="${key}">${value}</p>`;
      }

      if (showErrorList) {
        $('#errorList').html(`<div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Whoops, something went wrong</h4>
        <p>This form contains errors, please read the description below</p>
        <hr>
        <div id="errors"></div>
    </div>`);
        document.getElementById('errors').innerHTML = errorMsg;

        $('#errorList').fadeIn('slow');
      }
    }
  };

  const addError = (output, errorBorder, message) => {
    output.innerHTML = message;
    output.style.display = 'block';
    errorBorder.classList.add('error');
  };

  const removeError = (output, errorBorder) => {
    output.style.display = 'none';
    errorBorder.classList.remove('error');
  };
}
