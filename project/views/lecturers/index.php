<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Daftar Dosen (Lecturers)</h3>
  <a class="btn btn-primary" href="index.php?page=lecturers&action=create">+ Add New Lecturer</a>
</div>

<div class="card shadow-sm">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>NAME</th>
          <th>NIDN</th>
          <th>EMAIL</th>
          <th>PHONE</th>
          <th>DEPARTMENT</th>
          <th>JOIN DATE</th>
          <th class="text-center">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($lecturers)): ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-4">Belum ada data dosen.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($lecturers as $row): ?>
            <tr>
              <th><?php echo htmlspecialchars((string) $row['id']); ?></th>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['nidn']); ?></span></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td>
                <?php if (!empty($row['department_name'])): ?>
                  <span class="badge bg-info text-dark">
                    <?php echo htmlspecialchars($row['department_code'] . ' - ' . $row['department_name']); ?>
                  </span>
                <?php else: ?>
                  <span class="text-muted fst-italic">Belum ditentukan</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($row['join_date']); ?></td>
              <td class="text-center text-nowrap">
                <a class="btn btn-sm btn-success"
                   href="index.php?page=lecturers&action=edit&id=<?php echo (int) $row['id']; ?>">Edit</a>
                <a class="btn btn-sm btn-danger"
                   href="index.php?page=lecturers&action=delete&id=<?php echo (int) $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus data dosen ini? Semua mata kuliah yang diampu juga akan terhapus.');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
