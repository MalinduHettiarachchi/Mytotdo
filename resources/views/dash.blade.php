<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTodo</title>
    <!-- Add Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling for the black line (nav bar) */
        .nav-bar {
            width: 100%;
            height: 80px; /* Height of the nav bar */
            background-color: black; /* Color of the nav bar */
            position: fixed; /* Fix the nav bar at the top */
            top: 0;
            left: 0;
            z-index: 1000; /* Ensure it stays on top of other content */
            display: flex;
            align-items: center; /* Center items vertically */
            padding: 0 20px; /* Add padding to left and right */
        }

        /* Styling for the hamburger menu */
        .hamburger-menu {
            color: white; /* Color of the menu icon */
            font-size: 20px; /* Size of the menu icon */
            cursor: pointer; /* Change cursor to pointer on hover */
            margin-right: 20px; /* Add space between menu and text */
        }

        /* Styling for the text inside the nav bar */
        .nav-bar h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-family: Arial, sans-serif;
            text-align: center; /* Center text horizontally */
            flex: 1; /* Allow the text to take up remaining space */
        }

        /* Styling for the sidebar */
        .sidebar {
            width: 65px; /* Width of the sidebar when closed (icons only) */
            height: 100vh; /* Full height of the viewport */
            background-color: Black; /* Background color of the sidebar */
            position: fixed; /* Fix the sidebar */
            top: 80px; /* Adjusted to account for the nav bar */
            left: 0;
            transition: width 0.3s ease; /* Smooth transition for opening/closing */
            z-index: 999; /* Ensure it stays below the nav bar */
            overflow: hidden; /* Hide overflow text when sidebar is closed */
        }

        /* Styling for sidebar links */
        .sidebar a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: flex; /* Use flexbox to align icon and text */
            align-items: center; /* Center items vertically */
            font-size: 18px;
            border-bottom: 1px solid #444; /* Add a separator between links */
        }

        /* Styling for icons */
        .sidebar a i {
            margin-right: 15px; /* Add space between icon and text */
            min-width: 20px; /* Ensure icons stay in place */
        }

        /* Styling for text in sidebar links */
        .sidebar a span {
            white-space: nowrap; /* Prevent text from wrapping */
            opacity: 0; /* Hide text by default */
            transition: opacity 0.3s ease; /* Smooth transition for text visibility */
        }

        /* Hover effect for sidebar links */
        .sidebar a:hover {
            background-color: #444;
        }

        /* Optional: Add some padding to the body to prevent content from being hidden under the nav bar */
        body {
            margin: 0;
            padding-top: 80px; /* Adjust this value to match the height of the nav bar */
        }

        /* Class to open the sidebar */
        .sidebar.open {
            width: 250px; /* Expanded width of the sidebar */
        }

        /* Show text when sidebar is open */
        .sidebar.open a span {
            opacity: 1; /* Show text */
        }

        /* Styling for the content section */
        .content {
            margin-left: 65px; /* Adjust to match the width of the closed sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease; /* Smooth transition for content area */
        }

        /* Adjust content margin when sidebar is open */
        .sidebar.open ~ .content {
            margin-left: 250px; /* Adjust to match the width of the open sidebar */
        }

        /* Styling for the task list */
        .task-list {
            list-style-type: none;
            padding: 0;
        }

        .task-list li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-list li.completed {
            background-color: #e0f7fa;
            text-decoration: line-through;
        }

        .task-list li .task-date {
            font-size: 14px;
            color: #666;
        }

        .task-list li .task-actions {
            display: flex;
            gap: 10px;
        }

        .task-list li .task-actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #666;
        }

        .task-list li .task-actions button:hover {
            color: #333;
        }

        /* Styling for the tasks header */
        .tasks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .tasks-header h2 {
            margin: 0;
        }

        .tasks-header button {
            background-color: rgb(0, 0, 0);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .tasks-header button:hover {
            background-color: rgb(19, 19, 19);
        }

        /* Styling for the selected task count */
        .selected-task-count {
            position: fixed;
            bottom: 20px;
            left: 85px; /* Adjust to match the sidebar width */
            background-color: black;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            z-index: 1000;
            display: none; /* Hide by default */
        }

        /* Adjust position when sidebar is open */
        .sidebar.open ~ .content .selected-task-count {
            left: 270px; /* Adjust to match the expanded sidebar width */
        }
    </style>
</head>
<body>
    <!-- Black line (nav bar) with hamburger menu and text -->
    <div class="nav-bar">
        <!-- Hamburger Menu -->
        <div class="hamburger-menu">Dashboard</div>
        <!-- Text inside the nav bar -->
        <h1>MyTodo</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar" onmouseover="openSidebar()" onmouseout="closeSidebar()">
        <a href="#" onclick="loadSection('tasks')">
            <i class="fas fa-tasks"></i> <!-- Tasks Icon -->
            <span>Tasks</span> <!-- Tasks Text -->
        </a>
        <a href="#" onclick="loadSection('settings')">
            <i class="fas fa-cog"></i> <!-- Settings Icon -->
            <span>Settings</span> <!-- Settings Text -->
        </a>
        <a href="#" onclick="loadSection('logout')">
            <i class="fas fa-sign-out-alt"></i> <!-- Logout Icon -->
            <span>Logout</span> <!-- Logout Text -->
        </a>
    </div>

    <!-- Content Section -->
    <div class="content" id="content">
        <p>Welcome to the Todo App dashboard. Here you can manage your tasks.</p>
    </div>

    <!-- Selected Task Count -->
    <div class="selected-task-count" id="selected-task-count">0 tasks selected</div>

    <script>
        // Function to open the sidebar
        function openSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.add("open");
        }

        // Function to close the sidebar
        function closeSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.remove("open");
        }

        // Function to generate dummy task data
        function getDummyTasks() {
            return [
                { name: "Draft Project Proposal", date: "Tue Oct 17 2023" },
                { name: "Take Trash Out", date: "Wed Oct 18 2023" },
                { name: "Get Groceries", date: "Wed Oct 18 2023" },
                { name: "Get Groceries", date: "Wed Oct 20 2023" },
                { name: "Send Mail", date: "Wed Oct 18 2023" }
            ];
        }

        // Function to update the selected task count
        function updateSelectedTaskCount() {
            const selectedTasks = document.querySelectorAll(".task-list input[type='checkbox']:checked").length;
            const selectedTaskCount = document.getElementById("selected-task-count");
            selectedTaskCount.textContent = `${selectedTasks} tasks selected`;
        }

        // Function to load sections dynamically
        function loadSection(section) {
            const content = document.getElementById("content");
            const selectedTaskCount = document.getElementById("selected-task-count");

            // Clear existing content
            content.innerHTML = "";

            // Show or hide the selected task count based on the section
            if (section === "tasks") {
                selectedTaskCount.style.display = "block"; // Show the count
            } else {
                selectedTaskCount.style.display = "none"; // Hide the count
            }

            // Load new content based on the section
            switch (section) {
                case "tasks":
                    const tasks = getDummyTasks(); // Get dummy tasks
                    const taskListHTML = tasks.map(task => `
                        <li>
                            <div>
                                <input type="checkbox" onchange="updateSelectedTaskCount()">
                                <span>${task.name}</span>
                                <div class="task-date">${task.date}</div>
                            </div>
                            <div class="task-actions">
                                <button><i class="fas fa-trash"></i></button>
                            </div>
                        </li>
                    `).join("");

                    content.innerHTML = `
                        <div class="tasks-header">
                            <h2>Tasks</h2>
                            <button onclick="addTask()">Add Task</button>
                        </div>
                        <ul class="task-list">
                            ${taskListHTML}
                        </ul>
                    `;
                    updateSelectedTaskCount(); // Initialize the selected task count
                    break;
                case "settings":
                    content.innerHTML = "<h2>Settings</h2><p>This is the Settings section. Here you can configure your preferences.</p>";
                    break;
                case "logout":
                    content.innerHTML = "<h2>Logout</h2><p>You have been logged out. Redirecting to the login page...</p>";
                    // Simulate a logout action (e.g., redirect to login page)
                    setTimeout(() => {
                        window.location.href = "/"; // Replace with your login page URL
                    }, 2000);
                    break;
                default:
                    content.innerHTML = "<p>Welcome to the Todo App dashboard. Here you can manage your tasks.</p>";
                    break;
            }
        }

        // Function to handle the "Add Task" button click
        function addTask() {
            alert("Add Task button clicked!"); // Replace with your logic to add a task
        }
    </script>
</body>
</html>