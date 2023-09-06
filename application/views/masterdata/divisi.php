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
                    <table class="datatables-basic table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Divisi</th>
                                <th>Nama Divisi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Basic table -->

<!-- add new card modal  -->
<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="titleCard">Add New Divisi</h1>

                <!-- form -->
                <form id="form-divisi" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                    <input type="hidden" name="id" id="id">
                    <div class="col-12">
                        <label class="form-label" for="kode_divisi"><b>Kode Divisi</b></label>
                        <div class="input-group input-group-merge">
                            <input id="kode_divisi" name="kode_divisi" id="kode_divisi" class="form-control" type="text" placeholder="Exp. DIT"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" for="nama_divisi"><b>Nama Divisi</b></label>
                        <input type="text" name="nama_divisi" id="nama_divisi" class="form-control" placeholder="Depertement Teknologo Informasi" />
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

<?php include('js/divisi_ajax.php'); ?>