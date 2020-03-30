<?php
    class M_exam_configs extends CI_Model
    {
        protected $table = 'exam_configs'; 
        protected $primaryKey = 'exam_configs.exam_config_id'; 
        protected $foreignKey = 'exam_configs.question_categori_id'; 
        protected $question_categori_id;
        protected $exam_limit;
        protected $number_of_question;
        protected $create_at;

        protected $tableChoices = 'question_categories';
        protected $tableChoicesRelation = 'question_categories.question_categori_id=exam_configs.question_categori_id';

        public function get()
        {
            $this->db->select("*,IF(exam_configs.exam_limit=0,'-',CONCAT(exam_configs.exam_limit, 'Menit')) AS exam_limit_mod, IF(exam_configs.number_of_questions=0,'-',exam_configs.number_of_questions) AS number_of_questions_mod,",FALSE);
            $this->db->from($this->table);

            $this->db->join($this->tableChoices, $this->tableChoicesRelation);
            return $this->db->get()->result();
        }

        public function get_question( $id=NULL )
        {
            if ( $id ) {
                $this->db->where('questions.question_id',$id);
            }
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
                $this->question             = $this->post['question'];
                $this->block                = '0';

                $data= [
                    'question'=> $this->question,
                    'block'=> $this->block,
                ];
                $where= [
                    'question_id'=> $this->uri->segment(3)
                ];
                return $this->db->update( $this->table,$data,$where);

            } else { # insert
                $this->question_categori_id = $this->post['question_categori_id'];
                $this->question             = $this->post['question'];
                $this->block                = $this->post['publish'];
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
        public function check_relations($id=NULL)
        {
            if ( $id ) {
                $this->db->where($this->primaryKey,$id);
            }

            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->join($this->tableChoices, $this->tableChoicesRelation);
            $query = $this->db->get();

            return $query->num_rows();
        }
    }
    