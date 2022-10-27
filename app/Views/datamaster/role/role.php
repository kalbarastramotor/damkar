<style>
    #detail-role-table {
        width: 100% !important
    }

    .dataTables_filter {
        text-align: left !important;
    }

    .dataTables_length {
        text-align: right !important;

    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"> <?= $title ?> </div>
                        <div class="card-body">
                            <table id="role-table" class="table table-striped mb-0"></table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- /.modal Edit -->
    <div id="myModal_update" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Role Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="role-name">Nama Pengguna</label>
                                    <input type="text" class="form-control" id="role-name-update"  placeholder="Name" onkeyup="validateRoleNameUpdate(this.id)" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Routes / Hak Akses</label>
                                    <input type="text" class="form-control" id="role-routes-update" placeholder="Routes" onkeyup="validateRoleRoutesUpdate(this.id)" required />

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Publish Status</label>

                                    <select id="role-publish-update" class="show-role-publish-update form-control custom-select" style="width:100%" id="role-publish-update" required>
                                    </select>
                                    <div class="invalid-feedback"> Please provide a publish status. </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="button-update-role" class="btn btn-primary waves-effect waves-light">
                        Update
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End Modal Edit -->
</div>

<!-- Modal Add -->
<div id="myModal_add" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Role Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="date" value="<?php echo date("Y-m-d"); ?>" id="role-creattime-add" hidden>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="role-name-add">Nama User</label>
                                <input type="text" class="form-control" id="role-name-add" placeholder="Name" onkeyup="validateRoleNameAdd(this.id)" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label" for="role-routes-add">Routes </label>
                                <input type="text" class="form-control" id="role-routes-add" onkeyup="validateRoleRoutesAdd(this.id)" placeholder="Enter Route for this User" required />
                            </div>
                        </div>

                        <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Publish Status</label>

                                    <select id="role-publish-add" class=" form-control custom-select" style="width:100%" id="role-publish-update" required>
                                    </select>
                                    <div class="invalid-feedback"> Please provide a publish status. </div>

                                </div>
                            </div>

                     
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="button-add-role" class="btn btn-primary waves-effect waves-light">
                    Save
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Add -->



<!--  modal detail role  -->



<div id="myModal_detail" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="myModalLabel_detail">Detail Menu </h5>
                <button type="button" class="btn-close close-detail-data" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="detail-role-table" class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Menu</th>
                            <th>Status</th>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>