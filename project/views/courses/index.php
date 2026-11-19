<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Daftar Mata Kuliah (Courses)</h3>
  <a class="btn btn-primary" href="index.php?page=courses&action=create">+ Add New Course</a>
</div>

<div class="card shadow-sm">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>CODE</th>
          <th>COURSE NAME</th>
          <th class="text-center">CREDITS (SKS)</th>
          <th class="text-center">SEMESTER</th>
          <th>LECTURER (DOSEN PENGAMPU)</th>
          <th>DEPARTMENT</th>
          <th class="text-center">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($courses)): ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-4">Belum ada data mata kuliah.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($courses as $row): ?>
            <tr>
              <th><?php echo htmlspecialchars((string) $row['id']); ?></th>
              <td><span class="badge bg-dark"><?php echo htmlspecialchars($row['course_code']); ?></span></td>
              <td><?php echo htmlspecialchars($row['course_name']); ?></td>
              <td class="text-center"><?php echo (int) $row['credits']; ?> SKS</td>
              <td class="text-center">Semester <?php echo (int) $row['semester']; ?></td>
              <td>
                <?php echo htmlspecialchars($row['lecturer_name']); ?><br>
                <small class="text-muted">NIDN: <?php echo htmlspecialchars($row['lecturer_nidn']); ?></small>
              </td>
              <td><?php echo htmlspecialchars($row['department_name'] ?? '-'); ?></td>
              <td class="text-center text-nowrap">
                <a class="btn btn-sm btn-success"
                   href="index.php?page=courses&action=edit&id=<?php echo (int) $row['id']; ?>">Edit</a>
                <a class="btn btn-sm btn-danger"
                   href="index.php?page=courses&action=delete&id=<?php echo (int) $row['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus mata kuliah ini?');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
