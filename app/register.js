/* URL Error Params */
const params = new URLSearchParams(window.location.search);
const error = params.get('error');

if (error)
{
	const errorDiv = document.getElementById('error-msg');
	errorDiv.innerText = decodeURIComponent(error);
	errorDiv.style.display = 'block';

	const cleanUrl = window.location.origin + window.location.pathname;
	window.history.replaceState({}, document.title, cleanUrl);
}

/* Register Function */
function register()
{
	const user = document.getElementById("username").value.trim();
	const pass = document.getElementById("password").value.trim();
	const confirm = document.getElementById("confirm-password").value.trim();
	const errorMsg = document.getElementById("error-msg");

	if (!user && !pass && !confirm)
	{
		errorMsg.innerText = "Please fill in all fields";
		errorMsg.style.display = "block";
	}
	else if (!user)
	{
		errorMsg.innerText = "Please enter a username";
		errorMsg.style.display = "block";
	}
	else if (!pass)
	{
		errorMsg.innerText = "Please enter a password";
		errorMsg.style.display = "block";
	}
	else if (!confirm)
	{
		errorMsg.innerText = "Please confirm your password";
		errorMsg.style.display = "block";
	}
	else if (pass !== confirm)
	{
		errorMsg.innerText = "Passwords do not match";
		errorMsg.style.display = "block";
	}
	else
	{
		errorMsg.style.display = "none";

		const form = document.createElement("form");
		form.method = "POST";
		form.action = "validate_register.php";

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

		const confirmInput = document.createElement("input");
		confirmInput.type = "hidden";
		confirmInput.name = "confirm";
		confirmInput.value = confirm;
		form.appendChild(confirmInput);

		document.body.appendChild(form);
		form.submit();
	}
}

/* Event Listeners */
document.getElementById("register-btn").addEventListener("click", register);

["username", "password", "confirm-password"].forEach(id => {
	document.getElementById(id).addEventListener("keydown", function(event) 
	{
		if (event.key === "Enter")
		{
			event.preventDefault();
			document.getElementById("register-btn").click();
		}
	});
});