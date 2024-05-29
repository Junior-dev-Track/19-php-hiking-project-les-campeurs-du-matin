<h2>List of hikes</h2>

<?php if (!empty($hikes)): ?>
    <ul>
        <?php foreach($hikes as $hike): ?>
            
            <li>
                <a href="hikes/<?= $hike['id'] ?>">
                    <?= $hike['name'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="/hike/newHike" class="add-hike-button">Add New Hike</a>
<?php endif; ?>