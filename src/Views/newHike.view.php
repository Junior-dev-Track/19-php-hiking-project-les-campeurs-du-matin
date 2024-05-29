<?php   $user_id = isset($_SESSION['user']['sess_id']) ? $_SESSION['user']['sess_id'] : null;
?>
<form action="/hike/addHike/<?php echo $user_id; ?>" method="post">
    <label for="name">Hike Name:</label><br>
    <input type="text" id="name" name="name"><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description"></textarea><br>
    <label for="distance">Distance:</label><br>
    <input type="number" id="distance" name="distance" step="0.01"><br>
    <label for="duration">Duration:</label><br>
    <input type="number" id="duration" name="duration"><br>
    <label for="elevation_gain">Elevation Gain:</label><br>
    <input type="number" id="elevation_gain" name="elevation_gain"><br>
    <input type="submit" value="Add Hike">
</form>
