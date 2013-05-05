<?php

$queries = array();
$queries['TABLE_STATS'] = <<<EOQ

    SELECT
      rows_fetched,
      fetch_latency,
      rows_inserted,
      insert_latency,
      rows_updated,
      update_latency,
      rows_deleted,
      delete_latency,
      innodb_buffer_pages
    FROM
      ps_helper.schema_table_statistics
    WHERE
      table_schema = ? AND table_name = ?

EOQ;


	$a = 'slack_main';
	$b = 'users';

	$db = mysqli_connect('localhost', 'root', 'whatitis', 'mysql');
	if (!$db){
		$error = mysqli_connect_error();
		$errno = mysqli_connect_errno();
		print "$errno: $error\n";
		exit();
	}

echo $queries['TABLE_STATS'];

	$q = mysqli_stmt_init($db);
	print_r($q);

	$ok = mysqli_stmt_prepare($q, $queries['TABLE_STATS']);
	if (!$ok){
		$error = mysqli_connect_error();
		$errno = mysqli_connect_errno();
		print "$errno: $error\n";
		die("failed prepare\n");
	}
	mysqli_stmt_bind_param($q, 'ss', $a, $b);
	mysqli_stmt_execute($q);
	$result = mysqli_stmt_get_result($q);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);

	print_r($row);

