<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Kakeibo Controller
 *
 *
 * @method \App\Model\Entity\Kakeibo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KakeiboController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $kakeibo = $this->paginate($this->Kakeibo);

        $this->set(compact('kakeibo'));
    }

    /**
     * View method
     *
     * @param string|null $id Kakeibo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kakeibo = $this->Kakeibo->get($id, [
            'contain' => [],
        ]);

        $this->set('kakeibo', $kakeibo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kakeibo = $this->Kakeibo->newEmptyEntity();
        if ($this->request->is('post')) {
            $kakeibo = $this->Kakeibo->patchEntity($kakeibo, $this->request->getData());
            if ($this->Kakeibo->save($kakeibo)) {
                $this->Flash->success(__('The kakeibo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kakeibo could not be saved. Please, try again.'));
        }
        $this->set(compact('kakeibo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kakeibo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kakeibo = $this->Kakeibo->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kakeibo = $this->Kakeibo->patchEntity($kakeibo, $this->request->getData());
            if ($this->Kakeibo->save($kakeibo)) {
                $this->Flash->success(__('The kakeibo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kakeibo could not be saved. Please, try again.'));
        }
        $this->set(compact('kakeibo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kakeibo id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kakeibo = $this->Kakeibo->get($id);
        if ($this->Kakeibo->delete($kakeibo)) {
            $this->Flash->success(__('The kakeibo has been deleted.'));
        } else {
            $this->Flash->error(__('The kakeibo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
