<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <?php if (isset($_SESSION['login_id'])) : ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
    <li>
      <a class="nav-link text-white" href="./" role="button">
        <large><b><?php echo $_SESSION['system']['name'] ?></b></large>
      </a>
    </li>
  </ul>


  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <div class="container">
        <div class="notification-icon">
          <i class="fa fa-bell"></i>
          <span class="notification-count">0</span>
        </div>
        <div class="notification-content">
          <ul id="notification-list">
            <?php

            $query = "SELECT * FROM ticket_list WHERE status = '1' ORDER BY id DESC";
            $result = $conn->query($query);

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
              // Output data of each row
              echo "<h3>Ticket List</h3>";
              echo "<ul class='ticket-list'>";
              while ($row = $result->fetch_assoc()) {
                echo "<li><strong>Subject:</strong> " . $row["subject"] . " - <strong>Description:</strong> " . $row["description"] . "</li>";
                // You can format the output as per your requirement
              }
              echo "</ul>";
            } else {
              echo "<p>No tickets available</p>";
            }

            // Fetch the last five rows from the ticket_list table
            $query = "SELECT * FROM task_list ORDER BY id DESC LIMIT 5";
            $result = $conn->query($query);

            // Output the last five ticket entries as a separate list
            echo "<h3>Task List</h3>";
            echo "<ul class='notification-list'>";
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<li><strong>Subject:</strong> " . $row["task"] . " - <strong>Description:</strong> " . $row["description"] . "</li>";
                // You can format the output as per your requirement
              }
            } else {
              echo "<p>No notifications</p>";
            }
            echo "</ul>";


            ?>
          </ul>
        </div>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
        <span>
          <div class="d-felx badge-pill">
            <span class="fa fa-user mr-2"></span>
            <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
            <span class="fa fa-angle-down ml-2"></span>
          </div>
        </span>
      </a>
      <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
        <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
        <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
<script>
  $('#manage_account').click(function() {
    uni_modal('Manage Account', 'manage_user.php?id=<?php echo $_SESSION['login_id'] ?>')
  })
</script>