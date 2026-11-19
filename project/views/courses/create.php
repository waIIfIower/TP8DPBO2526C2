<div class="col-lg-6 mx-auto">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0 text-center">Create Course</h4>
    </div>
    <div class="card-body">
      <form method="post" action="index.php?page=courses&action=store">
        <div class="mb-3">
          <label class="form-label fw-semibold">COURSE CODE</label>
          <input type="text" name="course_code" class="form-control" placeholder="Contoh: IK201" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">COURSE NAME</label>
          <input type="text" name="course_name" class="form-control" placeholder="Contoh: Desain dan Pemrograman Berorientasi Objek" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">CREDITS (SKS)</label>
            <input type="number" name="credits" min="1" max="6" value="3" class="form-control" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">SEMESTER</label>
            <input type="number" name="semester" min="1" max="8" value="3" class="form-control" required>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">LECTURER (DOSEN PENGAMPU)</label>
          <select name="lecturer_id" class="form-select" required>
            <option value="">-- Pilih Dosen Pengampu --</option>
            <?php foreach ($lecturers as $lec): ?>
              <option value="<?php echo (int) $lec['id']; ?>">
                <?php echo htmlspecialchars($lec['name'] . ' (' . $lec['nidn'] . ')'); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-success" type="submit">Submit</button>
          <a class="btn btn-secondary" href="index.php?page=courses&action=index">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
