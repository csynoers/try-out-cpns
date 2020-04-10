<?php
    class M_answers extends CI_Model
    {
        protected $table = 'answers'; 
        protected $primaryKey = 'answers.answer_id'; 
        protected $answer_id;
        protected $username;
        protected $question_title;
        protected $total_questions;
        protected $limit_passing_grade;
        protected $passing_grade;
        protected $correct_answer;
        protected $wrong_answer;
        protected $not_answered;
        protected $exam_limit;
        protected $create_at;

        public function rows_by_username($username)
        {
            $this->db->where('answers.username',$username);
            return $this->db->get( $this->table )->num_rows();
        }
        public function store()
        {
            $data = $this->post;
            $this->db->insert('answers', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }
    