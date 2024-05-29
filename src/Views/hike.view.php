
<h2> <?= $hike['name'] ?> </h2>
<p> <?= $hike['description'] ?></p>
<p> <?= $hike['distance'] ?></p>
<p> <?= $hike['duration'] ?></p>
<p> <?= $hike['elevation_gain'] ?></p>
<p> <?= $hike['created_at'] ?></p>
<p> <?= $hike['updated_at'] ?></p>

<p>Tags:</p>
<ul>
    <?php foreach ($tags as $tag): ?>
        <li><?= $tag['name'] ?></li>
    <?php endforeach; ?>
</ul>
<form method="POST" action="/hike/deleteHike/<?php echo $hike['id']; ?>" onsubmit="return confirm('Are you sure you want to delete this hike?');">
    <input type="hidden" name="id" value="<?php echo $hike['id']; ?>">
    <button type="submit">Delete Hike</button>
</form>