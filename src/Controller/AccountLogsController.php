<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AccountLogs Controller
 *
 *
 * @method \App\Model\Entity\AccountLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $accountLogs = $this->paginate($this->AccountLogs);

        $this->set(compact('accountLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Account Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accountLog = $this->AccountLogs->get($id, [
            'contain' => [],
        ]);

        $this->set('accountLog', $accountLog);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accountLog = $this->AccountLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $accountLog = $this->AccountLogs->patchEntity($accountLog, $this->request->getData());
            if ($this->AccountLogs->save($accountLog)) {
                $this->Flash->success(__('The account log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The account log could not be saved. Please, try again.'));
        }
        $this->set(compact('accountLog'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Account Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accountLog = $this->AccountLogs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountLog = $this->AccountLogs->patchEntity($accountLog, $this->request->getData());
            if ($this->AccountLogs->save($accountLog)) {
                $this->Flash->success(__('The account log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The account log could not be saved. Please, try again.'));
        }
        $this->set(compact('accountLog'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Account Log id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accountLog = $this->AccountLogs->get($id);
        if ($this->AccountLogs->delete($accountLog)) {
            $this->Flash->success(__('The account log has been deleted.'));
        } else {
            $this->Flash->error(__('The account log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
