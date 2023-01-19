<div class="modal fade" id="trackModal" tabindex="-1" role="dialog" aria-labelledby="trackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="trackModalLabel">Track Devices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <label for="from">Start Date & Time</label>
                        <input type="datetime-local" id="from" name="from" class="form-control w-100">
                    </div>
                    <div class="col-md-6">
                        <label for="to">End Date & TIme</label>
                        <input type="datetime-local" id="to" name="to" class="form-control w-100">
                    </div>
                    <div class="col-md-12 mt-2 mb-2">
                       <button onclick="filterNow()" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
                <div id="map" style="width: 100%; height: 500px;"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
