<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_list";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle task deletion
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Task deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting task: " . $stmt->error;
    }
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Handle new task submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_name'])) {
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $due_date = $_POST['due_date'];
    $reminder_date = $_POST['reminder_date'];

    $stmt = $conn->prepare("INSERT INTO tasks (task_name, due_date, reminder_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $task_name, $due_date, $reminder_date);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Task added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Fetch all tasks
$tasks = $conn->query("SELECT * FROM tasks");

// Fetch today's reminders
$today = date("Y-m-d");
$reminders = $conn->query("SELECT * FROM tasks WHERE reminder_date = '$today'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List with Reminders</title>
    <style>
        .task-item { margin: 10px 0; padding: 5px; border: 1px solid #ddd; }
        .delete-btn { background: #ff4444; color: white; border: none; padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>To-Do List</h1>

    <form method="post">
        <input type="text" name="task_name" placeholder="Task name" required>
        <input type="date" name="due_date">
        <input type="date" name="reminder_date">
        <button type="submit">Add Task</button>
    </form>

    <?php if (isset($_SESSION['message'])): ?>
        <div style="color: green;"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h2>Your Tasks</h2>
    <?php if ($tasks->num_rows > 0): ?>
        <?php while($task = $tasks->fetch_assoc()): ?>
            <div class="task-item">
                <?= htmlspecialchars($task['task_name']) ?> 
                (Due: <?= $task['due_date'] ?>, Reminder: <?= $task['reminder_date'] ?>)
                <form method="post" style="display: inline;">
                    <input type="hidden" name="delete_id" value="<?= $task['id'] ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No tasks found!</p>
    <?php endif; ?>

    <h2>Today's Reminders (<?= $today ?>)</h2>
    <?php if ($reminders->num_rows > 0): ?>
        <?php while($reminder = $reminders->fetch_assoc()): ?>
            <div class="task-item">
                <?= htmlspecialchars($reminder['task_name']) ?> 
                <form method="post" style="display: inline;">
                    <input type="hidden" name="delete_id" value="<?= $reminder['id'] ?>">
                    <button type="submit" class="delete-btn">Dismiss</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reminders for today!</p>
    <?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>