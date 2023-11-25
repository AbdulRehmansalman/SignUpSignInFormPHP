<?php
//FIRST WE CREATE SOME VARIABLES
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='signup';

// SECOND STEP IS TO CREATE A VARIABLE THAT CONNECTS DATABASE

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
if($con){
?>
<script>
    alert("DB connection Succesful");
</script>
<?php
}
?>