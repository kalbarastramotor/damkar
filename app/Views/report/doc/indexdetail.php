<style>
  .select2-container {
    z-index: 0 !important
  }

  .dataTables_filter {
    text-align: left !important
  }

  .button-export {
    text-align: right !important
  }
  
   
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
        <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Grid options</h4>
                                        <p class="card-title-desc">See how aspects of the Bootstrap grid
                                            system work across multiple devices with a handy table.</p>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered  table-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        <th scope="col" colspan="2" >
                                                            Filter 
                                                        </th>
                                                        <th scope="col" colspan="2" class="text-center">
                                                           Status Approval
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                      
                                                        <td style="width:8%">
                                                            Dealer
                                                        </td>
                                                        <td>
                                                        <select class="filter-office form-control" style="width:100%"></select>
                                                        </td>
                                                        
                                                        <td style="width:10%">
                                                            Approved
                                                        </td>
                                                        <td style="width:8%">
                                                         <div id="total-data-approve" class="grid-example text-center bg-primary bg-gradient p-2 text-light">0 Event</div>
                                                        </td>
                                                       
                                                    </tr>

                                                    
                                                    <tr>
                                                       
                                                        <td style="width:8%">
                                                            Tahun
                                                        </td>
                                                        <td>
                                                        <?=$params['tahun'];?>
                                                        </td>
                                                        <th class="" scope="row">
                                                           Pending / Waiting Approval
                                                        </th>
                                                       
                                                        <td>
                                                         <div  id="total-data-pending"  class="grid-example text-center bg-warning bg-gradient p-2 text-light">0 Event</div>

                                                        </td>
                                                       
                                                    </tr>

                                                    <tr>
                                                       
                                                        <td style="width:8%">
                                                            Bulan
                                                        </td>
                                                        <td>
                                                        <?=$params['bulan'];?>
                                                        </td>
                                                        <th class="" scope="row">
                                                            Rejected
                                                        </th>
                                                       
                                                        <td>
                                                         <div  id="total-data-rejected"  class="grid-example text-center bg-danger bg-gradient p-2 text-light">0 Event</div>
                                                        </td>
                                                        
                                                    </tr>

                                                    <tr>
                                                        <th class="" scope="row">
                                                            Exhibiton
                                                        </th>
                                                     
                                                        <td>
                                                        <div id="total-01" class="text-right">Rp.0</div>
                                                        </td>
                                                        <th class="" scope="row">
                                                            Running
                                                        </th>
                                                     
                                                        <td>
                                                         <div  id="total-data-running"  class="grid-example text-center bg-info bg-gradient p-2 text-light">0 Event</div>
                                                        </td>
                                                        
                                                      
                                                    </tr>

                                                    <tr>
                                                        <th class="" scope="row">
                                                        Roadshow (by MD)
                                                        </th>
                                                       
                                                        <td>
                                                        <div id="total-02" class="text-right">Rp.0</div>

                                                        </td>
                                                        <th class="" scope="row">
                                                            Done
                                                        </th>
                                                       
                                                        <td>
                                                         <div  id="total-data-done"  class="grid-example text-center bg-success bg-gradient p-2 text-light">0 Event</div>
                                                        </td>
                                                       
                                                       
                                                    </tr>

                                                    <tr>
                                                        <th class="" scope="row">
                                                          Showroom Event
                                                        </th>
                                                      
                                                        <td>
                                                        <div id="total-03" class="text-right">Rp.0</div>
                                                        </td>
                                                        <th class="" scope="row">
                                                            Draft
                                                        </th>
                                                      
                                                        <td>
                                                         <div  id="total-data-draft"  class="grid-example text-center bg-secondary bg-gradient p-2 text-light">0 Event</div>
                                                        </td>
                                                       
                                                       
                                                    </tr>

                                                    

                                                   
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- end card body -->
                               
            <div class="card-body" >
              <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">
                    <span class="d-block d-sm-none">
                      <i class="bx bxs-doughnut-chart"></i>
                    </span>
                    <span class="d-none d-sm-block" id="title-category-0">Home</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab" aria-selected="false">
                    <span class="d-block d-sm-none">
                      <i class="bx   bxs-paper-plane "></i>
                    </span>
                    <span class="d-none d-sm-block" id="title-category-1">Profile</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " data-bs-toggle="tab" href="#messages1" role="tab" aria-selected="false">
                    <span class="d-block d-sm-none">
                      <i class="bx bxs-building-house "></i>
                    </span>
                    <span class="d-none d-sm-block" id="title-category-2">Messages</span>
                  </a>
                </li>
              </ul>
              <div class="tab-content p-3 text-muted" >
                <div class="tab-pane active" id="home1" role="tabpanel">
                    <div class="table-responsive table-striped">
                      <table class="table " id="table-category-data-0">
                        <thead style="vertical-align:middle;text-align:center" style="border:1px red solid !important">
                          <tr>
                            <th rowspan="3" class="fw-bold" style="width:70px">No.</th>
                            <th colspan="2" class="fw-bold">Periode</th>
                            <th rowspan="3" style="width:1%" class="fw-bold">Durasi <br>(hari) </th>
                            <th rowspan="3" class="fw-bold">Kode <br>Dealer </th>
                            <th rowspan="3" class="fw-bold">Nama Dealer</th>
                            <th rowspan="3" class="fw-bold">Lokasi</th>
                            <th colspan="2" class="fw-bold">Jumlah <br>Pengunjung </th>
                            <th colspan="2" class="fw-bold">Penjualan <br>Jumlah </th>
                            <th class="fw-bold">Jumlah <br>Hot <br>Prospect </th>
                            <th class="fw-bold" style="width:80px">Jumlah Closing <br>(Deal) dari <br>Hot Prospect </th>
                            <th class="fw-bold">% Deal <br>dari <br>Jumlah Prospek </th>
                            <th rowspan="3" class="fw-bold">Biaya Pameran</th>
                            <th rowspan="3" class="fw-bold">Status </th>
                          </tr>
                          <tr>
                            <th rowspan="2" class="fw-bold">Mulai</th>
                            <th rowspan="2" class="fw-bold">Berakhir</th>
                            <th rowspan="2" class="fw-bold">Target</th>
                            <th rowspan="2" class="fw-bold">Aktual*</th>
                            <th rowspan="2" class="fw-bold">Target</th>
                            <th rowspan="2" class="fw-bold">Aktual**</th>
                            <th class="fw-bold">Aktual</th>
                            <th class="fw-bold">Aktual</th>
                            <th class="fw-bold">Aktual</th>
                          </tr>
                          <tr>
                            <th colspan="3" class="fw-bold">Selama Pameran</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                </div>
                <div class="tab-pane" id="profile1" role="tabpanel">
                  <div class="table-responsive table-striped">
                    <table class="table  " id="table-category-data-1">
                      <thead style="vertical-align:middle;text-align:center" style="border:1px red solid !important">
                        <tr>
                          <th rowspan="3" class="fw-bold" style="width:70px">No.</th>
                          <th colspan="2" class="fw-bold">Periode</th>
                          <th rowspan="3" style="width:1%" class="fw-bold">Durasi <br>(hari) </th>
                          <th rowspan="3" class="fw-bold">Kode <br>Dealer </th>
                          <th rowspan="3" class="fw-bold">Nama Dealer</th>
                          <th rowspan="3" class="fw-bold">Lokasi</th>
                          <th colspan="2" class="fw-bold">Jumlah <br>Pengunjung </th>
                          <th colspan="2" class="fw-bold">Penjualan <br>Jumlah </th>
                          <th class="fw-bold">Jumlah <br>Hot <br>Prospect </th>
                          <th class="fw-bold" style="width:80px">Jumlah Closing <br>(Deal) dari <br>Hot Prospect </th>
                          <th class="fw-bold">% Deal <br>dari <br>Jumlah Prospek </th>
                          <th rowspan="3" class="fw-bold">Biaya Pameran</th>
                            <th rowspan="3" class="fw-bold">Status </th>
                            <!-- <th rowspan="3" class="fw-bold">Action</th> -->
                        </tr>
                        <tr>
                          <th rowspan="2" class="fw-bold">Mulai</th>
                          <th rowspan="2" class="fw-bold">Berakhir</th>
                          <th rowspan="2" class="fw-bold">Target</th>
                          <th rowspan="2" class="fw-bold">Aktual*</th>
                          <th rowspan="2" class="fw-bold">Target</th>
                          <th rowspan="2" class="fw-bold">Aktual**</th>
                          <th class="fw-bold">Aktual</th>
                          <th class="fw-bold">Aktual</th>
                          <th class="fw-bold">Aktual</th>
                        </tr>
                        <tr>
                          <th colspan="3" class="fw-bold">Selama Pameran</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <div class="tab-pane " id="messages1" role="tabpanel">
                  <div class="table-responsive table-striped">
                    <table class="table " id="table-category-data-2">
                      <thead style="vertical-align:middle;text-align:center" style="border:1px red solid !important">
                        <tr>
                          <th rowspan="3" class="fw-bold" style="width:70px">No.</th>
                          <th colspan="2" class="fw-bold">Periode</th>
                          <th rowspan="3" style="width:1%" class="fw-bold">Durasi <br>(hari) </th>
                          <th rowspan="3" class="fw-bold">Kode <br>Dealer </th>
                          <th rowspan="3" class="fw-bold">Nama Dealer</th>
                          <th rowspan="3" class="fw-bold">Lokasi</th>
                          <th colspan="2" class="fw-bold">Jumlah <br>Pengunjung </th>
                          <th colspan="2" class="fw-bold">Penjualan <br>Jumlah </th>
                          <th class="fw-bold">Jumlah <br>Hot <br>Prospect </th>
                          <th class="fw-bold" style="width:80px">Jumlah Closing <br>(Deal) dari <br>Hot Prospect </th>
                          <th class="fw-bold">% Deal <br>dari <br>Jumlah Prospek </th>
                          <th rowspan="3" class="fw-bold">Biaya Pameran</th>
                            <th rowspan="3" class="fw-bold">Status </th>
                            <!-- <th rowspan="3" class="fw-bold">Action</th> -->
                        </tr>
                        <tr>
                          <th rowspan="2" class="fw-bold">Mulai</th>
                          <th rowspan="2" class="fw-bold">Berakhir</th>
                          <th rowspan="2" class="fw-bold">Target</th>
                          <th rowspan="2" class="fw-bold">Aktual*</th>
                          <th rowspan="2" class="fw-bold">Target</th>
                          <th rowspan="2" class="fw-bold">Aktual**</th>
                          <th class="fw-bold">Aktual</th>
                          <th class="fw-bold">Aktual</th>
                          <th class="fw-bold">Aktual</th>
                        </tr>
                        <tr>
                          <th colspan="3" class="fw-bold">Selama Pameran</th>
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
    </div>
    <!-- modal detail  -->
    <div id="modal_upload_report" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
                           
                            <div class="modal-body p-4">
                                <form enctype="multipart/form-data" >
                                    <div>
                                     

                                        <div class="wizard-tab" style="display: block;">
                                        <div class="text-center mb-4">
                                                <h5>Form Upload Image Event </h5>
                                                <p class="card-title-desc">Fill Order Summery Details.</p>
                                            </div>
                                            <div>
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

                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <button type="button" class="btn btn-primary w-sm"  class="btn-close" data-bs-dismiss="modal" aria-label="Close">Previous</button>
                                            <button type="button" class="btn btn-primary w-sm ms-auto" id="nextBtn" onclick="nextPrev(1)">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
        </div><!-- /.modal-dialog -->
    </div>
    <!-- modal detail -->
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
                    <input type="text" class="form-control" id="name-menu-add" placeholder="Enter menu name" onkeyup="validateMenuNameAdd(this.id)" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label" for="validationCustom02">Code</label>
                    <input type="text" class="form-control" id="code-menu-add" placeholder="Enter menu code" onkeyup="validateMenuCodeAdd(this.id)" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label" for="dealer-name-add">Url</label>
                    <input type="text" class="form-control" id="url-menu-add" onkeyup="validateMenuUrlAdd(this.id)" placeholder="Enter menu url" required>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="button-add-menu" class="btn btn-primary waves-effect waves-light">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var tahun = "<?=$params['tahun'];?> ";
    var bulan="<?=$params['bulan'];?>";
    var documentid="<?=$params['documentid'];?>";
  </script>