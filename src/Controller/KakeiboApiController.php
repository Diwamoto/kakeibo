<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * KakeiboApi Controller
 *
 *
 * @method \App\Model\Entity\KakeiboApi[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KakeiboApiController extends AppController
{
    // /**
    //  * Index method
    //  *
    //  * @return \Cake\Http\Response|null|void Renders view
    //  */
    // public function index()
    // {
    //     $kakeiboApi = $this->paginate($this->KakeiboApi);

    //     $this->set(compact('kakeiboApi'));
    // }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Kakeibo Api id.
    //  * @return \Cake\Http\Response|null|void Renders view
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $kakeiboApi = $this->KakeiboApi->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set('kakeiboApi', $kakeiboApi);
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $kakeiboApi = $this->KakeiboApi->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $kakeiboApi = $this->KakeiboApi->patchEntity($kakeiboApi, $this->request->getData());
    //         if ($this->KakeiboApi->save($kakeiboApi)) {
    //             $this->Flash->success(__('The kakeibo api has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The kakeibo api could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('kakeiboApi'));
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Kakeibo Api id.
    //  * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $kakeiboApi = $this->KakeiboApi->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $kakeiboApi = $this->KakeiboApi->patchEntity($kakeiboApi, $this->request->getData());
    //         if ($this->KakeiboApi->save($kakeiboApi)) {
    //             $this->Flash->success(__('The kakeibo api has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The kakeibo api could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('kakeiboApi'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Kakeibo Api id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $kakeiboApi = $this->KakeiboApi->get($id);
    //     if ($this->KakeiboApi->delete($kakeiboApi)) {
    //         $this->Flash->success(__('The kakeibo api has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The kakeibo api could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
    public function webhook($apikey){
        if(empty($apikey)){
            throw new NotFoundException();
        }
    }
}
