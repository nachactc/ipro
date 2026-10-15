 
<!-- /.popup -->
<div class="modal fade" id="tedialog" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        </button>
        <h4 class="modal-title">
          Data Invoice
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="form" class="form-horizontal">
          <div class="row">
            <div class="col-md-8">
              <label>Search Agreement/ BO/ Invoice ID</label>
              <input  type="text" id="searchloo" class="form-control input-sm" placeholder="Search ..." >
            </div>
            <div class="col-md-4" align="right">
              <br>
              <input type="button" id="btnrek" value = "LOAD" class="btn btn-sm btn-info"/>
            </div>
          </div>
          <div class="portlet-body">
            <div class="table-container">
              <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                  <thead>
                    <tr>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width: 45px;">#</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">No.Invoice</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trade Name</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Invoice Amount</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Schedule Payment ID</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Schedule Payment Line</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement Type</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement ID</th>
                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Schedule Payment Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <br />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn green" data-dismiss="modal" id="addData">
          Add Selected Data
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
