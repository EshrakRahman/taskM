<?php
foreach ($tasks as $task):
?>
    <div>
        <input type="checkbox" <?php echo $task->is_completed ? 'checked' : ''; ?>>
        <?php echo htmlspecialchars($task->title); ?>
    </div>
<?php endforeach; ?>
