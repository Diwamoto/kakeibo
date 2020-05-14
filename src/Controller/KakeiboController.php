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
    
    public function initialize(): void
    {
        $this->loadComponent('Kakeibo');
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->loadModel('MstDeposits');
        $depoConfig = array_flip($this->MstDeposits->find('list')->toArray());
        $this->loadModel('MstPaymentMethods');
        $pmConfig = array_flip($this->MstPaymentMethods->find('list')->toArray());
        $this->loadModel('MstWithdraws');
        $wdConfig = array_flip($this->MstWithdraws->find('list')->toArray());
        //$withdraws = $this->Kakeibo->getWithdraws();
        $this->loadModel('MstWithdraws');
        $category = json_encode($this->MstWithdraws->find('list')->toArray(), JSON_UNESCAPED_UNICODE);
        $this->set(compact('category'));
        // $this->set(compact('withdraws'));
    }
}
