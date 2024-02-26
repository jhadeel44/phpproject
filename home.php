<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        body{
    background-color: whitesmoke;
}
#mother{
    width: 100%;
    font-size: 20px;
}
main{
    float: left;
    border: 1px solid gray;
    padding: 5px;
}
input{
    padding: 4px;
    border:2px solid black;
    text-align:center;
    font-size:17px;
}
aside{
    text-align:center;
    width: 300px;
    float:right;
    border:1px solid black;
    padding: 10px;
    font-size:20px;
    background-color:silver;
    color:white;
}
#tbl{
    width: 890px;
    font-size: 20px;
    text-align: center;
}

th,td{
    border: 1px solid #000;
}
#tbl th{
    background-color:silver;
    color: #000;
    font-size:20px;
    padding: 10px;
    text-align: center;
}
aside button{
    width: 190px;
    padding:8px;
    margin-top:20px;
    font-size:17px;
    font-weight:bold;
}
        </style>
</head>
<body dir='rtl'>
    <?php
    $host='localhost';
    $user='root';
    $pass='';
    $db='students';
    $con=mysqli_connect($host,$user,$pass,$db);
    $res= mysqli_query($con,"select * from student");
    #button variable --
    $id= '';
    $name='';
    $address='';
    if(isset($_POST['id'])){
        $id= $_POST['id'];
    }
    if(isset($_POST['name'])){
        $name = $_POST['name'];
    }
    if(isset($_POST['address'])){
        $address= $_POST['address'];
    }
    $sqls='';
    if(isset($_POST['add'])){
        $sqls= "insert into student value($id,'$name','$address')";
        mysqli_query($con,$sqls);
        header("location: home.php");
    }
    if (isset($_POST['del'])) {
        $id = $_POST['id']; 
        $sqls = "DELETE FROM student WHERE id = $id";
        mysqli_query($con, $sqls);
        header("location: home.php");
    }
    if (isset($_POST['updata'])) {
        $id = $_POST['id']; 
        $name=$_POST['name'];
        $address=$_POST['address'];
        $sqls = "UPDATE student SET name = '$name', address = '$address' WHERE id = $id";
        $stmt = $con->prepare("UPDATE student SET name = ?, address = ? WHERE id = ?");
$stmt->bind_param("ssi", $name, $address, $id);
$stmt->execute();
        $x=mysqli_query($con, $sqls);
        header("location: home.php");
    }
    if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT * FROM `student` 
    WHERE CONCAT(`id`, `name`,  `address`)
     LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `student`";
    $search_result = filterTable($query);
}
function filterTable($query)
{
    $con = mysqli_connect("localhost","root","","students");
    $filter_res = mysqli_query($con, $query);
    return $filter_res;
}
    ?>
    <div id='mother'>
<form  method='POST' action="home.php">
<aside>
    <div id='div'>
        <img src='img/j.jpg' alt='' width="100">
        <h3>لوحه المدير</h3>
        <label >رقم الطالب:</label><br>
        <input type='text' name='id' id='id'><br>
        <label >اسم الطالب:</label><br>
        <input type='text' name='name' id='name'><br>
        <label >عنوان الطالب:</label><br>
        <input type='text' name='address' id='address'><br>
        <label > بحث الطالب:</label>
        <input type="text" name="valueToSearch" id="Value To Search"><br><br>   
        <button name='add'> اضافه طالب</button>
        <button name='del'> حذف الطالب</button>
        <button name='updata'> تعديل البيانات</button>
        <button name='search'>بحث</button>
    </div>
</aside>
<main>
    <table id='tbl'>
        <tr>
            <th> الرقم التسلسلي</th>
            <th> اسم الطالب</th>
            <th> عنوان الطالب</th>
        </tr>
        <?php
        while ( $row = mysqli_fetch_array($search_result)){
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['address']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</main>
</form>
    </div>
</body>
</html>