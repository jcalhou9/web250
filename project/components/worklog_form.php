<?php
require_once 'database/db_config.php';
$editData = null;

// check for edit status
if (isset($_SESSION['edit_log_id'])) {
    $editId = $_SESSION['edit_log_id'];
    // get data for current user
    $stmt = $mysqli->prepare("SELECT * FROM work_logs WHERE id = ? AND user_id = ?");
    $stmt->bind_param('ii', $editId, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
    if (!$editData) {
        unset($_SESSION['edit_log_id']);
    }
}
$old = $_SESSION['old'] ?? null;
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success_message"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="error_message"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<!-- edit form only if edit session is true else add worklog-->
<form method="post" action="scripts/worklog_crud.php" class="log_form <?= $editData ? 'editing' : '' ?>">
    <h3><?= $editData ? 'Edit Worklog' : 'Add Worklog' ?></h3>
    <div class="datetime_row">
        <label>Date:
            <input type="date" name="log_date" required
                value="<?= $editData ? htmlspecialchars($editData['log_date']) : ($old['log_date'] ?? '') ?>">
        </label>
        <label>Time Started:
            <input type="time" name="time_started" required
                value="<?= $editData ? htmlspecialchars($editData['time_started']) : ($old['time_started'] ?? '') ?>">
        </label>
        <label>Time Ended:
            <input type="time" name="time_ended"
                value="<?= $editData ? htmlspecialchars($editData['time_ended']) : ($old['time_ended'] ?? '') ?>">
        </label>
    </div>
    <label>Work Description:
        <textarea name="work_description" required maxlength="1000"><?= $editData
            ? htmlspecialchars($editData['work_description'])
            : htmlspecialchars($old['work_description'] ?? '') ?></textarea>
    </label>
    <label>Notes:
        <textarea name="notes" maxlength="1000"><?= $editData
            ? htmlspecialchars($editData['notes'])
            : htmlspecialchars($old['notes'] ?? '') ?></textarea>
    </label>
    <?php if ($editData): ?>
        <input type="hidden" name="log_id" value="<?= $editData['id'] ?>">
        <input type="submit" name="update_log" value="Update Log">
        <button type="submit" name="cancel_edit" value="1">Cancel</button>
    <?php else: ?>
        <input type="submit" name="add_log" value="Add Log">
    <?php endif; ?>
</form>

<?php unset($_SESSION['old']); ?>

<!-- worklog table -->
<div class="log_table_wrapper">
    <h3>Your Logs</h3>
    <table class="log_table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time Started</th>
                <th>Time Ended</th>
                <th>Description</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $userId = $_SESSION['user_id'];
        $stmt = $mysqli->prepare("SELECT * FROM work_logs WHERE user_id = ? ORDER BY log_date DESC");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="6" class="no_logs">No logs yet. Add your first entry above.</td>
            </tr>
        <?php else:
            while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['log_date']) ?></td>
                <td><?= htmlspecialchars($row['time_started']) ?></td>
                <td><?= htmlspecialchars($row['time_ended']) ?></td>
                <td class="wide_cell"><?= nl2br(htmlspecialchars($row['work_description'])) ?></td>
                <td class="wide_cell"><?= nl2br(htmlspecialchars($row['notes'])) ?></td>
                <td>
                    <form method="post" action="scripts/worklog_crud.php" class="action_form">
                        <input type="hidden" name="log_id" value="<?= $row['id'] ?>">
                        <input type="submit" name="edit_log" value="Edit" class="small_btn">
                        <input type="submit" name="delete_log" value="Delete" class="small_btn delete_btn" onclick="return confirm('Are you sure?');">
                    </form>
                </td>
            </tr>
        <?php endwhile; endif; ?>
        </tbody>
    </table>
</div>
