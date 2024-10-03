<!-- partials/form-modal.blade.php -->
<div class="modal fade" id="modalUpdateProgress" tabindex="-1" role="dialog" aria-labelledby="modalUpdateProgressLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateProgressLabel">Update Progress</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tambahkan ID pada form -->
                <form id="formUpdateProgress" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label for="nama_proyek">Nama Proyek</label>
                        <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" readonly>
                    </div>
                    <div class="form-group">
                        <label for="progress">Progress Pengerjaan(%)</label>
                        <select class="form-control" id="progress" name="progress" required>
                            <?php for($i = 0; $i <= 100; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?>%</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Progress</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\ptsi_\resources\views/perencanaan_kebutuhan/update_progress.blade.php ENDPATH**/ ?>