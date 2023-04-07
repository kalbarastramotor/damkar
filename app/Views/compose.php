<form action="<?php echo base_url('email/send-email') ?>" class="form-horizontal" id="add_email_form" autocomplete="off" method="post" accept-charset="utf-8">
    <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Recipient Email</label>
        <div class="col-sm-10">
            <input type="hidden" name="id" value="9" id="id" />
            <input type="hidden" name="source_id" value="2" id="source_id" />
            <input type="text" name="email" value="" id="email" placeholder="Recipient Email Address" class="form-control" required />
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Subject</label>
        <div class="col-sm-10">
            <input type="text" name="subject" value="" id="subject" placeholder="Subject" class="form-control" required />
        </div>
    </div>
    <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Message</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="message" id="message"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info">Send Email</button>
        </div>
    </div>
</form>
