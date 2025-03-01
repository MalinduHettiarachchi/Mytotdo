<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
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

        .task-list li .task-description {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
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

        /* Styling for the buttons container */
        .buttons-container {
            position: fixed;
            bottom: 20px;
            left: 85px; /* Adjust to match the sidebar width */
            right: 20px; /* Add right padding */
            display: none; /* Hide by default */
            justify-content: space-between; /* Space between left and right buttons */
            align-items: center;
        }

        .buttons-container .left-buttons {
            display: flex;
            gap: 10px; /* Space between buttons on the left */
        }

        .buttons-container .right-buttons {
            display: flex;
            gap: 10px; /* Space between buttons on the right */
        }

        .buttons-container button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .buttons-container button:hover {
            background-color: rgb(46, 46, 46);
        }

        /* Adjust position when sidebar is open */
        .sidebar.open ~ .content .buttons-container {
            left: 270px; /* Adjust to match the expanded sidebar width */
        }

        /* Styling for the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1001; /* Ensure it appears above other content */
            justify-content: center;
            align-items: center;
        }

        .modal.open {
            display: flex; /* Show the modal */
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }

        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .modal-content input,
        .modal-content textarea {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-content textarea {
            resize: vertical; /* Allow vertical resizing */
        }

        .modal-content button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal-content button:hover {
            background-color: rgb(46, 46, 46);
        }
        .modal-content .close-button {
            width: 50px;
            position: right;
            top: 20px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }

        .modal-content .close-button:hover {
            color: #333;
        }.edit-modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1001; /* Ensure it appears above other content */
            justify-content: center;
            align-items: center;
        }

        .edit-modal.open {
            display: flex; /* Show the modal */
        }

        .edit-modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .edit-modal-content h2 {
            margin-top: 0;
            font-size: 24px;
            text-align: center;
        }

        .edit-modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .edit-modal-content input,
        .edit-modal-content textarea {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-modal-content textarea {
            resize: vertical; /* Allow vertical resizing */
        }

        .edit-modal-content button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .edit-modal-content button:hover {
            background-color: rgb(46, 46, 46);
        }

        .edit-modal-content .close-button {
            width: 50px;
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }

        .edit-modal-content .close-button:hover {
            color: #333;
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
        <a href="#" onclick="loadSection('logout')">
            <i class="fas fa-sign-out-alt"></i> <!-- Logout Icon -->
            <span>Logout</span> <!-- Logout Text -->
        </a>
    </div>

    <!-- Content Section -->
    <div class="content" id="content">
        <!-- Default content will be replaced by the Tasks section -->
    </div>

    <!-- Buttons Container -->
    <div class="buttons-container" id="buttons-container">
        <div class="left-buttons">
            <button id="task-count-button">0 tasks selected</button>
        </div>
        <div class="right-buttons">
            <button onclick="completeSelectedTasks()">Complete</button>
            <button onclick="deleteSelectedTasks()">Delete</button>
        </div>
    </div>

    <!-- Modal for adding a task -->
    <div class="modal" id="add-task-modal">
        <div class="modal-content">
            <!-- Close Button -->
            <button class="close-button" onclick="closeAddTaskModal()">&times;</button>
            <h2>Add Your Task</h2>
            <form id="add-task-form" method="POST" action="/savetask">
    @csrf
    <label for="task-name">Task Name</label>
    <input type="text" id="taskname" name="taskname" placeholder="Enter task name" required>

    <label for="task-description">Task Description</label>
    <textarea id="taskdes" name="taskdes" placeholder="Enter task description" rows="3"></textarea>

    <label for="task-date">Task Date</label>
    <input type="date" id="taskdate" name="taskdate" required>

    <button type="submit">Add Task</button>
</form>

        </div>
    </div>

    <!-- Modal for editing a task -->
    <div class="edit-modal" id="edit-task-modal">
        <div class="edit-modal-content">
            <!-- Close Button -->
            <button class="close-button" onclick="closeEditTaskModal()">&times;</button>
            <h2>Edit Task</h2>
            <form id="edit-task-form">
                <label for="edit-task-name">Task Name</label>
                <input type="text" id="edit-task-name" placeholder="Enter task name" required>
                
                <label for="edit-task-description">Task Description</label>
                <textarea id="edit-task-description" placeholder="Enter task description" rows="3"></textarea>
                
                <label for="edit-task-date">Task Date</label>
                <input type="date" id="edit-task-date" required>
                
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

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
                { name: "Draft Project Proposal", description: "Prepare the initial draft for the project proposal.", date: "Tue Oct 17 2023" },
                { name: "Take Trash Out", description: "Take out the trash before 8 PM.", date: "Wed Oct 18 2023" },
                { name: "Get Groceries", description: "Buy milk, eggs, and bread.", date: "Wed Oct 18 2023" },
                { name: "Send Mail", description: "Send the quarterly report to the manager.", date: "Wed Oct 18 2023" }
            ];
        }

        // Function to update the selected task count
        function updateSelectedTaskCount() {
            const selectedTasks = document.querySelectorAll(".task-list input[type='checkbox']:checked").length;
            const taskCountButton = document.getElementById("task-count-button");
            taskCountButton.textContent = `${selectedTasks} tasks selected`;
        }

        // Function to load sections dynamically
        function loadSection(section) {
            const content = document.getElementById("content");
            const buttonsContainer = document.getElementById("buttons-container");

            // Clear existing content
            content.innerHTML = "";

            // Show or hide the buttons container based on the section
            if (section === "tasks") {
                buttonsContainer.style.display = "flex"; // Show the buttons
            } else {
                buttonsContainer.style.display = "none"; // Hide the buttons
            }

            // Load new content based on the section
            switch (section) {
                case "tasks":
                    const tasks = getDummyTasks(); // Get dummy tasks
                    const taskListHTML = tasks.map((task, index) => `
                        <li>
                            <div>
                                <input type="checkbox" onchange="updateSelectedTaskCount()">
                                <span>${task.name}</span>
                                <div class="task-description">${task.description}</div>
                                <div class="task-date">${task.date}</div>
                            </div>
                            <div class="task-actions">
                                <button onclick="openEditTaskModal(${index})"><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-trash"></i></button>
                            </div>
                        </li>
                    `).join("");

                    content.innerHTML = `
                        <div class="tasks-header">
                            <h2>Tasks</h2>
                            <button onclick="openAddTaskModal()">Add Task</button>
                        </div>
                        <ul class="task-list">
                            ${taskListHTML}
                        </ul>
                    `;
                    updateSelectedTaskCount(); // Initialize the selected task count
                    break;
                case "logout":
                    content.innerHTML = "<h2>Logout</h2><p>You have been logged out. Redirecting to the login page...</p>";
                    // Simulate a logout action (e.g., redirect to login page)
                    setTimeout(() => {
                        window.location.href = "/"; // Replace with your login page URL
                    }, 2000);
                    break;
                default:
                    // Default to the Tasks section
                    loadSection("tasks");
                    break;
            }
        }

        // Function to open the add task modal
        function openAddTaskModal() {
            const modal = document.getElementById("add-task-modal");
            modal.classList.add("open");
        }

        // Function to close the add task modal
        function closeAddTaskModal() {
            const modal = document.getElementById("add-task-modal");
            modal.classList.remove("open");
        }

        // Function to open the edit task modal
        function openEditTaskModal(index) {
            const tasks = getDummyTasks();
            const task = tasks[index];

            // Fill the edit modal with task details
            document.getElementById("edit-task-name").value = task.name;
            document.getElementById("edit-task-description").value = task.description;
            document.getElementById("edit-task-date").value = task.date;

            // Open the edit modal
            const modal = document.getElementById("edit-task-modal");
            modal.classList.add("open");

            // Save the task index for updating later
            modal.dataset.taskIndex = index;
        }

        // Function to close the edit task modal
        function closeEditTaskModal() {
            const modal = document.getElementById("edit-task-modal");
            modal.classList.remove("open");
        }

        // Function to handle the form submission for adding a task
        document.getElementById("add-task-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting naturally

    // Get the form data
    const formData = new FormData(this);

    // Send the form data to the server using Fetch API
    fetch("/savetask", {
        method: "POST",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            // If the response is not OK, parse the error message
            return response.text().then(text => {
                throw new Error(text);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Close the modal
            closeAddTaskModal();

            // Clear the form fields
            document.getElementById("add-task-form").reset();

            // Reload the tasks section to reflect the new task
            loadSection("tasks");

            // Optionally, show a success message
            alert("Task added successfully!");
        } else {
            // Handle errors
            alert("Failed to add task: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while adding the task. Check the console for details.");
    });
});
// Function to handle the form submission for editing a task
        document.getElementById("edit-task-form").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get the updated task details from the form
            const taskName = document.getElementById("edit-task-name").value;
            const taskDescription = document.getElementById("edit-task-description").value;
            const taskDate = document.getElementById("edit-task-date").value;

            // Get the task index from the modal dataset
            const taskIndex = document.getElementById("edit-task-modal").dataset.taskIndex;

            // Update the task in the task list
            const taskList = document.querySelectorAll(".task-list li");
            const taskItem = taskList[taskIndex];

            taskItem.querySelector("span").textContent = taskName;
            taskItem.querySelector(".task-description").textContent = taskDescription;
            taskItem.querySelector(".task-date").textContent = taskDate;

            // Close the edit modal
            closeEditTaskModal();
        });

        // Function to handle the "Complete" button click
        function completeSelectedTasks() {
            const selectedCheckboxes = document.querySelectorAll(".task-list input[type='checkbox']:checked");
            selectedCheckboxes.forEach(checkbox => {
                const taskItem = checkbox.closest("li");
                taskItem.classList.add("completed"); // Mark as completed
            });
        }

        // Function to handle the "Delete" button click
        function deleteSelectedTasks() {
            const selectedCheckboxes = document.querySelectorAll(".task-list input[type='checkbox']:checked");
            selectedCheckboxes.forEach(checkbox => {
                const taskItem = checkbox.closest("li");
                taskItem.remove(); // Remove the task
            });
            updateSelectedTaskCount(); // Update the count after deleting tasks
        }

        // Load the Tasks section by default when the page loads
        window.onload = function () {
            loadSection("tasks");
        };
    </script>
</body>
</html>
