<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalViewLabel">Lihat Perancanaan Kebutuhan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label for="id_persetujuan_pengembangan" class="col-lg-2 col-lg-offset-1 control-label">Nama Proyek</label>
                    <div class="col-lg-6">
                        <input type="text" name="id_persetujuan_pengembangan" id="id_persetujuan_pengembangan" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stakeholders" class="col-lg-2 col-lg-offset-1 control-label">Stakeholders</label>
                    <div class="col-lg-6">
                        <textarea name="stakeholders" id="stakeholders" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kebutuhan_fungsional" class="col-lg-2 col-lg-offset-1 control-label">Kebutuhan Fungsional</label>
                    <div class="col-lg-6">
                        <textarea name="kebutuhan_fungsional" id="kebutuhan_fungsional" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kebutuhan_nonfungsional" class="col-lg-2 col-lg-offset-1 control-label">Kebutuhan Nonfungsional</label>
                    <div class="col-lg-6">
                        <textarea name="kebutuhan_nonfungsional" id="kebutuhan_nonfungsional" class="form-control" rows="4" readonly></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lampiran" class="col-lg-2 col-lg-offset-1 control-label">Lampiran</label>
                    <div class="col-lg-6">
                        <a href="#" id="lampiran-link" target="_blank" class="btn btn-primary">Lihat Lampiran</a>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_pemohon_2" class="col-lg-2 col-lg-offset-1 control-label">Nama Pemohon</label>
                    <div class="col-lg-6">
                        <input type="text" name="nama_pemohon_2" id="nama_pemohon_2" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan_pemohon" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Pemohon</label>
                    <div class="col-lg-6">
                        <input type="text" name="jabatan_pemohon" id="jabatan_pemohon" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_disiapkan" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Disiapkan</label>
                    <div class="col-lg-6">
                        <input type="date" name="tanggal_disiapkan" id="tanggal_disiapkan" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-lg-2 col-lg-offset-1 control-label">Nama Penyetuju</label>
                    <div class="col-lg-6">
                        <input type="text" name="nama" id="nama" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Penyetuju</label>
                    <div class="col-lg-6">
                        <input type="text" name="jabatan" id="jabatan" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_disetujui" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Disetujui</label>
                    <div class="col-lg-6">
                        <input type="date" name="tanggal_disetujui" id="tanggal_disetujui" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\ptsi_\resources\views/perencanaan_kebutuhan/viewform.blade.php ENDPATH**/ ?>