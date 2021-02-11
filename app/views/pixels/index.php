<?php
require APPROOT . '/views/inc/header.php';
echo "<h1>{$data['title']}</h1>";
?>

<div class="pixel-container">
    <div class="game-container" id="game-container">
        <div id="">
        </div>
    </div>
</div>
<div class="container">
    <table class="table">
        <thead>
        <tr class="table-primary">
            <th scope="col">Pixel ID</th>
            <th scope="col">Coordinate X</th>
            <th scope="col">Coordinate Y</th>
            <th scope="col">Pixel Color</th>
            <th scope="col">Pixel Size</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>
</div>

<script>
    const gameContainer = document.getElementById('game-container');
    const tableBody = document.getElementById('tableBody');

    addPixel();

    function addPixel(event){
        fetch('<?php echo URLROOT . 'pixels/' . $data['currentMethod']?>', {
            method: 'post',
        }).then(resp => resp.json())
            .then(data => {
                console.log(data);
                console.log("<?php echo $data['currentMethod']?>")
                showAllPixels(data.allPixels);
                showTableInfo(data.allPixels);
            }).catch(error => console.error())
    }

    function showAllPixels(pixels) {
        pixels.forEach((pixel) => {
            console.log(pixel)
            gameContainer.innerHTML +=
                `
                <div id="pixeletron${pixel}" class="pixeletron" style="background-color: ${pixel.color}; width: ${pixel.size}px;
                    height: ${pixel.size}px; bottom: ${pixel.coordinate_y}px; left: ${pixel.coordinate_x}px"></div>
                `

        });
    }

    function showTableInfo(pixels) {
        pixels.forEach((pixel) => {
            tableBody.innerHTML +=
                `
                    <tr>
                        <th scope="row">${pixel.pixel_id}</th>
                        <td>${pixel.coordinate_x}</td>
                        <td>${pixel.coordinate_y}</td>
                        <td>${pixel.color}</td>
                        <td>${pixel.size}px</td>
                        <td>
                            <a class="btn btn-primary" href="<?php echo URLROOT?>addpixel/index/${pixel.pixel_id}">EDIT</a>
                            <a class="btn btn-danger" href="<?php echo URLROOT?>addpixel/index?>">DELETE</a>
                        </td>
                    </tr>
                `

        });
    }
</script>
<?php
require APPROOT . '/views/inc/footer.php';
?>

