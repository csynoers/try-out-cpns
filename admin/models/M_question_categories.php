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
                ];
                $where= [
                    $this->primaryKey => $this->uri->segment(4)
                ];
                return $this->db->update( $this->table ,$data,$where);

            } else { # insert
                $data= [
                    'title'=> $this->post['title'],
                    'create_at'=> date('Y-m-d H:i:s'),
                ];
                return $this->db->insert( $this->table ,$data);

            }
        }
    }
    