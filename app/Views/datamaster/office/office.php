<style>
  #map {
    height: 400px;
    zoom: 150% !important
  }

  #map_add {
    height: 400px;
    zoom: 150% !important
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header"> <?=$title?> </div>
            <div class="card-body">
              <table id="office-table" class="table table-striped mb-0"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Edit Data Dealer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Code</label>
                  <input type="text" class="form-control" id="dealer-code-update" placeholder="Code" onkeyup="validateDealerCodeUpdate(this.id)" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="dealer-name">Dealer</label>
                  <input type="text" class="form-control" id="dealer-name-update" onkeyup="validateDealerNameUpdate(this.id)" placeholder="Enter Dealer Name" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Phone</label>
                  <input type="text" class="form-control" id="dealer-phone-update" placeholder="Phone" onkeyup="validateDealerPhoneUpdate(this.id)" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Provinsi</label>
                  <select class="province-update form-control" style="width:100%" id="dealer-province-update"></select>
                  <div class="invalid-feedback">Please provide a valid Province.</div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom02">Kota</label>
                  <select class="city-update form-control" style="width:100%" id="dealer-city-update"></select>
                  <div class="invalid-feedback">Please provide a valid City.</div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label" for="validationCustom04">Address</label>
                  <input type="text" class="form-control" id="dealer-address-update" placeholder="Address" onkeyup="validateDealerAddressUpdate(this.id)" required>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="button-update-office" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
      </div>
    </div>
  </div>
  <div id="myModal-maps" class="modal fade bs-example-modal-xl" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Office Location</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="map"></div>
          <br>
          <input type="text" class="form-control" id="update-map-lat">
          <br>
          <input type="text" class="form-control" id="update-map-long">
        </div>
        <div class="modal-footer" style="justify-content:center">
          <button type="button" id="button-update-map" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="myModal_add" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true" data-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Add Data Dealer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" novalidate>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" for="validationCustom02">Code</label>
                <input type="text" class="form-control" id="dealer-code-add" placeholder="Code" onkeyup="validateDealerCodeAdd(this.id)" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" for="dealer-name-add">Dealer</label>
                <input type="text" class="form-control" id="dealer-name-add" onkeyup="validateDealerNameAdd(this.id)" placeholder="Enter Dealer Name" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" for="dealer-phone-add">Phone</label>
                <input type="text" class="form-control" id="dealer-phone-add" onkeyup="validateDealerPhoneAdd(this.id)" placeholder="Phone" required>
              </div>
            </div>
           
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" for="validationCustom02">Provinsi</label>
                <select class="show-province form-control custom-select" style="width:100%" id="dealer-province-add" required></select>
                <div class="invalid-feedback">Please provide a valid Province.</div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" for="validationCustom02">Kota</label>
                <select class="show-city form-control custom-select" style="width:100%" id="dealer-city-add" required></select>
                <div class="invalid-feedback">Please provide a valid City.</div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label" for="validationCustom04">Address</label>
                <input type="text" class="form-control" id="dealer-address-add" onkeyup="validateDealerAddressAdd(this.id)" placeholder="Address" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <div id="map_add"></div>
                <br>
                <input type="text" class="form-control" id="add-map-lat">
                <br>
                <input type="text" class="form-control" id="add-map-long">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="button-add-office" class="btn btn-primary waves-effect waves-light">Save</button>
      </div>
    </div>
  </div>
</div>
