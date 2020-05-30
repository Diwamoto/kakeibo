<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Security;
use Cake\Core\App;
use Cake\Core\Configure;

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
        parent::initialize();
        $this->loadComponent('Kakeibo');
    }
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index']);
        
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index(){
                
        $this->loadModel('LogDeposits');
        $this->loadModel('LogWithdraws');
        $this->loadModel('MstWithdraws');
        $this->loadModel('MstDeposits');
        $this->loadModel('Accounts');
        $this->loadModel('Users');
        $this->loadModel('UserTokens');
        
        $terms = [];
        $years = range(2019,2025);
        $monthes = range(1,12);
        $id = 0;
        foreach($years as $year){
            foreach($monthes as $month){
                $terms[] = [
                    'year' => $year,
                    'month' => sprintf('%02d', $month)
                ];
                if(date($year . '-' . sprintf('%02d', $month) . '-d') == date("Y-m-d")){
                    $nowterm = $id;
                }
                $id++;
            }
        }
        
        //トークンがないorログインしてなければはじく
        $result = $this->Authentication->getResult();
        if($result->isValid()){
            $userId = $this->Authentication->getIdentity()->getIdentifier();
        }else{
            if($this->request->is('get') && $this->request->getQuery()){
                $query = $this->request->getQuery();
                $token = $query['token'];
                $tokenEntity = $this->UserTokens->find('all')->where([
                    'UserTokens.token' => $token,
                    'UserTokens.token_limit > ' => date("Y-m-d H:i:s")
                ])->first();
                if($tokenEntity){
                    $user = $this->Users->get($tokenEntity->user_id);
                    if($user){
                        $userId = $user->id;
                    }else{
                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                    }
                }else{
                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                }
            }elseif($this->request->is('post')){
                $request = $this->request->getData();
                $token = $request['token'];
                $tokenEntity = $this->UserTokens->find('all')->where([
                    'UserTokens.token' => $token,
                    'UserTokens.token_limit > ' => date("Y-m-d H:i:s")
                ])->first();
                if($tokenEntity){
                    $user = $this->Users->get($tokenEntity->user_id);
                    if($user){
                        $userId = $user->id;
                    }else{
                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                    }
                }
            }else{
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }
        }
        
        $wdConfig = $this->MstWithdraws->find('list')->toArray();
        $dpConfig = $this->MstDeposits->find('list')->toArray();
        
        $logDepositModel = $this->LogDeposits->find('all');
        $logWithdrawModel = $this->LogWithdraws->find('all');
        
        $request = $this->request->getData();
        
        if($this->request->is('post')){
            if($request["account_name"]){
                $logDepositModel->where([
                    'LogDeposits.account_id' => $request["account_name"]
                ]);
                $logWithdrawModel->where([
                    'LogWithdraws.account_id' => $request["account_name"]
                ]);
            }
            if($request['terms']){
                $targetTerm = $terms[$request['terms']];
                $logDepositModel->where([
                    'LogDeposits.modified > ' => date($targetTerm['year'] . '-' . $targetTerm['month'] . '-1'),
                    'LogDeposits.modified < ' => date($targetTerm['year'] . '-' . $targetTerm['month'] . '-t')
                ]);
                $logWithdrawModel->where([
                    'LogWithdraws.modified > ' => date($targetTerm['year'] . '-' . $targetTerm['month'] . '-1'),
                    'LogWithdraws.modified < ' => date($targetTerm['year'] . '-' . $targetTerm['month'] . '-t')
                ]);
            }else{
                $logDepositModel->where([
                    'LogDeposits.modified > ' => date('Y-m-1'),
                    'LogDeposits.modified < ' => date('Y-m-t')
                ]);
                $logWithdrawModel->where([
                    'LogWithdraws.modified > ' => date('Y-m-1'),
                    'LogWithdraws.modified < ' => date('Y-m-t')
                ]);
            }
        }
        
        $logWithdraws = $logDepositModel->order(['created' => 'DESC'])->toArray();
        $logDeposits = $logWithdrawModel->order(['created' => 'DESC'])->toArray();
        
        $data = array_merge($logWithdraws, $logDeposits);
        
        //unionが使えないので取得後の配列をソートする
        $sorter = function ($a, $b) {
            return $a->created < $b->created;
        };
        
        usort($data, $sorter);
        $amount = 0;
        foreach($data as $obj){
            if(get_class($obj) === "App\Model\Entity\LogWithdraw"){
                $amount -= $obj->amount;
            }else{
                $amount += $obj->amount;
            }
        }
        
        $names = [
            0 => '全て'
        ];
        $accountModel = $this->Accounts->find('all');
        $accountModel->where([
            'OR' => [
                ['Accounts.user_id' => 0],
                ['Accounts.user_id' => $userId]
            ]
        ]);
        $accounts = $accountModel->toArray();
        foreach($accounts as $account){
            $names[$account->id] = $account->name;
        }
        if(!empty($token)){
            $this->set(compact('token'));
        }
        if(empty($request)){
            $this->request = $this->request->withParsedBody([
                'terms' => $nowterm
            ]);
        }
        $this->set(compact('terms'));
        $this->set(compact('amount'));
        $this->set(compact('wdConfig'));
        $this->set(compact('dpConfig'));
        $this->set(compact('names'));
        $this->set(compact('data'));
    }
    

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
