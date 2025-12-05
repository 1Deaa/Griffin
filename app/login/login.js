/* URL Error Params */
const params = new URLSearchParams(window.location.search);
const error = params.get('error');
const success = params.get('success');
if (error)
{
	const errorDiv = document.getElementById('error-msg');
	errorDiv.innerText = decodeURIComponent(error);
	errorDiv.style.display = 'block';
	const cleanUrl = window.location.origin + window.location.pathname;
	window.history.replaceState({}, document.title, cleanUrl);
}

if (success)
{
	const successDiv = document.getElementById('success-msg');
	successDiv.innerText = decodeURIComponent(success);
	successDiv.style.display = 'block';
	const cleanUrl = window.location.origin + window.location.pathname;
	window.history.replaceState({}, document.title, cleanUrl);
}

/* Login Function */
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

		const form = document.createElement("form");
		form.method = "POST";
		form.action = "validate_login.php";

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

/* Event Listeners */
document.getElementById("login-btn").addEventListener("click", login);
document.getElementById("password").addEventListener("keydown", function(event) 
{
	if (event.key === "Enter")
	{
		event.preventDefault();
		document.getElementById("login-btn").click();
	}
});
document.getElementById("username").addEventListener("keydown", function(event) 
{
	if (event.key === "Enter")
	{
		event.preventDefault();
		document.getElementById("login-btn").click();
	}
});