<?php
    class M_question extends CI_Model
    {
        public function get_question()
        {
            $this->db->select("
                *,
                DATE_FORMAT(questions.create_at, '%W,  %d %b %Y') AS create_at_mod,
                IF(questions.block='0','YES','NO') AS block_mod,
                question_categories.title AS kategori_soal
            ");
            $this->db->join('question_categories','questions.question_categori_id=question_categories.question_categori_id','left');
            return $this->db->get('questions')->result();
        }
    }
    