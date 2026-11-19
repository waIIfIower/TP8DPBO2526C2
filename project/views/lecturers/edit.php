<div class="col-lg-6 mx-auto">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0 text-center">Update Lecturer</h4>
    </div>
    <div class="card-body">
      <form method="post" action="index.php?page=lecturers&action=update">
        <input type="hidden" name="id" value="<?php echo (int) $lecturer['id']; ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold">NAME</label>
          <input type="text" name="name" value="<?php echo htmlspecialchars($lecturer['name']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">NIDN</label>
          <input type="text" name="nidn" value="<?php echo htmlspecialchars($lecturer['nidn']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">EMAIL</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($lecturer['email']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">PHONE</label>
          <input type="text" name="phone" value="<?php echo htmlspecialchars($lecturer['phone']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">DEPARTMENT (PROGRAM STUDI)</label>
          <select name="department_id" class="form-select">
            <option value="">-- Pilih Departemen (Opsional) --</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?php echo (int) $dept['id']; ?>"
                <?php echo ((int) $lecturer['department_id'] === (int) $dept['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($dept['department_code'] . ' - ' . $dept['department_name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">JOIN DATE</label>
          <input type="date" name="join_date" value="<?php echo htmlspecialchars($lecturer['join_date']); ?>" class="form-control" required>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-success" type="submit">Update</button>
          <a class="btn btn-secondary" href="index.php?page=lecturers&action=index">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
