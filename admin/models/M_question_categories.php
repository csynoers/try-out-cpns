<?php
    class M_question_categories extends CI_Model
    {
        protected $table = 'question_categories';
        protected $primaryKey   = 'question_categories.question_categori_id';

        public function get_question_categories($id=NULL)
        {
            if ( $id ) {
                $this->db->where($this->primaryKey,$id);
            }
            $this->db->select("*,DATE_FORMAT(question_categories.create_at, '%W,  %d %b %Y') AS create_at_mod, IF(question_categories.block='0','YES','NO') AS block_mod");
            return $this->db->get( $this->table )->result();
        }
        public function store()
        {
            if ( $this->uri->segment(4) ) { # update
                $data= [
                    'title'=> $this->post['title'],
                    'block'=> $this->post['publish'],
                ];
                $where= [
                    $this->primaryKey => $this->uri->segment(4)
                ];
                return $this->db->update( $this->table ,$data,$where);

            } else { # insert
                $data= [
                    'title'=> $this->post['title'],
                    'true_question'=> $this->post['true_question'],
                    'block'=> $this->post['publish'],
                    'true_grade'=> ($this->post['true_question']=='same'? 5 : 0 ),
                    'create_at'=> date('Y-m-d H:i:s'),
                ];
                return $this->db->insert( $this->table ,$data);

            }
        }
        public function check_relations($id=NULL)
        {
            if ( $id ) {
                $this->db->where($this->primaryKey,$id);
            }

            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->join('questions', "questions.question_id = {$this->primaryKey}");
            $query = $this->db->get();

            return $query->num_rows();
        }
        public function delete($id)
        {
            $where= [
                "{$this->primaryKey}"=> $id
            ];
            return $this->db->delete($this->table,$where);
        }
    }
    