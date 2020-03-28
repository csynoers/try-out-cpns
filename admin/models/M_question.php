<?php
    class M_question extends CI_Model
    {
        protected $table = 'questions'; 
        protected $question_categori_id;
        protected $question;
        protected $block;
        protected $create_at;

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
                $this->question_categori_id = $this->post['question_categori_id'];
                $this->question             = $this->post['question'];
                $this->block                = '0';
                $this->create_at            = date('Y-m-d H:i:s');

                $data= [
                    'question_categori_id'=> $this->question_categori_id,
                    'question'=> $this->question,
                    'block'=> $this->block,
                    'create_at'=> $this->create_at,
                ];
                $this->db->insert( $this->table, $data );

                // # get last insert id
                return $this->db->insert_id();

            }
        }
    }
    