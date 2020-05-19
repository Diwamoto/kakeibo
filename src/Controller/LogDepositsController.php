<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LogDeposits Controller
 *
 * @property \App\Model\Table\LogDepositsTable $LogDeposits
 *
 * @method \App\Model\Entity\LogDeposit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogDepositsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Accounts', 'MstDeposits'],
        ];
        $logDeposits = $this->paginate($this->LogDeposits);

        $this->set(compact('logDeposits'));
    }

    /**
     * View method
     *
     * @param string|null $id Log Deposit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $logDeposit = $this->LogDeposits->get($id, [
            'contain' => ['Users', 'Accounts', 'MstDeposits'],
        ]);

        $this->set('logDeposit', $logDeposit);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $logDeposit = $this->LogDeposits->newEmptyEntity();
        if ($this->request->is('post')) {
            $logDeposit = $this->LogDeposits->patchEntity($logDeposit, $this->request->getData());
            if ($this->LogDeposits->save($logDeposit)) {
                $this->Flash->success(__('The log deposit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log deposit could not be saved. Please, try again.'));
        }
        $users = $this->LogDeposits->Users->find('list', ['limit' => 200]);
        $accounts = $this->LogDeposits->Accounts->find('list', ['limit' => 200]);
        $mstDeposits = $this->LogDeposits->MstDeposits->find('list', ['limit' => 200]);
        $this->set(compact('logDeposit', 'users', 'accounts', 'mstDeposits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Log Deposit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $logDeposit = $this->LogDeposits->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $logDeposit = $this->LogDeposits->patchEntity($logDeposit, $this->request->getData());
            if ($this->LogDeposits->save($logDeposit)) {
                $this->Flash->success(__('The log deposit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log deposit could not be saved. Please, try again.'));
        }
        $users = $this->LogDeposits->Users->find('list', ['limit' => 200]);
        $accounts = $this->LogDeposits->Accounts->find('list', ['limit' => 200]);
        $mstDeposits = $this->LogDeposits->MstDeposits->find('list', ['limit' => 200]);
        $this->set(compact('logDeposit', 'users', 'accounts', 'mstDeposits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Log Deposit id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $logDeposit = $this->LogDeposits->get($id);
        if ($this->LogDeposits->delete($logDeposit)) {
            $this->Flash->success(__('The log deposit has been deleted.'));
        } else {
            $this->Flash->error(__('The log deposit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
