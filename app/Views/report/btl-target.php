<style>
  .dataTables_filter{
    text-align: left !important;
  }
  .button-export{
    text-align: right !important;
    
  }
  </style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header text-center">
            <h4 class="card-title"> <?=$title?></h4>  
           </div>
            <div class="card-body">
              <table id="btl-table" class="table table-striped mb-0">
              <thead style="border:1px red solid !important">
                <tr>
                    <th></th>
                    <th style="vertical-align : middle;text-align:center;" rowspan="3">DEALER CODE</th>
                    <th style="vertical-align : middle;text-align:center;" rowspan="3">	DEALER NAME</th>
                </tr>
                <tr>
                    <th></th>
                    <th  style="vertical-align : middle;text-align:center;" colspan="2">Exhibiton</th>
                    <th  style="vertical-align : middle;text-align:center;" colspan="2">Roadshow (by MD)</th>
                    <th style="vertical-align : middle;text-align:center;" colspan="2">	Showroom Event	</th>
                </tr>
                <tr>
                <th></th>
                <th  style="vertical-align : middle;text-align:center;">Freq/Month</th>
                <th style="vertical-align : middle;text-align:center;">Subsidi MD/ titik</th>
                <th style="vertical-align : middle;text-align:center;">Freq/Month</th>
                <th style="vertical-align : middle;text-align:center;">Subsidi MD/ titik</th>
                <th style="vertical-align : middle;text-align:center;">Freq/Month</th>
                <th style="vertical-align : middle;text-align:center;">Subsidi MD/ titik</th>
              </tr>

        </thead>
       
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- container-fluid -->
  </div>
  <!-- End Page-content -->

  