<?php

/**
 * Issue SELECT command through adapter using name based container paramaterization
 */

$adapter = include ((file_exists('bootstrap.php')) ? 'bootstrap.php' : 'bootstrap.dist.php');
refresh_data($adapter);

$artistTable = new Zend\Db\TableGateway\TableGateway('artist', $adapter);
$artistTable->setSelectResultPrototype(
    new Zend\Db\ResultSet\ResultSet(new Zend\Db\RowGateway\RowGateway($artistTable, 'id'))
);

// find and update
$rowset = $artistTable->select(array('id' => 2));
$row = $rowset->current();
$row['name'] = 'New Artist'; // array notation
$affected = $row->save();

// check
$rowset = $artistTable->select(array('id' => 2));
$row = $rowset->current();

assert_example_works($row->name == 'New Artist'); // object notation