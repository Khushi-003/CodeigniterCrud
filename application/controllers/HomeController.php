<?php
class HomeController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('pagination');
        $this->load->model('crudModel');
    }

    public function index()
    {
        //pagination settings
        $config['base_url'] = site_url('HomeController/index');
        $config['total_rows'] = $this->db->count_all('profile');
        $config['per_page'] = "3";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['profileList'] = $this->crudModel->getDetails($config["per_page"], $data['page'], NULL);
        // print_r($data['profileList']);
        $data['pagination'] = $this->pagination->create_links();
        $data['country'] = $this->crudModel->fetch_country();
        $this->load->view('HomeView', $data);
    }
    function fetchstate()
    {
        $data = $this->tryModel->fetch_state($this->input->post('country_name'));
        // $this->load->view('tryView', $data);
        echo $data;
    }
    function fetch_city()
    {
        $data = $this->tryModel->fetch_city($this->input->post('state_name'));
        echo $data;
    }
    function index2()
    {
        if ($this->input->post('submit') == FALSE) {
            $data['country'] = $this->crudModel->fetch_country();
            $this->load->view('myform', $data);
        } else {
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $dob = $this->input->post('dob');
            $country = $this->input->post('country'); //countyename
            $state = $this->input->post('state'); // statename and country id
            $city = $this->input->post('city'); //city name countryid state id 

            $cCheck = "SELECT * FROM country WHERE country_id='$country'";
            $countryCheck = $this->db->query($cCheck);
            //
            $sCheck = "SELECT * FROM state WHERE state_id='$state'";
            $stateCheck = $this->db->query($sCheck);
            //
            $ctCheck = "SELECT * FROM city WHERE city_id='$city'";
            $cityCheck = $this->db->query($ctCheck);
            // var_dump(count($countryCheck->result()), $country);

            if (count($countryCheck->result()) != 0) {
                if (count($stateCheck->result()) != 0) {
                    if (count($cityCheck->result()) != 0) {
                        $data = array(
                            'Fname' => $fname,
                            'Lname' => $lname,
                            'Phone' => $phone,
                            'Email' => $email,
                            'DOB' => $dob,
                            'Country' => $country,
                            'City' => $city,
                            'State' => $state
                        );
                        $this->db->insert('profile', $data);
                        $this->load->view('myform');
                    } else {
                        $qcity = "INSERT INTO city (city_name,state_id,country_id) VALUES('$city','$state','$country')";
                        $queryCityInsert = $this->db->query($qcity);
                        $qCityR = "SELECT city_id from city WHERE city_name='$city'";
                        $querystateCity = $this->db->query($qCityR);
                        $city_id = $querystateCity->result()[0]->city_id;
                        //
                        $data = array(
                            'Fname' => $fname,
                            'Lname' => $lname,
                            'Phone' => $phone,
                            'Email' => $email,
                            'DOB' => $dob,
                            'Country' => $country,
                            'City' => $city_id,
                            'State' => $state
                        );
                        $this->db->insert('profile', $data);
                        $this->load->view('myform');
                    }
                } else {
                    $qS = "INSERT INTO state (state_name,country_id) VALUES('$state','$country')";
                    $queryStateInsert = $this->db->query($qS);
                    $qSR = "SELECT state_id from state WHERE state_name='$state'";
                    $querystateRead = $this->db->query($qSR);
                    $state_id = $querystateRead->result()[0]->state_id;
                    //
                    $qcity = "INSERT INTO city (city_name,state_id,country_id) VALUES('$city','$state_id','$country')";
                    $queryCityInsert = $this->db->query($qcity);
                    $qCityR = "SELECT city_id from city WHERE city_name='$city'";
                    $querystateCity = $this->db->query($qCityR);
                    $city_id = $querystateCity->result()[0]->city_id;
                    //
                    $data = array(
                        'Fname' => $fname,
                        'Lname' => $lname,
                        'Phone' => $phone,
                        'Email' => $email,
                        'DOB' => $dob,
                        'Country' => $country,
                        'City' => $city_id,
                        'State' => $state_id
                    );
                    $this->db->insert('profile', $data);
                    $this->load->view('myform');
                }
            } else {
                //
                $qC = "INSERT INTO country (country_name) VALUES('$country')";
                $queryCountryInsert = $this->db->query($qC);
                $qCR = "SELECT country_id from country WHERE country_name='$country'";
                $queryCountryRead = $this->db->query($qCR);
                $country_id = $queryCountryRead->result()[0]->country_id;
                //
                $qS = "INSERT INTO state (state_name,country_id) VALUES('$state','$country_id')";
                $queryStateInsert = $this->db->query($qS);
                $qSR = "SELECT state_id from state WHERE state_name='$state'";
                $querystateRead = $this->db->query($qSR);
                $state_id = $querystateRead->result()[0]->state_id;
                //
                $qcity = "INSERT INTO city (city_name,state_id,country_id) VALUES('$city','$state_id','$country_id')";
                $queryCityInsert = $this->db->query($qcity);
                $qCityR = "SELECT city_id from city WHERE city_name='$city'";
                $querystateCity = $this->db->query($qCityR);
                $city_id = $querystateCity->result()[0]->city_id;
                //
                $data = array(
                    'Fname' => $fname,
                    'Lname' => $lname,
                    'Phone' => $phone,
                    'Email' => $email,
                    'DOB' => $dob,
                    'Country' => $country_id,
                    'City' => $city_id,
                    'State' => $state_id
                );
                $this->db->insert('profile', $data);
                $this->load->view('myform');
            }
        }
    }
    public function edit($id)
    {
        $result = $this->crudModel->get_Details($id);
        $r = $result[0];

        $sqlCountry = "SELECT country_name FROM country WHERE country_id='$r->Country'";
        $queryContry = $this->db->query($sqlCountry);
        $country = $queryContry->result()[0];

        $sqlState = "SELECT state_name FROM state WHERE state_id='$r->State'";
        $queryState = $this->db->query($sqlState);
        $state = $queryState->result()[0];

        $sqlCity = "SELECT city_name FROM city WHERE city_id='$r->City'";
        $queryCity = $this->db->query($sqlCity);
        $city = $queryCity->result()[0];

        $Viewdata = array(
            'userId' => $id,
            'fname' => $result[0]->Fname,
            'lname' => $result[0]->Lname,
            'phone' => $result[0]->Phone,
            'email' => $result[0]->Email,
            'dob' => $result[0]->DOB,

            'citycc' => $city->city_name,
            'citycode' => $r->City,

            'countrycc' => $country->country_name,
            'countrycode' => $r->Country,

            'statecc' => $state->state_name,
            'statecode' => $r->State

        );
        $Viewdata['country'] = $this->crudModel->fetch_country();
        $this->load->view('formsuccess', $Viewdata);
        if ($this->input->post('submit') == FALSE) {
        } else {
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $dob = $this->input->post('dob');
            $country = $this->input->post('country'); //countyename
            $state = $this->input->post('state'); // statename and country id
            $city = $this->input->post('city'); //city name countryid state id 

            $cCheck = "SELECT * FROM country WHERE country_id='$country'";
            $countryCheck = $this->db->query($cCheck);
            //
            $sCheck = "SELECT * FROM state WHERE state_id='$state'";
            $stateCheck = $this->db->query($sCheck);
            //
            $ctCheck = "SELECT * FROM city WHERE city_id='$city'";
            $cityCheck = $this->db->query($ctCheck);
            // var_dump(count($countryCheck->result()), $country);

            if (count($countryCheck->result()) != 0) {
                if (count($stateCheck->result()) != 0) {
                    if (count($cityCheck->result()) != 0) {
                        $data = array(
                            'Fname' => $fname,
                            'Lname' => $lname,
                            'Phone' => $phone,
                            'Email' => $email,
                            'DOB' => $dob,
                            'Country' => $country,
                            'City' => $city,
                            'State' => $state
                        );
                        $this->db->where('ID', $id);
                        $this->db->update('profile', $data);
                    } else {
                        $qcity = "INSERT INTO city (city_name,state_id,country_id) VALUES('$city','$state','$country')";
                        $queryCityInsert = $this->db->query($qcity);
                        $qCityR = "SELECT city_id from city WHERE city_name='$city'";
                        $querystateCity = $this->db->query($qCityR);
                        $city_id = $querystateCity->result()[0]->city_id;
                        //
                        $data = array(
                            'Fname' => $fname,
                            'Lname' => $lname,
                            'Phone' => $phone,
                            'Email' => $email,
                            'DOB' => $dob,
                            'Country' => $country,
                            'City' => $city_id,
                            'State' => $state
                        );
                        $this->db->where('ID', $id);
                        $this->db->update('profile', $data);
                    }
                } else {
                    $qS = "INSERT INTO state (state_name,country_id) VALUES('$state','$country')";
                    $queryStateInsert = $this->db->query($qS);
                    $qSR = "SELECT state_id from state WHERE state_name='$state'";
                    $querystateRead = $this->db->query($qSR);
                    $state_id = $querystateRead->result()[0]->state_id;
                    //
                    $qcity = "INSERT INTO city (city_name,state_id,country_id) VALUES('$city','$state_id','$country')";
                    $queryCityInsert = $this->db->query($qcity);
                    $qCityR = "SELECT city_id from city WHERE city_name='$city'";
                    $querystateCity = $this->db->query($qCityR);
                    $city_id = $querystateCity->result()[0]->city_id;
                    //
                    $data = array(
                        'Fname' => $fname,
                        'Lname' => $lname,
                        'Phone' => $phone,
                        'Email' => $email,
                        'DOB' => $dob,
                        'Country' => $country,
                        'City' => $city_id,
                        'State' => $state_id
                    );
                    $this->db->where('ID', $id);
                    $this->db->update('profile', $data);
                }
            } else {
                //
                $qC = "INSERT INTO country (country_name) VALUES('$country')";
                $queryCountryInsert = $this->db->query($qC);
                $qCR = "SELECT country_id from country WHERE country_name='$country'";
                $queryCountryRead = $this->db->query($qCR);
                $country_id = $queryCountryRead->result()[0]->country_id;
                //
                $qS = "INSERT INTO state (state_name,country_id) VALUES('$state','$country_id')";
                $queryStateInsert = $this->db->query($qS);
                $qSR = "SELECT state_id from state WHERE state_name='$state'";
                $querystateRead = $this->db->query($qSR);
                $state_id = $querystateRead->result()[0]->state_id;
                //
                $qcity = "INSERT INTO city (city_name,state_id,country_id) VALUES('$city','$state_id','$country_id')";
                $queryCityInsert = $this->db->query($qcity);
                $qCityR = "SELECT city_id from city WHERE city_name='$city'";
                $querystateCity = $this->db->query($qCityR);
                $city_id = $querystateCity->result()[0]->city_id;
                //
                $data = array(
                    'Fname' => $fname,
                    'Lname' => $lname,
                    'Phone' => $phone,
                    'Email' => $email,
                    'DOB' => $dob,
                    'Country' => $country_id,
                    'City' => $city_id,
                    'State' => $state_id
                );
                $this->db->where('ID', $id);
                $this->db->update('profile', $data);
            }
        }
    }
    function delete($id)
    {
        $this->crudModel->delete($id);
        echo "<script>setTimeout(() => window.location.replace('http://localhost/CRUD/index.php/HomeController/'), 500) </script>";
    }

    function search()
    {
        // get search string
        $search = ($this->input->post("fname")) ? $this->input->post("fname") : "NIL";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("HomeController/search/$search");
        $config['total_rows'] = $this->crudModel->getDetailsCount($search);
        $config['per_page'] = "3";
        $config["uri_segment"] = 4;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        // get books list
        $data['profileList'] = $this->crudModel->getDetails($config['per_page'], $data['page'], $search);
        $data['country'] = $this->crudModel->fetch_country();

        $data['pagination'] = $this->pagination->create_links();

        //Load view
        $this->load->view('HomeView', $data);
    }
    function asc()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/asc");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->asc($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function ascfname()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/ascfname");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->ascfname($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function asclname()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/asclname");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->asclname($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function ascphone()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/ascphone");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->ascphone($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function ascemail()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/ascemail");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->ascemail($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function ascdob()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/ascdob");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->ascdob($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function asccountry()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/asccountry");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->asccountry($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function ascstate()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/ascstate");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->ascstate($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function asccity()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/asccity");
        $config['total_rows'] = $this->crudModel->sortCount_asc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->asccity($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function desc()
    {
        $config = array();
        $config['base_url'] = site_url("HomeController/desc");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->desc($config["per_page"], $data['page']);
        $data['country'] = $this->crudModel->fetch_country();

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function descfname()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/descfname");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->descfname($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function desclname()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/desclname");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->desclname($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function descphone()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/descphone");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->descphone($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function descemail()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/descemail");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->descemail($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function descdob()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/descdob");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->descdob($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function desccountry()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/desccountry");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->desccountry($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function descstate()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/descstate");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->descstate($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function desccity()
    {

        $config = array();
        $config['base_url'] = site_url("HomeController/desccity");
        $config['total_rows'] = $this->crudModel->sortCount_desc();
        $config['per_page'] = 3;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['profileList'] = $this->crudModel->desccity($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('HomeView', $data);
    }
    function check_email_exists()
    {

        $count = $this->crudModel->email_exists($this->input->post('email'));
        if ($count == TRUE) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(TRUE);
        }
    }
    function check_phone_exists()
    {

        $count = $this->crudModel->phone_exists($this->input->post('phone'));
        if ($count == TRUE) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(TRUE);
        }
    }
}
