<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends CI_Controller {

	public function create() {

		$variaveis['titulo'] = 'Novo Cadastro';
        $this->load->view('v_cadastro', $variaveis);
        
	}

	public function store() {
		
		$this->load->library('form_validation');
		
		$regras = array(
		        array(
		                'field' => 'nome',
		                'label' => 'Nome',
		                'rules' => 'required'
		        ),
		        array(
		                'field' => 'telefone',
		                'label' => 'telefone',
		                'rules' => 'required'		                
		        ),
		        array(
		                'field' => 'email',
		                'label' => 'E-mail',
		                'rules' => 'required|valid_email'
		        ),
		        array(
		                'field' => 'observacoes',
		                'label' => 'Observações',
		                'rules' => 'required'
		        )
		);
		
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$variaveis['titulo'] = 'Novo Registro';
            $this->load->view('v_cadastro', $variaveis);
            
		} else {
			
			$id = $this->input->post('id');
			
			$dados = array(
			
				"nome" => $this->input->post('nome'),
				"telefone" => $this->input->post('telefone'),
				"email" => $this->input->post('email'),
				"observacoes" => $this->input->post('observacoes')
			
            );
            
			if ($this->m_cadastros->store($dados, $id)) {
				$variaveis['mensagem'] = "Dados gravados com sucesso!";
                $this->load->view('v_sucesso', $variaveis);
                
			} else {

				$variaveis['mensagem'] = "Ocorreu um erro. Por favor, tente novamente.";
                $this->load->view('errors/html/v_erro', $variaveis);
                
			}
				
		}
	}

	public function edit($id = null) {
		
		if ($id) {
			
			$cadastros = $this->m_cadastros->get($id);
			
			if ($cadastros->num_rows() > 0 ) {
				$variaveis['titulo'] = 'Edição de Registro';
				$variaveis['id'] = $cadastros->row()->id;
				$variaveis['nome'] = $cadastros->row()->nome;
				$variaveis['telefone'] = $cadastros->row()->telefone;
				$variaveis['email'] = $cadastros->row()->email;
				$variaveis['observacoes'] = $cadastros->row()->observacoes;
                $this->load->view('v_cadastro', $variaveis);
                
			} else {

				$variaveis['mensagem'] = "Registro não encontrado." ;
                $this->load->view('errors/html/v_erro', $variaveis);
                
			}
			
		}
		
	}

	public function delete($id = null) {

		if ($this->m_cadastros->delete($id)) {

			$variaveis['mensagem'] = "Registro excluído com sucesso!";
            $this->load->view('v_sucesso', $variaveis);
            
		}
	}
}
