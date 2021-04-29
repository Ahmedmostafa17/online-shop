<?php

function getTitle()
{
    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {

        echo ' Defulte';
    }
}
// redirect fnction 
// v.1

// function redirectHome($errorMsg ,$second = 3)

// {
// echo "<div class='alert alert-danger'>$errorMsg</div>";

// echo "<div class='alert alert-info'>You Redirect to HomePage After $second</div>";

// header("refresh:$second;url=dashbored.php");
// exit();

// }

// redirect fnction 
// v.2

function redirectHome($msg, $url = null, $second = 2)

{
    if ($url == null) {
        $url = 'dashbored.php';
        $link = 'Home Page';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ' ') {

            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previoud Page';
        } else {
            $url = 'dashbored.php';
            $link = 'Home Page';
        }
    }
    echo $msg;
    echo "<div class='alert alert-info'>You Redirect to  $link After $second</div>";
    header("refresh:$second;url=$url");
    exit();
}

// select the user if he exist or not
function checkItem($select, $user, $value)
{
    global $conn;
    $statment = $conn->prepare("SELECT $select FROM $user WHERE $select=? ");
    $statment->execute(array($value));
    $conect = $statment->rowCount();
    return $conect;
}
function getCats($select, $user, $value)
{
    global $conn;
    $statment = $conn->prepare("SELECT $select FROM $user WHERE $select=? ");
    $statment->execute(array($value));
    $cats = $statment->fetchAll();
    return $cats;
}

// count the number of items

function contItem($item, $table)
{

    global $conn;
    $stat = $conn->prepare("SELECT COUNT($item) FROM $table ");
    $stat->execute();
    return $stat->fetchColumn();
}
function CountMember($item, $table)
{

    global $conn;
    $stat = $conn->prepare("SELECT COUNT($item) FROM $table WHERE GroupID =0 ");
    $stat->execute();
    return $stat->fetchColumn();
}
// get pending members

function contPendingItem($item, $table)
{

    global $conn;
    $stat = $conn->prepare("SELECT COUNT($item) FROM $table WHERE RegStatus = 0");
    $stat->execute();
    return $stat->fetchColumn();
}


// get latest members
function latestItem($select, $table, $order, $LIMI = 5)
{
    global $conn;

    $statment = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT  $LIMI");
    $statment->execute();
    $row = $statment->fetchAll();
    return $row;
}

function latestMember($select, $table, $order, $LIMI = 5)
{
    global $conn;

    $statment = $conn->prepare("SELECT $select FROM $table  WHERE GroupID = 0  ORDER BY $order DESC LIMIT  $LIMI  ");
    $statment->execute();
    $row = $statment->fetchAll();
    return $row;
}
