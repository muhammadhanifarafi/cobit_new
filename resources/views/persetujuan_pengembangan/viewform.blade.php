<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalViewLabel">Lihat Persetujuan Pengembangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label for="id_permintaan_pengembangan" class="col-lg-2 col-lg-offset-1 control-label">Nomor Dokumen</label>
                    <div class="col-lg-6">
                        <input type="text" name="id_permintaan_pengembangan" id="id_permintaan_pengembangan" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_proyek" class="col-lg-2 col-lg-offset-1 control-label">Nama Proyek</label>
                    <div class="col-lg-6">
                        <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="deskripsi" class="col-lg-2 col-lg-offset-1 control-label">Deskripsi</label>
                    <div class="col-lg-6">
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_mst_persetujuan" class="col-lg-2 col-lg-offset-1 control-label">Status Persetujuan</label>
                    <div class="col-lg-6">
                        <textarea name="id_mst_persetujuan" id="id_mst_persetujuan" class="form-control" rows="4" readonly></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_mst_persetujuanalasan" class="col-lg-2 col-lg-offset-1 control-label">Alasan Persetujuan</label>
                    <div class="col-lg-6">
                        <textarea name="id_mst_persetujuanalasan" id="id_mst_persetujuanalasan" class="form-control" rows="3" readonly></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namapemohon" class="col-lg-2 col-lg-offset-1 control-label">Nama Pemohon</label>
                    <div class="col-lg-6">
                        <input type="text" name="namapemohon" id="namapemohon" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namapeninjau" class="col-lg-2 col-lg-offset-1 control-label">Nama Peninjau</label>
                    <div class="col-lg-6">
                        <input type="text" name="namapeninjau" id="namapeninjau" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatanpeninjau" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Pemohon</label>
                    <div class="col-lg-6">
                        <input type="text" name="jabatanpeninjau" id="jabatanpeninjau" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namapenyetuju" class="col-lg-2 col-lg-offset-1 control-label">Jabatan Penyetuju</label>
                    <div class="col-lg-6">
                        <input type="text" name="namapenyetuju" id="namapenyetuju" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
