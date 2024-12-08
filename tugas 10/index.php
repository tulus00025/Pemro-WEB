<?php
    include "config/db.php";

    
    $rs = $db->query("SELECT * FROM categories");
    // $rs->setFetchMode(PDO::FETCH_ASSOC);
    $rs->setFetchMode(PDO::FETCH_OBJ);
    
    $dtask = $db->query("SELECT tasks.id, tasks.title, tasks.description, tasks.is_completed, categories.name AS category_name 
            FROM tasks 
            LEFT JOIN categories ON tasks.category_id = categories.id");
    // $dtask->setFetchMode(PDO::FETCH_ASSOC);
    $dtask->setFetchMode(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h1>To-Do List</h1>
        
        <!-- Button to open the modal -->
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary  me-1" data-bs-toggle="modal" data-bs-target="#taskModal">Add New Task</button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Categories</button>
        </div>

        <!-- Tasks Table -->
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Completed</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dtask as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task->title) ?></td>
                        <td><?= htmlspecialchars($task->description) ?></td>
                        <td><?= $task->is_completed ? 'Yes' : 'No' ?></td>
                        <td><?= htmlspecialchars($task->category_name) ?></td>
                        <td class="d-flex gap-2">        
                            <a href="edit_form.php?id=<?php echo base64_encode(sha1(rand())."|".$task->id)?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="crud/delete.php?id=<?php echo base64_encode(sha1(rand())."|".$task->id)?>>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            <div>
                                <form action="crud/status.php" method="post">
                                    <input type="hidden" name="is_completed" value="1"> <!-- Nilai true (1) untuk menandai selesai -->
                                    <input type="hidden" name="id" value="<?php echo base64_encode(rand() . "|" . $task->id); ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Completed</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Modal for Adding a New Task -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/addtask.php" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <?php foreach ($rs as $category): ?>
                                    <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding a New Category -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/addcat.php" method="POST">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="category_name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (including dependencies like Popper.js for modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>