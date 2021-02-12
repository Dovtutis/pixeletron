<?php require APPROOT . '/views/inc/header.php';
?>

    <div class="container">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Time</th>
                    <th scope="col">Action</th>
                    <th scope="col">Pixel ID</th>
                    <th scope="col">Coordinate X</th>
                    <th scope="col">Coordinate Y</th>
                    <th scope="col">Color</th>
                    <th scope="col">Size</th>
                </tr>
                </thead>
                <tbody>
        <?php foreach ($data['activityLog'] as $activity) :?>
                <tr>
                    <th scope="row"><?php echo $activity['timestamp']?></th>
                    <td><?php echo $activity['action']?></td>
                    <td><?php echo $activity['pixel_id']?></td>
                    <td><?php echo $activity['coordinate_x']?></td>
                    <td><?php echo $activity['coordinate_y']?></td>
                    <td><?php echo $activity['color']?></td>
                    <td><?php echo $activity['size']?></td>
                </tr>
        <?php endforeach;?>
                </tbody>
            </table>
    </div>

<?php require APPROOT . '/views/inc/footer.php';