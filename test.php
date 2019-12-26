<?php


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head></head>
<body>
</body>

<script type="text/javascript">


//var data = '{"Result":[{"invoice_id":"1","quotation_number":"168","date":"2017-05-18","value":"200.00","created_date":"2017-05-24 00:00:00","created_by":"","status_id":"1","value_paid":"0.00"}]}';
var data = '{"invoice_id":"1","quotation_number":"168","date":"2017-05-18","value":"200.00","created_date":"2017-05-24 00:00:00","created_by":"","status_id":"1","value_paid":"0.00"}';
var obj = JSON.parse(data);

alert(obj.date);

</script>


</html>