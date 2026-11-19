<div class="col-lg-6 mx-auto">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0 text-center">Create Department</h4>
    </div>
    <div class="card-body">
      <form method="post" action="index.php?page=departments&action=store">
        <div class="mb-3">
          <label class="form-label fw-semibold">DEPARTMENT CODE</label>
          <input type="text" name="department_code" class="form-control" placeholder="Contoh: ILKOM" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">DEPARTMENT NAME</label>
          <input type="text" name="department_name" class="form-control" placeholder="Contoh: Ilmu Komputer" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">FACULTY</label>
          <input type="text" name="faculty" class="form-control" placeholder="Contoh: FPMIPA" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">OFFICE LOCATION</label>
          <input type="text" name="office_location" class="form-control" placeholder="Contoh: Gedung FPMIPA C Lt. 2" required>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-success" type="submit">Submit</button>
          <a class="btn btn-secondary" href="index.php?page=departments&action=index">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
