function validateForm() {
    const usernameInput = document.getElementById('firstName') + ' ' + document.getElementById('lastName');
    const emailInput = document.getElementById('email');
    const contactNumberInput = document.getElementById('contactNumber');
    const postcodeInput = document.getElementById('postcode');
    const passwordInput = document.getElementById('password');

    // Username validation (example: alphanumeric and at least 3 characters)
    const usernameRegex = /^[a-zA-Z0-9]{3,}$/;
    if (!usernameRegex.test(usernameInput.value)) {
        alert('Username must be alphanumeric and at least 3 characters long.');
        usernameInput.focus();
        return false;
    }

    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
        alert('Please enter a valid email address.');
        emailInput.focus();
        return false;
    }

    // Contact Number validation (basic 10-digit check)
    const contactNumberRegex = /^\d{10}$/;
    if (!contactNumberRegex.test(contactNumberInput.value)) {
        alert('Please enter a valid 10-digit contact number.');
        contactNumberInput.focus();
        return false;
    }

    // Postcode validation (only 4 characters)
    const postcodeRegex = /^[0-9]{4}$/;
    if (!postcodeRegex.test(postcodeInput.value)) {
        alert('Please enter a valid 4-digit postcode.');
        postcodeInput.focus();
        return false;
    }

    // Password validation (at least 8 characters, one uppercase, one lowercase, one number)
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    console.log(passwordRegex);
    if (!passwordRegex.test(passwordInput.value)) {
        alert('Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, and one number.');
        passwordInput.focus();
        return false;
    }

    return true; // Allow form submission
}

// LOGIN VALIDATION
function checkEmail(){
    const email = document.getElementById("email");
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        alert('Please enter a valid email address.');
        emailInput.focus();
        return false;
    }
    return true;
}

function checkPassword(){
    const passwordInput = document.getElementById("password");
    // Password validation (at least 8 characters, one uppercase, one lowercase, one number)
   const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
   console.log(passwordRegex);
   if (!passwordRegex.test(passwordInput.value)) {
       alert('Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, and one number.');
       passwordInput.focus();
       return false;
   }
    return true;
}

function validateLoginInfo(document){
    if(checkEmail(document) && checkPassword(document)){
        return true;
    }
   return false;
}



// Navbar code

