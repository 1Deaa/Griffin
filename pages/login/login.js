function login()
{
    const user = document.getElementById("username").value.trim();
    const pass = document.getElementById("password").value.trim();
    const errorMsg = document.getElementById("error-msg");
    if (user === "" || pass === "")
	{
        errorMsg.innerText = "Please enter your username and password";
        errorMsg.style.display = "block";
    }
	else
	{
        errorMsg.style.display = "none";
        // TODO: Replace this alert with actual backend submission
        alert("Login submitted! Replace with validate.php");
    }
}