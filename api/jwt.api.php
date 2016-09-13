<?php

/*********************************************************************************
* MUST BE CONFIGURED IN /etc/apache2/sites-enabled/apache2.conf FOR URL-REWRITE  *
*********************************************************************************/
header('Content-type: application/json');

DEFINE("DBCONN","test_site.rw.ini");


include_once '../../../resources/DB4/DB4.1.class.php';
require_once '../../../resources/slim2/Slim/Slim.php';
// ** require_once '../php/SlimPHPConsole/PHPConsoleWriter.php';

// FirePHP
//include_once '../../../resources/FirePHPCore/fb.php';
//FB::info("FirePHP loaded.");

// PHP Console fore Chrome
require_once '../../resources/PhpConsole/__autoload.php';
// Call debug from global PC class-helper (most short & easy way)
PhpConsole\Helper::register(); // required to register PC class in global namespace, must be called only once
// Examples of writing to console
// PC::debug('called from PC::debug()', 'db');
// PC::db('called from PC::__callStatic()'); // means "db" will be handled as debug tag


\Slim\Slim::registerAutoloader();

// ** $logwriter = new \Amenadiel\SlimPHPConsole\PHPConsoleWriter(true);

//$app = new \Slim\Slim();
$app = new \Slim\Slim(array(
	'mode'  => 'development',
	'debug' => true,
	'log.enabled' => true,
	'log.level' => \Slim\Log::DEBUG
));


// Example (test) ** $app->log->info('This is just info');

//-------------------------------------------------

$app->get('/getClasses',
	function() use ($app) {
		$cnn = new DB(DBCONN);
		$typ = "qry";  // get, sel, qry
		$sql = "SELECT ClassId, Name FROM Classes";
		$par = array();
		$res = $cnn->query($typ, $sql, $par);
		echo $cnn->formatData($res);
		$cnn = null;
	}
);

$app->get('/getStudents',
	function() use ($app) {
		$cnn = new DB(DBCONN);
		$typ = "qry";  // get, sel, qry
		$sql = "SELECT StudentId, Name, Major, Active FROM Students";
		$par = array();
		$res = $cnn->query($typ, $sql, $par);
		echo json_encode($res);
		$cnn = null;	
	}
);

$app->get('/getStudent/:studentId',
	function($studentId) use ($app) {
		$cnn = new DB(DBCONN);
		$typ = "qry";  // get, sel, qry
		$sql = "SELECT StudentId, Name, Major, Active 
                FROM Students
                WHERE StudentId = ?";
		$par = array($studentId);
		$res = $cnn->query($typ, $sql, $par);
		echo json_encode($res);
		$cnn = null;	
	}
);
//--------------------------------------------
$app->get('/getBooks',
	function() use ($app) {
		$jwt = $app->request->params('jwt');
		PC::debug('called from PC::debug()', 'db');
		$cnn = new DB(DBCONN);
		$typ = "qry";  // get, sel, qry
		$sql = "SELECT BookId, Title, Author, PageCount FROM Books";
		$par = array();
		$res = $cnn->query($typ, $sql, $par);
		echo $cnn->formatData($res);
		//echo $jwt;
		$cnn = null;	
	}
);
//---------------------------------------------
$app->get('/getBooks-p',
	function() use ($app) {
		$callback = isset($_GET["callback"]) ? $_GET["callback"] : NULL ;
		$cnn = new DB(DBCONN);
		$typ = "qry";  // get, sel, qry
		$sql = "SELECT BookId, Title, Author, PageCount FROM Books";
		$par = array();
		$res = $cnn->query($typ, $sql, $par);
		$res = json_encode($res);
		echo $callback."(".$res.")";
		$cnn = null;	
	}
);


$app->get('/getBook/:bookId',
	function($bookId) use ($app) {
        //FB::Info("Testing...");
		$cnn = new DB(DBCONN);
		$typ = "sel";  // use sel and qry only for Angular, get returns value inside quotes
		$sql = "SELECT BookId, Title, Author, PageCount 
                FROM Books
                WHERE BookId = ?";
		$par = array($bookId);
		$res = $cnn->query($typ, $sql, $par);
		echo json_encode($res);
		$cnn = null;	
	}
);

$app->put('/updateBook/:bookId',
	function($bookId) use ($app) {
        //$form = json_decode($app->request->getBody());  
        $form = json_decode($app->request->getBody());  
        PC::debug($form, 'form.decode');
        $title = $form->title;
        $author = $form->author;
        PC::debug($title, 'form.title');
        PC::debug($author, 'form.author');
		$cnn = new DB(DBCONN);
		$sql = "UPDATE Books SET Title = ?, Author = ?
                WHERE BookId = ?";
		$par = array($title, $author, $bookId);
		$res = $cnn->update($sql, $par);
		echo json_encode($res);
		$cnn = null;	
	}
);


/*
$app->post('/save',
	function() use ($app) {
		$conn = new DB4(DBCONN);
		$form = $app->request->post();  // array
		$sql = "INSERT INTO tblTest
					(field1, field2, field3, field4, field5)
				VALUES 
					(?,?,?,?,?)";
		$par = array($form["input1"], $form["input2"], $form["input3"], $form["input4"], $form["input5"]);
		$res = $conn->insert($sql, $par);
		echo $res;
		$conn = null;
	}
);

$app->put('/update',
	function() use ($app) {
		$conn = new DB4(DBCONN);
		$form = $app->request->put();
		$sql = "UPDATE tblTest SET input1 = ? WHERE id = ?";
		$par = array($form["input1"], $form["id"]);
		$res = $conn->update($sql, $par);
		echo $res;
		$conn = null;
	}
);

$app->delete('/delete',
	function() {
		$conn = new DB4(DBCONN);
		$sql = "DELETE FROM tblTest WHERE id > 1";
		$par = array();
		$res = $conn->delete($sql, $par);
		echo $res;
		$conn = null;
	}
);
*/

$app->run();
