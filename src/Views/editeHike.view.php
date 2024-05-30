
<form method="POST" action="/hike/updateHike/<?php echo $hike['id']; ?>">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo $hike['name']; ?>"><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description"><?php echo $hike['description']; ?></textarea><br>
    <label for="distance">Distance:</label><br>
    <input type="number" id="distance" name="distance" step="0.01" value="<?php echo $hike['distance']; ?>"><br>
    <label for="duration">Duration:</label><br>
    <input type="number" id="duration" name="duration" value="<?php echo $hike['duration']; ?>"><br>
    <label for="elevation_gain">Elevation Gain:</label><br>
    <input type="number" id="elevation_gain" name="elevation_gain" value="<?php echo $hike['elevation_gain']; ?>"><br>

    <button type="submit">Save Changes</button>
</form>

