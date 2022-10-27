<style>
 

   
  #googleMap {
    zoom: 150% !important
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="avatar">
                  <div class="avatar-title rounded bg-success">
                    <i class="bx bxs-doughnut-chart font-size-24 mb-0 text-sucess"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0 font-size-15">Exhibiton</h6>
                </div>
                <div class="flex-shrink-0">
                  <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                      <a class="dropdown-item" href="#">Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mt-3 pt-1 mb-0 font-size-22" id="total_1">0 <span class="text-success fw-medium font-size-14 align-middle">
                      <i class="mdi mdi-run-fast"></i>0 running </span>
                  </h4>
                </div>
              </div>
            </div>
            <div>
              <div id="mini-1" data-colors='["#e6ecf9"]' class="apex-charts"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="avatar">
                  <div class="avatar-title rounded bg-info">
                    <i class="bx   bxs-paper-plane font-size-24 mb-0 "></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0 font-size-15">Roadshow (by MD)</h6>
                </div>
                <div class="flex-shrink-0">
                  <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                      <a class="dropdown-item" href="#">Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mt-3 mb-0 font-size-22" id="total_2">0 <span class="text-danger fw-medium font-size-14 align-middle">
                      <i class="mdi mdi-run-fast"></i>0 </span>
                  </h4>
                </div>
              </div>
            </div>
            <div>
              <div id="mini-2" data-colors='["#e6ecf9"]' class="apex-charts"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="avatar">
                  <div class="avatar-title rounded bg-primary">
                    <i class="bx bxs-building-house font-size-24 mb-0 "></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0 font-size-15">Showroom Event</h6>
                </div>
                <div class="flex-shrink-0">
                  <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                      <a class="dropdown-item" href="#">Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mt-3 mb-0 font-size-22" id="total_3">0<span class="text-success fw-medium font-size-14 align-middle">
                      <i class="mdi mdi-run-fast"></i>0 </span>
                  </h4>
                </div>
              </div>
            </div>
            <div>
              <div id="mini-3" data-colors='["#e6ecf9"]' class="apex-charts"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="avatar">
                  <div class="avatar-title rounded bg-warning">
                    <i class="bx  bx-time-five font-size-24 mb-0"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0 font-size-15">Approval</h6>
                </div>
                <div class="flex-shrink-0">
                  <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-horizontal text-muted font-size-22"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                      <a class="dropdown-item" href="#">Detail</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="mt-3 mb-0 font-size-22">0 <span class="text-danger fw-medium font-size-14 align-middle">
                      <i class="mdi mdi-run-fast"></i>0 </span>
                  </h4>
                </div>
              </div>
            </div>
            <div>
              <div id="mini-4" data-colors='["#e6ecf9"]' class="apex-charts"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-8">
          <div class="card">
            <div class="card-body">
              <div id="googleMap" style="width:100%;height:530px"></div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body pt-2">
              <div class="table-responsive" style="width:100%;height:600px">
                <table class="table align-middle table-nowrap mb-1" id="table-category-data-cabang">
                  <thead style="vertical-align:middle;" style="border:1px red solid !important">
                      <tr>
                      <th class="fw-bold" >Cabang</th>
                          <th class="fw-bold">Total Event</th>
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


    <!-- sample modal content -->
    <div id="myModalMap" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Detail Maps</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <tbody>
                      <tr>
                        <th scope="row">DEALER</th>
                        <td id="dashboard-dealer-name"></td>
                      </tr>
                      <tr>
                        <th scope="row">AREA</th>
                        <td id="dashboard-area"></td>
                      </tr>
                      <tr>
                        <th scope="row">Bulan</th>
                        <td><?=date('M');?></td>
                      </tr>
                      <tr>
                        <th scope="row">Exhibiton</th>
                        <td id="dashboard-exhibiton">0 EVENT</td>
                      </tr>
                      <tr>
                        <th scope="row">Roadshow (by MD)</th>
                        <td  id="dashboard-roadshow">0 EVENT</td>
                      </tr>
                      <tr>
                        <th scope="row">Showroom Event</th>
                        <td id="dashboard-showroom">0 EVENT</td>
                      </tr>
                      <tr>
                        <th scope="row">In Progress</th>
                        <td id="dashboard-inprogress">0 EVENT</td>
                      </tr>

                      <tr>
                        <th scope="row">Running</th>
                        <td id="dashboard-running">0 EVENT</td>
                      </tr>
                      <tr>
                        <th scope="row">Done</th>
                        <td id="dashboard-done">0 EVENT</td>
                      </tr>
                      

                      <tr>
                        <th scope="row">Visitor</th>
                        <td id="dashboard-actual_visitor">0 EVENT</td>
                      </tr>

                      <tr>
                        <th scope="row">Prospek</th>
                        <td id="dashboard-target_actual_prospect">0 EVENT</td>
                      </tr>
                      <tr>
                        <th scope="row">Deal</th>
                        <td id="dashboard-actual_sell">0 EVENT</td>
                      </tr>
                      


                    </tbody>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->