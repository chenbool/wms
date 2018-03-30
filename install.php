<?php 

if( isset($_POST['host']) ){
	//读取文件内容
	$_sql = file_get_contents('wms.sql');
	$_arr = explode(';', $_sql);

	$_mysqli = new mysqli($_POST['host'],$_POST['username'],$_POST['password']);
	if (mysqli_connect_errno()) {
	  exit('连接数据库出错');
	}

	//创建数据库
	$_mysqli->query('CREATE DATABASE `'.$_POST['db'].'` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;');
	$_mysqli->query('USE `'.$_POST['db'].'`;');

	//执行sql语句
	foreach ($_arr as $_value) {
	  $_mysqli->query($_value.';');
	}
	$_mysqli->close();
	$_mysqli = null;

	//替换 模板
	$_conf = file_get_contents('./app/config.php');
	$dirRoot = dirname($_SERVER['SCRIPT_NAME']);
	if( $dirRoot == '\\' && $dirRoot == "/" ){
		file_put_contents('./app/config.php',str_replace('dirname($_SERVER[\'SCRIPT_NAME\']).','',$_conf));
	}
	
	//替换数据库
	$_dbConfig	= include './app/database.php';
	$_dbConfig['hostname'] = $_POST['host'];
	$_dbConfig['database'] = $_POST['db'];
	$_dbConfig['username'] = $_POST['username'];
	$_dbConfig['password'] = $_POST['password'];
	file_put_contents('./app/database.php','<?php return '.var_export($_dbConfig,true).';' );


	die( '<center style="margin-top:150px;padding:15px;">
		<h1>安装成功</h1>
		<a href="http://'.$_POST['host'].$_POST['dir'].'/index.php">立即访问</a>
	<center>' );
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>安装</title>
</head>
<body>
<center style="margin-top:150px;">
	<h1>安装</h1>
<hr>
<form action="" method="post">
	<table>	
		<tr>
			<td>数据库</td>
			<td><input type="text" value="localhost" name="host"></td>
		</tr>
		<tr>
			<td>账户</td>
			<td><input type="text" value="root" name="username"></td>
		</tr>
		<tr>
			<td>密码</td>
			<td><input type="password" value="root" name="password"></td>
		</tr>
		<tr>
			<td>数据库</td>
			<td><input type="text" value="db" name="db"></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<input type="submit" value="安装">
			</td>
		</tr>
<!-- 		<tr>
			<td>管理员账户</td>
			<td><input type="text" value="admin"></td>
		</tr>
		<tr>
			<td>管理员密码</td>
			<td><input type="password" value="admin"></td>
		</tr> -->
	</table>
</form>
<hr>	
</center>
</body>
</html>
