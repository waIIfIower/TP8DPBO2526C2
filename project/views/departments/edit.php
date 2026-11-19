<div class="col-lg-6 mx-auto">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0 text-center">Update Department</h4>
    </div>
    <div class="card-body">
      <form method="post" action="index.php?page=departments&action=update">
        <input type="hidden" name="id" value="<?php echo (int) $department['id']; ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold">DEPARTMENT CODE</label>
          <input type="text" name="department_code" value="<?php echo htmlspecialchars($department['department_code']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">DEPARTMENT NAME</label>
          <input type="text" name="department_name" value="<?php echo htmlspecialchars($department['department_name']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">FACULTY</label>
          <input type="text" name="faculty" value="<?php echo htmlspecialchars($department['faculty']); ?>" class="form-control" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">OFFICE LOCATION</label>
          <input type="text" name="office_location" value="<?php echo htmlspecialchars($department['office_location']); ?>" class="form-control" required>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-success" type="submit">Update</button>
          <a class="btn btn-secondary" href="index.php?page=departments&action=index">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
