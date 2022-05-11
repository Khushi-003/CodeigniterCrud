<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIgniter Pagination Example with Search Query Filter</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <style type="text/css">
        .bg-border {
            border: 1px solid #ddd;
            border-radius: 4px 4px;
            padding: 15px 15px;
        }

        a.dropdown-item {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-20 col-md-offset-0.5 well">
                <?php
                $attr = array("class" => "form-horizontal", "role" => "form", "id" => "form1", "name" => "form1");
                echo form_open("HomeController/search", $attr); ?>
                <div class="form-group">
                    <div class="col-md-6">
                        <input class="form-control" id="fname" name="fname" placeholder="Search for first Name..." type="text" value="<?php echo set_value('fname'); ?>" />
                    </div>
                    <div class="col-md-6">
                        <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Search" />
                        <a href="<?php echo base_url() . "index.php/HomeController/index"; ?>" class="btn btn-primary">Show All</a>
                        <a id="addbtn" href="<?php echo base_url() . "index.php/HomeController/index2"; ?>" class="btn btn-warning">Add</a>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-20 col-md-offset-0.5 bg-border">
                <table class="table table-striped table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>
                                <span style="display: flex;">
                                    id <a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/asc'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/desc'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    FirstName<a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/ascfname'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/descfname'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    LastName<a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/asclname'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/desclname'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    Phone <a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/ascphone'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/descphone'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    Email <a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/ascemail'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/descemail'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    DOB <a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/ascdob'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/descdob'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    Country<a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/asccountry'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/desccountry'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    State <a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/ascstate'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/descstate'); ?>">🔽</a>
                                </span>
                            </th>
                            <th><span style="display: flex;">
                                    City <a class="dropdown-item asc" href="<?php echo base_url('index.php/HomeController/asccity'); ?>">🔼</a>
                                    <a class="dropdown-item desc" href="<?php echo base_url('index.php/HomeController/desccity'); ?>">🔽</a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($profileList); ++$i) { ?>
                            <tr>
                                <td>
                                    <!-- <center> -->
                                    <a id="editbtn" href="<?php echo site_url('HomeController/edit/' . $profileList[$i]->ID); ?>" class="btn btn-info btn-sm editbtn"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <a id="delbtn" href="<?php echo site_url('HomeController/delete/' . $profileList[$i]->ID); ?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
                                    <!-- </center> -->
                                </td>
                                <!-- <?php var_dump($profileList[$i]) ?> -->
                                <td><?php echo $profileList[$i]->ID; ?></td>
                                <td><?php echo $profileList[$i]->Fname; ?></td>
                                <td><?php echo $profileList[$i]->Lname; ?></td>
                                <td><?php echo $profileList[$i]->Phone; ?></td>
                                <td><?php echo $profileList[$i]->Email; ?></td>
                                <td><?php echo $profileList[$i]->DOB; ?></td>
                                <td><?php echo $profileList[$i]->country_name->country_name; ?></td>
                                <td><?php echo $profileList[$i]->state_name->state_name; ?></td>
                                <td><?php echo $profileList[$i]->city_name->city_name; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
</body>

<script>
    document.querySelector('#addbtn').addEventListener('click', () => {
        console.log('Clicked')
        localStorage.setItem('add', 0)
    })
    var checkboxes = document.querySelectorAll('.editbtn');
    for (var i = 0, element; element = checkboxes[i]; i++) {
        console.log('Clicked')
        localStorage.setItem('edit', 0)
    }
</script>

</html>