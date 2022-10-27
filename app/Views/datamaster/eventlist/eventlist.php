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
                            <table id="eventlist-table" class="table table-striped mb-0"></table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


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
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Start Date Event</label>
                                    <input type="datetime-local" class="form-control" id="eventlist-start-date-add" required>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label" for="validationCustom02">End Date Event</label>
                                <input type="datetime-local" class="form-control" id="eventlist-end-date-add" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Event Name</label>
                                    <input type="text" class="form-control" id="eventlist-name-add" placeholder="Input Event Name" onkeyup="validateEventlistNameAdd(this.eventid)" required>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label" for="validationCustom02">Event Category</label>
                                <select class="form-control" id="eventlist-categoryid-add" onkeyup="validateEventlistCategoryAdd(this.eventid)" required>
                                    <option value="">Please Select Category</option>
                                    <option value="0">Exibition</option>
                                    <option value="1">Roadshow</option>
                                    <option value="2">Showroom</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Map Latitute</label>
                                    <input type="text" class="form-control" id="eventlist-location-lat-add" placeholder="-6.1754228" required>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label" for="validationCustom02">Map Longtitute</label>
                                <input type="text" class="form-control" id="eventlist-location-long-add" placeholder="106.8215195" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Month</label>
                                    <input type="number" class="form-control" id="eventlist-month-add" min="0" max="12" placeholder="01" required>
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label" for="validationCustom02">Years</label>
                                <input type="number" class="form-control" id="eventlist-year-add" min="2000" max="2040" placeholder="2022" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Target Visitor</label>
                                    <input type="number" class="form-control" id="eventlist-target-visitor-add" min="0" max="1000" placeholder="Input Target Visitor" required />
                                </div>
                            </div>
                            <div class="col">
                                <label class="form-label" for="validationCustom02">Target Sell</label>
                                <input type="number" class="form-control" id="eventlist-target-sell-add" min="0" max="1000" placeholder="Input Target Sell" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Budget Event</label>
                                    <input type="number" class="form-control" id="eventlist-butget-add" placeholder="Input Budget Event" />
                                </div>
                            </div>
                            <div class="col custom-file">
                                <label class="custom-file-label" for="validationCustom02">Cover Event</label>
                                <input type="file" class="custom-file-input" id="eventlist-cover-add" accept="image/png, image/jpeg" max-size="200">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Event Description</label>
                                    <textarea name="w3review" rows="4" cols="74" id="eventlist-description-add" placeholder="Please Descrip your event"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="button-add-eventlist" class="btn btn-primary waves-effect waves-light">
                        Save
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="myModal_edit" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Menu Kategoru</h5>
                    <button type="button" class="btn-close close-form-edit" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Name Menu Kategory</label>
                                    <input type="text" class="form-control" id="eventcategory-name-edit" onkeyup="validateEventcategoryNameEdit(this.id)" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom02">Kategory Code</label>
                                    <input type="text" class="form-control" id="eventcategory-code-edit" onkeyup="validateEventcategoryNameEdit(this.id)" required />
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="button-edit-eventcategory" class="btn btn-primary waves-effect waves-light">
                        Update
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>