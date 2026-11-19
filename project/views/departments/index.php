<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Daftar Departemen (Departments)</h3>
  <a class="btn btn-primary" href="index.php?page=departments&action=create">+ Add New Department</a>
</div>

<div class="card shadow-sm">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>CODE</th>
          <th>DEPARTMENT NAME</th>
          <th>FACULTY</th>
          <th>OFFICE LOCATION</th>
          <th class="text-center">TOTAL LECTURERS</th>
          <th class="text-center">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($departments)): ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-4">Belum ada data departemen.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($departments as $row): ?>
            <tr>
              <th><?php echo htmlspecialchars((string) $row['id']); ?></th>
              <td><span class="badge bg-primary"><?php echo htmlspecialchars($row['department_code']); ?></span></td>
              <td><?php echo htmlspecialchars($row['department_name']); ?></td>
              <td><?php echo htmlspecialchars($row['faculty']); ?></td>
              <td><?php echo htmlspecialchars($row['office_location']); ?></td>
              <td class="text-center">
                <span class="badge bg-secondary"><?php echo (int) $row['total_lecturers']; ?> Dosen</span>
              </td>
              <td class="text-center text-nowrap">
                <a class="btn btn-sm btn-success"
                   href="index.php?page=departments&action=edit&id=<?php echo (int) $row['id']; ?>">Edit</a>
                <a class="btn btn-sm btn-danger"
                   href="index.php?page=departments&action=delete&id=<?php echo (int) $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus departemen ini?');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
