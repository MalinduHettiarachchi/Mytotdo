<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: rgb(0, 0, 0);
        }

        .topic {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            /* Adjust top margin as needed */
            position: absolute;
            top: 20px;
            color: white;
        }

        .form-box {
            width: 350px;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .button-box {
            display: flex;
            justify-content: space-between;
            width: 100%;
            background: #ddd;
            border-radius: 30px;
            position: relative;
        }

        .tog-b {
            width: 50%;
            padding: 10px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        #btn {
            position: absolute;
            width: 50%;
            height: 100%;
            background: black;
            border-radius: 30px;
            transition: 0.5s;
        }

        .tog-b:nth-child(1) {
            color: white;
        }

        .input-group {
            display: none;
            flex-direction: column;
            margin-top: 20px;
        }

        .input-group.active {
            display: flex;
        }

        .infield {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .chekbox {
            margin-right: 5px;
        }

        .subutn {
            width: 100%;
            padding: 10px;
            border: none;
            background: black;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .role-select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: white;
            color: black;
        }
    </style>
</head>


<body>
    <div class="topic">MyTodo</div>

    <div class="form-box">
        <div class="button-box">
            <div id="btn"></div>
            <button type="button" class="tog-b" onclick="showLogin()">Log In</button>
            <button type="button" class="tog-b" onclick="showRegister()">Register</button>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="input-group active" onsubmit="submitLoginForm(event)" action="{{ route('login') }}"
            method="POST">
            @csrf
            <input type="email" class="infield" placeholder="Email" name="email" required>
            <input type="password" class="infield" placeholder="Enter Password" name="password" required>
            <select class="role-select" name="role" required>
                <option value="" disabled selected>Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="subutn">Log In</button>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="input-group" onsubmit="submitRegisterForm(event)" action="{{ url('/regiuser') }}"
            method="post">
            @csrf
            <input type="text" class="infield" placeholder="Name" name="username" required>
            <input type="text" class="infield" placeholder="Phone No" name="userphone" required>
            <input type="email" class="infield" placeholder="Email" name="useremail" required>
            <input type="password" class="infield" placeholder="Enter Password" name="userpassword" required>
            <select class="role-select" name="rolevalue" required>
                <option value="" disabled selected>Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="subutn">Register</button>
        </form>
    </div>

    <script>
        // Function to handle login form submission
        function submitLoginForm(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Get the form data
            const form = event.target;
            const formData = new FormData(form);

            // Send an AJAX request
            fetch("{{ route('login') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token
                }
            })
                .then(response => {
                    if (!response.ok) {
                        // If the response is not OK, parse it as JSON to get the error message
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Login failed');
                        });
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    if (data.success) {
                        alert("Login successful!"); // Display success message
                        window.location.href = "/dash"; // Redirect to the dashboard
                    } else {
                        alert("Login failed: " + data.message); // Display error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Log the error to the console
                    alert("An error occurred. Please try again."); // Display generic error message
                });
        }
        
        // Function to handle registration form submission
        function submitRegisterForm(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Get the form data
            const form = event.target;
            const formData = new FormData(form);

            // Send an AJAX request
            fetch("{{ url('/regiuser') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    if (data.success) {
                        alert("Registration successful!"); // Display success message
                        window.location.href = "/"; // Redirect to the dashboard
                    } else {
                        alert("Registration failed: " + data.message); // Display error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Log the error to the console
                    alert("An error occurred. Please try again."); // Display generic error message
                });
        }

        // Function to show the login form
        function showLogin() {
            document.getElementById("loginForm").classList.add("active");
            document.getElementById("registerForm").classList.remove("active");
            document.getElementById("btn").style.transform = "translateX(0)";
        }

        // Function to show the registration form
        function showRegister() {
            document.getElementById("loginForm").classList.remove("active");
            document.getElementById("registerForm").classList.add("active");
            document.getElementById("btn").style.transform = "translateX(100%)";
        }
    </script>
</body>

</html>