<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<div class="row ">
    <div class="col-sm-12 fl-center"> <b><center><u>RECEIPT</u>  <center></b></div>
    <div class="col-sm-12 fl-center"><b><center><u>APPELLATE TRIBUNAL FOR ELECTRICITY</u> <center> </b> </div>
    <div class="col-sm-12"><center>Core 4,7th Floor,SCOPE Builiding,Lodhi Road,New Delhi-110003</center></div>
</div>

<table>
  <tr>
    <th>Appellant Name</th>
    <th>Respondent Name</th>
    <th>Bank Transaction Id</th>
    <th>Payment Date</th>
    <th>Status</th>
    <th>Total Amount</th>
  </tr>
  <tr>
    <td><?php echo "Delhi Electricity Regulatory Commission"; ?></td>
    <td><?php echo "Delhi Electricity Regulatory Commission"; ?></td>
    <td><?php echo $refId; ?></td>
    <td><?php echo $bankTransacstionDate; ?></td>
    <td><?php echo $status; ?></td>
    <td><?php echo $totalAmount; ?></td>
  </tr>
</table>
</body>
</html>
