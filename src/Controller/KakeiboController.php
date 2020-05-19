<?php
declare(strict_types=1);

namespace App\Controller;

use JonnyW\PhantomJs\Client;

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
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function withdraw()
    {
        $this->loadModel('LogWithdraws');
        $this->loadModel('MstWithdraws');
        $wdConfig = $this->MstWithdraws->find('list')->toArray();
        $wdCategories = array_flip($wdConfig);
        $withdraws = [];
        foreach($wdCategories as $key => $category){
            $logs = $this->LogWithdraws->find('all')->where([
                'LogWithdraws.withdraw_id' => $category
            ])->toArray();
            foreach($logs as $log){
                $withdraws[$key] = $log->amount;
            }
        }
        
        $category = json_encode($wdConfig, JSON_UNESCAPED_UNICODE);
        $this->set(compact('category'));
        $this->set(compact('withdraws'));
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function deposit()
    {
        $this->loadModel('LogDeposits');
        $this->loadModel('MstDeposits');
        $dpConfig = $this->MstDeposits->find('list')->toArray();
        $dpCategories = array_flip($dpConfig);
        $deposits = [];
        foreach($dpCategories as $key => $category){
            $logs = $this->LogDeposits->find('all')->where([
                'LogDeposits.deposit_id' => $category
            ])->toArray();
            foreach($logs as $log){
                $deposits[$key] = $log->amount;
            }
        }
        
        $category = json_encode($dpConfig, JSON_UNESCAPED_UNICODE);
        $this->set(compact('category'));
        $this->set(compact('deposits'));
    }
}
