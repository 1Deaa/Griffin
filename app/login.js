// Show error if ?error=... exists in URL
const params = new URLSearchParams(window.location.search);
const error = params.get('error');
if (error)
{
    const errorDiv = document.getElementById('error-msg');
    errorDiv.innerText = decodeURIComponent(error);
    errorDiv.style.display = 'block';
	
    // Remove query params from the URL without reloading
    const cleanUrl = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, cleanUrl);
}

// Login function
function login()
{
    const user = document.getElementById("username").value.trim();
    const pass = document.getElementById("password").value.trim();
    const errorMsg = document.getElementById("error-msg");
 
	if (pass === "" && user === "")
	{
		errorMsg.innerText = "Please enter your username and password";
        errorMsg.style.display = "block";
	}
    else if (pass === "")
	{
        errorMsg.innerText = "Please enter your password";
        errorMsg.style.display = "block";
    }
	else if (user === "")
	{
		errorMsg.innerText = "Please enter your username";
		errorMsg.style.display = "block";
	} 
	else
	{
        errorMsg.style.display = "none";

        // Dynamically create a form and submit to validate.php
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "validate.php";

        const usernameInput = document.createElement("input");
        usernameInput.type = "hidden";
        usernameInput.name = "username";
        usernameInput.value = user;
        form.appendChild(usernameInput);

        const passwordInput = document.createElement("input");
        passwordInput.type = "hidden";
        passwordInput.name = "password";
        passwordInput.value = pass;
        form.appendChild(passwordInput);

        document.body.appendChild(form);
        form.submit();
    }
}

// Attach event listener to the login button
document.getElementById("login-btn").addEventListener("click", login);