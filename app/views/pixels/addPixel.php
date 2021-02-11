<?php require APPROOT . '/views/inc/header.php';
?>

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card card-body bd-light mt-5">
                <?php flash('register_success');?>
                <h2>Add Pixel</h2>
                <form action="" method="post" autocomplete="off" id="addPixelForm">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg"
                               name="x-coordinate" id="x-coordinate" value="<?php echo $data['currentPixel'][0]['coordinate_x'] ?? ''?>" placeholder="X coordinate">
                        <span class="invalid-feedback" id="x-coordinate-err"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg"
                               name="y-coordinate" id="y-coordinate" value="<?php echo $data['currentPixel'][0]['coordinate_y'] ?? ''?>" placeholder="Y coordinate">
                        <span class="invalid-feedback" id="x-coordinate-err"></span>
                    </div>
                    <div class="form-group">
                        <label for="colorSelector">Select color:</label>
                        <select class="form-control" name="colorSelector" id="colorSelector">
                            <option name="pixelColor" value="#2ecc71">Green</option>
                            <option name="pixelColor" value="#3498db">Blue</option>
                            <option name="pixelColor" value="#d35400">Orange</option>
                            <option name="pixelColor" value="#2c3e50">Dark Blue</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pixelSize" class="form-label">Select pixelotron size from 1px to 20px.
                            <span id="pixelInformation">Your pixel size now is 11px</span>
                        </label><br>
                        <input type="range" name="pixelSize" class="form-range w-100" min="1" max="20" id="pixelSize">
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="<?php echo $data['currentPixel'] ? 'Edit Pixel' : 'Create Pixel'?>" class="btn btn-primary btn-block">
                        </div>
                    </div>
                </form>
            </div>
            <p id="generalError"></p>
        </div>
    </div>

    <script>
        const addPixelFormEl = document.getElementById('addPixelForm');
        const xCoordinateEl = document.getElementById('x-coordinate');
        const yCoordinateEl = document.getElementById('y-coordinate');
        const generalErrorEl = document.getElementById('generalError');
        const pixelInformationEl = document.getElementById('pixelInformation');
        const pixelSizeEl = document.getElementById('pixelSize');

        addPixelFormEl.addEventListener('submit', addPixel);
        pixelSizeEl.addEventListener('change', showPixel);

        function addPixel(event){
            event.preventDefault();
            resetErrors();
            const addPixelFormData = new FormData(addPixelFormEl);
            fetch('<?php echo URLROOT . 'addpixel/add'?>', {
                method: 'post',
                body: addPixelFormData
            }).then(resp => resp.json())
                .then(data => {
                    console.log(data)
                    if (data.success){
                        handlePixelSuccess(data);
                    }else {
                        showErrors(data.errors);
                    }
                }).catch(error => console.error())
        }

        function showPixel(){
            pixelInformationEl.innerHTML = ` Your pixel size now is ${pixelSizeEl.value}px`;
        }

        function handlePixelSuccess(data){
            generalErrorEl.innerHTML = data.success;
            xCoordinateEl.value = "";
            yCoordinateEl.value = "";
        }

        function showErrors(errors){
            console.log("veikia errorai");
            if (errors.x){
                xCoordinateEl.classList.add('is-invalid');
                xCoordinateEl.nextElementSibling.innerHTML = errors.x;
            }
            if (errors.y){
                yCoordinateEl.classList.add('is-invalid');
                yCoordinateEl.nextElementSibling.innerHTML = errors.y;
            }
            if (errors.coordinateErr){
                generalErrorEl.innerHTML = errors.coordinateErr;
            }
        }

        function resetErrors(){
            const errorEl = addPixelFormEl.querySelectorAll('.is-invalid');
            errorEl.forEach((element) => {
                element.classList.remove('is-invalid');
            });
            generalErrorEl.innerHTML = "";
        }

    </script>
<?php require APPROOT . '/views/inc/footer.php';