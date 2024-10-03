<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <?php echo method_field('post'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nomor_proyek" class="col-lg-2 col-lg-offset-1 control-label">Nomor Proyek</label>
                        <div class="col-lg-6">
                            <input type="text" name="nomor_proyek" id="nomor_proyek" class="form-control" required autofocus placeholder="Input Nama Proyek"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="condition-set-1">
                        <div class="form-group row">
                                <label for="id_persetujuan_pengembangan" class="col-lg-2 col-lg-offset-1 control-label">Nama Proyek</label>
                                <div class="col-lg-6">
                                    <select name="id_persetujuan_pengembangan" id="id_persetujuan_pengembangan" class="form-control" required>
                                        <option value="">Pilih Nama Proyek</option>
                                        <?php $__currentLoopData = $trx_persetujuan_pengembangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="help-block with-errors"></span>
                                </div>
                        </div>
                    </div>
                    <!-- <div class="condition-set-2">
                        <div class="form-group row">
                            <label for="nama_proyek" class="col-lg-2 col-lg-offset-1 control-label">Nama Proyek</label>
                                <div class="col-lg-6">
                                    <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" required readonly></input>
                                    <span class="help-block with-errors"></span>
                                </div>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="pemilik_proyek" class="col-lg-2 col-lg-offset-1 control-label">Pemilik Proyek</label>
                        <div class="col-lg-6">
                            <input type="text" name="pemilik_proyek" id="pemilik_proyek" class="form-control" required autofocus placeholder="Input Nama Pemilik Proyek"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="manajer_proyek" class="col-lg-2 col-lg-offset-1 control-label">Manajer Proyek</label>
                        <div class="col-lg-6">
                            <input type="text" name="manajer_proyek" id="manajer_proyek" class="form-control" required autofocus placeholder="Input Nama Manajer Proyek"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ruang_lingkup" class="col-lg-2 col-lg-offset-1 control-label">Ruang Lingkup</label>
                        <div class="col-lg-6">
                            <textarea type="text" name="ruang_lingkup" id="ruang_lingkup" class="form-control" required autofocus placeholder="Input Ruang Lingkup Proyek"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_mulai" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Mulai</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required autofocus></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="target_selesai" class="col-lg-2 col-lg-offset-1 control-label">Target Selesai</label>
                        <div class="col-lg-6">
                            <input type="date" name="target_selesai" id="target_selesai" class="form-control" required autofocus></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="estimasi_biaya" class="col-lg-2 col-lg-offset-1 control-label">Estimasi Biaya</label>
                        <div class="col-lg-6">
                            <input type="text" name="estimasi_biaya" id="estimasi_biaya" class="form-control" required autofocus placeholder="Input Estimasi Biaya Proyek"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_pemohon" class="col-lg-2 col-lg-offset-1 control-label">Nama Pemohon</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" required autofocus placeholder="Input Nama Pemohon"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan_pemohon" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Pemohon</label>
                        <div class="col-lg-6">
                            <input type="text" name="jabatan_pemohon" id="jabatan_pemohon" class="form-control" required autofocus placeholder="Input Jabatan Pemohon"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_disiapkan" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Disiapkan</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal_disiapkan" id="tanggal_disiapkan" class="form-control" required autofocus></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-lg-2 col-lg-offset-1 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama" id="nama" class="form-control" required autofocus placeholder="Input Nama Penyetuju"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-lg-2 col-lg-offset-1 control-label">Jabatan</label>
                        <div class="col-lg-6">
                            <input type="text" name="jabatan" id="jabatan" class="form-control" required autofocus placeholder="Input Jabatan Penyetuju"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_disetujui" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Disetujui</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal_disetujui" id="tanggal_disetujui" class="form-control" required autofocus></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\laragon\www\ptsi_\resources\views/perencanaan_proyek/form.blade.php ENDPATH**/ ?>