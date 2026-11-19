<div class="col-lg-6 mx-auto">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0 text-center">Create Lecturer</h4>
    </div>
    <div class="card-body">
      <form method="post" action="index.php?page=lecturers&action=store">
        <div class="mb-3">
          <label class="form-label fw-semibold">NAME</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Dr. Budi Santoso, M.T." required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">NIDN</label>
          <input type="text" name="nidn" class="form-control" placeholder="Contoh: 0012048501" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">EMAIL</label>
          <input type="email" name="email" class="form-control" placeholder="nama@kampus.ac.id" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">PHONE</label>
          <input type="text" name="phone" class="form-control" placeholder="081234567890" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">DEPARTMENT (PROGRAM STUDI)</label>
          <select name="department_id" class="form-select">
            <option value="">-- Pilih Departemen (Opsional) --</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?php echo (int) $dept['id']; ?>">
                <?php echo htmlspecialchars($dept['department_code'] . ' - ' . $dept['department_name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">JOIN DATE</label>
          <input type="date" name="join_date" class="form-control" required>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-success" type="submit">Submit</button>
          <a class="btn btn-secondary" href="index.php?page=lecturers&action=index">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
