<!-- Basic table -->
<section id="basic-datatable">
    <div class="row" id="table-responsive">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom p-1">
                    <div class="head-label">
                        <h4 class="mb-0"><?= $title; ?></h4>
                    </div>
                    <div class="text-end">
                        <div class="d-inline-flex"> 
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addNewCard"><span><i data-feather="plus"></i>  Add New Record</span></button> 
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatables-basic table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>Divisi</th>
                                    <th>Jabatan</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Basic table -->

<!-- add new card modal  -->
<div class="modal fade" id="addNewCard" aria-labelledby="addNewCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-refer-earn">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="titleCard">Add New Karyawan</h1>

                <!-- form -->
                <form id="form-karyawan" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                    <input type="hidden" name="id" id="id">
                    <div class="col-12">
                        <label class="form-label" for="nik"><b>NIK Karyawan</b></label>
                        <div class="input-group input-group-merge">
                            <input id="nik" name="nik" class="form-control" type="text" placeholder="220011"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="nama"><b>Nama Karyawan</b></label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="John Die" />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="divisi_id"><b>Divisi</b></label>
                        <select id="divisi_id" name="divisi_id" class="select2 form-select">
                            <option selected disabled>Open this select menu</option>
                            <?php foreach ($divisi as $kDivisi => $vDivisi) {?>
                            <option value="<?= $vDivisi->id ?>"><?= $vDivisi->nama_divisi ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="jabatan_id"><b>Jabatan</b></label>
                        <select id="jabatan_id" name="jabatan_id" class="select2 form-select">
                            <option selected disabled>Open this select menu</option>
                            <?php foreach ($jabatan as $kJabatan => $vJabatan) {?>
                            <option value="<?= $vJabatan->id ?>"><?= $vJabatan->nama_jabatan ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="email"><b>Email</b></label>
                        <div class="input-group input-group-merge">
                            <input id="email" name="email" class="form-control" type="text" placeholder="example@gmail.com"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="no_hp"><b>Nomor Handphone</b></label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="081554XXXXXX" />
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="tempat_lahir"><b>Tempat Lahir</b></label>
                        <div class="input-group input-group-merge">
                            <input id="tempat_lahir" name="tempat_lahir" class="form-control" type="text" placeholder="Surabaya"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="tgl_lahir"><b>Tanggal Lahir</b></label>
                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" placeholder="Surabaya" />
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="alamat"><b>Alamat</b></label>
                        <div class="input-group input-group-merge">
                            <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Jl. Wijaya Kusuma No 23"></textarea>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="button" id="btn-submit" class="btn btn-success me-1 mt-1 btn-submit" onclick="save()">Submit</button>

                        <button class="btn btn-success me-1 mt-1 d-none btn-loading" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                        </button>
                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ add new card modal  -->

<?php include('js/karyawan_ajax.php'); ?>