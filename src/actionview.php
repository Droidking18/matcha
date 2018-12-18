<?php

function display_list($list, $str) {
	$lists = unserialize($list);
	echo "<table class=\"redTable\">
	<thead>
	<tr>
	<th>$str</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
	<td colspan=\"1\">
	</td>
	</tr>
	</tfoot>
	<tbody>";
	foreach ($lists as $person)
		echo "<tr><td> $person </td></tr>";

echo 	"</tbody>
	</table>
	<a href='me.php'>back</a>";
}
?>

<style>
table.redTable {
  border: 2px solid #A40808;
  background-color: #EEE7DB;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.redTable td, table.redTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.redTable tbody td {
  font-size: 13px;
}
table.redTable tr:nth-child(even) {
  background: #F5C8BF;
}
table.redTable thead {
  background: #A40808;
}
table.redTable thead th {
  font-size: 19px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #A40808;
}
table.redTable thead th:first-child {
  border-left: none;
}

table.redTable tfoot {
  font-size: 13px;
  font-weight: bold;
  color: #FFFFFF;
  background: #A40808;
}
table.redTable tfoot td {
  font-size: 13px;
}
table.redTable tfoot .links {
  text-align: right;
}
table.redTable tfoot .links a{
  display: inline-block;
  background: #FFFFFF;
  color: #A40808;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
<body style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">