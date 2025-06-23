<?php
include("../config/conn.php");

// Generate new class code
function generateClassCode($conn) {
    $last = $conn->query("SELECT class_code FROM classes ORDER BY id DESC LIMIT 1");
    if ($last->num_rows > 0) {
        $row = $last->fetch_assoc();
        $num = (int)substr($row['class_code'], 3);
        return 'CL-' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
    }
    return 'CL-001';
}

// Fetch class table HTML
function fetchClassTable($conn) {
    $classes = $conn->query("SELECT classes.*, teachers.full_name AS teacher_name FROM classes 
                             LEFT JOIN teachers ON classes.teacher_id = teachers.id ORDER BY classes.id ASC");
    $i = 1;
    ob_start();
    while ($row = $classes->fetch_assoc()):
    ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= htmlspecialchars($row['class_name']) ?></td>
      <td><?= htmlspecialchars($row['class_code']) ?></td>
      <td><?= htmlspecialchars($row['class_type']) ?></td>
      <td><?= htmlspecialchars($row['teacher_name']) ?></td>
      <td><?= htmlspecialchars($row['max_students']) ?></td>
      <td>
        <span class="badge <?= strtolower($row['status']) === 'active' ? 'bg-success' : 'bg-secondary' ?>">
          <?= htmlspecialchars($row['status']) ?>
        </span>
      </td>
      <td>
        <button 
          class="btn btn-sm btn-primary viewClassBtn" 
          data-bs-toggle="modal" 
          data-bs-target="#viewClassModal"
          data-name="<?= htmlspecialchars($row['class_name']) ?>"
          data-code="<?= htmlspecialchars($row['class_code']) ?>"
          data-type="<?= htmlspecialchars($row['class_type']) ?>"
          data-level="<?= htmlspecialchars($row['level']) ?>"
          data-teacher="<?= htmlspecialchars($row['teacher_name']) ?>"
          data-max="<?= htmlspecialchars($row['max_students']) ?>"
          data-status="<?= htmlspecialchars($row['status']) ?>"
          data-gender="<?= htmlspecialchars($row['gender']) ?>"
          data-days="<?= htmlspecialchars($row['days_active']) ?>"
          data-room="<?= htmlspecialchars($row['room']) ?>"
          data-time="<?= htmlspecialchars($row['time_slot']) ?>"
        >More info</button>

        <button class="btn btn-sm btn-warning editBtn"
          data-id="<?= $row['id'] ?>"
          data-name="<?= htmlspecialchars($row['class_name']) ?>"
          data-code="<?= htmlspecialchars($row['class_code']) ?>"
          data-type="<?= htmlspecialchars($row['class_type']) ?>"
          data-level="<?= htmlspecialchars($row['level']) ?>"
          data-teacher="<?= $row['teacher_id'] ?>"
          data-max="<?= $row['max_students'] ?>"
          data-gender="<?= $row['gender'] ?>"
          data-start="<?= explode('-', $row['time_slot'])[0] ?>"
          data-end="<?= explode('-', $row['time_slot'])[1] ?>"
          data-days="<?= $row['days_active'] ?>"
          data-room="<?= $row['room'] ?>"
          data-status="<?= $row['status'] ?>"
        >
          Edit
        </button>

        <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $row['id'] ?>">Delete</button>
      </td>
    </tr>
    <?php
    endwhile;
    return ob_get_clean();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['mode']) && $_GET['mode'] === 'generate_code') {
        echo json_encode(['class_code' => generateClassCode($conn)]);
    } else {
        echo fetchClassTable($conn);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DELETE
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
        exit;
    }

    // UPDATE
    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $name = $_POST['class_name'] ?? null;
        $type = $_POST['class_type'] ?? null;
        $code = $_POST['class_code'] ?? null;
        $level = $_POST['level'] ?? null;
        $teacher = $_POST['teacher_id'] ?? null;
        $max = $_POST['max_students'] ?? null;
        $status = $_POST['status'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $room = $_POST['room'] ?? null;
        $start = $_POST['time_start'] ?? null;
        $end = $_POST['time_end'] ?? null;
        $days = isset($_POST['days_active']) ? implode(',', $_POST['days_active']) : null;

        if (!$name || !$type || !$level || !$teacher || !$max || !$status || !$gender || !$room || !$start || !$end || !$days) {
            echo json_encode(["status" => "error", "message" => "Please fill all required fields"]);
            exit;
        }

        // Check duplicate class_name except current id
        $chk = $conn->prepare("SELECT id FROM classes WHERE class_name = ? AND id <> ?");
        $chk->bind_param("si", $name, $id);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Class name already exists. Choose another."]);
            exit;
        }

        $time_slot = $start . '-' . $end;

        $stmt = $conn->prepare("UPDATE classes SET class_name=?, class_code=?, class_type=?, level=?, teacher_id=?, max_students=?, gender=?, time_slot=?, days_active=?, room=?, status=? WHERE id=?");
        $stmt->bind_param("ssssissssssi", $name, $code, $type, $level, $teacher, $max, $gender, $time_slot, $days, $room, $status, $id);

        echo $stmt->execute() ? json_encode(['status' => 'success']) : json_encode(['status' => 'error', 'message' => $stmt->error]);
        exit;
    }

    // INSERT
    $name = $_POST['class_name'] ?? null;
    $type = $_POST['class_type'] ?? null;
    $level = $_POST['level'] ?? null;
    $teacher = $_POST['teacher_id'] ?? null;
    $max = $_POST['max_students'] ?? null;
    $status = $_POST['status'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $room = $_POST['room'] ?? null;
    $days = isset($_POST['days_active']) ? implode(',', $_POST['days_active']) : null;
    $start = $_POST['time_start'] ?? null;
    $end = $_POST['time_end'] ?? null;

    if (!$name || !$type || !$level || !$teacher || !$max || !$status || !$gender || !$room || !$start || !$end || !$days) {
        echo json_encode(["status" => "error", "message" => "Please fill all required fields"]);
        exit;
    }

    // Check duplicate class_name on insert
    $chk = $conn->prepare("SELECT id FROM classes WHERE class_name = ?");
    $chk->bind_param("s", $name);
    $chk->execute();
    $chk->store_result();
    if ($chk->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Class name already exists. Choose another."]);
        exit;
    }

    $code = generateClassCode($conn);
    $time_slot = $start . '-' . $end;

    $stmt = $conn->prepare("INSERT INTO classes (class_name, class_code, class_type, level, teacher_id, max_students, gender, time_slot, days_active, room, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssss", $name, $code, $type, $level, $teacher, $max, $gender, $time_slot, $days, $room, $status);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "class_code" => $code]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    exit;
}
?>
