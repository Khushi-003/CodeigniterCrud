<html>

<head>
    <title>My Form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        * {
            box-sizing: border-box;
        }

        input[type=text],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .col-25 {
            float: left;
            width: 25%;
            margin-top: 6px;
        }

        .col-75 {
            float: left;
            width: 75%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {

            .col-25,
            .col-75,
            input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div style="margin-top: 2rem;">
        <center>
            <p>CRUD</p>
        </center><br>
        <form action="" method="post" id="ajax_form">
            <div class="container">

                <div class="row">
                    <div class="col-25">
                        <label for="fname"> First Name</label>
                    </div>
                    <div class="col-25">
                        <input type="text" id="fname" name="fname" placeholder="first name.." required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> Last Name</label>
                    </div>
                    <div class="col-25">
                        <input type="text" id="lname" name="lname" placeholder="last name.." required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="phone">Phone No</label>
                    </div>
                    <div class="col-25">
                        <input type="text" id="phone" name="phone" placeholder="Your number.." required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-25">
                        <input type="email" id="email" name="email" placeholder="Your email.." required>

                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="dob">DOB</label>
                    </div>
                    <div class="col-25">
                        <input type="date" id="dob" name="dob" placeholder="DOB.." max="2014-05-20" required></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="country">Country</label>
                    </div>
                    <div class="col-25">
                        <select name="country" id="country" class="form-control input-lg">
                            <option value="">Select Country</option>
                            <?php
                            foreach ($country as $row) {
                                echo '<option value="' . $row->country_id . '">' . $row->country_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="state">State</label>
                    </div>
                    <div class="col-25">
                        <select name="state" id="state" class="form-control input-lg">
                            <option value="">Select State</option>
                        </select>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-25">
                        <label for="city">City</label>
                    </div>
                    <div class="col-25">
                        <select name="city" id="city" class="form-control input-lg">
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
                <div class="alert alert-success d-none" id="msg_div">
                    <span id="res_message"></span>
                </div>
                <div class="row">
                    <input type="submit" name="submit" id="submit" value="Submit">&#160;&#160;&#160;&#160;
                    <a type="button" class="btn btn-primary" href="<?php echo base_url('index.php/HomeController/index'); ?>">Show Grid</a>
                </div>
                <br>
            </div>
        </form>
    </div>
</body>
<script>
    $("#country").select2({
        tags: true
    });
    $("#state").select2({
        tags: true
    });
    $("#city").select2({
        tags: true
    });
    $(document).ready(function() {
        $('#country').change(function() {
            var country_id = $('#country').val();
            if (country_id != '') {
                $.ajax({
                    url: "http://localhost/try/index.php/tryController/fetchstate",
                    method: "POST",
                    data: {
                        country_id: country_id,
                    },
                    success: function(data) {
                        console.log('data :', data);
                        $('#state').html(data);
                        $('#city').html('<option value="">Select City</option>');
                    }
                })
            } else {
                $('#state').html('<option value="">Select State</option>');
                $('#city').html('<option value="">Select City</option>');
            }
        });

        $('#state').change(function() {
            var state_id = $('#state').val();
            if (state_id != '') {
                $.ajax({
                    url: "http://localhost/try/index.php/tryController/fetch_city",
                    method: "POST",
                    data: {
                        state_id: state_id
                    },
                    success: function(data) {
                        $('#city').html(data);
                    }
                });
            } else {
                $('#city').html('<option value="">Select City</option>');
            }
        });

    });

    document.querySelector('#submit').addEventListener('click', () => {
        console.log('Clicked')
        localStorage.setItem('add', 1)
    });
    $(document).ready(function() {
        if (Number(localStorage.getItem('add')) === 1) {
            window.location.replace('http://localhost/CRUD/index.php/HomeController/index')
        }
    });
    $(document).ready(function() {
        $("#ajax_form").validate({

            rules: {
                fname: {
                    lettersonly: true,
                    required: true,
                    maxlength: 50
                },
                lname: {
                    lettersonly: true,
                    required: true,
                    maxlength: 50
                },

                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: "<?php echo base_url('index.php/HomeController/check_phone_exists'); ?>",
                        type: "post",
                    }
                },
                email: {
                    required: true,
                    maxlength: 50,
                    email: true,
                    remote: {
                        url: "<?php echo base_url('index.php/HomeController/check_email_exists'); ?>",
                        type: "post",
                    }
                },
                dob: {
                    required: true,
                    minAge: 10
                },
                country: {
                    required: true,
                    maxlength: 50,
                    digits: false
                },
                city: {
                    required: true,
                    maxlength: 50,
                    digits: false
                },
                state: {
                    required: true,
                    maxlength: 50,
                    digits: false
                },
            },
            messages: {

                fname: {
                    required: "Please enter first name",
                    maxlength: "Your last name maxlength should be 50 characters long."
                },
                lname: {
                    required: "Please enter last name",
                    maxlength: "Your last name maxlength should be 50 characters long."
                },
                phone: {
                    remote: "Phone No already in use.",
                    required: "Please enter contact number",
                    minlength: "The contact number should be 10 digits",
                    digits: "Please enter only numbers",
                    maxlength: "The contact number should be 10 digits",
                },
                email: {
                    remote: "Email Id already in use.",
                    required: "Please enter valid email",
                    email: "Please enter valid email",
                    maxlength: "The email name should less than or equal to 50 characters",

                },
                dob: {
                    required: "Please enter you date of birth.",
                    minAge: "You must be at least 10 years old!"
                },
                country: {
                    required: "Please enter country",
                    maxlength: "Your last country maxlength should be 50 characters long."
                },
                city: {
                    required: "Please enter city",
                    maxlength: "Your last city maxlength should be 50 characters long."
                },
                state: {
                    required: "Please enter state",
                    maxlength: "Your last state maxlength should be 50 characters long."
                },

            },

        })
        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Letters only please");
    });
    $.validator.addMethod("minAge", function(value, element, min) {
        var today = new Date();
        var birthDate = new Date(value);
        var age = today.getFullYear() - birthDate.getFullYear();

        if (age > min + 1) {
            return true;
        }

        var m = today.getMonth() - birthDate.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age >= min;
    }, "You are not old enough!");
    $(document).on("keydown", "form", function(event) {
        return event.key != "Enter";
    });
    $(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#dob').attr('max', maxDate);
    });
</script>

</html>