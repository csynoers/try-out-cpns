<?php
    class M_choice extends CI_Model
    {
        public $post;

        protected $table = 'choices';
        protected $question_id;
        protected $question_code;
        protected $weight;
        protected $choice;

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

        public function store()
        {
            if ( $this->uri->segment(3) ) { # update
                $data= [
                    'title'=> $this->post['title'],
                    'slug'=> $this->post['slug'],
                    'description'=> $this->post['description'],
                ];
                $where= [
                    'id'=> $this->uri->segment(3)
                ];
                return $this->db->update('pages',$data,$where);

            } else { # insert
                $this->question_id = $this->post['question_id'];
                $this->question_code = $this->post['question_code'];
                $this->weight = $this->post['weight'];
                $this->choice = $this->post['choice'];

                $data= [
                    'question_id'=> $this->question_id,
                    'question_code'=> $this->question_code,
                    'weight'=> $this->weight,
                    'choice'=> $this->choice,
                ];

                # return TRUE or FALSE
                return $this->db->insert( $this->table, $data );

            }
        }
    }
    