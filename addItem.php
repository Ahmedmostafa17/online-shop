<?php
session_start();
$pageTitle = 'Create New Item';
require_once 'init.php';
if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] = 'POST') {

        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $Description = filter_var($_POST['Description'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $Country = filter_var($_POST['country_made'], FILTER_SANITIZE_STRING);
        $Status = filter_var($_POST['statue'], FILTER_SANITIZE_STRING);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
        $tags = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imagetemp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        // file types
        $imageAllowExtention = array("jpeg", "jpg", "png", "gif");

        $tmp = explode('.', $imageName);
        $imageExtention = strtolower(end($tmp));
        //Validation 
        $formError = array();
        if (empty($name)) {
            $formError[] = 'please full the Item Name ';
        }
        if (strlen($name) < 4) {
            $formError[] = 'please full Item Name  more than 4 character';
        }
        if (empty($Description)) {
            $formError[] = 'please enter the Description  ';
        }
        if (strlen($Description) < 15) {
            $formError[] = 'please full Description more than 15 character';
        }

        if (empty($price)) {
            $formError[] = 'please Enter Price ';
        }
        if (empty($Country)) {
            $formError[] = 'please Enter  the Country Made  ';
        }
        if ($Status == 0) {
            $formError[] = 'You Must Choose The Status ';
        }


        if ($category == 0) {
            $formError[] = 'You Must Choose The Category ';
        }
        if (!in_array($imageExtention, $imageAllowExtention)) {
            $formError[] = 'This Extention is not <strong> Allowed</strong> ';
        }
        if (empty($imageName)) {
            $formError[] = 'Image is required</strong> ';
        }
        if ($imageSize > (4 * 1024 * 1024)) {
            $formError[] = 'Max size is 4 MB</strong> ';
        }
        // foreach ($formError as $error) {
        //     echo '<div class="alert alert-danger">' . $error .
        //         '</div>';
        // }

        if (empty($formError)) {

            $image = rand(0, 10000000) . '_' . $imageName;
            move_uploaded_file($imagetemp, "admin\uploads\items\\" . $image);

            //insert userinfo in database

            $stmt = $conn->prepare("INSERT INTO 
                items(`Name`,`Description`,Price,Country_Made,`Status`,Add_Date ,Category_ID,Member_ID,tags,`image`)
                VALUES(:name, :desc, :price, :country,:status, now(),:category ,:member,:tags ,:imge)");
            $stmt->execute(array(
                'name' => $name, 'desc' => $Description, 'price' => $price, 'country' => $Country, 'status' => $Status,
                'category' => $category, 'member' => $_SESSION['userID'], 'tags' => $tags, 'imge' => $image
            ));

            echo '<div class="container">';
            //echo success message
            $msg = '<div class="alert alert-success">' . $stmt->rowCount() .
                'Record Add</div>';
            redirectHome($msg, 'back', 1);
            echo '</div>';
        }
    } else {

        echo '<div class="container mt-3">';
        $Msg = "<div class='alert alert-danger'>sorry you can not Browes this page Directily</div>";
        redirectHome($Msg, 1);
        echo '</div>';
    }

?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-3">


            <h1 class="text-center mt-1"> Create New Item </h1>


            <div class="crad adding">
                <div class="card-header"> Adding New Item </div>
                <div class="card-body  ">
                    <div class="row">
                        <div class="col md-6 adding_item">
                            <form class="" action="<?PHP $_SERVER['PHP_SELF'] ?>" method='POST'
                                enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> Name:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control live " name="name" id="name"
                                            autocomplete='off' placeholder="Name of the Item" data-class='.live-name'
                                            required pattern=".{4,}" title="This Field require At least 4 Characters">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> Description:</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control live " name="Description" id="Description"
                                            autocomplete='off' placeholder="Fll the Description Field" rows="3"
                                            data-class='.live-des' required pattern=".{4,}"
                                            title="This Field require At least 15 Characters"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> Price:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control live " name="price" id="price"
                                            autocomplete='off' placeholder="Fll the Price Field"
                                            data-class='.live-price' required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> Country Made:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control  " name="country_made" id="country_made"
                                            autocomplete='off' placeholder="Fll the country Field" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> Status:</label>
                                    <div class="col-sm-10">
                                        <select class=" form-control" name="statue" required>
                                            <option value="">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Copy</option>
                                            <option value="4">Old</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> categories:</label>
                                    <div class="col-sm-10">
                                        <select class=" form-control" name="category" required>
                                            <option value="">...</option>
                                            <?php
                                                $stmt2 = $conn->prepare("SELECT * FROM categories");
                                                $stmt2->execute();
                                                $cats = $stmt2->fetchAll();

                                                foreach ($cats as $cat) {
                                                    echo "<option value= " . $cat['CateID'] . ">" . $cat['Name'] . "</option>";

                                                    /**child */
                                                    $stmt2 = $conn->prepare("SELECT * FROM categories WHERE parent= ?");
                                                    $stmt2->execute(array($cat['CateID']));
                                                    $childs = $stmt2->fetchAll();
                                                    foreach ($childs as $child) {
                                                        echo "<option value= " . $child['CateID'] . ">----" . $child['Name'] . "</option>";
                                                    }
                                                }


                                                ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> Tage:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control  " name="tags" id="tags"
                                            autocomplete='off' placeholder="Seperate tage with comman (,)" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail1"> image:</label>
                                    <div class="col-sm-10">
                                        <input type="file" name=" image" id="image" autocomplete='off' required>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-info w-100 mt-1 ml-5">Add Items</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- 
                <div class="col-md-4 adding-info">

                    <div class="thumbnail items live-preview">
                        <span class=" price">$

                            <span class="live-price"></span>
                        </span>
                        <img src="img.jpg" alt="" />
                        <div class="caption text-center">
                            <h3 class="live-name">Name</h3>
                            <p class="live-des">Description</p>
                        </div>
                    </div>
                </div> -->
                    </div>

                </div>
                <?php
                    if (empty($formError)) {

                        foreach ($formError as $error) {
                            echo '<div class="alert alert-danger">' . $error .
                                '</div>';
                        }
                    }

                    ?>

            </div>


        </div>
    </div>


</div>


<?php } else {
    header('loation:login.php');
    exit();
}
?>
<?php require_once $temp . 'footer.php';
?>