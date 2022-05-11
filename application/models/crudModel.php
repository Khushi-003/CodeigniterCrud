<?php
class crudModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getDetails($limit, $start, $st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from profile where fname like '%$st%' ORDER BY ID DESC limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        $arr = array();

        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];
            $arr[] = $row;
        }
        // var_dump($arr);
        return $arr;
    }

    function fetch_country()
    {
        $this->db->order_by("country_name", "ASC");
        $query = $this->db->get("country");
        return $query->result();
    }

    function fetch_state($country_id)
    {
        $sql = "SELECT * FROM state WHERE country_id='$country_id' ORDER BY state_name ASC";
        $query = $this->db->query($sql);
        $output = '<option value="">Select State</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' .  $row->state_id . '">' . $row->state_name . '</option>';
        }
        echo $output;
    }

    function fetch_city($state_id)
    {
        $this->db->where('state_id', $state_id);
        $this->db->order_by('city_name', 'ASC');
        $query = $this->db->get('city');
        $output = '<option value="">Select City</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->city_id . '">' . $row->city_name . '</option>';
        }
        return $output;
    }
    function getDetailsCount($st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from profile where fname like '%$st%'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function sortCount_asc()
    {
        $sql = "SELECT * FROM profile
        ORDER BY ID ASC;";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function sortCount_desc()
    {
        $sql = "SELECT * FROM profile
        ORDER BY ID DESC;";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function get_Details($id)
    {
        $sql = "SELECT * FROM profile WHERE ID='$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function delete($id)
    {
        $this->db->where('ID', $id);
        $this->db->delete('profile');
    }
    function asc($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY ID ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function desc($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY ID DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function ascfname($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Fname ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function descfname($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Fname DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function ascLname($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Lname ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function desclname($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Lname DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function ascphone($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Phone ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function descphone($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Phone DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function ascemail($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Email ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function descemail($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Email DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function ascdob($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY DOB ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function descdob($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY DOB DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function asccountry($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Country ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function desccountry($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Country DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function ascstate($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY Profile.State ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function descstate($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY State DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function asccity($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY City ASC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function desccity($limit, $start)
    {
        $sql = "SELECT * FROM profile
        ORDER BY City DESC limit " . $start . ", " . $limit;
        $arr = array();
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $sqlCountry = "SELECT country_name FROM country WHERE country_id='$row->Country'";
            $queryContry = $this->db->query($sqlCountry);
            $row->country_name = $queryContry->result()[0];

            $sqlState = "SELECT state_name FROM state WHERE state_id='$row->State'";
            $queryState = $this->db->query($sqlState);
            $row->state_name = $queryState->result()[0];

            $sqlCity = "SELECT city_name FROM city WHERE city_id='$row->City'";
            $queryCity = $this->db->query($sqlCity);
            $row->city_name = $queryCity->result()[0];

            $arr[] = $row;
        }
        return $arr;
    }
    function email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('profile');
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function phone_exists($phone)
    {
        $this->db->where('phone', $phone);
        $query = $this->db->get('profile');
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
