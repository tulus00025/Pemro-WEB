<!DOCTYPE html>
<html>
	<head>
		<title>Edit Form</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
        
		<div class="row mt-5">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<?php
					include "config/db.php";

                    $rs = $db->query("SELECT * FROM categories");
                    // $rs->setFetchMode(PDO::FETCH_ASSOC);
                    $rs->setFetchMode(PDO::FETCH_OBJ);

					$id = explode("|", base64_decode($_GET['id']));
					$cektask=$db->prepare("SELECT * FROM tasks WHERE id=?");
					$cektask->execute([$id[1]]);

					if($cektask->rowCount()>0)
					{
						$cektask->setFetchMode(PDO::FETCH_OBJ);
        				$task = $cektask->fetch();

				?>
					<form method="post" action="crud/edit.php" class="form-group">						
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo $task->title?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" id="description" class="form-control"value="<?php echo $task->description?>">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <?php foreach ($rs as $category): ?>
                                    <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo base64_encode(sha1(rand())."|".$task->id)?>">
                        <button type="submit" class="btn btn-primary">Edit Task</button>
                        <a class="btn btn-danger" href="index.php">Batal</a>
					</form>
				<?php
					}
					else
					{
						header("Location: index.php");	
					}
				?>
			</div>
			<div class="col-md-4">
			</div>
		</div>
	</body>
</html>