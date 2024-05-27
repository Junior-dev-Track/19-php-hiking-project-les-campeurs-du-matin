
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