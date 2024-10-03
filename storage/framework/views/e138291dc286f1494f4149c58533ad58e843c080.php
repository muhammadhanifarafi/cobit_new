<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?php echo e(route('permintaan_pengembangan.store')); ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                        <label for="nomor_dokumen" class="col-lg-2 col-lg-offset-1 control-label">Nomor Dokumen</label>
                        <div class="col-lg-6">
                            <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="latar_belakang" class="col-lg-2 col-lg-offset-1 control-label">Latar Belakang</label>
                        <div class="col-lg-6">
                            <textarea type="textarea" name="latar_belakang" id="latar_belakang" class="form-control" required autofocus placeholder="Latar Belakang atau Deskripsi Proyek"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tujuan" class="col-lg-2 col-lg-offset-1 control-label">Tujuan</label>
                        <div class="col-lg-6">
                            <textarea type="textarea" name="tujuan" id="tujuan" class="form-control" required autofocus placeholder="Tujuan Proyek"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="target_implementasi_sistem" class="col-lg-2 col-lg-offset-1 control-label">Target Implementasi Sistem</label>
                        <div class="col-lg-6">
                            <textarea name="target_implementasi_sistem" id="target_implementasi_sistem" class="form-control" rows="4" cols="50" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fungsi_sistem_informasi" class="col-lg-2 col-lg-offset-1 control-label">Fungsi-fungsi Sistem Informasi</label>
                        <div class="col-lg-6">
                            <textarea type="text" name="fungsi_sistem_informasi" id="fungsi_sistem_informasi" class="form-control" required autofocus placeholder="Fungsi Sistem Informasi"></textarea>
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
                        <label for="pengguna" class="col-lg-2 col-lg-offset-1 control-label">Pengguna</label>
                        <div class="col-lg-6">
                            <select name="pengguna" id="pengguna" class="form-control" required>
                                <option value="">Pilih Pengguna</option>
                                <option value="internal">Internal</option>
                                <option value="eksternal">Eksternal</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="uraian_permintaan_tambahan" class="col-lg-2 col-lg-offset-1 control-label">Uraian Permintaan Tambahan/Khusus</label>
                        <div class="col-lg-6">
                            <textarea type="textareas" name="uraian_permintaan_tambahan" id="uraian_permintaan_tambahan" class="form-control" required autofocus placeholder="Permintaan Tambahan"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lampiran" class="col-lg-2 col-lg-offset-1 control-label">Lampiran</label>
                        <div class="col-lg-6">
                            <input type="file" name="lampiran" id="lampiran" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pic" class="col-lg-2 col-lg-offset-1 control-label">Nama PIC</label>
                        <div class="col-lg-6">
                            <input type="text" name="pic" id="pic" class="form-control" required autofocus placeholder="Masukkan Nama PIC"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_pemohon" class="col-lg-2 col-lg-offset-1 control-label">Nama Pemohon</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" required autofocus placeholder="Masukkan Nama Pemohon"></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan_pemohon" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Pemohon</label>
                        <div class="col-lg-6">
                            <input type="text" name="jabatan_pemohon" id="jabatan_pemohon" class="form-control" required autofocus></input>
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
                            <input type="text" name="nama" id="nama" class="form-control" required autofocus></input>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Penyetuju</label>
                        <div class="col-lg-6">
                            <select name="jabatan" id="jabatan" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                <option value="kepala_sp">Kepala SP</option>
                                <option value="vp">VP</option>|
                                <option value="kepala_divisi">Kepala Divisi</option>|
                                <option value="kepala_cabang">Kepala Cabang</option>|
                            </select>
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
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\laragon\www\ptsi_\resources\views/permintaan_pengembangan/form.blade.php ENDPATH**/ ?>