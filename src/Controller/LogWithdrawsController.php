<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LogWithdraws Controller
 *
 * @property \App\Model\Table\LogWithdrawsTable $LogWithdraws
 *
 * @method \App\Model\Entity\LogWithdraw[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogWithdrawsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->loadModel('MstWithdraws');
        $this->loadModel('MstPaymentMethods');
        
        $paymentMethods = array_values($this->MstPaymentMethods->find('list')->toArray());
        $withdrawConfig = array_values($this->MstWithdraws->find('list')->toArray());
        
        $this->paginate = [
            'contain' => ['Users', 'MstWithdraws', 'Accounts', 'MstPaymentMethods'],
        ];
        $logWithdraws = $this->paginate($this->LogWithdraws);

        $this->set(compact('logWithdraws'));
        $this->set(compact('withdrawConfig'));
        $this->set(compact('paymentMethods'));
    }

    /**
     * View method
     *
     * @param string|null $id Log Withdraw id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $logWithdraw = $this->LogWithdraws->get($id, [
            'contain' => ['Users', 'MstWithdraws', 'Accounts', 'MstPaymentMethods'],
        ]);

        $this->set('logWithdraw', $logWithdraw);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $logWithdraw = $this->LogWithdraws->newEmptyEntity();
        if ($this->request->is('post')) {
            $logWithdraw = $this->LogWithdraws->patchEntity($logWithdraw, $this->request->getData());
            if ($this->LogWithdraws->save($logWithdraw)) {
                $this->Flash->success(__('The log withdraw has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log withdraw could not be saved. Please, try again.'));
        }
        $users = $this->LogWithdraws->Users->find('list', ['limit' => 200]);
        $mstWithdraws = $this->LogWithdraws->MstWithdraws->find('list', ['limit' => 200]);
        $accounts = $this->LogWithdraws->Accounts->find('list', ['limit' => 200]);
        $mstPaymentMethods = $this->LogWithdraws->MstPaymentMethods->find('list', ['limit' => 200]);
        $this->set(compact('logWithdraw', 'users', 'mstWithdraws', 'accounts', 'mstPaymentMethods'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Log Withdraw id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $logWithdraw = $this->LogWithdraws->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $logWithdraw = $this->LogWithdraws->patchEntity($logWithdraw, $this->request->getData());
            if ($this->LogWithdraws->save($logWithdraw)) {
                $this->Flash->success(__('The log withdraw has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log withdraw could not be saved. Please, try again.'));
        }
        $users = $this->LogWithdraws->Users->find('list', ['limit' => 200]);
        $mstWithdraws = $this->LogWithdraws->MstWithdraws->find('list', ['limit' => 200]);
        $accounts = $this->LogWithdraws->Accounts->find('list', ['limit' => 200]);
        $mstPaymentMethods = $this->LogWithdraws->MstPaymentMethods->find('list', ['limit' => 200]);
        $this->set(compact('logWithdraw', 'users', 'mstWithdraws', 'accounts', 'mstPaymentMethods'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Log Withdraw id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $logWithdraw = $this->LogWithdraws->get($id);
        if ($this->LogWithdraws->delete($logWithdraw)) {
            $this->Flash->success(__('The log withdraw has been deleted.'));
        } else {
            $this->Flash->error(__('The log withdraw could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
