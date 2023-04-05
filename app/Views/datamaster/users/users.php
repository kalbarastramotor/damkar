<style>
 .filter-jabatan-select2>span {
    z-index: 0 !important
  }

</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped mb-0">
                  <thead>
                    <tr>
                      <th scope="col" style="width:10%"></th>
                      <th scope="col">Filter</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr>
                      <th class="text-nowrap" scope="row">Jabatan</th>
                      <td class="filter-jabatan-select2">
                        <select class="filter-jabatan form-control" style="width:100%"></select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header"> <?=$title?> </div>
            <div class="card-body">
              <table id="user-table" class="table table-striped mb-0"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="myModal_edit" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Form Edit Users</h5>
          <button type="button" class="btn-close close-detail-data" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="needs-validation" novalidate>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Name</label>
                <input type="text" class="form-control" id="name-users-edit"  onkeyup="validateAddNameEdit(this.id)" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Email</label>
                <input type="text" class="form-control" id="email-users-edit"  onkeyup="ValidateEmailEdit(this.id)"  required>
                <span id="message-email-edit"></span>
              </div>
            </div>

            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Phone</label>
                <input type="text" class="form-control" id="phone-users-edit"  onkeyup="ValidatePhoneEdit(this.id)"  required>
                <span id="message-phone-edit"></span>
              </div>
            </div>

            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Gender</label>
                <select
                  class="show-gender-edit form-control custom-select"
                  style="width:100%"
                  id="gender-users-edit"
                  required
                >
              </select>
                <div class="invalid-feedback"> Please provide a valid gender. </div>
              </div>
            </div>
       
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="button-update-users" class="btn btn-primary waves-effect waves-light">Save</button>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal_Add" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Form Tambah Users</h5>
          <button type="button" class="btn-close close-form-add" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="needs-validation" novalidate>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Name</label>
                <input type="text" class="form-control" id="name-users-add"  onkeyup="validateAddName(this.id)" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Email</label>
                <input type="text" class="form-control" id="email-users-add"  onkeyup="ValidateEmail(this.id)"  required>
                <span id="message-email"></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Phone</label>
                <input type="text" class="form-control" id="phone-users-add"  onkeyup="ValidatePhone(this.id)"  required>
                <span id="message-phone-add"></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Gender</label>
                <select
                  class="show-gender-add form-control custom-select"
                  style="width:100%"
                  id="gender-users-add"
                  required
                >
              </select>
                <div class="invalid-feedback"> Please provide a valid gender. </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Password</label>
                <input type="text" class="form-control" id="password-users-add"  onkeyup="verifyPassword(this.id)"  required>
                <span id="message-password"></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Re-Password</label>
                <input type="text" class="form-control" id="re-password-users-add"   onkeyup="ReverifyPassword(this.id)"   required>
                <span id="message-repassword"></span>
              </div>
            </div>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="button-add-users" class="btn btn-primary waves-effect waves-light">Save</button>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal_change_password" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Change Password </h5>
          <button type="button" class="btn-close close-detail-data" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="needs-validation" novalidate>
          <div class="row">
          <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Password</label>
                <input type="password" class="form-control" id="password-users-update"  onkeyup="ChangeVerifyPassword(this.id)"  required>
                <span id="message-password-update"></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" >Re-Password</label>
                <input type="password" class="form-control" id="re-password-users-update"   onkeyup="ChangeReverifyPassword(this.id)"   required>
                <span id="message-repassword-update"></span>
              </div>
            </div>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="button-update-password" class="btn btn-primary waves-effect waves-light">Save</button>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal_change_access" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Set Hak akses User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row">
              
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom03">Hak Akses</label>
                  <select class="show-access-update form-control custom-select" style="width:100%" id="id-set-user-role" required></select>
                  <div class="invalid-feedback">Please provide a valid Access.</div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom03">Area</label>
                  <select class="show-area-update form-control custom-select" style="width:100%" id="id-set-user-area" required></select>
                  <div class="invalid-feedback">Please provide a valid Access.</div>
                </div>
              </div>
             
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="button-set-role-users" class="btn btn-primary waves-effect waves-light">Save</button>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal_change_office" class="modal fade" aria-labelledby="myModalLabel_change_office" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel_change_office">Change Dealer</h5>
          <button type="button" class="btn-close close-form-edit" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row">
             
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom03">Dealer</label>
                  <select class="show-office-update form-control custom-select" style="width:100%" id="id-set-dealer-user" required></select>
                  <div class="invalid-feedback">Please provide a valid dealer.</div>
                </div>
              </div>
           
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="button-set-office" class="btn btn-primary waves-effect waves-light">Save</button>
        </div>
      </div>
    </div>
  </div>