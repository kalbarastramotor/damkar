<style>
  #detail-menu-table {
    width: 100% !important
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
              <table id="menu-table" class="table table-striped mb-0"></table>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- container-fluid -->
  </div>
  <!-- End Page-content -->

  <div id="myModal_detail" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Detail Menu </h5>
          <button type="button" class="btn-close close-detail-data" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table id="detail-menu-table" class="table table-striped mb-0"></table>

        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <div id="myModal_add" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Add Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Name</label>
                  <input type="text" class="form-control" id="name-menu-add" placeholder="Enter menu name" onkeyup="validateMenuNameAdd(this.id)" required />
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Code</label>
                  <input type="text" class="form-control" id="code-menu-add" placeholder="Enter menu code" onkeyup="validateMenuCodeAdd(this.id)" required />
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="dealer-name-add">Url </label>
                  <input type="text" class="form-control" id="url-menu-add" onkeyup="validateMenuUrlAdd(this.id)" placeholder="Enter menu url" required />
                </div>
              </div>

              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom03">Parent</label>

                  <select class="show-parent form-control custom-select" style="width:100%" id="menu-parent-add" required>

                  </select>

                  <div class="invalid-feedback"> Please provide a valid PIC. </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Status</label>
                  <select class="show-publish-menu form-control custom-select" style="width:100%" id="menu-publish-add" required>

                  </select>
                  <div class="invalid-feedback"> Please provide a valid Status. </div>

                </div>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="button" id="button-add-menu" class="btn btn-primary waves-effect waves-light">
            Save
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>



  <div id="myModal_edit" class="modal fade" aria-labelledby="myModalLabel_edit" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel_edit">Edit Menu</h5>
          <button type="button" class="btn-close close-form-edit" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Name</label>
                  <input type="text" class="form-control" id="name-menu-edit" onkeyup="validateMenuNameUpdate(this.id)" required />
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Code</label>
                  <input type="text" class="form-control" id="code-menu-edit" onkeyup="validateMenuCodeUpdate(this.id)" required />
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="dealer-name-add">Url </label>
                  <input type="text" class="form-control" id="url-menu-edit" onkeyup="validateMenuUrlUpdate(this.id)" placeholder="Enter Dealer Name" required />
                </div>
              </div>

              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom03">Parent</label>

                  <select class="show-parent-edit form-control custom-select" style="width:100%" id="parent-menu-edit" required>

                  </select>
                  <div class="invalid-feedback"> Please provide a valid Parent Menu. </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Status</label>
                  <select class="show-publish-menu-edit form-control custom-select" style="width:100%" id="menu-publish-edit" required>

                  </select>
                  <div class="invalid-feedback"> Please provide a valid Status. </div>

                </div>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="button" id="button-update-menu" class="btn btn-primary waves-effect waves-light">
            Save
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>