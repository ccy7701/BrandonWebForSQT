<?PHP
include('config.php');

//start session
session_start();

//this action called when Delete link is clicked
if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = $_GET["id"];
    $sql = "DELETE FROM challenge WHERE ch_id=" . $id . " AND userID=" . $_SESSION["UID"];
    //echo $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully<br>";
    echo '<a href="my_challenge.php">Back</a>';
    } else {
    echo "Error deleting record: " . mysqli_error($conn) . "<br>";
    echo '<a href="my_challenge.php">Back</a>';
    }
}
mysqli_close($conn);
?>
