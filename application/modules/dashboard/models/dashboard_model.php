<?php
/**
 * dashboard_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		https://www.acacha.com/index.php/ebre-escool
 */
class dashboard_model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getTeachersStatistics() {

        $teachers_statistics = array();
        $teachers_statistics['total_teachers'] = 69;
        return $teachers_statistics;
    }

    function getEnrollmentStatistics() {

        $enrollment_statistics = array();

        $this->db->from('enrollment');
        //TODO: get current period from config
        $this->db->where('enrollment_periodid',"2017-18");
        $query = $this->db->get();

        $enrollment_statistics['total_number_of_current_period_enrolled_persons'] = $query->num_rows();

        /*SELECT
        FROM enrollment
        INNER JOIN enrollment_submodules ON enrollment.enrollment_id = enrollment_submodules.enrollment_submodules_enrollment_id
        WHERE enrollment.`enrollment_periodid`="2014-15"
        */

        $this->db->from('enrollment');
        //TODO: get current period from config
        $this->db->where('enrollment_periodid',"2017-18");
        $this->db->join('enrollment_submodules', 'enrollment_submodules.enrollment_submodules_enrollment_id = enrollment.enrollment_id');
        $query = $this->db->get();

        $enrollment_statistics['total_study_submodules'] = $query->num_rows();

        return $enrollment_statistics;

    }


    function getCurriculumStatistics() {

        $curriculum_statistics = array();

        //All studies
        $this->db->from('studies');
        $query = $this->db->get();
        $curriculum_statistics['total_studies'] = $query->num_rows();

        //All courses
        $this->db->from('course');
        $query = $this->db->get();
        $curriculum_statistics['total_courses'] = $query->num_rows();

        //All departments
        $this->db->from('department');
        $query = $this->db->get();
        $curriculum_statistics['total_departments'] = $query->num_rows();

        //All classgroups
        $this->db->from('classroom_group');
        $query = $this->db->get();
        $curriculum_statistics['total_classroom_group'] = $query->num_rows();

        //All classgroups
        $this->db->from('study_module');
        $query = $this->db->get();
        $curriculum_statistics['total_study_modules'] = $query->num_rows();

        //All classgroups
        $this->db->from('study_submodules');
        $query = $this->db->get();
        $curriculum_statistics['total_study_submodules'] = $query->num_rows();

        return $curriculum_statistics;
    }



    function getStudentsStatistics() {

        $students_statistics = array();

        $students_statistics['total_students'] = 56;


        return $students_statistics;
    }

    function getEmployersStatistics() {

        $employers_statistics = array();

        $employers_statistics['total_employers'] = 15;


        return $employers_statistics;
    }

    function getPersonsStatistics() {

    	$person_statistics = array();

    	//All persons
    	$this->db->from('person');
        //$this->db->select('organizational_unit_name');
        //$this->db->where('organizational_unit_Id',$ou_id);

        $query = $this->db->get();

        $person_statistics['total_number_of_persons'] = $query->num_rows();

        $photos_url = array();
        $photos_url_filenotexists = array();
        $photos_url_filenotexists_id = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                $base_url = "/usr/share/ebre-escool/uploads/person_photos";
                $photo_url = $base_url . "/" . $row->person_photo;
                $photos_url[] = $photo_url;
                if ( !file_exists ( $photo_url ) ) {
                    $photos_url_filenotexists[] = $photo_url;
                    $photos_url_filenotexists_id[] = $row->person_id;
                }
            }
        }

        //PHOTOS
        //SELECT `person_photo` FROM `person`
        $person_statistics['without_photo_persons'] = $photos_url_filenotexists;
        $person_statistics['without_photo_persons_id'] = $photos_url_filenotexists_id;


		//All persons without person_official_id (DNI p.ex.) duplicates!
		$this->db->from('person');
		$this->db->select('person_official_id');
        $this->db->distinct();

        $query = $this->db->get();

        $person_statistics['total_number_of_distinct_persons'] = $query->num_rows();

        $person_statistics['total_number_of_duplicated_persons'] = $person_statistics['total_number_of_persons'] - $person_statistics['total_number_of_distinct_persons'];

        $duplicated_person_ids = array();

        //Get Duplicated ids
		/*
        SELECT `person_official_id`
		FROM person
		GROUP BY `person_official_id`
		HAVING count( * ) >1
		*/

		//All persons without person_official_id (DNI p.ex.) duplicates!
		$this->db->from('person');
		$this->db->select('person_official_id');
        $this->db->group_by("person_official_id");
        $this->db->having('count( * ) > 1');

        $query = $this->db->get();
        $duplicated_person_ids = array();

        if ($query->num_rows() > 0)	{
   			foreach ($query->result() as $row)	{
      			$duplicated_person_ids[] = $row->person_official_id;
   			}
		}

        $person_statistics['duplicated_person_ids'] = $duplicated_person_ids;

        /*
        /* SELECT `person_gender`,count(`person_id`) FROM `person` GROUP BY  `person_gender`
        /*
        */

        $this->db->from('person');
        $this->db->select('person_gender,count(person_id) as total');
        $this->db->group_by("person_gender");

        $query = $this->db->get();

        $male_persons = 0;
        $female_persons = 0;

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                if ($row->person_gender == "M")
                    $male_persons = $row->total;
                if ($row->person_gender == "F")
                    $female_persons  = $row->total;
            }
        }

        $person_statistics['male_persons'] = $male_persons;
        $person_statistics['female_persons'] = $female_persons;
        $person_statistics['not_gender_defined_persons'] = $person_statistics['total_number_of_persons'] - $female_persons - $male_persons;

        //emails
        //SELECT `person_email`,count(`person_id`) as total FROM `person` GROUP BY  `person_email`HAVING total > 1 ORDER BY total DESC

        $this->db->from('person');
        $this->db->select('person_email,count(person_id) as total');
        $this->db->group_by("person_email");
        $this->db->having('total > 1');

        $query = $this->db->get();

        $male_persons = 0;
        $female_persons = 0;

        $undefined_emails="";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)  {
                if ($row->person_email == "") {
                    $undefined_emails = $row->total;
                }
            }
        }

        $person_statistics['undefined_emails'] = $undefined_emails;
        $person_statistics['duplicated_emails'] = $query->num_rows() -1;

        return $person_statistics;
    }



    function get_primary_key($table_name) {
		$fields = $this->db->field_data($table_name);

		foreach ($fields as $field)	{
			if ($field->primary_key) {
					return $field->name;
			}
		}
		return false;
	}



}
