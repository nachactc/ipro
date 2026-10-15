<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.button1 {
  background-color: white;
  color: white;
   border: 0px;
  /* Green */
}
</style>
</head>

<body>
<?php echo form_open(base_url('index.php/schedule_payment/schedule_payment/previewsoppdf'),'name="form1" '); ?>

<input type="hidden" value="<?php echo $schedule_id;?>" name="schedule_id"  />
<input type="submit" id="btn" value="PREVIEW" name="button" class="button1"  />
</form>
<script>
  document.getElementById('btn').click();

</script>
</body>
</html>