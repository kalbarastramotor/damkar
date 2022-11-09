<style>
  .filter-office-select2>span {
    z-index: 0 !important
  }

  .filter-category-select2>span {
    z-index: 0 !important
  }

  .filter-year-select2>span {
    z-index: 0 !important
  }

  .filter-event-select2>span {
    z-index: 0 !important
  }

  .filter-month-select2>span {
    z-index: 0 !important
  }

  .dataTables_filter {
    text-align: left !important
  }

  .button-export {
    text-align: right !important
  }

  #map {
    height: 400px;
    zoom: 150% !important
  }
  #map_update{
    height: 400px;
    zoom: 150% !important
    
  }
  #pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 400px;
  }

</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12 col-lg-12">
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
                  <tbody> <?php 
                    if($_SESSION['roleid']=="1"){
                        ?> <tr>
                      <th class="text-nowrap" scope="row">Dealer</th>
                      <td class="filter-office-select2">
                        <select class="filter-office form-control" style="width:100%"></select>
                      </td>
                    </tr> <?php 
                      }
                    ?> <tr>
                      <th class="text-nowrap" scope="row">Status Event</th>
                      <td class="filter-event-select2">
                        <select class="filter-event form-control" style="width:100%"></select>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-nowrap" scope="row">Category</th>
                      <td class="filter-category-select2">
                        <select class="filter-category form-control" style="width:100%"></select>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-nowrap" scope="row">Year</th>
                      <td class="filter-year-select2">
                        <select class="filter-year form-control" style="width:100%"></select>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-nowrap" scope="row">Month</th>
                      <td class="filter-month-select2">
                        <select class="filter-bulan form-control" style="width:100%"></select>
                      </td>
                    </tr>

                    <tr>
                      <th class="text-nowrap" scope="row">Download</th>
                      <td class="filter-month-select2">
                          <button type="button" id="button-download-report"  class="btn btn-success waves-effect waves-light">
                            <i class="bx bx-file font-size-16 align-middle me-2"></i> Download
                          </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-striped mb-0" id="table-event-data">
                <thead>
                  <tr>
                    <th rowspan="2" class="fw-bold" style="width:70px">No.</th>
                    <th rowspan="2" class="text-center">Event Name</th>
                    <th colspan="2" class="text-center">Periode</th>
                    <th rowspan="2" class="fw-bold">Durasi <br>(hari) </th>
                    <th rowspan="2" class="text-center">Status</th>
                    <th rowspan="2" class="fw-bold">Kategori</th>
                    <th rowspan="2" class="fw-bold">Kode <br>Dealer </th>
                    <th rowspan="2" class="fw-bold">Nama Dealer</th>
                    <th rowspan="2" class="fw-bold">Action</th>
                  </tr>
                  <tr>
                    <th class="fw-bold">Mulai</th>
                    <th class="fw-bold">Berakhir</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="myModal_detail" class="modal fade bs-example-modal-xl" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title" id="myModalLabel">Detail Event</h5>
        <button type="button" class="btn-close close-detail-data" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <div class="invoice-title">
              <div class="table-responsive">
                <table class="table table-striped mb-0">
                  <tbody>
                    <tr>
                      <th scope="row">Event</th>
                      <td id="id-event-name"></td>
                    </tr>
                    <tr>
                      <th scope="row" style="width:50%">Periode</th>
                      <td id="id-event-durasi"></td>
                    </tr>
                    <tr>
                      <th scope="row">Durasi (hari)</th>
                      <td id="id-event-days"></td>
                    </tr>
                    <tr>
                      <th scope="row">Kategori</th>
                      <td id="id-event-kategori"></td>
                    </tr>
                    <tr>
                      <th scope="row">Kode Dealer</th>
                      <td id="id-dealer-code"></td>
                    </tr>
                    <tr>
                      <th scope="row">Nama Dealer</th>
                      <td id="id-dealer-name"></td>
                    </tr>
                    <tr>
                      <th scope="row">Biaya Event</th>
                      <td id="id-event-biaya"></td>
                    </tr>
                    <tr>
                      <th scope="row">Status</th>
                      <td id="id-event-status"></td>
                    </tr>
                    <tr>
                      <th scope="row">Action</th>
                      <td id="id-event-action"></td>
                    </tr>
                    <tr>
                      <th scope="row">Created By :</th>
                      <td id="id-created-by"></td>
                    </tr>
                    <tr>
                      <th scope="row">Cover</th>
                      <td id="id-event-cover"></td>
                    </tr>
                    <tr>
                      <th scope="row">History Status</th>
                      <td id="id-event-action-history">
                        <button type="button" class="btn btn-soft-secondary">Show</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <table class="table table-striped mb-0">
                  <thead class="table-light">
                    <tr>
                      <th colspan="2" class="text-center">Jumlah <br>Pengunjung </th>
                      <th colspan="2" class="text-center">Jumlah Peserta <br>Riding Test </th>
                      <th colspan="2" class="text-center">Penjualan</th>
                      <th class="text-center">Jumlah <br>Hot Prospect </th>
                      <th class="text-center">Jumlah Closing <br>(Deal) dari Hot Prospect </th>
                      <th class="text-center">% Deal dari <br>Jumlah Prospek </th>
                    </tr>
                    <tr>
                      <th class="text-center">Estimasi</th>
                      <th class="text-center">Aktual*</th>
                      <th class="text-center">Estimasi</th>
                      <th class="text-center">Aktual*</th>
                      <th class="text-center">Estimasi</th>
                      <th class="text-center">Aktual*</th>
                      <th class="text-center">Aktual*</th>
                      <th class="text-center">Aktual*</th>
                      <th class="text-center">Aktual*</th>
                    </tr>
                    <tr>
                      <th colspan="9" class="text-center">Selama Pameran</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center" id="id-target-visitor">0</td>
                      <td class="text-center" id="id-actual-visitor">0</td>
                      <td class="text-center" id="id-target-riding">0</td>
                      <td class="text-center" id="id-actual-riding">0</td>
                      <td class="text-center" id="id-target-sell">0</td>
                      <td class="text-center" id="id-actual-sell">0</td>
                      <td class="text-center" id="id-target-prospect-text">0</td>
                      <td class="text-center" id="id-target-actual-text">0</td>
                      <td class="text-center" id="id-target-actual-persen">0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <br>
            <div class="card">
              <div class="card-header text-center">
                <h4 class="card-title">Galery Event</h4>
                <p class="card-title-desc">Galery ditampilak berdasarkan tanggal pelaksanaan</p>
              </div>
              <div class="card-body">
                <div class="row" id="data-image"></div>
              </div>
            </div>
            <br>
            <br>
            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="card-header">
                    <h4 class="card-title">Note</h4>
                    <ul class="card-title-desc list-unstyled mb-0">
                      <li>1. Foto harus dilengkapi dengan info lokasi dan waktu (Aplikasi "GPS Map Camera: Geotag Photos & Add GPS Location")</li>
                      <li>2. Keterangan lokasi dan waktu pada foto harus sesuai sesuai dengan periode yang ada pada tabel diatas</li>
                      <li>3. Angle foto harus sesuai dengan contoh foto di atas (display unit pada booth/tenda pameran dan sales people yang sedang melakukan flyering</li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xl-12">
                        <div>
                          <footer class="blockquote-footer">
                            <code class="highlighter-rouge">*</code>
                            <cite title="Source Title">Pengunjung adalah orang yang dinilai tertarik terhadap promosi yang dijalankan dan yang bersedia memberikan data identitas yang diperlukan (nama dan nomor telepon)</cite>
                          </footer>
                          <footer class="blockquote-footer">
                            <code class="highlighter-rouge">**</code>
                            <cite title="Source Title">Penjualan aktual adalah minimal konsumen yang sudah memberikan tanda jadi</cite>
                          </footer>
                          <footer class="blockquote-footer">
                            <code class="highlighter-rouge">***</code>
                            <cite title="Source Title">Hot prospek adalah konsumen yang sudah menunjukan ketertarikan terhadap unit tertentu selama masa pameran</cite>
                          </footer>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="myModal_add" class="modal fade bs-example-modal-xl" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Add Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" enctype="multipart/form-data" novalidate>
          <div class="row">
            <div class="col">
              <label class="form-label" for="validationCustom02">Start Date Event</label>
              <input type="datetime-local" class="form-control" id="eventlist-start-date-add" required>
            </div>
            <div class="col">
              <label class="form-label" for="validationCustom02">End Date Event</label>
              <input type="datetime-local" class="form-control" id="eventlist-end-date-add" required>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-label" for="validationCustom02">Event Name</label>
              <input type="text" class="form-control" id="eventlist-name-add" onkeyup="validatNameAdd(this.id)" placeholder="Input Event Name"  required>
            </div>
            <div class="col modal-select2">
              <label class="form-label" for="validationCustom02">Event Category</label>
              <select class="form-control filter-category-add" id="eventlist-categoryid-add" style="width:100%" required></select>
              <div class="invalid-feedback"> Please select category. </div>
            </div>
          </div>
          <div class="row" id="dealer-show">
           
            <div class="col modal-select2">
              <label class="form-label" for="validationCustom02">Dealer 

              </label>
              <select class="form-control filter-office-add" id="eventlist-officeid-add" style="width:100%" required>
                      
            </select>
              <div class="invalid-feedback"> Please select Dealer. </div>
            </div>
          </div>
          <div class="row">
            <div class="col text-center">
              <label class="form-label" for="validationCustom02">Pin Point Maps</label>
              <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box"/> -->
              <div id="map"></div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-label" for="validationCustom02">Map Latitute</label>
              <input type="text" class="form-control" id="eventlist-location-lat-add" placeholder="Silahkan Pin Point dari maps"  required>
            </div>
            <div class="col">
              <label class="form-label" for="validationCustom02">Map Longtitute</label>
              <input type="text" class="form-control" id="eventlist-location-long-add" placeholder="Silahkan Pin Point dari maps"  required>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <label class="form-label" for="validationCustom02">Target Visitor</label>
                <input type="number" class="form-control" id="eventlist-target-visitor-add" min="0" max="1000" placeholder="Input Target Visitor" required>
            </div>
            <div class="col">
              <label class="form-label" for="validationCustom02">Target Sell</label>
              <input type="number" class="form-control" id="eventlist-target-sell-add" min="0" max="1000" placeholder="Input Target Sell" required>
            </div>
            <div class="col">
                <label class="form-label" for="validationCustom02">Budget Event</label>
                <input type="number" class="form-control" id="eventlist-butget-add" placeholder="Input Budget Event">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="custom-file-label" for="validationCustom02">Cover Event</label>
              <input type="file" class="form-control custom-file-input" id="eventlist-cover-add" onchange="loadFileCover(event)" accept="image/png, image/jpeg">
              <div id="display_cover">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <label class="form-label" for="validationCustom02">Location</label>
                <textarea name="w3review" class="form-control" rows="4" cols="74" id="eventlist-location-add" placeholder="Please insert location"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <label class="form-label" for="validationCustom02">Event Description</label>
                <textarea name="w3review" class="form-control" rows="4" cols="74" id="eventlist-description-add" placeholder="Please Descrip your event"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="button-add-eventlist" class="btn btn-primary waves-effect waves-light">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- modal detail  -->
<div id="modal_upload_report" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
                            <div class="modal-body p-4">
                                <form enctype="multipart/form-data" >
                                    <div>
                                     

                                        <div class="wizard-tab" style="display: block;">
                                        <div class="text-center mb-4">
                                                <h5>Form Upload Report Event </h5>
                                                <p class="card-title-desc">Upload report data event.</p>
                                            </div>
                                            <div>
                                            <div class="table-responsive">
                                              <table class="table table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                  <th colspan="2" class="text-center">Jumlah <br>Pengunjung </th>
                                                  <th colspan="2" class="text-center">Jumlah Peserta <br>Riding Test </th>
                                                  <th colspan="2" class="text-center">Penjualan</th>
                                                  <th class="text-center">Jumlah <br>Hot Prospect </th>
                                                  <th class="text-center">Jumlah Closing <br>(Deal) dari Hot Prospect </th>
                                                  <th class="text-center">% Deal dari <br>Jumlah Prospek </th>
                                                </tr>
                                                <tr>
                                                  <th class="text-center">Estimasi</th>
                                                  <th class="text-center">Aktual*</th>
                                                  <th class="text-center">Estimasi</th>
                                                  <th class="text-center">Aktual*</th>
                                                  <th class="text-center">Estimasi</th>
                                                  <th class="text-center">Aktual*</th>
                                                  <th class="text-center">Aktual*</th>
                                                  <th class="text-center">Aktual*</th>
                                                  <th class="text-center">Aktual*</th>
                                                </tr>
                                                <tr>
                                                  <th colspan="9" class="text-center">Selama Pameran</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                  <td class="text-center" id="id-target-visitor-report">0</td>
                                                  <td class="text-center editable" id="id-actual-visitor-report">0</td>
                                                  <td class="text-center editable" id="id-target-riding-report">0</td>
                                                  <td class="text-center editable" id="id-actual-riding-report">0</td>
                                                   <td class="text-center" id="id-target-sell-report">0</td>
                                                  <td class="text-center editable" id="id-actual-sell-report">0</td>
                                                 
                                                  <td class="text-center editable" id="target_prospect">0</td>
                                                  <td class="text-center editable" id="target_actual_prospect">0</td>
                                                  <td class="text-center" id="target_actual_prospect_persen">0</td>
                                                </tr>
                                                </tbody>
                                              </table>
                                            </div>
                                                <div class="table-responsive">
                                                    <table class="table table-nowrap">

                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Item name</th>
                                                                <th scope="col">Description</th>
                                                                <th scope="col" width="120px">Total</th>
                                                                <th scope="col" class="text-center">Action</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody id="datail_form">
                                                            

                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <!-- wizard-tab -->

                                        <div class="d-flex align-items-start gap-3 mt-4" style="justify-content:center">
                                            <button type="button" class="btn btn-primary w-sm"  class="btn-close" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
        </div><!-- /.modal-dialog -->
    </div>


    <div class="modal fade bs-example-modal-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="background-color:navajowhite;">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Note Reject</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="mb-3">
                          <label for="message-text" class="col-form-label">Message:</label>
                          <textarea class="form-control" id="reject-note"></textarea>
                      </div>
                  </form>
              </div>
              <div class="modal-footer" style="justify-content:center">
                  <button type="button" class="btn btn-danger" id="button-reject"  status="3">Reject</button>
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade bs-example-modal-center" id="modal-request-approve" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="background-color:lavender;">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Request</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="mb-3">
                          <label for="message-text" class="col-form-label">Message:</label>
                          <textarea class="form-control" id="request-note"></textarea>
                      </div>
                  </form>
              </div>
              <div class="modal-footer" style="justify-content:center">
                  <button type="button"  id="button-request"  status="1" class="btn btn-primary">Request</button>
              </div>
          </div>
      </div>
  </div>

<!-- start modal approve  -->
<div class="modal fade bs-example-modal-center" id="modal-approve" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="background-color:lavender;">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Approve</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="mb-3">
                          <label for="message-text" class="col-form-label">Message:</label>
                          <textarea class="form-control" id="approve-note"></textarea>
                      </div>
                  </form>
              </div>
              <div class="modal-footer" style="justify-content:center">
                  <button type="button"  id="button-approve"  status="2" class="btn btn-primary">Approve</button>
              </div>
          </div>
      </div>
  </div>
<!-- end modal approve  -->

  <!-- start modal history status -->

  <div class="modal fade bs-example-modal-center" id="historyStatus" tabindex="-1" aria-labelledby="historyStatusLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content" style="background-color:cornsilk;">
              <div class="modal-header">
                  <h5 class="modal-title" id="historyStatusLabel">History Status Event</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                  <div class="table-responsive">
                    <table class="table table-sm m-0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Time</th>
                          <th>Updated By</th>
                          <th>Note</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="detail-history-event">
                       
                      </tbody>
                    </table>
                  </div>
                  </div>
          </div>
      </div>
  </div>
  <!-- end modal history status -->


  <!--  start edit event -->
  <div id="myModal_edit" class="modal fade bs-example-modal-xl" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Edit Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" enctype="multipart/form-data" novalidate>
          <div class="row">
            <div class="col">
              <label class="form-label" for="validationCustom02">Start Date Event</label>
              <input type="datetime-local" class="form-control" id="eventlist-start-date-update" required>
            </div>
            <div class="col">
              <label class="form-label" for="validationCustom02">End Date Event</label>
              <input type="datetime-local" class="form-control" id="eventlist-end-date-update" required>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-label" for="validationCustom02">Event Name</label>
              <input type="text" class="form-control" id="eventlist-name-update" onkeyup="validatNameAdd(this.id)" placeholder="Input Event Name"  required>
            </div>
            <div class="col modal-select2">
              <label class="form-label" for="validationCustom02">Event Category</label>
              <select class="form-control filter-category-update" id="eventlist-categoryid-update" style="width:100%" required></select>
              <div class="invalid-feedback"> Please select category. </div>
            </div>
          </div>
          <div class="row">
           
            <div class="col modal-select2">
              <label class="form-label" for="validationCustom02">Dealer</label>
              <select class="form-control filter-office-update" id="eventlist-officeid-update" style="width:100%" required></select>
              <div class="invalid-feedback"> Please select Dealer. </div>
            </div>
          </div>
          <div class="row">
            <div class="col text-center">
              <label class="form-label" for="validationCustom02">Pin Point Maps</label>
              <div id="map_update"></div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-label" for="validationCustom02">Map Latitute</label>
              <input type="text" class="form-control" id="eventlist-location-lat-update" placeholder="Silahkan Pin Point dari maps"   required>
            </div>
            <div class="col">
              <label class="form-label" for="validationCustom02">Map Longtitute</label>
              <input type="text" class="form-control" id="eventlist-location-long-update" placeholder="Silahkan Pin Point dari maps" required>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <label class="form-label" for="validationCustom02">Target Visitor</label>
                <input type="number" class="form-control" id="eventlist-target-visitor-update" min="0" max="1000" placeholder="Input Target Visitor" required>
            </div>
            <div class="col">
              <label class="form-label" for="validationCustom02">Target Sell</label>
              <input type="number" class="form-control" id="eventlist-target-sell-update" min="0" max="1000" placeholder="Input Target Sell" required>
            </div>
            <div class="col">
                <label class="form-label" for="validationCustom02">Budget Event</label>
                <input type="number" class="form-control" id="eventlist-butget-update" placeholder="Input Budget Event">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="custom-file-label" for="validationCustom02">Cover Event</label>
              <input type="file" class="form-control custom-file-input" id="eventlist-cover-update" onchange="loadFileCover(event)" accept="image/png, image/jpeg">
              <div id="display_cover_update">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <label class="form-label" for="validationCustom02">Location</label>
                <textarea name="w3review" class="form-control" rows="4" cols="74" id="eventlist-location-update" placeholder="Please insert location"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <label class="form-label" for="validationCustom02">Event Description</label>
                <textarea name="w3review" class="form-control" rows="4" cols="74" id="eventlist-description-update" placeholder="Please Descrip your event"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="button-update-eventlist" class="btn btn-primary waves-effect waves-light">Save</button>
      </div>
    </div>
  </div>
</div>
  <!-- end edit event -->