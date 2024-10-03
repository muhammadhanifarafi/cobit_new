<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?php echo e(route('quality_assurance_testing.store')); ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                        <div class="condition-set">
                        <label for="id_permintaan_pengembangan" class="col-lg-2 col-lg-offset-1 control-label">Nomor Dokumen Permintaan</label>
                            <div class="col-lg-6">
                                <select name="id_permintaan_pengembangan" id="id_permintaan_pengembangan" class="form-control" required>
                                    <option value="">Pilih Nomor Dokumen Permintaan</option>
                                    <?php $__currentLoopData = $trx_permintaan_pengembangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_proyek" class="col-lg-2 col-lg-offset-1 control-label">Nomor Proyek</label>
                        <div class="col-lg-6">
                            <input type="text" name="nomor_proyek" id="nomor_proyek" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_aplikasi" class="col-lg-2 col-lg-offset-1 control-label">Nama Aplikasi</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_aplikasi" id="nama_aplikasi" class="form-control" required autofocus placeholder="Masukkan Nama Aplikasi">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis_aplikasi" class="col-lg-2 col-lg-offset-1 control-label">Jenis Aplikasi</label>
                        <div class="col-lg-6">
                            <select name="jenis_aplikasi" id="jenis_aplikasi" class="form-control" required>
                                <option value="">Pilih Jenis Aplikasi</option>
                                <option value="mobile">Mobile</option>
                                <option value="dekstop">Dekstop</option>
                                <option value="web">Web</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label for="unit_pemilik" class="col-lg-2 col-lg-offset-1 control-label">Unit Pemilik Sistem</label>
                        <div class="col-lg-6">
                            <input type="text" name="unit_pemilik" id="unit_pemilik" class="form-control" required autofocus placeholder="Masukkan Unit Pemilik Sistem"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kebutuhan_nonfungsional" class="col-lg-2 col-lg-offset-1 control-label">Kebutuhan Non-Fungsional</label>
                        <div class="col-lg-6">
                            <input type="text" name="kebutuhan_nonfungsional" id="kebutuhan_nonfungsional" class="form-control" required autofocus placeholder="Masukkan Kebutuhan Non Fungsional"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi_pengujian" class="col-lg-2 col-lg-offset-1 control-label">Lokasi Pengujian</label>
                        <div class="col-lg-6">
                            <input type="text" name="lokasi_pengujian" id="lokasi_pengujian" class="form-control" required autofocus placeholder="Masukkan Lokasi Pengujian"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_pengujian" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Pengujian</label>
                        <div class="col-lg-6">
                            <input type="date" name="tgl_pengujian" id="tgl_pengujian" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="manual_book" class="col-lg-2 col-lg-offset-1 control-label">Manual Book</label>
                        <div class="col-lg-6">
                            <input type="text" name="manual_book" id="manual_book" class="form-control" required autofocus placeholder="Masukkan Manual Book"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_mengetahui" class="col-lg-2 col-lg-offset-1 control-label">Nama Mengetahui</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_mengetahui" id="nama_mengetahui" class="form-control" required autofocus placeholder="Masukkan Nama Mengetahui"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan_mengetahui" class="col-lg-2 col-lg-offset-1 control-label">Jabatan</label>
                        <div class="col-lg-6">
                            <input type="text" name="jabatan_mengetahui" id="jabatan_mengetahui" class="form-control" required autofocus placeholder="Masukkan Nama Jabatan"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_diketahui" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Diketahui</label>
                        <div class="col-lg-6">
                            <input type="date" name="tgl_diketahui" id="tgl_diketahui" class="form-control" required autofocus></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_penyetuju" class="col-lg-2 col-lg-offset-1 control-label">Nama Penyetuju</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_penyetuju" id="nama_penyetuju" class="form-control" required autofocus placeholder="Masukkan Nama Penyetuju"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan_penyetuju" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Penyetuju</label>
                        <div class="col-lg-6">
                            <input type="text" name="jabatan_penyetuju" id="jabatan_penyetuju" class="form-control" required autofocus placeholder="Masukkan Jabatan Penyetuju"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_disetujui" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Disetujui</label>
                        <div class="col-lg-6">
                            <input type="date" name="tgl_disetujui" id="tgl_disetujui" class="form-control" required autofocus ></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\ptsi_\resources\views/quality_assurance_testing/form.blade.php ENDPATH**/ ?>