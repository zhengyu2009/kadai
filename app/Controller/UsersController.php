<?php
App::uses('AppController', 'Controller');
App::uses( 'CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if($this->Session->check('editInfo')) {
			$this->data = $this->Session->read('editInfo');
			$this->User->set($this->data);
			$this->Session->delete('editInfo');
		}
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$this->Session->write('userInfo', $this->request->data);
				return $this->redirect(array('action' => 'confirm'));
			} else {
				$this->Flash->error(__('入力データをご確認ください'));
			}
		}
	}
	
	public function confirm() {
		if($this->Session->check('userInfo')) {
			$this->data = $this->Session->read('userInfo');
			$this->User->set($this->data);
			$this->Session->delete('userInfo');
		}
		if ($this->request->is('post')) {
			$this->log($_POST);
			if(isset($_POST['save'])) {
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('登録情報が保存されました、ありがとうございました。'));
					$this->Session->write('savedInfo', $this->request->data);
					return $this->redirect(array('action' => 'thanks'));
				} else {
					$this->Flash->error(__('保存できなかった'));
				}
			}elseif (isset($_POST['edit'])) {
				$this->Session->write('editInfo', $this->request->data);
				return $this->redirect(array('action' => 'add'));
			}
		}
	}
	
	public function thanks() {
		if($this->Session->check('savedInfo')) {
			$this->data = $this->Session->read('savedInfo');
			// $this->log($this->data);
			$name = $this->data['User']['name'];
			$email = $this->data['User']['email'];
			$this->set(compact('name', 'email'));
			$this->log($email);
			$this->Session->delete('savedInfo');
			
			
		$sendmail = new CakeEmail('gmail');//使用するメール送信の設定。
        $sent = $sendmail
            ->from(array('yan.yzy@gmail.com' => '事務局'))//送信元メールアドレス→送信元の表示名。
            ->to($email)//送信先のメールアドレス、申込者のメールアドレスを自動取得する。
            ->subject('ご登録ありがとうございました')//送信メールの件名。
            ->send($name . '様、このたびご登録、ありがとうございました。');
        if ($sent) {
            //echo 'メール送信成功！';
        } else {
            echo 'メール送信失敗';
        }
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
