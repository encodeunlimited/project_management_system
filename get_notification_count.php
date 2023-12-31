<?php
include('db_connect.php');

// Fetch the notification count from the ticket_list table
$queryTicket = "SELECT COUNT(*) AS ticketCount FROM ticket_list WHERE status = '1'";
$resultTicket = $conn->query($queryTicket);

// Fetch the notification count from the task_list table
$queryTask = "SELECT COUNT(*) AS taskCount FROM task_list";
$resultTask = $conn->query($queryTask);

if ($resultTicket && $resultTask) {
    $rowTicket = $resultTicket->fetch_assoc();
    $rowTask = $resultTask->fetch_assoc();

    $notificationCount = $rowTicket['ticketCount'] + $rowTask['taskCount'];
    echo json_encode(['notificationCount' => $notificationCount]);
} else {
    echo json_encode(['notificationCount' => 0]);
}

// Close the database connection
$conn->close();
?>
